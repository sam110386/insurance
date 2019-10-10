<?php

namespace App\Admin\Controllers;

use App\Models\Lead;
use App\Models\LeadAssignment;
use App\Models\Note;
use App\Models\Group;
use App\Models\GroupMember;
use Encore\Admin\Facades\Admin as LoginAdmin;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Input;
use Encore\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;


class NotesController extends Controller
{
    use HasResourceActions;
    protected $leadListUsers = ['administrator', 'manager','director','associate','vendor'];
    protected $leadEditUsers = ['administrator', 'manager','director','associate'];
    protected $leadStatusUpdateUsers = ['administrator', 'manager','director','associate'];
    protected $leadAddNoteUsers = ['administrator', 'manager','director','associate','vendor'];
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Recent interface.
     *
     * @param Content $content
     * @return Content
     */
    public function recent(Content $content)
    {
        return $content
            ->header('Lead Notes')
            ->description(' ')
            ->body($this->gridRecent());
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

        if(!self::noteBelongToUser($id)){
            admin_error('Error','Access denied.');
            return redirect()->route('admin.updates');
        }

        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $valid = request()->validate([
            'comments' => 'required',
        ]);
        // if(Client::create($request->all())){
        //     admin_success('Success','Client has been successfully added!');
        //     return redirect()->route('Clients.index');
        // }else{
        //     admin_error('Error','Something went wrong! Please Try Again.');
        //     return back();
        // }
        return back();
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Note);

