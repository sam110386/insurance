<?php

namespace App\Admin\Controllers;

use App\Models\Note;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Input;

class NotesController extends Controller
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

        $grid->column(trans('Notes User'))->display(function(){
            return "<a href='/admin/leads/".$this->lead->id."' class='text-muted'>" . $this->user->name . "</a>";
        });
        $grid->notes(trans('Notes'))->display(function($notes){
            return "<a href='/admin/leads/".$this->lead->id."' class='text-muted'>" . $notes . "</a>";
        });
        $grid->created_at(trans('admin.created_at'))->sortable();
        $grid->disableActions();
        $grid->disableCreateButton();
        // $grid->disableTools();
        // $grid->disableFilter();
        // $grid->disableExport();
        $grid->disableRowSelector();
        $grid->filter(function($filter){ 
            $filter->disableIdFilter(); 
            $filter->where(function ($query) {
                $query->where('notes', 'like', "%{$this->input}%");
            }, 'Search by text')->placeholder('Enter notes text...');
            $filter->date('created_at', 'Search by date');
        });
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
        $show = new Show(Comment::findOrFail($id));

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
        $form = new Form(new Comment);

        $form->display('ID');
        $form->display('Created at');
        $form->display('Updated at');

        return $form;
    }
}
