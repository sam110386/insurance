<?php

namespace App\Admin\Controllers;

use App\Models\Note;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

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
            ->header('Updates')
            ->description('Leads Recent Notes')
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
        $grid->model()->orderby('created_at','desc');
        
        $grid->column(trans('ID'))->display(function(){
            return "<a href='/admin/leads/".$this->lead->id."' class='text-muted'>" . $this->lead->id . "</a>";
        });
        $grid->column(trans('First Name'))->sortable()->display(function(){
            return "<a href='/admin/leads/". $this->lead->id ."' class='text-muted'>" . $this->lead->first_name . "</a>";
        });
        $grid->column(trans('Last Name'))->sortable()->display(function(){
            return "<a href='/admin/leads/".$this->lead->id."' class='text-muted'>" . $this->lead->last_name . "</a>";
        });

        $grid->user_id(trans('Notes User'))->sortable()->display(function($user_id){
            return "<a href='/admin/leads/".$this->lead->id."' class='text-muted'>" . $this->user->name . "</a>";
        });
        $grid->notes(trans('Notes'))->sortable()->display(function($notes){
            return "<a href='/admin/leads/".$this->lead->id."' class='text-muted'>" . $notes . "</a>";
        });
        $grid->created_at('Created at')->sortable();
        $grid->disableActions();
        $grid->disableCreateButton();
        $grid->disableTools();
        $grid->disableFilter();
        $grid->disableExport();
        $grid->disableRowSelector();
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
