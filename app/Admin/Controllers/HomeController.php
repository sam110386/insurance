<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadAssignment;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\AdminUser;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Table;
use App\Admin\Controllers\AdminLeadsController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Encore\Admin\Facades\Admin as LoginAdmin;
use Encore\Admin\Admin;
use Illuminate\Support\Facades\Crypt;
use App\Helpers\CommonMethod;


class HomeController extends Controller
{
	public function dashboard(Content $content){
		$script = <<<SCRIPT
		jQuery.pjax({url: '/admin/dashboard', container: '#pjax-container'})
SCRIPT;
		Admin::script($script);
		return $content
		->header('Dashboard')
		->row(function (Row $row) {
			$row->column(12, function (Column $column) {
				$column->append("<div class='ajax-container'><center><div class='dashboard-spinner'>Loading...</div></center></div>");
			});
		});
	}

	public function index(Content $content)
	{
		return $content
		->header('Dashboard')
		->row(function (Row $row) {
			$row->column(12, function (Column $column) {
				$leads = AdminLeadsController::getLeadCounts(); 
				$infoRow =  new Row;
				$infoRow->column(1,"<style>.fa-sm{font-size:0.5em;}</style>");
				$infoRow->column(2, function (Column $infoColumn)  use($leads) {
					$from =  $to = Carbon::today()->format('Y-m-d');
					$infoBox = new InfoBox(trans('Today'), 'users fa-sm', 'purple', "/admin/leads/$from/$to", '<span>'.$leads['today']['total'].'</span>'.'<span class="text-black font-light">/</span><span class="text-green">'.$leads['today']['low'].'</span>'.'<span class="text-black font-light">/</span><span class="text-red">'.$leads['today']['high'].'</span>');
					$infoColumn->append($infoBox->render());
				});
				$infoRow->column(2, function (Column $infoColumn)use($leads) {
					$from = Carbon::today()->subDays(7)->format('Y-m-d');
					$to = Carbon::today()->format('Y-m-d');
					$infoBox = new InfoBox(trans('7 Days'), 'users fa-sm', 'purple', "/admin/leads/$from/$to", '<span>'.$leads['week']['total'].'</span>'.'<span class="text-black font-light">/</span><span class="text-green">'.$leads['week']['low'].'</span>'.'<span class="text-black font-light">/</span><span class="text-red">'.$leads['week']['high'].'</span>');
					$infoColumn->append($infoBox->render());
				});
				$infoRow->column(2, function (Column $infoColumn)use($leads) {
					$from = Carbon::today()->subDays(30)->format('Y-m-d');
					$to = Carbon::today()->format('Y-m-d');
					$infoBox = new InfoBox(trans('30 days'), 'users fa-sm', 'purple', "/admin/leads/$from/$to", '<span>'.$leads['month']['total'].'</span>'.'<span class="text-black font-light">/</span><span class="text-green">'.$leads['month']['low'].'</span>'.'<span class="text-black font-light">/</span><span class="text-red">'.$leads['month']['high'].'</span>');
					$infoColumn->append($infoBox->render());
				});
				$infoRow->column(2, function (Column $infoColumn) use($leads){
					$from =  Carbon::parse("first day of January ". Carbon::today()->format('Y'))->format('Y-m-d');
					$to = Carbon::now()->format('Y-m-d');                    
					$infoBox = new InfoBox(trans('YTD'), 'users fa-sm', 'purple', "/admin/leads/$from/$to", '<span>'.$leads['year']['total'].'</span>'.'<span class="text-black font-light">/</span><span class="text-green">'.$leads['year']['low'].'</span>'.'<span class="text-black font-light">/</span><span class="text-red">'.$leads['year']['high'].'</span>');
					$infoColumn->append($infoBox->render());
				});
				$infoRow->column(2, function (Column $infoColumn)use($leads) {
					$infoBox = new InfoBox(trans('Lifetime'), 'users fa-sm', 'purple', "/admin/leads", '<span>'.$leads['lifetime']['total'].'</span>'.'<span class="text-black font-light">/</span><span class="text-green">'.$leads['lifetime']['low'].'</span>'.'<span class="text-black font-light">/</span><span class="text-red">'.$leads['lifetime']['high'].'</span>');
					$infoColumn->append($infoBox->render());
				});                                                

				$box = new Box('Lead Chart',$infoRow);
				$box->collapsable();
				$box->style('primary');
				$box->solid();                    
				$column->append($box);
			});
		})
		->row(function (Row $row) {
			$this->userDashboard($row);
		});

	}

