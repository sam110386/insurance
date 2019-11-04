<?php

namespace App\Admin\Controllers;

use App\Models\Vehicle;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class VehiclesController extends Controller
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
            ->header('Vehicle')
            ->description('List')
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
            ->header('Vehicle')
            ->description('Description')
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
            ->header('Vehicle')
            ->description('Edit')
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
            ->header('Vehicle')
            ->description('Create')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        
        $grid = new Grid(new Vehicle);
        $grid->id('ID');
        $grid->year(trans('Year'));
        $grid->make(trans('Make'));
        $grid->vmodel(trans('Model'));
        $grid->trim_1(trans('Trim New'));
        $grid->trim_2(trans('Trim Old'));
        $grid->updated_at(trans('admin.timestamp'))->setAttributes(['width' => '180px']);

        // Last updated record
        $lastUpdateData = $this->lastUpdateData();
        $grid->tools(function (Grid\Tools $tools) use($lastUpdateData) {
            $tools->append("<div class='col-12 vehicle-last-update'><span class='mr-1'>Last Update: <strong>{$lastUpdateData['date']}</strong> by <strong>{$lastUpdateData['username']}</strong></span></div>");
        });        
        return $grid;
    }

    protected function lastUpdateData(){
        $vehicle = Vehicle::whereNotNull('updated_at')->orderBy('updated_at','DESC')->get()->first();
        return ($vehicle) ? ['date' => $vehicle->updated_at,'username' => $vehicle->user->username] : ['date' => '','username' => ''];
    }
    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Vehicle::findOrFail($id));

        $show->id('ID');
        $show->year(trans('Year'));
        $show->make(trans('Make'));
        $show->vmodel(trans('Model'));
        $show->trim_1(trans('Trim New'));
        $show->created_at(trans('Created at'));
        $show->updated_at(trans('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Vehicle);
        $form->row(function ($row) use ( $form) {
            $row->width(2)->text('year', trans('Year'))->rules('required|numeric');
            $row->width(2)->text('make', trans('Make'))->rules('required');
            $row->width(3)->text('vmodel', trans('Model'))->rules('required');
        });

        $form->row(function ($row) use ( $form) {
            $row->width(8)->text('trim_1', trans('Trim (new)'));
        });

        $form->row(function ($row) use ( $form) {
            $row->width(8)->text('trim_2', trans('Trim (old)'));
        });

        $form->row(function ($row) use ( $form) {
            $row->width(8)->textarea('description', trans('Description'));
        });
        $form->saving(function (Form $form) {
            $form->user_id = Auth::guard('admin')->user()->id;
        });        
        return $form;
    }

    // public function update($id,Request $request){
    //     dd($request->all());
    // }

}
