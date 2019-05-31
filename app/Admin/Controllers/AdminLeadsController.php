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
        // $data['years'] = CommonMethod::getYears();
        // $data['zipcodes'] = CommonMethod::getZipcodeInfo();
        // $data['carMakes'] = CommonMethod::getCarMakes();
        // $data['carModels'] = CommonMethod::getModels();
        // $data['states'] = CommonMethod::getStates();
        // $data['insuranceComp'] = ["21st Century","AIG","Allstate","Country Financial","Esurance","Farmers Ins","Geico","Liberty Mutual","MetLife","Nationwide","Progressive","State Farm","Other"];
        return $content
        ->header('Create')
        ->description('description')
        // ->body(view('Admin.Lead.new',$data));
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
            $actions->disableEdit();
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
            $tools->disableEdit();
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
        if($id>0){
            $lead = Lead::findOrFail($id);
            $fv['make']=[$lead['first_vehicle_make']];
            $fv['model']=[$lead['first_vehicle_model']];
            $fv['trim']=[$lead['first_vehicle_trim']];
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
            $form->row(function($row) use($zipcodes){
                $row->width(6)->text('city', trans('City'))->attribute(["id" =>"city", 'readonly'=>'readonly','disabled' => "disabled"])->rules('required');
                $row->width(6)->text('state', trans('State'))->attribute(['readonly'=>'readonly','disabled' => "disabled",'value' => "California"])->rules('required');
            });
        })->tab('VEHICLE INFORMATION', function ($form) use($years,$fv){
            $form->row(function($row) use($years,$fv){
                $row->width(12)->html(
                    "<div class='box-header with-border'><h3 class='box-title text-upper box-header'>First Vehicle</h3></div>"
                );
                $row->width(6)->select('first_vehicle_year', trans('Year'))->options($years)->rules('required')->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('first_vehicle_make', trans('Make'))->options($fv['make'])->rules('required')->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('first_vehicle_model', trans('Model'))->options($fv['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"])->rules('required');
                $row->width(6)->select('first_vehicle_trim', trans('Trim'))->options($fv['trim'])->attribute(['select_class'=>"trim"])->rules('required');
                $row->width(6)->text('first_vehicle_vin',trans('Vin'))->rules("required");
                $row->width(12)->radio('first_vehicle_owenership',trans('Owenership'))->options(['Owned','Financed','Leased'])->rules("required");
                $row->width(12)->radio('first_vehicle_uses',trans('Owenership'))->options(['Commute','Pleasure','Business','Farm'])->rules("required");
                $row->width(12)->radio('first_vehicle_mileage',trans('Owenership'))->options(['Less than 5,000','5,000-10,000','10,000-15,000','15,000-20,000','More than 20,000'])->rules("required");
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
