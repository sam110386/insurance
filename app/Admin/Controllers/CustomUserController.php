<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Routing\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\UserController;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\AdminUser;
use Encore\Admin\Auth\Database\Administrator;

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
        $userModel = config('admin.database.users_model');

        $grid = new Grid(new $userModel());

        $grid->id('ID')->sortable();
        $grid->username(trans('admin.username'));
        $grid->name(trans('admin.name'));
        $grid->roles(trans('admin.role'))->pluck('name')->label();
        $grid->created_at(trans('admin.created_at'));
        $grid->updated_at(trans('admin.updated_at'));

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
        $userModel = config('admin.database.users_model');

        $show = new Show($userModel::findOrFail($id));

        $show->id('ID');
        $show->username(trans('admin.username'));
        $show->email(trans('Email'));
        $show->name(trans('admin.name'));
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
        $form->text('phone', trans('admin.phone'));
        if($id){
            $form->display('email', trans('admin.email'));
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
            $user = Administrator::findOrFail($id);
            if(!empty($user->roles)){
                $role = $user->roles[0]->slug;

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

        // $form->display('created_at', trans('admin.created_at'));
        // $form->display('updated_at', trans('admin.updated_at'));

        $form->ignore(['password_confirmation','groups']);
        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            }
        });
        $form->disableViewCheck();
        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        return $form;
    }
}
