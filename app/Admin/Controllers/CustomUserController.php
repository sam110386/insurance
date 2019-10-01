<?php

namespace App\Admin\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\AdminUser;
use App\Helpers\SendMail;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Routing\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\UserController;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomUserController extends UserController
{
	use HasResourceActions;

	/**
	 * Index interface.
	 *
	 * @return Content
	 */
	public function index(Content $content)
	{
		return $content
		->header(trans('admin.users'))
		->description(' ')
		->body($this->grid()->render());
	}

	/**
	 * Show interface.
	 *
	 * @param mixed   $id
	 * @param Content $content
	 *
	 * @return Content
	 */
	public function show($id, Content $content)
	{
		return $content
		->header(trans('admin.user'))
		->description(trans('admin.detail'))
		->body($this->detail($id));
	}

	/**
	 * Edit interface.
	 *
	 * @param $id
	 *
	 * @return Content
	 */
	public function edit($id, Content $content)
	{
		return $content
		->header(trans('admin.user'))
		->description(trans('admin.edit'))
		->body($this->form($id)->edit($id));
	}

	/**
	 * Create interface.
	 *
	 * @return Content
	 */
	public function create(Content $content)
	{
		return $content
		->header(trans('admin.administrator'))
		->description(trans('admin.create'))
		->body($this->form());
	}

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid()
	{

		$grid = new Grid(new AdminUser);

		$grid->id('ID')->sortable();
		$grid->name(trans('admin.first_name'));
		$grid->last_name(trans('admin.last_name'));
		$grid->username(trans('admin.username'));
		$grid->email(trans('admin.email'));
		$grid->roles(trans('admin.role'))->pluck('name')->label()->display(function($text){
			if($this->roles()->pluck('slug')[0] == 'administrator'){
				$roleClass = "role-purple";
			}elseif($this->roles()->pluck('slug')[0] == 'manager'){
				$roleClass = "role-orange";
			}elseif($this->roles()->pluck('slug')[0] == 'vendor'){
				$roleClass = "role-blue";
			}else{
				$roleClass = "";
			}
			return "<span class='$roleClass'>$text</span>";
		});

		$grid->created_at(trans('admin.timestamp'))->setAttributes(['width' => '180px']);


		$grid->actions(function (Grid\Displayers\Actions $actions) {
			if ($actions->getKey() == 1) {
				$actions->disableDelete();
			}
		});

		$grid->tools(function (Grid\Tools $tools) {
			$tools->batch(function (Grid\Tools\BatchActions $actions) {
				$actions->disableDelete();
			});
		});

		return $grid;
	}

	/**
	 * Make a show builder.
	 *
	 * @param mixed $id
	 *
	 * @return Show
	 */
	protected function detail($id)
	{

		$user = AdminUser::findOrFail($id);
		$userModel = config('admin.database.users_model');

		$show = new Show($userModel::findOrFail($id));

		$show->id('ID');
		$show->name(trans('admin.first_name'));
		$show->last_name(trans('admin.last_name'));
		$show->username(trans('admin.username'));
		$show->email(trans('email'));
		$show->phone(trans('phone'));
		$show->roles(trans('admin.role'))->as(function ($roles) {
			return $roles->pluck('name');
		})->label();
		$show->permissions(trans('admin.permissions'))->as(function ($permission) {
			return $permission->pluck('name');
		})->label();
		$show->created_at(trans('admin.created_at'));
		$show->updated_at(trans('admin.updated_at'));

		return $show;
	}

	/**
	 * Make a form builder.
	 *
	 * @return Form
	 */
	public function form($id=null)
	{
		Admin::script("$('select.roles').removeAttr('multiple');");
		$userModel = config('admin.database.users_model');
		$permissionModel = config('admin.database.permissions_model');
		$roleModel = config('admin.database.roles_model');

		$form = new Form(new $userModel());

		$userId = ($id) ? ",{$id},id" : ""; 
		$userTable = config('admin.database.users_table');
		$userEmailRules = "required|email|max:190|unique:{$userTable}".$userId;
		if (request()->isMethod('POST')) {
			$userNameRules = "required|unique:{$userTable}";
		} else {
			// $userEmailRules = "required|email|max:190";
			// $userEmailRules = "required";
			$userNameRules = 'required';
		}

		$form->hidden('id');
		$form->display('username', trans('admin.username'));
		$form->text('name', trans('admin.first_name'))->rules('required');
		$form->text('last_name', trans('admin.last_name'));
		$form->mobile('phone', trans('admin.phone'))->options(['mask' => '999-999-9999'])->attribute(['style' => 'width:100%;']);
		if($id){
			$form->display('email', trans('admin.email'));
			$form->hidden('username');
		}else{
			$form->text('email', trans('admin.email'))->rules($userEmailRules);
		}

		$form->image('avatar', trans('admin.avatar'));
		$form->divide();
		$form->password('password', trans('admin.password'))->rules('required|confirmed');
		$form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
		->default(function ($form) {
			return $form->model()->password;
		});

		$form->divide();
		$userGroups = [];
		if($id){
			$user = AdminUser::findOrFail($id);
			if(!empty($user->roles)){
				$role = $user->roles[0]->slug;
				$groups = [];
				if($role == 'manager'){
					$groups = Group::select('id')->where('manager_id',$id)->get();
				}elseif($role == 'associate'){
					$groups = GroupMember::select('group_id as id')->where('member_id',$id)->get();
				}else{
				}
				foreach ($groups as $group) {
					$userGroups[] = $group->id;
				}
			}
		}
		$form->multipleSelect('groups')->options(Group::all()->pluck('name', 'id'))->value($userGroups);
		$form->multipleSelect('roles', trans('admin.role'))->options($roleModel::all()->pluck('name', 'id'))->rules('required');
		$form->multipleSelect('permissions', trans('admin.permissions'))->options($permissionModel::all()->pluck('name', 'id'));
		$form->ignore(['password_confirmation','groups']);
		$form->saving(function (Form $form) use($id) {
			if ($form->password && $form->model()->password != $form->password) {
				$form->password = bcrypt($form->password);
			}
			if(request()->id == null){
				$form->username = $form->email;
				$form->created_by = Auth::guard('admin')->user()->id;
			}
		});

		$form->saved(function(Form $form) use($id){
			self::saveUserGroups($form);
			if(request()->id == null){
				self::sendNewUserEmails($form->model()->id);
			}
			return redirect()->route('users.index');
		});

		$form->disableViewCheck();
		$form->disableEditingCheck();
		$form->disableCreatingCheck();
		return $form;
	}

	public static function saveUserGroups($form){
		$user = AdminUser::findOrFail($form->model()->id);
		if(!empty($user->roles)){
			$role = $user->roles[0]->slug;

			$groupsIds = array_filter(request()->groups, function($value) { return !is_null($value) && $value !== ''; });
			if($role == 'manager'){
				self::updateManagerGroup($groupsIds,$form->model()->id);
			}elseif($role == 'associate'){
				self::updateAssociateGroup($groupsIds,$form->model()->id);
			}else{
				// No need to perform task on group
			}
		}
		return true;
	}

	public static function updateManagerGroup($groupsIds,$managerId){
		return Group::whereIn('id',$groupsIds)->update(['manager_id' => $managerId]);
	}

	public static function updateAssociateGroup($groupsIds,$associateId){
		$existingGroups = GroupMember::where('member_id',$associateId)->pluck('group_id')->toArray();

		$groups = [];
		foreach ($groupsIds as $group) {
			if(!in_array($group, $existingGroups))
				$groups[] = ['group_id'=> $group, 'member_id' => $associateId,'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()];
		}
		GroupMember::where('member_id',$associateId)->whereNotIn('group_id',$groupsIds)->delete();
		if(!empty($groups)){
			if(GroupMember::insert($groups)){
				self::sendNotificationToManager($groups,$associateId);
			}
		}
	}

	public static function sendNewUserEmails($userId){
		$user = AdminUser::findOrFail($userId);
		SendMail::adminNewUserNotification($user);
		SendMail::userWelcomeNotification($user);
	}

	public static function sendNotificationToManager($groups,$associateId){
		$user = AdminUser::findOrFail($associateId);
		foreach ($groups as $group) {
			SendMail::sendMailToMangerOnNewUser(Group::findOrFail($group['group_id']),$user );
		}
	}

}
