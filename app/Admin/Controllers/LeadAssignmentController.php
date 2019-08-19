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

	public static function assignLeadToGroup($lead = null, $groupId=null){
		$lead = Lead::findOrFail($lead);
		$group = Group::findOrFail($groupId);
		$lead['group_id'] = $groupId;
		$lead['manager_id'] = $group['manager_id'];
		$lead['member_id'] = 0;

		return $lead->update();
	}


	public static function adminAssignLeadToUser($lead = null, $memberId=null){
		$lead = Lead::findOrFail($lead);
		$lead['member_id'] = $memberId;
		$lead['current_status'] = 1;
		return $lead->update();
	}


	public function assignLead(Request $request){
		if(!$request->assign_to || !$request->assign_id){
            admin_error('Error','Select Group/Associate to assign.');
		}elseif(!$request->lead_id) {
            admin_error('Error','Something went wrong! Please try again!');
		}else{
			if($request->assign_to == 'group'){
				self::assignLeadToGroup($request->lead_id,$request->assign_id);
			}else{
				self::adminAssignLeadToUser($request->lead_id,$request->assign_id);
			}
            admin_success('Success','Lead has been assigned successfully.');
		}
        return back();
	}
}