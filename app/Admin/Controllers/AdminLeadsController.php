<?php

namespace App\Admin\Controllers;

use App\Models\Lead;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Carbon\Carbon;
use App\Helpers\CommonMethod;
use Encore\Admin\Admin;
use Encore\Admin\Widgets\Tab;

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
        $grid->ip_address(trans('IP Address'));
        $grid->created_at(trans('Created at'));
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            // $actions->disableEdit();
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
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
        $show = new Show(Lead::findOrFail($id));

        $show->id('ID');
        $show->first_name(trans('First Name'));
        $show->last_name(trans('Last Name'));
        $show->email(trans('Email'));
        $show->phone(trans('Phone'));
        $show->street(trans('Street'));  
        $show->city(trans('City'));    
        $show->state(trans('State'));   
        $show->zip(trans('Zipcode'));         
        $show->married(trans('Married'))->as(function($val){
            return ($val) ? "Yes" : "No";
        });
        $show->children(trans('Children'))->as(function($val){
            return ($val) ? "Yes" : "No";
        });

        $show->homeowner(trans('Homeowner'));
        $show->bundled(trans('Bundled'))->as(function($val){
            return ($val) ? "Yes" : "No";
        });
        $show->first_driver_first_name(trans('First Driver First Name')); 
        $show->first_driver_last_name(trans('First Driver Last Name'));  
        $show->first_driver_dob(trans('First Driver Dob'));        
        $show->first_driver_gender(trans('First Driver Gender'));     
        $show->first_driver_dl(trans('First Driver DL No.'));         
        $show->first_driver_state(trans('First Driver State'));      

        $show->second_driver_first_name(trans('Second Driver First Name')); 
        $show->second_driver_last_name(trans('Second Driver Last Name'));  
        $show->second_driver_dob(trans('Second Driver Dob'));
        $show->second_driver_gender(trans('Second Driver Gender'));
        $show->second_driver_dl(trans('Second Driver DL No'));     
        $show->second_driver_state(trans('Second Driver State')); 

        $show->third_driver_first_name(trans('Third Driver First Name'));    
        $show->third_driver_last_name(trans('Third Driver Last Name'));     
        $show->third_driver_dob(trans('Third Driver Dob'));           
        $show->third_driver_gender(trans('Third Driver Gender'));        
        $show->third_driver_dl(trans('Third Driver DL No'));            
        $show->third_driver_state(trans('Third Driver State'));         

        $show->fourth_driver_first_name(trans('Fourth Driver First Name')); 
        $show->fourth_driver_last_name(trans('Fourth Driver Last Name'));
        $show->fourth_driver_dob(trans('Fourth Driver Dob'));
        $show->fourth_driver_gender(trans('Fourth Driver Gender'));
        $show->fourth_driver_dl(trans('Fourth Driver DL No'));
        $show->fourth_driver_state(trans('Fourth Driver State'));

        $show->fifth_driver_first_name(trans('Fifth Driver First Name')); 
        $show->fifth_driver_last_name(trans('Fifth Driver Last Name'));
        $show->fifth_driver_dob(trans('Fifth Driver Dob'));
        $show->fifth_driver_gender(trans('Fifth Driver Gender'));
        $show->fifth_driver_dl(trans('Fifth Driver DL No'));
        $show->fifth_driver_state(trans('Fifth Driver State'));

        $show->first_vehicle_year(trans('First Vehicle Year'));
        $show->first_vehicle_make(trans('First Vehicle Make'));

        $show->first_vehicle_model(trans('First Vehicle Model'));      
        $show->first_vehicle_trim(trans('First Vehicle Trim'));      
        $show->first_vehicle_vin(trans('First Vehicle Vim'));       
        $show->first_vehicle_owenership(trans('First Vehicle Owenership'));
        $show->first_vehicle_uses(trans('First Vehicle Uses'));      
        $show->first_vehicle_mileage(trans('First Vehicle Mileage'));   


        $show->second_vehicle_year(trans('Second Vehicle Year'));
        $show->second_vehicle_make(trans('Second Vehicle Make'));
        $show->second_vehicle_model(trans('Second Vehicle Model'));     
        $show->second_vehicle_trim(trans('Second Vehicle Trim'));     
        $show->second_vehicle_vin(trans('Second Vehicle Vim'));       
        $show->second_vehicle_owenership(trans('Second Vehicle Owenership'));
        $show->second_vehicle_uses(trans('Second Vehicle Uses'));     
        $show->second_vehicle_mileage(trans('Second Vehicle Mileage'));   


        $show->third_vehicle_year(trans('Third Vehicle Year'));
        $show->third_vehicle_make(trans('Third Vehicle Make'));
        $show->third_vehicle_model(trans('Third Vehicle Model'));     
        $show->third_vehicle_trim(trans('Third Vehicle Trim'));     
        $show->third_vehicle_vin(trans('Third Vehicle Vim'));       
        $show->third_vehicle_owenership(trans('Third Vehicle Owenership'));
        $show->third_vehicle_uses(trans('Third Vehicle Uses'));     
        $show->third_vehicle_mileage(trans('Third Vehicle Mileage'));   

        $show->fourth_vehicle_year(trans('Fourth Vehicle Year'));
        $show->fourth_vehicle_make(trans('Fourth Vehicle Make'));
        $show->fourth_vehicle_model(trans('Fourth Vehicle Model'));     
        $show->fourth_vehicle_trim(trans('Fourth Vehicle Trim'));     
        $show->fourth_vehicle_vin(trans('Fourth Vehicle Vim'));       
        $show->fourth_vehicle_owenership(trans('Fourth Vehicle Owenership'));
        $show->fourth_vehicle_uses(trans('Fourth Vehicle Uses'));     
        $show->fourth_vehicle_mileage(trans('Fourth Vehicle Mileage'));   

        $show->fifth_vehicle_year(trans('Fifth Vehicle Year'));
        $show->fifth_vehicle_make(trans('Fifth Vehicle Make'));
        $show->fifth_vehicle_model(trans('Fifth Vehicle Model'));     
        $show->fifth_vehicle_trim(trans('Fifth Vehicle Trim'));     
        $show->fifth_vehicle_vin(trans('Fifth Vehicle Vim'));       
        $show->fifth_vehicle_owenership(trans('Fifth Vehicle Owenership'));
        $show->fifth_vehicle_uses(trans('Fifth Vehicle Uses'));     
        $show->fifth_vehicle_mileage(trans('Fifth Vehicle Mileage'));   



        $show->liability(trans('Liability'));           
        $show->body_injury(trans('Body Injury'))->as(function($val){
            return $val." $";
        });         
        $show->deduct(trans('Deduct'));              
        $show->medical(trans('Medical'));             
        $show->towing(trans('Towing'))->as(function($val){
            return ($val) ? "Yes" : "No";
        });              
        $show->uninsured(trans('Uninsured'))->as(function($val){
            return ($val) ? "Yes" : "No";
        });           
        $show->rental(trans('Rental'))->as(function($val){
            return ($val) ? "Yes" : "No";
        });              
        $show->previous_insurance(trans('Previous Insurance'))->as(function($val){
            return ($val) ? "Yes" : "No";
        });  
        $show->current_insurance(trans('Current Insurance'));   
        $show->duration(trans('Duration'));            
        $show->at_fault(trans('At Fault'))->as(function($val){
            return ($val) ? "Yes" : "No";
        });            
        $show->tickets(trans('Tickets'))->as(function($val){
            return ($val) ? "Yes" : "No";
        });             
        $show->dui(trans('Dui'))->as(function($val){
            return ($val) ? "Yes" : "No";
        });                 
        $show->quality_provides(trans('Quality Provides'));    
        $show->agent_in_person(trans('Agent In Person'))->as(function($val){
            return ($val) ? "Yes" : "No";
        });    
        $show->referrer(trans('Referrer')); 
        $show->referrer_name(trans('Referrer Name'));       
        $show->ip_address(trans('Ip Address'));          

        $show->created_at(trans('Created at'));
        $show->panel()
        ->tools(function ($tools) {
            // $tools->disableEdit();
            $tools->disableDelete();
        });
        // return $show;
        return view('Admin.Lead.view',['lead' => Lead::find($id)]);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=0)
    {
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
                            })
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
                            debugger
                            var options = $.map(data, function (d) {
                                d.id = d.trim_1;
                                d.text = d.trim_1;
                                return d;
                            })
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
}