	protected function userDashboard($row){
		if(LoginAdmin::user()->inRoles(['vendor'])) return;
		$row->column(4, function (Column $column) {
			$column->append($this->userProfileBox());
		});
		$row->column(8, function (Column $column) {
			$box = $this->groupMembersBox();
			$column->append($box);                
		});
	}

	protected function userProfileBox(){
		if(LoginAdmin::user()->inRoles(['administrator'])){
			$bgClass = "bg-admin";
			$role = "Administrator";
		}elseif(LoginAdmin::user()->inRoles(['manager'])){
			$bgClass = "bg-manager";
			$role = "Manager";
		}elseif(LoginAdmin::user()->inRoles(['associate'])){
			$bgClass = "bg-associate";
			$role = "Associate";
		}elseif(LoginAdmin::user()->inRoles(['director'])){
			$bgClass = "bg-director";
			$role = "Director";
		}else{
			$bgClass = "bg-primary";
			$role = "Vendor";
		}
		
		$profilePic = (LoginAdmin::user()->avatar) ? LoginAdmin::user()->avatar : "/images/default-user.png";
		$userInfo = '<div class="box box-widget widget-user-2">
			<div class="widget-user-header '. $bgClass .'">
				<div class="widget-user-image">
				<img class="img-circle" src="'.$profilePic.'" alt="User Avatar"/>
				</div>
				<h3 class="widget-user-username">'.LoginAdmin::user()->name.'</h3>
				<h5 class="widget-user-desc">'. $role .'</h5>
			</div>
			<div class="box-footer no-padding">
				<ul class="nav nav-stacked">
				<li><a href="javascript:;"><strong>First Name</strong> <span class="pull-right">'.LoginAdmin::user()->name.'</span></a></li>
				<li><a href="javascript:;"> <strong>Last Name</strong> <span class="pull-right">'.LoginAdmin::user()->last_name.'</span></a></li>
				<li><a href="javascript:;"> <strong>Username</strong> <span class="pull-right">'.LoginAdmin::user()->username.'</span></a></li>
				<li><a href="javascript:;"> <strong>Email</strong> <span class="pull-right">'.LoginAdmin::user()->email.'</span></a></li>
				<li><a href="javascript:;"> <strong>Phone</strong> <span class="pull-right">'.LoginAdmin::user()->phone.'</span></a></li>
				</ul>
			</div>
			</div>
			<div class="text-center">
			<a href="'.route('admin.setting').'" class="btn btn-info"><i class="fa fa-pencil"></i> <span class="hidden-xs">Update Profile</span></a>
			</div>';
		if(LoginAdmin::user()->inRoles(['administrator'])){
			$activeProfileClass ="primary admin-box";
		}elseif(LoginAdmin::user()->inRoles(['manager'])){
			$activeProfileClass ="primary manager-box";
		}elseif(LoginAdmin::user()->inRoles(['director'])){
			$activeProfileClass ="primary director-box";
		}elseif(LoginAdmin::user()->inRoles(['associate'])){
			$activeProfileClass ="primary associate-box";
		}else{
			$activeProfileClass = "primary vendor-box";
		}          
		$box = new Box('My Profile',$userInfo);
		$box->collapsable();
		$box->style($activeProfileClass);
		$box->solid();
		return $box;
	}

	protected function groupMembersBox(){
		$box = new Box('Group Members',$this->groupList());
		$box->collapsable();
		$box->style('info');
		$box->solid();
		return $box;
	}

