<?php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Encore\Admin\Auth\Database\Administrator;
use App\Models\Group;
use App\Models\Lead;
use App\Models\LeadAssignment;


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
		$leadIds = explode(',',$leads);
		foreach ($leadIds as $leadId) {	
			$assignment = LeadAssignment::firstOrCreate(array('lead_id' => $leadId));
			$assignment->group_id = $groupId;
			if(!$assignment->save()){
	            admin_error('Error','Error to assign one or more Lead(s).');
			}
		}
		return true;
	}


	public static function adminAssignLeadToUser($leads = null, $memberId=null){
		$leadIds = explode(',',$leads);
		foreach ($leadIds as $leadId) {	
			$assignment = LeadAssignment::firstOrCreate(array('lead_id' => $leadId));
			$assignment->associate_id = $memberId;
			if(!$assignment->save()){
	            admin_error('Error','Error to assign one or more Lead(s).');
			}
		}
		return true;		
		// return Lead::whereIn('id',$leadIds)->update(['current_status'=>1,'member_id' => $memberId]);
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