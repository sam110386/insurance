<?php

namespace App\Admin\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\AdminUser;
use Encore\Admin\Auth\Database\Administrator;

class GroupsController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Groups')
            ->description(' ')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form($id)->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }


    /*
    * Store Group with members
    *
    */
    public function store(Request $request){
        if(empty($request->members)){
            admin_error('Error','Please select atleast 1 member.');
            return back();
        }
        $excludeIds = [];
        $members = [];
        $group = Group::create($request->all());
        foreach ($request->members as $member) {
            if(!in_array($member['member_id'],$excludeIds)){
                $members[] = ['group_id'=> $group->id, 'member_id' => $member['member_id'],'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()];
                $excludeIds[] = $member['member_id'];
            }
        }
        if(GroupMember::insert($members)){
            admin_success('Success','Group has been saved.');
        }else{
            admin_error('Error','Group not saved! Please try again.');
        }
        return redirect()->route('groups.index');
    }

    /*
    * Store Group with members
    *
    */
    public function update($id,Request $request){
        if(empty($request->members)){
            admin_error('Error','Please select atleast 1 member.');
            return back();
        }        
        $error = false;
        $group = Group::findOrFail($id);
        $group->manager_id = $request->manager_id;
        $group->name = $request->name;
        $group->email = $request->email;
        $group->update();

        $excludeIds = [];
        $members = [];

        foreach ($request->members as $key => $member) {
            if(!in_array($member['member_id'],$excludeIds)){
                /*Update Member or Insert Record - Check by Member ID*/
                if(is_numeric($key) && $member['_remove_']){
                    GroupMember::destroy($member['id']);
                }elseif(is_numeric($key) && $member['id']){
                    $member = GroupMember::findOrFail($member['id']);
                    $member->member_id = $member['member_id'];
                    $member['updated_at'] = Carbon::now();                    
                    $member->update();
                }else{
                    $member['group_id'] = $id;
                    if(!GroupMember::create($member)) $error = true;
                }
                $excludeIds[] = $member['member_id'];
            }
        }; 
        if($error){
            admin_error('Error','Group not updated! Please try again.');
        }else{
            admin_success('Success','Group has been updated.');
        }
        return redirect()->route('groups.index');
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Group);

        $grid->id('ID');
        $grid->name('Name');
        $grid->column('user.name',trans('Manager'));
        $grid->members(trans('Members'))->display(function($members){
            return count($members);
            // return "<span class='label label-warning'>{$count}</span>";
        });
        $grid->created_at(trans('admin.created_at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Group::findOrFail($id));

        $show->id('ID');
        $show->name('Name');
        $show->user(trans('Manager'))->as(function($manager){
            return $manager->name;
        });
        $show->members(trans('Members Details'),function($members){
            $members->name(trans('Member Name'))->display(function($member){
                return $this->user->name;
            });
            $members->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableView();
                $actions->disableEdit();
            });
            $members->disableCreateButton();
            $members->disableFilter();
            $members->disableTools();
            $members->disablePagination();
            $members->disableExport();
            $members->disableRowSelector();
            $members->disableActions();        
            return $members;
        });
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($gid = null)
    { 
        $managers = $this->getUsersByRole(['manager']);
        $mg = [];
        foreach ($managers as $manager) {
            $mg[$manager->id] = $manager->name; 
        }
        
        $associates = $this->getUsersByRole(['associate']);
        $asso = [];
        


        $allAsso = GroupMember::all()->pluck('member_id');
        if($gid){
            $currentAssoIds = GroupMember::where('group_id',$gid)->get()->pluck('member_id');
            $currentAsso = AdminUser::select(['id','name'])->whereIn('id',$currentAssoIds)->get();

            foreach ($associates as $associate) {
                if(!in_array($associate->id, $allAsso->toArray()) || (in_array($associate->id, $allAsso->toArray()) && in_array($associate->id, $currentAssoIds->toArray()))){
                    $asso[$associate->id] = $associate->name;
                }        
            }            
        }else{
            foreach ($associates as $associate) {
                if(!in_array($associate->id, $allAsso->toArray())){
                    $asso[$associate->id] = $associate->name; 
                }
            }            
        }


        $form = new Form(new Group);
        $form->tab('Group Details', function ($form) use($mg){
            $form->text('name',trans("Name"))->rules('required');
            $form->email('email',trans("Email"))->rules('email');
            $form->select('manager_id',trans("Manager"))->options($mg)->rules('required');
        })->tab('Members', function ($form) use($asso) {
            $form->hasMany('members', function (Form\NestedForm $form) use($asso) {
                $form->select('member_id',trans('Member'))->options($asso)->rules('required');
            });
        });
        return $form;
    }

    private function getUsersByRole($role = ['manager','associate','vendor']){
        return AdminUser::whereHas('roles',  function ($query) use($role) {
            $query->whereIn('slug', $role);
        })->get(['id','name']);
    }

    public static function sendNotificationToManager($groups,$associateId){
        $user = AdminUser::findOrFail($associateId);
        foreach ($groups as $group) {
            SendMail::sendMailToMangerOnNewUser(Group::findOrFail($group['group_id']),$user );
        }
    }    
}
