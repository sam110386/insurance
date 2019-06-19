<?php

namespace App\Admin\Controllers;

use App\Models\Lead;
use App\Models\Note;
use App\Models\AdminUser;
use App\Http\Controllers\Controller;
use App\Admin\Extensions\Tools\BulkEmailLead;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Carbon\Carbon;
use App\Helpers\CommonMethod;
use Encore\Admin\Admin;
use Encore\Admin\Facades\Admin as LoginAdmin;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Widgets\Tab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminLeadsController extends Controller
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
        ->header('Lead')
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
        ->header('Detail')
        ->description('description')
        // ->breadcrumb(
        //     ['text' => 'Dashboard', 'url' => '/admin'],
        //     ['text' => 'Leads', 'url' => '/admin/leads'],
        //     ['text' => 'Details']
        // )        
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
        if (!LoginAdmin::user()->inRoles(['administrator', 'manager'])){
            admin_error('Error','Access denied.');
            return back();
        }
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
        if (!LoginAdmin::user()->inRoles(['administrator', 'manager'])){
            admin_error('Error','Access denied.');
            return back();
        }        
        return $content
        ->header('Create')
        ->description('description')
        ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Lead);
        $grid->id('ID');
        $grid->first_name(trans('First Name'));
        $grid->last_name(trans('Last Name'));
        $grid->email(trans('Email'));
        $grid->phone(trans('Phone'));
        $grid->status(trans('Risk'))->display(function($risk){
            if($risk === 1){
                $str = "<span class='text-success'><i class='fa fa-circle'></i> Low</span>";
            }elseif ($risk === 0) {
                $str = "<span class='text-danger'><i class='fa fa-circle'></i> High</span>";
            }else{
                $str = "N/A";
            }
            return $str;
        });
        $grid->ip_address(trans('IP Address'));
        $grid->created_at(trans('Created at'));
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            if (!LoginAdmin::user()->inRoles(['administrator', 'manager'])){
                $actions->disableEdit();            
            }
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $batch) {
                $batch->disableDelete();
                $batch->add("Send Leads", new BulkEmailLead());
            });

            $users= AdminUser::select(['id','name'])->get();
            $options= "";
            foreach ($users as $user) {
                $options .= "<option value='". $user->id ."'>". $user->name ."</option>";
            }
            $tools->append('<div class="modal fade" id="bulkMail" data-controls-modal="bulkMail" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="bulkMail">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button id="cancelSmallBtn" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Send Leads Email</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="'.route("lead.bulk.email").'" method="POST">
                                      <input type="hidden" name="lead_ids" id="lead_ids" />'. csrf_field() .'

                                      <div class="form-group">
                                        <label for="user">Select User</label>
                                        <select id="admin_users" class="c-select form-control" name="user">' .$options . '
                                        </select>
                                      </div>
                                      <div class="form-group text-center">
                                        <h4>OR</h4>
                                      </div>
                                      <div class="form-group">
                                        <label for="email">Enter Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter Email Address" name="email">
                                        <small>Note: This field will override above selected User.</small>
                                      </div>
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>');            
        });
        $grid->filter(function($filter){ 
            $filter->disableIdFilter(); 

            $filter->where(function ($query) {
                $query->where('first_name', 'like', "%{$this->input}%")
                ->orWhere('phone', 'like', "%{$this->input}%")
                ->orWhere('email', 'like', "%{$this->input}%")
                ->orWhere('last_name', 'like', "%{$this->input}%")
                ->orWhere('first_driver_dl', 'like', "%{$this->input}%")
                ->orWhere('second_driver_first_name', 'like', "%{$this->input}%")
                ->orWhere('second_driver_last_name', 'like', "%{$this->input}%")
                ->orWhere('second_driver_dl', 'like', "%{$this->input}%")
                ->orWhere('third_driver_first_name', 'like', "%{$this->input}%")
                ->orWhere('third_driver_last_name', 'like', "%{$this->input}%")
                ->orWhere('third_driver_dl', 'like', "%{$this->input}%")
                ->orWhere('fourth_driver_first_name', 'like', "%{$this->input}%")
                ->orWhere('fourth_driver_last_name', 'like', "%{$this->input}%")
                ->orWhere('fourth_driver_dl', 'like', "%{$this->input}%")
                ->orWhere('fifth_driver_first_name', 'like', "%{$this->input}%")
                ->orWhere('fifth_driver_last_name', 'like', "%{$this->input}%")
                ->orWhere('fifth_driver_dl', 'like', "%{$this->input}%");

            }, 'Search')->placeholder('Enter First name,Last name,Email,Phone or Drivers license');
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
        return view('Admin.Lead.view',['lead' => Lead::find($id),'showIp'=> LoginAdmin::user()->inRoles(['administrator']) , 'updateStatus' => LoginAdmin::user()->inRoles(['administrator', 'manager']),'addNotes' => LoginAdmin::user()->inRoles(['administrator', 'manager','associate'])]);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=0)
    {
        if (!LoginAdmin::user()->inRoles(['administrator', 'manager'])){
            admin_error('Error','Access denied.');
            return back();
        }        
        $zipcodes = CommonMethod::getZipcodeInfo();
        $zipJson = json_encode($zipcodes);
        $script = <<<SCRIPT
                    var zipcodes = $zipJson;
                    $('#zipcode').change(function(e){
                        $("#city").val("");
                        if($(this).val()){
                            $("#city").val(zipcodes[$(this).val()]);
                        }
                    });
                    
                    $("select[select_class=year]").on("change",function(){
                        var parent = $(this).closest('.row');
                        var year =  $(this).val();
                        var target= $(this).data('target');
                        parent.find("select[select_class=" + target + "]").find("option").remove();
                        $.get("/ajax/makes/"+year).then(function(data){

                            var options = $.map(data, function (d) {
                                d.id = d.make;
                                d.text = d.make;
                                return d;
                            });
                            options = [{"id": "", "text": "Select Make"}].concat(options);
                            parent.find("select[select_class=" + target + "]").select2({data: options});
                        })
                    });
                    $("select[select_class=make]").on("change",function(e){
                        var parent = $(this).closest('.row');
                        var make = $(this).val();
                        var year =  parent.find("select[select_class=year]").val();
                        var target= $(this).data('target');
                        parent.find("select[select_class=" + target + "]").find("option").remove();
                        $.get("/ajax/models/"+year+"/" + make).then(function(data){
                            var options = $.map(data, function (d) {
                                d.id = d.vmodel;
                                d.text = d.vmodel;
                                return d;
                            })
                            options = [{"id": "", "text": "Select Model"}].concat(options);
                            parent.find("select[select_class=" + target + "]").select2({data: options});
                        })
                    });
                    $("select[select_class=model]").on("change",function(e){
                        var parent = $(this).closest('.row');
                        var model = $(this).val();
                        var year =  parent.find("select[select_class=year]").val();
                        var make =  parent.find("select[select_class=make]").val();
                        var target= $(this).data('target');
                        parent.find("select[select_class=" + target + "]").find("option").remove();
                        $.get("/ajax/trims/" + year + "/" + make + "/" + model).then(function(data){
                            var options = $.map(data, function (d) {
                                d.id = d.trim_1;
                                d.text = d.trim_1;
                                return d;
                            })
                            options = [{"id": "", "text": "Select Trim"}].concat(options);
                            parent.find("select[select_class=" + target + "]").select2({data: options});
                        })
                    });                      

SCRIPT;

        Admin::script($script);

        $zipcodes = array_keys($zipcodes);
        $yr = CommonMethod::getYears();
        foreach ($yr as $y) {
            $years[$y->year] = $y->year;
        }
        $first_v = ['make' => [], 'model' => [],'trim' => []];
        $second_v = ['make' => [], 'model' => [],'trim' => []];
        $third_v = ['make' => [], 'model' => [],'trim' => []];
        $fourth_v = ['make' => [], 'model' => [],'trim' => []];
        $fifth_v = ['make' => [], 'model' => [],'trim' => []];

        if($id>0){
            $lead = Lead::findOrFail($id);
            $first_v = ['make' => [$lead['first_vehicle_make']], 'model' => [$lead['first_vehicle_model']],'trim' => [$lead['first_vehicle_trim']]];
            $second_v = ['make' => [$lead['second_vehicle_make']], 'model' => [$lead['second_vehicle_model']],'trim' => [$lead['second_vehicle_trim']]];
            $third_v = ['make' => [$lead['third_vehicle_make']], 'model' => [$lead['third_vehicle_model']],'trim' => [$lead['third_vehicle_trim']]];
            $fourth_v = ['make' => [$lead['fourth_vehicle_make']], 'model' => [$lead['fourth_vehicle_model']],'trim' => [$lead['fourth_vehicle_trim']]];
            $fifth_v = ['make' => [$lead['fifth_vehicle_make']], 'model' => [$lead['fifth_vehicle_model']],'trim' => [$lead['fifth_vehicle_trim']]];
        }

        $form = new Form(new Lead);
        $form->tab('CONTACT INFORMATION', function ($form) use($zipcodes) {
            $form->row(function($row){
                $row->width(6)->text('first_name', trans('First Name'))->rules('required');
                $row->width(6)->text('last_name', trans('Last Name'))->rules('required');
            });
            $form->row(function($row){
                $row->width(6)->text('phone', trans('Phone'))->rules('required|numeric');
                $row->width(6)->email('email', trans('Email'))->rules('required');
            });
            $form->row(function($row) use($zipcodes){
                $row->width(6)->text('street', trans('Street'))->rules('required');
                $row->width(6)->select('zip', trans('Zipcode'))->attribute(["id"=>"zipcode"])->options(array_combine($zipcodes, $zipcodes))->rules('required');
            });                
            $form->row(function($row){
                $row->width(6)->text('city', trans('City'))->attribute(["id" =>"city", 'readonly'=>'readonly','disabled' => "disabled"])->rules('required');
                $row->width(6)->text('state', trans('State'))->attribute(['readonly'=>'readonly','disabled' => "disabled",'value' => "California"])->rules('required');
            });
            $form->row(function($row){
                $row->width(6)->radio('married',trans('Married'))->options([1=>'Yes',0=>'No'])->rules("required");
                $row->width(6)->radio('children',trans('Children'))->options([1=>'Yes',0=>'No'])->rules("required");
                $row->width(6)->radio('homeowner',trans('Homeowner'))->options(['owner'=>'Owner','renter'=>'Renter'])->rules("required");
                $row->width(6)->radio('bundled',trans('Bundled'))->options([1=>'yes',0=>'No'])->rules("required"); 
            });       
        })->tab('VEHICLES', function ($form) use($years,$first_v,$second_v,$third_v,$fourth_v,$fifth_v){
            $form->row(function($row) use($years,$first_v){
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>First Vehicle</h4></div>"
                );
                $row->width(6)->select('first_vehicle_year', trans('Year'))->options($years)->rules('required')->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('first_vehicle_make', trans('Make'))->options($first_v['make'])->rules('required')->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('first_vehicle_model', trans('Model'))->options($first_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"])->rules('required');
                $row->width(6)->select('first_vehicle_trim', trans('Trim'))->options($first_v['trim'])->attribute(['select_class'=>"trim"])->rules('required');
                $row->width(6)->text('first_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('first_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased'])->rules("required");
                $row->width(12)->radio('first_vehicle_uses',trans('Owenership'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm'])->rules("required");
                $row->width(12)->radio('first_vehicle_mileage',trans('Owenership'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000'])->rules("required");
            });
            $form->row(function($row) use($years,$second_v){
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Second Vehicle</h4></div>"
                );
                $row->width(6)->select('second_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('second_vehicle_make', trans('Make'))->options($second_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('second_vehicle_model', trans('Model'))->options($second_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('second_vehicle_trim', trans('Trim'))->options($second_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('second_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('second_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('second_vehicle_uses',trans('Owenership'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('second_vehicle_mileage',trans('Owenership'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
            });
            $form->row(function($row) use($years,$third_v){
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Third Vehicle</h4></div>"
                );
                $row->width(6)->select('third_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('third_vehicle_make', trans('Make'))->options($third_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('third_vehicle_model', trans('Model'))->options($third_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('third_vehicle_trim', trans('Trim'))->options($third_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('third_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('third_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('third_vehicle_uses',trans('Owenership'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('third_vehicle_mileage',trans('Owenership'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
            });            
            $form->row(function($row) use($years,$fourth_v){
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Fourth Vehicle</h4></div>"
                );
                $row->width(6)->select('fourth_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('fourth_vehicle_make', trans('Make'))->options($fourth_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('fourth_vehicle_model', trans('Model'))->options($fourth_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('fourth_vehicle_trim', trans('Trim'))->options($fourth_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('fourth_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('fourth_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('fourth_vehicle_uses',trans('Owenership'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('fourth_vehicle_mileage',trans('Owenership'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
            }); 
            $form->row(function($row) use($years,$fifth_v){
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Fifth Vehicle</h4></div>"
                );
                $row->width(6)->select('fifth_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('fifth_vehicle_make', trans('Make'))->options($fifth_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('fifth_vehicle_model', trans('Model'))->options($fifth_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('fifth_vehicle_trim', trans('Trim'))->options($fifth_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('fifth_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('fifth_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('fifth_vehicle_uses',trans('Owenership'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('fifth_vehicle_mileage',trans('Owenership'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
            });                      
        })->tab('DRIVERS', function ($form){
            $st = CommonMethod::getStates();
            $states = array_combine($st,$st);
            $form->row(function($row) use($states){
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>First Driver</h4></div>"
                );
                $row->width(6)->text('first_driver_first_name',trans('First Name'))->rules('required');
                $row->width(6)->text('first_driver_last_name',trans('Last Name'))->rules('required');
                $row->width(6)->text('first_driver_dl',trans('Driving License Number'))->rules('required');

                $row->width(3)->date('first_driver_dob',trans('Date Of Birth'))->rules("required");
                $row->width(3)->radio('first_driver_gender',trans('Gender'))->options(['Male'=> 'Male','Female'=>'Female','Non-Binary' => 'Non-Binary'])->rules("required");
                $row->width(6)->select('first_driver_state', trans("State"))->options($states)->rules('required');
            });
            $form->row(function($row) use($states){
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Second Driver</h4></div>"
                );
                $row->width(6)->text('second_driver_first_name',trans('First Name'));
                $row->width(6)->text('second_driver_last_name',trans('Last Name'));
                $row->width(6)->text('second_driver_dl',trans('Driving License Number'));

                $row->width(3)->date('second_driver_dob',trans('Date Of Birth'));
                $row->width(3)->radio('second_driver_gender',trans('Gender'))->options(['Male'=> 'Male','Female'=>'Female','Non-Binary' => 'Non-Binary']);
                $row->width(6)->select('second_driver_state', trans("State"))->options($states);
            });
            $form->row(function($row) use($states){
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Third Driver</h4></div>"
                );
                $row->width(6)->text('third_driver_first_name',trans('First Name'));
                $row->width(6)->text('third_driver_last_name',trans('Last Name'));
                $row->width(6)->text('third_driver_dl',trans('Driving License Number'));

                $row->width(3)->date('third_driver_dob',trans('Date Of Birth'));
                $row->width(3)->radio('third_driver_gender',trans('Gender'))->options(['Male'=> 'Male','Female'=>'Female','Non-Binary' => 'Non-Binary']);
                $row->width(6)->select('third_driver_state', trans("State"))->options($states);
            });
            $form->row(function($row) use($states){
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Fourth Driver</h4></div>"
                );
                $row->width(6)->text('fourth_driver_first_name',trans('First Name'));
                $row->width(6)->text('fourth_driver_last_name',trans('Last Name'));
                $row->width(6)->text('fourth_driver_dl',trans('Driving License Number'));

                $row->width(3)->date('fourth_driver_dob',trans('Date Of Birth'));
                $row->width(3)->radio('fourth_driver_gender',trans('Gender'))->options(['Male'=> 'Male','Female'=>'Female','Non-Binary' => 'Non-Binary']);
                $row->width(6)->select('fourth_driver_state', trans("State"))->options($states);
            });
            $form->row(function($row) use($states){
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Fifth Driver</h4></div>"
                );
                $row->width(6)->text('fifth_driver_first_name',trans('First Name'));
                $row->width(6)->text('fifth_driver_last_name',trans('Last Name'));
                $row->width(6)->text('fifth_driver_dl',trans('Driving License Number'));

                $row->width(3)->date('fifth_driver_dob',trans('Date Of Birth'));
                $row->width(3)->radio('fifth_driver_gender',trans('Gender'))->options(['Male'=> 'Male','Female'=>'Female','Non-Binary' => 'Non-Binary']);
                $row->width(6)->select('fifth_driver_state', trans("State"))->options($states);
            });                                                
        })->tab('COVERAGE', function ($form){
            $form->row(function($row){
                $row->width(4)->select('body_injury',trans('Bodily Injury'))->options(["15-30" =>"$15k/$30k","25-50"=>"$25k/$50k","30-60"=>"$30k/$60k","50-100"=>"$50k/$100k","100-300"=>"$100k/$300k","250-500"=>"$250k/$500k","500-1000"=>"$500k/$1Mil"])->rules('required');
                $row->width(4)->select('deduct',trans('Deductible'))->options(["250" => "$250", "500" => "$500", "1000" => "$1000"])->rules('required');
                $row->width(4)->select('medical',trans('Medical'))->options(["0" => "$0", "5000" => "$5000", "10000" => "$10000"])->rules('required');
            });
            $form->row(function($row){
                $row->width(4)->radio('towing',trans('Towing'))->options(["1" => "Yes", "0" => "No"])->rules('required');
                $row->width(4)->radio('uninsured',trans('Uninsured'))->options(["1" => "Yes", "0" => "No"])->rules('required');
                $row->width(4)->radio('rental',trans('Rental'))->options(["1" => "Yes", "0" => "No"])->rules('required');
            });            
        })->tab('HISTORY', function ($form){
            $form->row(function($row){
                $insuranceComp =  CommonMethod::getInsuranceCompanies();
                $row->width(4)->radio('previous_insurance',trans('Have you had auto insurance in the past 30 days?'))->options(["1" => "Yes", "0" => "No"])->rules('required');
                $row->width(4)->select('duration',trans('How long have you continuously had auto insurance?'))->options(["0-1" => "Less than a year", "1-2" => "1 to 2 years","2-3"=>"2 to 3 years",'4+'=>"4+ years"])->default("")->attribute(["id"=>"duration"]);
                $row->width(4)->select('current_insurance',trans('Current Auto Insurance'))->options(array_combine($insuranceComp, $insuranceComp))->attribute(["id"=>"current_insurance"]);
            });
            $form->row(function($row){
                $row->width(12)->html("<h4 class='col-xs-12'>Has anyone on this policy had:</h4>");
                $row->width(12)->radio('at_fault',trans('An at-fault accident in the past three (3) years?'))->options(["1" => "Yes", "0" => "No"])->rules('required');
                $row->width(12)->radio('tickets',trans('Two (2) or more tickets in the past three (3) years?'))->options(["1" => "Yes", "0" => "No"])->rules('required');
                $row->width(12)->radio('dui',trans('A DUI conviction in the past ten (10) years?'))->options(["1" => "Yes", "0" => "No"])->rules('required');
            });

        })->tab('PREFERENCE', function ($form){
            $form->row(function($row){
                $row->width(6)->select('quality_provides',trans('What is the most important quality you look for when choosing an auto insurer?'))->options(["provides-quality-service"=>"Provides quality service","guidance-with-insurance-decisions"=>"Guidance with insurance decisions","provides-a-local-presence"=>"Provides a local presence","is-a-reputable-company"=>"Is a reputable company","provides-general-representatives-for-customer-care"=>"Provides general representatives for customer care","offers-a-low-price-and-discounts"=>"Offers a low price and discounts","provides-24/7-access-to-insurance-information"=>"Provides 24/7 access to insurance information","provides-an-accountable-point-of-contact"=>"Provides an accountable point of contact","offers-a-thorough-review-of-the-coverage"=>"Offers a thorough review of the coverage","provides-hassle-free-process"=>"Provides hassle-free process","offers-face-to-face-interaction"=>"Offers face-to-face interaction"]);
                $row->width(6)->radio('agent_in_person',trans('Will it be important to you to be able to speak to your local agent in person?'))->options(["1"=> "Yes","0" => "No"]);
            });
            $form->row(function($row){
                $row->width(6)->select('referrer',trans('How did you hear about us?'))->options(["friend-or-family" => "Friend or Family", "auto-dealer" => "Auto Dealer","other"=>"Other"])->default("");
                $row->width(6)->text('referrer_name',trans('Referrer Name'));
            });                        
        });
        return $form;
    }


    public static function getLeadCounts(){
        $leads['today'] = Lead::whereDate('created_at', Carbon::today())->get()->count();
        
        $leads['week'] = Lead::where('created_at', ">", Carbon::today()->subDays(7))->get()->count();
        $leads['month'] = Lead::where('created_at', ">", Carbon::today()->subDays(30))->get()->count();
        $leads['year'] = Lead::whereYear('created_at', date('Y'))->get()->count();
        $leads['total'] = Lead::get()->count();
        return $leads;
    }

    public function updateStatus($id,Request $request){
        if (!LoginAdmin::user()->inRoles(['administrator', 'manager'])){
            admin_error('Error','Access denied.');
            return back();
        }        
        if(isset($request->approve) || isset($request->deny)){
            $lead = Lead::findOrFail($id);
            if($lead['status']){
                admin_error('Error','Request not allowed.');
            }else{                
                $lead['status'] = (isset($request->approve)) ? 1 : 0;
                if($lead->update()){
                    admin_success('Success','Record has been updated.');
                }else{
                    admin_error('Error','Record not updated! Please try again.');
                }
            }
        }else{
            admin_error('Error','Unautorized request.');
        }
        return redirect()->route('leads.show',[$id]);
    }


    public function sendBulkEmail(Request $request){
        if (!LoginAdmin::user()->inRoles(['administrator', 'manager'])){
            admin_error('Error','Access denied.');
            return back();
        }
        $lead_ids = $request->lead_ids;
        
        if(!$request->lead_ids){
            admin_error('Error','Select atleast one record.');
            return back();
        }
        if($request->email){
            $email = $request->email;
        }else{
            $email = AdminUser::select('email')->where('id',$request->user)->get()->first();
            $email = ($email) ? $email->email : $email;
        }
        if($email){
            $leads = Lead::whereIn('id',explode(',', $lead_ids))->get();
            foreach ($leads as $lead) {
                \Mail::send('Admin.Lead.email', ['lead' => $lead],
                function ($message) use($email){
                    $message->to($email)->subject('New Lead - Insurance');
                });            
            }
            admin_success('Success','Email sent.');
        }else{
            admin_error('Error','User not found.');
        }
        return back();
    }

    public function addNotes($lead,Request $request){
        if (!LoginAdmin::user()->inRoles(['administrator', 'manager','associate'])){
            admin_error('Error','Access denied.');
            return back();
        }        
        $valid = request()->validate([
            'notes' => 'required',
        ]);
        $data['user_ip'] = $_SERVER['REMOTE_ADDR'];
        $data['user_id'] = Auth::guard('admin')->user()->id;
        $data['lead_id'] = $lead;
        $data['notes'] = $request->notes;

        if(Note::create($data)){
            admin_success('Success','Notes has been saved.');
        }else{
            admin_error('Error','Notes not saved! Please try again.');
        }
        return back();
    }
}
