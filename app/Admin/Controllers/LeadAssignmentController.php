<?php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Encore\Admin\Auth\Database\Administrator;
use App\Models\Group;
use App\Models\Lead;

use App\Admin\Controllers\AdminUsersController;

class LeadAssignmentController extends Controller
{
	public function getAssignmentList(Request $request){
		$assignType = $request->get('q');
		if($assignType == 'group'){
			return $this->getGroups();
		}else{
			return $this->getAssociates();
		}
	}

	private function getGroups(){
		return Group::get(['id','name as text']);
	}
	private function getAssociates(){
		$list = new AdminUsersController();
		return $list->getUsersByRole(['associate']);
	}

	public static function assignLeadToGroup($leads = null, $groupId=null){
		$group = Group::findOrFail($groupId);
		$leadIds = explode(',',$leads);
 		return Lead::whereIn('id',$leadIds)->update(['group_id'=>$groupId,'manager_id' => $group['manager_id'], 'member_id' => 0]);
	}


	public static function adminAssignLeadToUser($leads = null, $memberId=null){
		$leadIds = explode(',',$leads);
		return Lead::whereIn('id',$leadIds)->update(['current_status'=>1,'member_id' => $memberId]);
	}


	public function assignLead(Request $request){
		if(!$request->assign_to || !$request->assign_id){
            admin_error('Error','Select Group/Associate to assign.');
		}elseif(!$request->lead_ids) {
            admin_error('Error','Something went wrong! Please try again!');
		}else{
			if($request->assign_to == 'group'){
				self::assignLeadToGroup($request->lead_ids,$request->assign_id);
			}else{
				self::adminAssignLeadToUser($request->lead_ids,$request->assign_id);
			}
            admin_success('Success','Lead(s) assigned successfully.');
		}
        return back();
	}
}