	protected function groupList(){
		$html = " ";
		if(LoginAdmin::user()->inRoles(['associate'])){
			$groups = GroupMember::where('member_id',LoginAdmin::user()->id)->get()->pluck('group_id')->toArray();
				$html .= $this->groupDetails($groups[0]);

		}elseif(LoginAdmin::user()->inRoles(['manager'])){
			$groups = Group::where('manager_id',LoginAdmin::user()->id)->get()->pluck('id')->toArray();
			foreach($groups as $gid){
				$html .= $this->groupDetails($gid);
			}
		}elseif(LoginAdmin::user()->inRoles(['administrator'])){
			$groups = Group::all()->pluck('id')->toArray();
			foreach($groups as $gid){
				$html .= $this->groupDetails($gid);
			}
			/* Un Grouped Users */
			$html .= $this->unGroupedMemberList($gid);
		}elseif(LoginAdmin::user()->inRoles(['director'])){
			$groups = Group::all()->pluck('id')->toArray();
			foreach($groups as $gid){
				$html .= $this->groupDetails($gid);
			}
			$html .= $this->unGroupedMemberList($gid);
		}else{
			$html = "Comming soon!";
		}
		return $html;
	}

	protected function groupDetails($gid){
		$group = Group::findOrFail($gid);
		if(LoginAdmin::user()->inRoles(['associate'])) return  $this->groupMembersList($group);
		$box = new Box($group->name,$this->groupMembersList($group));
		$box->collapsable();
		$box->style('primary');
		$box->solid();
		return $box;
	}

	protected function groupMembersList($group){
		$html = "<div class='row'>";
		$userPreHtml = "<div class='col-md-4'>";
		$userPostHtml = "</div>";

		$members = GroupMember::where('group_id',$group->id)->get()->pluck('member_id')->toArray();
		if(!$members) return "<h5>No member in this group.</h5>";
		
		$currentUser = LoginAdmin::user()->id ;
		
		if(LoginAdmin::user()->inRoles(['associate','administrator','director'])) $html .= $userPreHtml.$this->managerLeadDetails($group->manager_id) . $userPostHtml;
		foreach ($members as $mid) {
			$html .= $userPreHtml . $this->memberLeadDetails($mid,$group->id). $userPostHtml; 
		}
		return $html."</div>";
	}


	protected function unGroupedMemberList(){
		$html = "<div class='row'>";
		$userPreHtml = "<div class='col-md-4'>";
		$userPostHtml = "</div>";
		$gManagers = Group::all()->pluck('manager_id')->toArray();
		$gMembers = GroupMember::all()->pluck('member_id')->toArray();
		$skipIds = array_merge($gManagers,$gMembers);
		$members  = AdminUser::whereNotIn('id',$skipIds)->whereHas("roles", function($q){
			$q->where("slug", "associate");
			$q->orWhere("slug", "manager");
		})->get()->pluck('id')->toArray();

		if(empty($members)) $html = "<h5>No member to show here.</h5>"; 
		foreach ($members as $mid) {
			$html .= $userPreHtml . $this->memberLeadDetails($mid,0). $userPostHtml; 
		}

		$box = new Box('Ungrouped Members',$html);
		$box->collapsable();
		$box->style('primary');
		$box->solid();
		return $box;
	}

	protected function managerLeadDetails($magaerId){
		$user = AdminUser::findOrFail($magaerId);
		$leads = $this->managerLeads($user);
		return $this->userBox($user,$leads);
	}
	protected function memberLeadDetails($uid,$gid){
		$user = AdminUser::findOrFail($uid);
		$userLeads = $this->memberLeads($uid,$gid);
		return $this->userBox($user,$userLeads);
	}

