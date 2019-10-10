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
		}elseif($assignType == 'vendor'){
			return $this->getVendors();
		}else{
			return $this->getAssociates();
		}
	}

	private function getGroups(){
		return Group::get(['id','name as text']);
	}

	private function getVendors(){
		$list = new AdminUsersController();
		return $list->getUsersByRole(['vendor']);
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


	public static function adminAssignLeadToUser($leads = null, $memberId=null,$userColumn = "associate_id"){
		$leadIds = explode(',',$leads);
		foreach ($leadIds as $leadId) {	
			$assignment = LeadAssignment::firstOrCreate(array('lead_id' => $leadId));
			$assignment->$userColumn = $memberId;
			if(!$assignment->save()){
	            admin_error('Error','Error to assign one or more Lead(s).');
			}
		}
		return true;
	}


	public function assignLead(Request $request){
		if(!$request->assign_to || !$request->assign_id){
            admin_error('Error','Select Group/Associate to assign.');
		}elseif(!$request->lead_ids) {
            admin_error('Error','Something went wrong! Please try again!');
		}else{
			if($request->assign_to == 'group'){
				self::assignLeadToGroup($request->lead_ids,$request->assign_id);
			}elseif($request->assign_to == 'member'){
				self::adminAssignLeadToUser($request->lead_ids,$request->assign_id,'associate_id');
			}else{
				self::adminAssignLeadToUser($request->lead_ids,$request->assign_id,'vendor_id');
			}
            admin_success('Success','Lead(s) assigned successfully.');
		}
        return back();
	}

	/*
	* Move assignments from old table(leads) to new table(lead_assignments)
	*/
	public function moveAssignments(){
		$leads = Lead::select(['id','group_id','member_id'])->where('group_id','>',0)->orWhere('member_id','>',0)->get()->toArray();
		$successIds = [];
		$errorIds = [];
		foreach ($leads as $lead) {
			$assignment = LeadAssignment::firstOrCreate(array('lead_id' => $lead['id']));
			$assignment->associate_id = $lead['member_id'];
			$assignment->group_id = $lead['group_id'];
			if(!$assignment->save()){
				$errorIds[] = $lead['id'];
			}else{
				$successIds[] = $lead['id'];
			}
	        admin_error('Error','Not assigned '. implode(',', $errorIds));
	        admin_success('Success','Assigned '.implode(',', $successIds));
		}
		return redirect()->route('leads.index');
	}
}