        $grid->id('ID');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        return $grid;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function gridRecent()
    {
        $grid = new Grid(new Note);
        $grid =  $this->leadListConditions($grid);
        $grid->model()->whereRaw("exists (select 1 from leads where id = notes.lead_id)");
        if(!Input::get('_sort')) $grid->model()->orderby('created_at','desc');
        
        $grid->column(trans('ID'))->display(function(){
            return "<a href='/admin/leads/".$this->lead->id."' class='text-muted'>" . $this->lead->id . "</a>";
        });
        $grid->column(trans('First Name'))->display(function(){
            return "<a href='/admin/leads/". $this->lead->id ."' class='text-muted'>" . $this->lead->first_name . "</a>";
        });
        $grid->column(trans('Last Name'))->display(function(){
            return "<a href='/admin/leads/".$this->lead->id."' class='text-muted'>" . $this->lead->last_name . "</a>";
        });

        $grid->column(trans('User Name'))->display(function(){
            return "<a href='/admin/leads/".$this->lead->id."' class='text-muted'>" . $this->user->name . "</a>";
        });
        $grid->notes(trans('Notes'))->display(function($notes){
            return "<a href='/admin/leads/".$this->lead->id."' class='text-muted'>" . $notes . "</a>";
        });
        $grid->created_at(trans('admin.timestamp'))->sortable()->setAttributes(['width' => '180px']);
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
            if(LoginAdmin::user()->inRoles(['associate','vendor'])){
                if($actions->row->user_id != Auth::guard('admin')->user()->id){
                    $actions->disableEdit();
                }  
            }
        });        
        $grid->disableCreateButton();
        $grid->filter(function($filter){ 
            $filter->disableIdFilter(); 
            $filter->where(function ($query) {
                $query->where('notes', 'like', "%{$this->input}%");
            }, 'Search by text')->placeholder('Enter notes text...');
            $filter->date('created_at', 'Search by date');
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append("<div class='select-all-checkbox pull-left' ><input  type='checkbox' class='grid-select-all' /></div>");
            $tools->disableBatchActions();
        });
        Admin::script("$('.grid-select-all').iCheck({checkboxClass:'icheckbox_minimal-blue'});");
        
        Admin::script("$('.grid-select-all').on('ifChanged', function(event) {
            if (this.checked) {
                $('.grid-row-checkbox').iCheck('check');
            } else {
                $('.grid-row-checkbox').iCheck('uncheck');
            }
        });");
        return $grid;
    }

    protected function leadListConditions($grid){
        $userId = Auth::guard('admin')->user()->id;
        if(LoginAdmin::user()->inRoles(['administrator'])) return $grid;
        
        if(LoginAdmin::user()->inRoles(['manager'])){
            $group_ids = Group::where('manager_id', $userId)->get()->pluck('id')->toArray();
            $leadIds = LeadAssignment::whereIn('group_id',$group_ids)->get()->pluck('lead_id')->toArray();
            $grid->model()->whereIn('lead_id',$leadIds);
        
        }elseif(LoginAdmin::user()->inRoles(['director'])) {
            $leadIds = LeadAssignment::where('group_id','>',0)->get()->pluck('lead_id')->toArray();
            $grid->model()->whereIn('lead_id',$leadIds);
        
        }elseif(LoginAdmin::user()->inRoles(['associate'])){
            $group_ids = GroupMember::where('member_id',$userId)->get()->pluck('group_id')->toArray();
            $leadIds = LeadAssignment::whereIn('group_id',$group_ids)->orWhere('associate_id',$userId)->get()->pluck('lead_id')->toArray();
            $grid->model()->whereIn('lead_id',$leadIds);
        
        }elseif(LoginAdmin::user()->inRoles(['vendor'])){
            $leadIds = LeadAssignment::where('vendor_id',$userId)->get()->pluck('lead_id')->toArray();
            $grid->model()->whereIn('lead_id',$leadIds);
        
        }else{

        }
        return $grid;


        if(LoginAdmin::user()->inRoles(['manager'])){
            $groupsMembers = Group::where('manager_id',Auth::guard('admin')->user()->id)->with('members')->get();

            $members = [];
            foreach ($groupsMembers as $groupsMember) {
                $members = array_merge($members, $groupsMember->members->toArray()) ;
            }
            $userIds = Arr::pluck($members, 'member_id');
            $grid->model()->whereIn('user_id', $userIds);
        }elseif(LoginAdmin::user()->inRoles(['associate'])){
            $groupId = GroupMember::where('member_id',Auth::guard('admin')->user()->id)->pluck('group_id')->first();
            $userIds = GroupMember::where('group_id',$groupId)->pluck('member_id');
            $grid->model()->whereIn('user_id', $userIds);
        }
        return $grid;

    }

    public static function noteBelongToUser($noteId){
        $note = Note::findOrFail($noteId);
        $access = false;
        $userId = Auth::guard('admin')->user()->id;
        // return if user is admin
        if(LoginAdmin::user()->inRoles(['administrator'])){$access = true;}
        // Check for director
        elseif(LoginAdmin::user()->inRoles(['director'])){
            $leadIds = LeadAssignment::where('group_id','>',0 )->get()->pluck('lead_id')->toArray();
            if(in_array($note->lead_id,$leadIds )) $access = true;
        }
        // Check for manager
        elseif(LoginAdmin::user()->inRoles(['manager'])){
            $managerGroups = Group::where('manager_id', $userId)->get()->pluck('id')->toArray();
            $leadIds = LeadAssignment::whereIn('group_id',$managerGroups)->get()->pluck('lead_id')->toArray();   
            if(in_array($note->lead_id,$leadIds )) $access = true;
        }
        // Check for Associate/Vendor
        elseif(LoginAdmin::user()->inRoles(['associate','vendor'])){
            if($note->user_id == $userId) $access = true;
        }else{

        } 
        return $access;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Note::findOrFail($id));

        $show->id('ID');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Note);
        // $form->setAction(route('admin.update_note_post',$id));
        $form->display('lead.id');
        $form->display('lead.first_name',trans('admin.first_name'));
        $form->display('lead.last_name',trans('admin.last_name'));
        $form->display('user.name',trans('admin.username'));
        $form->editor('notes',trans('Notes'));
        $form->display('created_at','Created at');
        $form->display('updated_at','Updated at');
        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });
        
        return $form;
    }

    public function updateNote($id,Request $request){
        if(!self::noteBelongToUser($id)){
            admin_error('Error','Access denied.');
            return back();
        }        
        $note = Note::findOrFail($id);
        $note->notes = $request->notes;
        if($note->update()){
            admin_success('Success','Note has been updated.');
            return back();
        }else{
            admin_error('Error','Note not updated!Please try again.');
            return back();
        }
    }
}