	protected function userBox($user,$userLeads){
		if($user->inRoles(['administrator'])){
			$boxClass = "admin-box";
			$role = "Administrator";
		}elseif($user->inRoles(['manager'])){
			$boxClass = "manager-box";
			$role = "Manager";
		}elseif($user->inRoles(['associate'])){
			$boxClass = "associate-box";
			$role = "Associate";
		}else{
			$boxClass = "vendor-box";
			$role = "Vendor";
		}

		$boxClass = ($user->inRoles(['associate'])) ? "associate-box" : "manager-box";
		$totalLeads = (count($userLeads) > 99) ? "99+" : count($userLeads);

		$leadWithoutStatusOrNote = $this->leadWithoutStatusOrNote($userLeads);
		$leadWithoutStatusOrNoteCount = (count($leadWithoutStatusOrNote) > 99 ) ? '99+' : count($leadWithoutStatusOrNote);

		$leadStatuses = $this->leadStatuses($userLeads);

		$newLeadLink = "0";
		if(count($leadStatuses[0]) > 0){
			$newLeadLink = '<a href="'.route('admin.user-leads',[CommonMethod::encryptData($user->id),CommonMethod::encryptData(json_encode($leadStatuses[0]))]).'" class="text-white">'.count($leadStatuses[0]).'</a>';
		}

		$pendingLeadLink = "0";
		if(count($leadStatuses[1]) > 0){
			$pendingLeadLink = '<a href="'.route('admin.user-leads',[CommonMethod::encryptData($user->id),CommonMethod::encryptData(json_encode($leadStatuses[1]))]).'" class="text-white">'.count($leadStatuses[1]).'</a>';
		}

		$inProgressLeadLink = "0";
		if(count($leadStatuses[2]) > 0){
			$inProgressLeadLink = '<a href="'.route('admin.user-leads',[CommonMethod::encryptData($user->id),CommonMethod::encryptData(json_encode($leadStatuses[2]))]).'" class="text-white">'.count($leadStatuses[2]).'</a>';
		}

		$completeLeadLink = "0";
		if(count($leadStatuses[3]) > 0){
			$completeLeadLink = '<a href="'.route('admin.user-leads',[CommonMethod::encryptData($user->id),CommonMethod::encryptData(json_encode($leadStatuses[3]))]).'" class="text-white">'.count($leadStatuses[3]).'</a>';
		}

		$incompleteLeadLink = "0";
		if(count($leadStatuses[4]) > 0){
			$incompleteLeadLink = '<a href="'.route('admin.user-leads',[CommonMethod::encryptData($user->id),CommonMethod::encryptData(json_encode($leadStatuses[4]))]).'" class="text-white">'.count($leadStatuses[4]).'</a>';
		}

		$declinedLeadLink = "0";
		if(count($leadStatuses[5]) > 0){
			$declinedLeadLink = '<a href="'.route('admin.user-leads',[CommonMethod::encryptData($user->id),CommonMethod::encryptData(json_encode($leadStatuses[5]))]).'" class="text-white">'.count($leadStatuses[5]).'</a>';
		}

		$transferLeadLink = "0";
		if(count($leadStatuses[6]) > 0){
			$transferLeadLink = '<a href="'.route('admin.user-leads',[CommonMethod::encryptData($user->id),CommonMethod::encryptData(json_encode($leadStatuses[6]))]).'" class="text-white">'.count($leadStatuses[6]).'</a>';
		}

		$notEligibleLeadLink = "0";
		if(count($leadStatuses[7]) > 0){
			$notEligibleLeadLink = '<a href="'.route('admin.user-leads',[CommonMethod::encryptData($user->id),CommonMethod::encryptData(json_encode($leadStatuses[7]))]).'" class="text-white">'.count($leadStatuses[7]).'</a>';
		}

		// $leadStatuses = (empty($leadStatuses)) ? [0,0,0,0,0,0,0,0] : $leadStatuses;
		$leadStatuses = [0,0,0,0,0,0,0,0];
		$profilePic = ($user->avatar) ? $user->avatar : "/images/default-user.png";
		$userInfo = '<div class="box box-solid '.$boxClass.' box-success widget-user-2">
			<div class="box-header">
				<div class="widget-user-image">
				<img class="img-circle" src="'.$profilePic.'" alt="User Avatar"/>
				</div>
				<h3 class="widget-user-username">'.$user->name.'</h3>
				<h5 class="widget-user-desc">'.$role.'</h5>
			</div>
			<div class="box-body">			
				<div class="row">
					<div class="col-xs-12">
						<h5>Total Leads <span class="pull-right label label-info"><a href="'.route('admin.user-leads',[CommonMethod::encryptData($user->id),CommonMethod::encryptData(json_encode($userLeads))]) .'" class="text-white">'.$totalLeads.'</a></span></h5>
					</div>
					<div class="col-xs-12">
						<h5>Lead without Status/Note  <span class="pull-right label label-danger"><a href="'.route('admin.user-leads',[CommonMethod::encryptData($user->id),CommonMethod::encryptData(json_encode($leadWithoutStatusOrNote))]) .'" class="text-white">'.$leadWithoutStatusOrNoteCount.'</a></span></h5>
					</div>
					<div class="col-xs-12">
						<hr/>			
						<h4>Lead Statuses</h4>
						<h5>New <span class="pull-right label label-primary">'.$newLeadLink.'</span></h5>
						<h5>Pending <span class="pull-right label label-primary">'.$pendingLeadLink.'</span></h5>
						<h5>In Progress <span class="pull-right label label-primary">'.$inProgressLeadLink.'</span></h5>
						<h5>Complete <span class="pull-right label label-primary">'.$completeLeadLink.'</span></h5>
						<h5>Incomplete <span class="pull-right label label-primary">'.$incompleteLeadLink.'</span></h5>
						<h5>Declined <span class="pull-right label label-primary">'.$declinedLeadLink.'</span></h5>
						<h5>Transfer <span class="pull-right label label-primary">'.$transferLeadLink.'</span></h5>
						<h5>Not Eligible <span class="pull-right label label-primary">'.$notEligibleLeadLink.'</span></h5>
					</div>
				</div>
			</div>
		</div>';        
		return $userInfo;
	}

	/* Lead Ids associated to manager */
	protected function managerLeads($manager){
		$groupIds = $manager->managerGroups->pluck('id')->toArray();
		$memberIds = GroupMember::whereIn('group_id',$groupIds)->get()->pluck('member_id')->toArray();

		return LeadAssignment::whereIn('group_id',$groupIds)->orWhereIn('associate_id',$memberIds)->get()->pluck('lead_id')->toArray();
	}
	/* Lead Ids associated to associate */
	protected function memberLeads($uid,$gid){
		return LeadAssignment::where('group_id',$gid)->orWhere('associate_id',$uid)->get()->pluck('lead_id')->toArray();
	}

	protected function leadWithoutStatusOrNote($leads = []){
		if(empty($leads)) return [];
		$leadsWithoutStatus = Lead::whereIn('id',$leads)->where('current_status',0)->get()->pluck('id')->toArray();
		$leadsWithoutNotes = Lead::whereIn('id',$leads)->whereDoesntHave('notes')->get()->pluck('id')->toArray();
		return array_values(array_unique(array_merge($leadsWithoutStatus,$leadsWithoutNotes)));
	}

	protected function leadStatuses($leads = []){
		if(empty($leads)) return [];
		$leadsIds = Lead::select(['id','current_status'])->whereIn('id',$leads)->get()->toArray();
		$status = [[],[],[],[],[],[],[],[]];
		foreach ($leadsIds as $lead) {
			$status[$lead['current_status']][] = $lead['id'];
		}
		return $status;

		// $statusCounts = Lead::selectRaw('count(*) as total, current_status')->whereIn('id',$leads)->groupBy('current_status')->get()->toArray();
		// $counts = [0,0,0,0,0,0,0,0];
		// foreach ($statusCounts as $value) {
		// 	$counts[$value['current_status']] = $value['total'];
		// }
		// return $counts;
	}



	public function testMail($id,$status){
		$parameter =[
            'user_id' =>1,
            'leads' => 'new'
        ];

        for($i = 0; $i<100; $i++) {
        	$number = rand(1,99999999999);
        	$encrypt = rtrim(strtr(base64_encode($number), '+/', '-_'), '=');
        	$decrypt = base64_decode(str_pad(strtr($encrypt, '-_', '+/'), strlen($encrypt) % 4, '=', STR_PAD_RIGHT));
        	echo "$number -> $encrypt -> $decrypt" ;
        	echo "<br>";
        }

  	// 	$data = base64_encode(99999999999999);
	 	// // $data = str_replace(array('+','/','='),array('-','_','.'),$data);
   //      echo $data;

		  // $data = str_replace(array('-','_','.'),array('+','/','='),$data);
		  // $mod4 = strlen($data) % 4;
		  // if ($mod4) {
		  //   $data .= substr('====', $mod4);
		  // }
		  // echo base64_decode($data);        
		die;
		// $email = 'sgstest2505@gmail.com';
		// $lead = Lead::findOrFail(5);
		// $mailStatus = \Mail::send('Admin.Lead.email', ['lead' => $lead],
		// 		function ($message) use($email){
		// 			$message->to($email)->subject('New Lead - Insurance');
		// }); 

		// dd($mailStatus);
	}
}
