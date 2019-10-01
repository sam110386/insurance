<?php

namespace App\Admin\Controllers;

use App\Models\Lead;
use App\Models\Note;
use App\Models\AdminUser;
use App\Models\Group;
use App\Models\GroupMember;
use App\Helpers\CommonMethod;
use App\Helpers\SendMail;
use App\Http\Controllers\Controller;
use App\Admin\Extensions\Tools\BulkEmailLead;
use App\Admin\Extensions\Tools\BulkLeadAssignment;
use App\Admin\Extensions\Tools\BulkLeadCurrentStatus;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Carbon\Carbon;
use Encore\Admin\Admin;
use Encore\Admin\Facades\Admin as LoginAdmin;
use Encore\Admin\Auth\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use App\Admin\Controllers\LeadAssignmentController;

class AdminLeadsController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index($from = false, $to=false, Content $content)
    {
        return $content
        ->header('Lead Inventory')
        ->description(' ')
        ->body($this->grid($from,$to));
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
        // Check if manager have access for this lead
        $lead = Lead::findOrFail($id);
        $userId = Auth::guard('admin')->user()->id;            
        if(LoginAdmin::user()->inRoles(['associate'])) {
            $access = $this->validateAssoShowAccess($lead,$userId);
            if($access !== true) return $access;
        }
        if(LoginAdmin::user()->inRoles(['manager']) &&  $lead->manager_id != $userId) {        
            admin_error('Error','Access denied.');
            return back();  
        }
        return $content
        ->header('Lead #'.$id)
        ->description(' ')      
        ->body($this->detail($id));
    }

    private function validateAssoShowAccess($lead,$userId){
        if($lead->member_id == $userId){
            return true;
        }
        $memberGroups = GroupMember::where('member_id', $userId)->get()->pluck('group_id');
        if(!empty($memberGroups) && $lead->group_id == $memberGroups[0]){
            return true;
        }
        admin_error('Error','Access denied.');
        return redirect()->route('leads.index');  
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
        // Check if manager have access for this lead
        if(LoginAdmin::user()->inRoles(['manager'])){
            $lead = Lead::findOrFail($id);
            if($lead->manager_id !=Auth::guard('admin')->user()->id){
                admin_error('Error','Access denied.');
                return back();                
            }
        }
        return $content
        ->header('Detail')
        ->description('Edit')
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
    protected function grid($from,$to)
    {   
        $searchText = trans('admin.filter');
        Admin::script("$('#filter-box button.submit').html('<i class=\"fa fa-search\"></i>&nbsp;&nbsp;".$searchText."');");
        Admin::script("$(\"#assignment\").on(\"show.bs.modal\", function (event) {
            $('#assign_to,#assign_id').val('');
            $('#assign_to,#assign_id').select2({ width: '100%' });
            $('#assign_to').on('change',function(){
                $('.ajax-loader').toggleClass('d-none');
                $.get('/admin/api/assignment/list/?q='+ $(this).val(),function(data){
                    $('#assign_id').html(''); 
                    $('#assign_id').append('<option value=\"\">--Select--</option>'); 
                    $.each(data,function(i,d){
                        $('#assign_id').append('<option value=\"' + d.id + '\">' + d.text + '</option>');
                    });
                    $('.ajax-loader').toggleClass('d-none');
                });
            })
        });");
        $grid = new Grid(new Lead);
        if (!LoginAdmin::user()->inRoles(['administrator'])){
            if(LoginAdmin::user()->inRoles(['manager'])){
                $grid->model()->where('manager_id', Auth::guard('admin')->user()->id);
            }else{
                $grid->model()->where('member_id', Auth::guard('admin')->user()->id);
                $memberGroups = GroupMember::where('member_id',Auth::guard('admin')->user()->id)->get()->pluck('group_id');
                if(!empty($memberGroups)){
                    dd($memberGroups);
                    $grid->model()->orWhere('group_id', $memberGroups[0]);
                }
            }
        }

        if($from && $to){
            $grid->model()->whereBetween('created_at',["$from 00:00:00","$to 23:59:59"]);
        }

        $grid = self::advanceSearchConditions($grid);
        if(!Input::get('_sort')) $grid->model()->orderby('id','desc');
        $grid->id('ID')->display(function($text){
            return "<a href='/admin/leads/$this->id' class='text-muted'>$text</a>";
        });
        $grid->first_name(trans('First Name'))->sortable()->display(function($text){
            return "<a href='/admin/leads/$this->id' class='text-muted'>$text</a>";
        });
        $grid->last_name(trans('Last Name'))->sortable()->display(function($text){
            return "<a href='/admin/leads/$this->id' class='text-muted'>$text</a>";
        });
        $grid->email(trans('Email'))->display(function($text){
            return "<a href='/admin/leads/$this->id' class='text-muted'>$text</a>";
        });
        $grid->phone(trans('Phone'))->display(function($phone){
            return "<a href='/admin/leads/$this->id' class='text-muted'>".CommonMethod::phoneNumber($phone)."</a>";
        });
        $grid->status(trans('Risk'))->display(function($risk){
            if($risk === 1){
                $str = "<span class='text-success'><i class='fa fa-circle'></i> Low</span>";
            }elseif ($risk === 0) {
                $str = "<span class='text-danger'><i class='fa fa-circle'></i> High</span>";
            }else{
                $str = "N/A";
            }
            return "<a href='/admin/leads/$this->id' class='text-muted'>" . $str . "</a>";
        });
        $grid->column(trans('Assignment'))->display(function(){
            $member =  ($this->member_id) ? $this->user->name : "";
            $group =  ($this->group_id) ? $this->group->name : "";
            $g_pre = "";
            $g_post = "";
            $str = "NA";
            if($member && $group){
                $g_pre = " (";
                $g_post = ")";
            }
            if($member || $group){
                $str = $member . $g_pre . $group . $g_post;
            }
            return " <a href='/admin/leads/$this->id' class='text-muted'>" . $str . "</a> ";
        });
        // $grid->column(trans('Assign lead'))->display(function(){
        //     return "<a href='javascript:;' data-toggle='modal' data-target='#assignment' data-lead='" . $this->id ."'><i class='fa fa-pencil-square-o'></i></a>";
        // });

        $grid->current_status(trans('Status'))->display(function($current_status){
            switch ($current_status) {
                case 0:
                    $str = "New";
                    break;
                case 1:
                    $str = "Pending";
                    break;
                case 2:
                    $str = "In Progress";
                    break;
                case 3:
                    $str = "Complete";
                    break;
                case 4:
                    $str = "Incomplete";
                    break;
                case 5:
                    $str = "Declined";
                    break;
                case 6:
                    $str = "Transfer";
                    break;
                case 7:
                    $str = "Not Eligible";
                    break;
                default:
                    $str = "New";
                    break;
            }
            return "<a href='/admin/leads/$this->id' class='text-muted'>$str</a>";

        });
        // $grid->ip_address(trans('IP Address'))->display(function($text){
        //     return "<a href='/admin/leads/$this->id' class='text-muted'>$text</a>";
        // });
        $grid->created_at(trans('admin.timestamp'))->sortable('desc')->display(function($text){
            return "<a href='/admin/leads/$this->id' class='text-muted'>$text</a>";
        })->setAttributes(['width' => '180px']);
        $grid->disableActions();
        // $grid->actions(function ($actions) {
        //     $actions->disableDelete();
        //     if (!LoginAdmin::user()->inRoles(['administrator', 'manager'])){
        //         $actions->disableEdit();            
        //     }
        // });
        $grid->disableCreateButton();
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append("<a href='/admin/leads/create' class='btn btn-sm btn-success pull-left mr-1'><i class='fa fa-plus'></i> <span class='hidden-xs'>New</span></a> &nbsp;");
            $tools->append("<a href='". route('lead-advance-search') ."' class='btn btn-sm btn-primary pull-right mr-1'><i class='fa fa-plus'></i> <span class='hidden-xs'>Advance Search</span></a> &nbsp;");
            
            $tools->batch(function (Grid\Tools\BatchActions $batch) {
                $batch->disableDelete();
                $batch->add("Send Leads", new BulkEmailLead());
                if(LoginAdmin::user()->inRoles(['administrator'])){
                    $batch->add("Assign Leads", new BulkLeadAssignment());
                }
                $batch->add("Update Status", new BulkLeadCurrentStatus());
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
                if(LoginAdmin::user()->inRoles(['administrator'])){
                    $tools->append('<div class="modal fade" id="assignment" data-controls-modal="assignment" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="assignment">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Assign Leads</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="'.route("lead.assignment").'" method="POST">
                                      <input type="hidden" name="lead_ids" id="lead_ids" />'. csrf_field() .'
                                      <div class="form-group">
                                        <label for="assign_to">Assign to</label>
                                        <select id="assign_to" class="c-select form-control" name="assign_to" required>
                                        <option value="">--Select--</option>
                                        <option value="group">Group</option>
                                        <option value="member">Associate</option>
                                        </select>
                                      </div>
                                      <div class="form-group ajax-loader text-center d-none">
                                        <div class="lds-facebook">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                      </div>
                                      <div class="form-group ajax-loader">
                                        <label for="assign_id">Select Group/Associate</label>
                                        <select id="assign_id" class="form-control" name="assign_id" required></select>
                                      </div>
                                      <button type="submit" class="btn btn-primary">Assign</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>');
                }
                /* Manager Leads Assign to Associates
                if(LoginAdmin::user()->inRoles(['manager'])){
                    $tools->append('<div class="modal fade" id="assignment" data-controls-modal="assignment" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="assignment">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Assign Leads</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="'.route("lead.assignment").'" method="POST">
                                      <input type="hidden" name="lead_ids" id="lead_ids" />'. csrf_field() .'
                                      <div class="form-group">
                                        <input type="hidden" name="assign_to" value="member" />
                                        </div>
                                      <div class="form-group">
                                        <label for="assign_id">Select Associate</label>
                                        <select id="assign_id" class="form-control" name="assign_id" required></select>
                                      </div>
                                      <button type="submit" class="btn btn-primary">Assign</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>');
                }*/
                $tools->append('<div class="modal fade" id="change_status" data-controls-modal="change_status" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="change_status">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Change Leads Status</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="'.route("lead.bulk_status_update").'" method="POST">
                                      <input type="hidden" name="lead_ids" id="lead_ids" />'. csrf_field() .'
                                      <div class="form-group">
                                        <label for="current_status">Status</label>
                                        <select id="current_status" class="c-select form-control" name="current_status" required>
                                        <option value="">--Select--</option>
                                        <option value="0">New</option>
                                        <option value="1">Pending</option>
                                        <option value="2">In Progress</option>
                                        <option value="3">Complete</option>
                                        <option value="4">Incomplete</option>  
                                        <option value="5">Declined</option>
                                        <option value="6">Transfer</option>  
                                        <option value="7">Not Eligible</option>
                                        </select>
                                      </div>
                                      <button type="submit" class="btn btn-primary">Update Status</button>
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
            }, 'Search by text')->placeholder('Enter First or Last Name, Email, Phone Number, or Drivers License');
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
        $lead = Lead::findOrFail($id);
        // $st = CommonMethod::getStates();
        // $st = array_flip($st);
        // $lead->first_driver_state = $st[$lead->first_driver_state];
        // if($lead->second_driver_state){
        //     $lead->second_driver_state = $st[$lead->second_driver_state];
        // }
        return view('Admin.Lead.view',['lead' => $lead,'showIp'=> LoginAdmin::user()->inRoles(['administrator']) , 'updateStatus' => LoginAdmin::user()->inRoles(['administrator', 'manager']),'addNotes' => LoginAdmin::user()->inRoles(['administrator', 'manager','associate'])]);
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

        $vehicleDefaults = [
            'first_v' => ['make' => [], 'model' => [],'trim' => []],
            'second_v' => ['make' => [], 'model' => [],'trim' => []],
            'third_v' => ['make' => [], 'model' => [],'trim' => []],
            'fourth_v' => ['make' => [], 'model' => [],'trim' => []],
            'fifth_v' => ['make' => [], 'model' => [],'trim' => []],
            'sixth_v' => ['make' => [], 'model' => [],'trim' => []],
            'seventh_v' => ['make' => [], 'model' => [],'trim' => []],
            'eighth_v' => ['make' => [], 'model' => [],'trim' => []],
            'ninth_v' => ['make' => [], 'model' => [],'trim' => []],
            'tenth_v' => ['make' => [], 'model' => [],'trim' => []],
        ];

        if($id>0){
            $lead = Lead::findOrFail($id);
            $vehicleDefaults['first_v'] = ['make' => [$lead['first_vehicle_make'] => $lead['first_vehicle_make']], 'model' => [$lead['first_vehicle_model'] => $lead['first_vehicle_model']],'trim' => [$lead['first_vehicle_trim'] => $lead['first_vehicle_trim']]];
            $vehicleDefaults['second_v'] = ['make' => [$lead['second_vehicle_make']=>$lead['second_vehicle_make']], 'model' => [$lead['second_vehicle_model']=>$lead['second_vehicle_model']],'trim' => [$lead['second_vehicle_trim']=>$lead['second_vehicle_trim']]];
            $vehicleDefaults['third_v'] = ['make' => [$lead['third_vehicle_make']=>$lead['third_vehicle_make']], 'model' => [$lead['third_vehicle_model']=>$lead['third_vehicle_model']],'trim' => [$lead['third_vehicle_trim']=>$lead['third_vehicle_trim']]];
            $vehicleDefaults['fourth_v'] = ['make' => [$lead['fourth_vehicle_make']=>$lead['fourth_vehicle_make']], 'model' => [$lead['fourth_vehicle_model']=>$lead['fourth_vehicle_model']],'trim' => [$lead['fourth_vehicle_trim']=>$lead['fourth_vehicle_trim']]];
            $vehicleDefaults['fifth_v'] = ['make' => [$lead['fifth_vehicle_make']=>$lead['fifth_vehicle_make']], 'model' => [$lead['fifth_vehicle_model']=>$lead['fifth_vehicle_model']],'trim' => [$lead['fifth_vehicle_trim']=>$lead['fifth_vehicle_trim']]];
            $vehicleDefaults['sixth_v'] = ['make' => [$lead['sixth_vehicle_make']=>$lead['sixth_vehicle_make']], 'model' => [$lead['sixth_vehicle_model']=>$lead['sixth_vehicle_model']],'trim' => [$lead['sixth_vehicle_trim']=>$lead['sixth_vehicle_trim']]];
            $vehicleDefaults['seventh_v'] = ['make' => [$lead['seventh_vehicle_make']=>$lead['seventh_vehicle_make']], 'model' => [$lead['seventh_vehicle_model']=>$lead['seventh_vehicle_make']],'trim' => [$lead['seventh_vehicle_trim']=>$lead['seventh_vehicle_trim']]];
            $vehicleDefaults['eighth_v'] = ['make' => [$lead['eighth_vehicle_make']=>$lead['eighth_vehicle_make']], 'model' => [$lead['eighth_vehicle_model']=>$lead['eighth_vehicle_model']],'trim' => [$lead['eighth_vehicle_trim']=>$lead['eighth_vehicle_trim']]];
            $vehicleDefaults['ninth_v'] = ['make' => [$lead['ninth_vehicle_make']=>$lead['ninth_vehicle_make']], 'model' => [$lead['ninth_vehicle_model']=>$lead['ninth_vehicle_model']],'trim' => [$lead['ninth_vehicle_trim']=>$lead['ninth_vehicle_trim']]];
            $vehicleDefaults['tenth_v'] = ['make' => [$lead['tenth_vehicle_make']=>$lead['tenth_vehicle_make']], 'model' => [$lead['tenth_vehicle_model']=>$lead['tenth_vehicle_model']],'trim' => [$lead['tenth_vehicle_trim']=>$lead['tenth_vehicle_trim']]];
        }

        $members = [];
        if(LoginAdmin::user()->inRoles(['manager']) && $id>0){
            $gMembers = GroupMember::where('group_id',$lead['group_id'])->with('user')->get();
            foreach ($gMembers as $member) {
                $members[$member->user->id] = $member->user->name;
            }
        }

        $form = new Form(new Lead);
        $form->tab('CONTACT INFORMATION', function ($form) use($zipcodes) {
            $form->row(function($row){
                $row->width(6)->text('first_name', trans('First Name'))->rules('required');
                $row->width(6)->text('last_name', trans('Last Name'))->rules('required');
            });
            $form->row(function($row){
                $row->width(6)->mobile('phone', trans('Phone'))->options(['mask' => '(999) 999-9999'])->attribute(['style' => 'width:100%;'])->rules('required|regex:/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/',['regex'=> 'Invalid phone number']);
                $row->width(6)->email('email', trans('Email'))->rules('required');
            });
            $form->row(function($row) use($zipcodes){
                $row->width(6)->text('street', trans('Street'))->rules('required');
                $row->width(6)->select('zip', trans('Zipcode'))->attribute(["id"=>"zipcode"])->options(array_combine($zipcodes, $zipcodes))->rules('required');
            });                
            $form->row(function($row){
                $row->width(6)->text('city', trans('City'))->attribute(["id" =>"city", 'readonly'=>'readonly'])->rules('required');
                $row->width(6)->text('state', trans('State'))->attribute(['readonly'=>'readonly','value' => "California"])->rules('required');
            });
            $form->row(function($row){
                $row->width(6)->radio('married',trans('Married'))->options([1=>'Yes',0=>'No'])->rules("required");
                $row->width(6)->radio('children',trans('Children'))->options([1=>'Yes',0=>'No'])->rules("required");
                $row->width(6)->radio('homeowner',trans('Homeowner'))->options(['owner'=>'Owner','renter'=>'Renter'])->rules("required");
                $row->width(6)->radio('bundled',trans('Bundled'))->options([1=>'yes',0=>'No'])->rules("required"); 
            });        
        })->tab('VEHICLES', function ($form) use($years,$vehicleDefaults){
            $form->row(function($row) use($years,$vehicleDefaults){
                $first_v = $vehicleDefaults['first_v'];
                // dd($first_v);
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>First Vehicle</h4></div>"
                );
                $row->width(6)->select('first_vehicle_year', trans('Year'))->options($years)->rules('required')->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('first_vehicle_make', trans('Make'))->options($first_v['make'])->rules('required')->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('first_vehicle_model', trans('Model'))->options($first_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"])->rules('required');
                $row->width(6)->select('first_vehicle_trim', trans('Trim'))->options($first_v['trim'])->attribute(['select_class'=>"trim"])->rules('required');
                $row->width(6)->text('first_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('first_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased'])->rules("required");
                $row->width(12)->radio('first_vehicle_uses',trans('Uses'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm'])->rules("required");
                $row->width(12)->radio('first_vehicle_mileage',trans('Mileage'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000'])->rules("required");
            });
            $form->row(function($row) use($years,$vehicleDefaults){
                $second_v = $vehicleDefaults['second_v'];
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Second Vehicle</h4></div>"
                );
                $row->width(6)->select('second_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('second_vehicle_make', trans('Make'))->options($second_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('second_vehicle_model', trans('Model'))->options($second_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('second_vehicle_trim', trans('Trim'))->options($second_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('second_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('second_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('second_vehicle_uses',trans('Uses'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('second_vehicle_mileage',trans('Mileage'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
            });
            $form->row(function($row) use($years,$vehicleDefaults){
                $third_v = $vehicleDefaults['third_v'];      
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Third Vehicle</h4></div>"
                );
                $row->width(6)->select('third_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('third_vehicle_make', trans('Make'))->options($third_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('third_vehicle_model', trans('Model'))->options($third_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('third_vehicle_trim', trans('Trim'))->options($third_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('third_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('third_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('third_vehicle_uses',trans('Uses'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('third_vehicle_mileage',trans('Mileage'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
            });            
            $form->row(function($row) use($years,$vehicleDefaults){
                $fourth_v = $vehicleDefaults['fourth_v'];
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Fourth Vehicle</h4></div>"
                );
                $row->width(6)->select('fourth_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('fourth_vehicle_make', trans('Make'))->options($fourth_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('fourth_vehicle_model', trans('Model'))->options($fourth_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('fourth_vehicle_trim', trans('Trim'))->options($fourth_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('fourth_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('fourth_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('fourth_vehicle_uses',trans('Uses'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('fourth_vehicle_mileage',trans('Mileage'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
            }); 
            $form->row(function($row) use($years,$vehicleDefaults){
                $fifth_v = $vehicleDefaults['fifth_v'];
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Fifth Vehicle</h4></div>"
                );
                $row->width(6)->select('fifth_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('fifth_vehicle_make', trans('Make'))->options($fifth_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('fifth_vehicle_model', trans('Model'))->options($fifth_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('fifth_vehicle_trim', trans('Trim'))->options($fifth_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('fifth_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('fifth_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('fifth_vehicle_uses',trans('Uses'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('fifth_vehicle_mileage',trans('Mileage'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
            });
            $form->row(function($row) use($years,$vehicleDefaults){
                $sixth_v = $vehicleDefaults['sixth_v'];
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>sixth Vehicle</h4></div>"
                );
                $row->width(6)->select('sixth_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('sixth_vehicle_make', trans('Make'))->options($sixth_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('sixth_vehicle_model', trans('Model'))->options($sixth_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('sixth_vehicle_trim', trans('Trim'))->options($sixth_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('sixth_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('sixth_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('sixth_vehicle_uses',trans('Uses'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('sixth_vehicle_mileage',trans('Mileage'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
            });
            $form->row(function($row) use($years,$vehicleDefaults){
                $seventh_v = $vehicleDefaults['seventh_v'];
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>seventh Vehicle</h4></div>"
                );
                $row->width(6)->select('seventh_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('seventh_vehicle_make', trans('Make'))->options($seventh_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('seventh_vehicle_model', trans('Model'))->options($seventh_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('seventh_vehicle_trim', trans('Trim'))->options($seventh_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('seventh_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('seventh_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('seventh_vehicle_uses',trans('Uses'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('seventh_vehicle_mileage',trans('Mileage'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
            });
            $form->row(function($row) use($years,$vehicleDefaults){
                $eighth_v = $vehicleDefaults['eighth_v'];
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>eighth Vehicle</h4></div>"
                );
                $row->width(6)->select('eighth_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('eighth_vehicle_make', trans('Make'))->options($eighth_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('eighth_vehicle_model', trans('Model'))->options($eighth_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('eighth_vehicle_trim', trans('Trim'))->options($eighth_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('eighth_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('eighth_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('eighth_vehicle_uses',trans('Uses'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('eighth_vehicle_mileage',trans('Mileage'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
            });
            $form->row(function($row) use($years,$vehicleDefaults){
                $ninth_v = $vehicleDefaults['ninth_v'];
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>ninth Vehicle</h4></div>"
                );
                $row->width(6)->select('ninth_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('ninth_vehicle_make', trans('Make'))->options($ninth_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('ninth_vehicle_model', trans('Model'))->options($ninth_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('ninth_vehicle_trim', trans('Trim'))->options($ninth_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('ninth_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('ninth_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('ninth_vehicle_uses',trans('Uses'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('ninth_vehicle_mileage',trans('Mileage'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
            });
            $form->row(function($row) use($years,$vehicleDefaults){
                $tenth_v = $vehicleDefaults['tenth_v'];
                $row->width(12)->html(
                    "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>tenth Vehicle</h4></div>"
                );
                $row->width(6)->select('tenth_vehicle_year', trans('Year'))->options($years)->attribute(['select_class'=>"year", 'data-target' => "make"]);
                $row->width(6)->select('tenth_vehicle_make', trans('Make'))->options($tenth_v['make'])->attribute(['select_class'=>"make", 'data-target' => "model"]);
                $row->width(6)->select('tenth_vehicle_model', trans('Model'))->options($tenth_v['model'])->attribute(['select_class'=>"model", 'data-target' => "trim"]);
                $row->width(6)->select('tenth_vehicle_trim', trans('Trim'))->options($tenth_v['trim'])->attribute(['select_class'=>"trim"]);
                $row->width(6)->text('tenth_vehicle_vin',trans('Vin'));
                $row->width(12)->radio('tenth_vehicle_owenership',trans('Owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
                $row->width(12)->radio('tenth_vehicle_uses',trans('Uses'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm']);
                $row->width(12)->radio('tenth_vehicle_mileage',trans('Mileage'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000']);
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
                $row->width(3)->radio('first_driver_gender',trans('Gender'))->options(['Male'=> 'Male','Female'=>'Female'])->rules("required");
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
                $row->width(3)->radio('second_driver_gender',trans('Gender'))->options(['Male'=> 'Male','Female'=>'Female']);
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
                $row->width(3)->radio('third_driver_gender',trans('Gender'))->options(['Male'=> 'Male','Female'=>'Female']);
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
                $row->width(3)->radio('fourth_driver_gender',trans('Gender'))->options(['Male'=> 'Male','Female'=>'Female']);
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
                $row->width(3)->radio('fifth_driver_gender',trans('Gender'))->options(['Male'=> 'Male','Female'=>'Female']);
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
                $row->width(6)->select('quality_provides',trans('What is the most important quality you look for when choosing an auto insurer?'))->options(["provides-quality-service"=>"Provides quality service","is-a-reputable-company"=>"Is a reputable company","offers-a-low-price-and-discounts"=>"Offers a low price and discounts"]);
                $row->width(6)->radio('agent_in_person',trans('Will it be important to you to be able to speak to your local agent in person?'))->options(["1"=> "Yes","0" => "No"]);
            });
            $form->row(function($row){
                $row->width(6)->select('referrer',trans('How did you hear about us?'))->options(["Email" => "Email", "Social Media" => "Social Media","Google / Yahoo / Bing" => "Google / Yahoo / Bing","Other"=>"Other"])->default("");
                $row->width(6)->text('referrer_name',trans('Referrer Name'));
            });                        
        })->tab('ASSIGNMENTS', function ($form) use($members,$id){
            $form->hidden('ip_address')->value($_SERVER['REMOTE_ADDR']);
            $form->row(function($row)use($members,$id){
                if (LoginAdmin::user()->inRoles(['administrator'])){
                    $row->width(12)->html(
                        "<div class='col-xs-12 bg-primary'><h4 class='text-uppercase'>Assign Lead to Group or Associate</h4></div>"
                    );
                    $row->width(6)->select('assign_type', trans('Assign to'))->options(['group' => 'Group', 'associate' => 'Associate'])->load('assign_id', '/admin/api/assignment/list');
                    $row->width(6)->select('assign_id', trans('Select Group/Associate'))->options($members);
                }else if (LoginAdmin::user()->inRoles(['manager'])){
                    $row->width(6)->select('assign_id', trans('Select Associate'))->options($members);
                }else{}
    
                if($id){
                    $leadRecord = Lead::findOrFail($id);
                    $member =  ($leadRecord->member_id) ? $leadRecord->user->name : "";
                    $group =  ($leadRecord->group_id) ? $leadRecord->group->name : "";
                    $g_pre = "";
                    $g_post = "";
                    $str = "NA";
                    if($member && $group){
                        $g_pre = " (";
                        $g_post = ")";
                    }
                    if($member || $group){
                        $str = $member . $g_pre . $group . $g_post;
                    }
                    $row->width(12)->html(
                        "<div class='col-xs-12'><h4 class='text-uppercase'>Current assignment: {$str}</h4></div>"
                    );                    
                }
            });            
        });
        $form->saved(function (Form $form) use($id){
            $assign_id = request()->assign_id;
            if (LoginAdmin::user()->inRoles(['administrator'])){
                if(request()->assign_type=='group'){
                    return LeadAssignmentController::assignLeadToGroup(request()->route('lead'),$assign_id);
                }elseif(request()->assign_type=='associate'){
                    return  LeadAssignmentController::adminAssignLeadToUser(request()->route('lead'),$assign_id);
                }else{}
            }elseif(LoginAdmin::user()->inRoles(['manager'])){
                    return  LeadAssignmentController::adminAssignLeadToUser(request()->route('lead'),$assign_id);
            }else{}

        });        
        $form->submitted(function (Form $form) {
            $form->ignore('assign_type');
            $form->ignore('assign_id');
            $form->ip_address = $_SERVER["REMOTE_ADDR"];
        });
        return $form;
    }

    public static function getLeadCounts(){

        $leads['today']['total'] = Lead::whereDate('created_at', Carbon::today())->get()->count();
        $leads['today']['low'] = Lead::where('status',1)->whereDate('created_at', Carbon::today())->get()->count();
        $leads['today']['high'] = Lead::where('status',0)->whereDate('created_at', Carbon::today())->get()->count();
        
        $leads['week']['total'] = Lead::where('created_at', ">", Carbon::today()->subDays(7))->get()->count();
        $leads['week']['low'] = Lead::where('status',1)->where('created_at', ">", Carbon::today()->subDays(7))->get()->count();
        $leads['week']['high'] = Lead::where('status',0)->where('created_at', ">", Carbon::today()->subDays(7))->get()->count();


        $leads['month']['total'] = Lead::where('created_at', ">", Carbon::today()->subDays(30))->get()->count();
        $leads['month']['low'] = Lead::where('status',1)->where('created_at', ">", Carbon::today()->subDays(30))->get()->count();
        $leads['month']['high'] = Lead::where('status',0)->where('created_at', ">", Carbon::today()->subDays(30))->get()->count();


        $leads['year']['total'] = Lead::whereYear('created_at', date('Y'))->get()->count();
        $leads['year']['low'] = Lead::where('status',1)->whereYear('created_at', date('Y'))->get()->count();
        $leads['year']['high'] = Lead::where('status',0)->whereYear('created_at', date('Y'))->get()->count();
        
        $leads['lifetime']['total'] = Lead::get()->count();
        $leads['lifetime']['low'] = Lead::where('status',1)->get()->count();
        $leads['lifetime']['high'] = Lead::where('status',0)->get()->count();
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
                    admin_success('Success','Lead has been updated.');
                }else{
                    admin_error('Error','Lead not updated! Please try again.');
                }
            }
        }else{
            admin_error('Error','Unautorized request.');
        }
        return redirect()->route('leads.show',[$id]);
    }

    public function updateBulkCurrentStatus(Request $request){
        if (!LoginAdmin::user()->inRoles(['administrator', 'manager'])){
            admin_error('Error','Access denied.');
            return back();
        }
        if(isset($request->current_status) && isset($request->lead_ids)){
            // $lead = Lead::findOrFail($id);
            $data['current_status'] = $request->current_status;
            if(Lead::whereIn('id',explode(',', $request->lead_ids))->update($data)){
                admin_success('Success','Lead(s) updated.');
            }else{
                admin_error('Error','Lead(s) not updated! Please try again.');
            }
        }else{
            admin_error('Error','Unautorized request.');
        }
        return redirect()->back();        
    }    

    public function updateCurrentStatus($id,Request $request){
        if (!LoginAdmin::user()->inRoles(['administrator', 'manager'])){
            admin_error('Error','Access denied.');
            return back();
        }
        if(isset($request->current_status)){
            $lead = Lead::findOrFail($id);
            $lead['current_status'] = $request->current_status;
            if($lead->update()){
                admin_success('Success','Lead has been updated.');
            }else{
                admin_error('Error','Lead not updated! Please try again.');
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
                SendMail::bulkLeadEmail($lead,$email);
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
            $leadData = Lead::findOrFail($lead);
            if($leadData['current_status'] < 1) $leadData['current_status'] = 1;
            $leadData->update();
            admin_success('Success','Notes has been saved.');
        }else{
            admin_error('Error','Notes not saved! Please try again.');
        }
        return back();
    }

    public function advanceSearch(Content $content){
        if (!LoginAdmin::user()->inRoles(['administrator', 'manager'])){
            admin_error('Error','Access denied.');
            return back();
        }        
        return $content
        ->header('Lead Advance Search')
        ->description('description')
        ->body($this->advanceSearchForm());
    }
    protected function advanceSearchForm(){
        Admin::script("$('input.previous_insurance').on('ifClicked', function (event) {
            if(this.value ==1 ) {
                $('select#duration,input#current_insurance').removeAttr('disabled');
            }else{
                $('select#duration,input#current_insurance').attr('disabled','disabled');
            }
            });
            $('.content form').attr('method','get');
        ");
        $form = new Form(New Lead);
        $form->row(function($row){
            $row->width(12)->html("<h3 class='col-xs-12 m-0 text-uppercase'>Contact Information:</h3>");
        });
        $form->row(function($row){
            $row->width(4)->text('name',trans('admin.name'));
            $row->width(4)->email('email',trans('admin.email'));
            $row->width(4)->mobile('phone',trans('admin.phone'))->options(['mask' => '(999) 999-9999'])->attribute(['style'=>'width:100%;']);            
        });

        $form->row(function($row){
            $row->width(4)->text('street',trans('admin.street'));
            $row->width(4)->text('city',trans('admin.city'));
            $row->width(4)->text('state',trans('admin.state'));
        });
        $form->row(function($row){
            $row->width(4)->text('zip',trans('admin.zipcode'));
            $row->width(4)->date('dob',trans('Date Of Birth'))->attribute(['style'=>'width:100%;']);
            $row->width(4)->text('dl',trans('Driving License Number'));
        });
        $form->row(function($row){
            $row->width(2)->radio('gender',trans('Gender'))->options(['Male'=> 'Male','Female'=>'Female'])->stacked();
            $row->width(2)->radio('married',trans('Married'))->options([1=>'Yes',0=>'No'])->default('3')->stacked();
            $row->width(2)->radio('children',trans('Children'))->options([1=>'Yes',0=>'No'])->default('3')->stacked();
            $row->width(2)->radio('homeowner',trans('Homeowner'))->options(['owner'=>'Owner','renter'=>'Renter'])->stacked();
            $row->width(2)->radio('bundled',trans('Bundled'))->options([1=>'yes',0=>'No'])->default('3')->stacked(); 
        });

        $form->row(function($row){
            $row->width(12)->html("<h3 class='col-xs-12 m-0 text-uppercase'>VEHICLE:</h3>");
        });
        $form->row(function($row){
            $row->width(4)->text('year',trans('admin.year'));
            $row->width(4)->text('make',trans('admin.make'));
            $row->width(4)->text('model',trans('admin.model'));
        });
        $form->row(function($row){
            $row->width(4)->text('trim',trans('admin.trim'));
            $row->width(4)->text('vin',trans('admin.vin'));
            $row->width(4)->radio('owenership',trans('admin.owenership'))->options(['Owned'=>'Owned','Financed'=>'Financed','Leased'=>'Leased']);
        });
        $form->row(function($row){
            $row->width(4)->radio('uses',trans('admin.uses'))->options(['Commute'=>'Commute','Pleasure'=>'Pleasure','Business'=>'Business','Farm'=>'Farm'])->stacked();
            $row->width(4)->radio('mileage',trans('admin.mileage'))->options(['Less than 5,000'=>'Less than 5,000','5,000-10,000'=>'5,000-10,000','10,000-15,000'=>'10,000-15,000','15,000-20,000'=>'15,000-20,000','More than 20,000'=>'More than 20,000'])->stacked();
        });

        $form->row(function($row){
            $row->width(12)->html("<h3 class='col-xs-12 m-0 text-uppercase'>COVERAGE:</h3>");
        });
        $form->row(function($row){
            $row->width(4)->select('body_injury',trans('Bodily Injury'))->options(["15-30" =>"$15k/$30k","25-50"=>"$25k/$50k","30-60"=>"$30k/$60k","50-100"=>"$50k/$100k","100-300"=>"$100k/$300k","250-500"=>"$250k/$500k","500-1000"=>"$500k/$1Mil"]);
            $row->width(4)->select('deduct',trans('Deductible'))->options(["250" => "$250", "500" => "$500", "1000" => "$1000"]);
            $row->width(4)->select('medical',trans('Medical'))->options(["0" => "$0", "5000" => "$5000", "10000" => "$10000"])->default('3');
        });
        $form->row(function($row){
            $row->width(2)->radio('towing',trans('Towing'))->options(["1" => "Yes", "0" => "No"])->stacked()->default('3');
            $row->width(2)->radio('uninsured',trans('Uninsured'))->options(["1" => "Yes", "0" => "No"])->stacked()->default('3');
            $row->width(2)->radio('rental',trans('Rental'))->options(["1" => "Yes", "0" => "No"])->stacked()->default('3');
        });

        $form->row(function($row){
            $row->width(12)->html("<h3 class='col-xs-12 m-0 text-uppercase'>HISTORY:</h3>");
        });
        $form->row(function($row){
            $insuranceComp =  CommonMethod::getInsuranceCompanies();
            $row->width(4)->radio('previous_insurance',trans('Have you had auto insurance in the past 30 days?'))->options(["1" => "Yes", "0" => "No"])->stacked()->default('3');
            $row->width(4)->select('duration',trans('How long have you continuously had auto insurance?'))->options(["0-1" => "Less than a year", "1-2" => "1 to 2 years","2-3"=>"2 to 3 years",'4+'=>"4+ years"])->default("")->attribute(["id"=>"duration"])->attribute(['disabled' => true]);
            $row->width(4)->text('current_insurance',trans('Current Auto Insurance'))->attribute(['disabled' => true]);
        });
        $form->row(function($row){
            $row->width(4)->radio('at_fault',trans('An at-fault accident in the past three (3) years?'))->options(["1" => "Yes", "0" => "No"])->stacked()->default('3');
            $row->width(4)->radio('tickets',trans('Two (2) or more tickets in the past three (3) years?'))->options(["1" => "Yes", "0" => "No"])->stacked()->default('3');
            $row->width(4)->radio('dui',trans('A DUI conviction in the past ten (10) years?'))->options(["1" => "Yes", "0" => "No"])->stacked()->default('3');
        });

        $form->row(function($row){
            $row->width(12)->html("<h3 class='col-xs-12 m-0 text-uppercase'>PREFERENCE:</h3>");
        });

        $form->row(function($row){
            $row->width(4)->text('quality_provides',trans('What is the most important quality looking for when choosing an auto insurer?'));
            $row->width(4)->radio('agent_in_person',trans('Will it be important to you to be able to speak to your local agent in person?'))->options(["1"=> "Yes","0" => "No"])->default('3');
            $row->width(4)->text('referrer',trans('Referrer'));
            // $row->hidden('_method')->value('get');
        });
        $form->tools(function (Form\Tools $tools) {
            // Disable list btn
            $tools->disableListButton();
        });
        $form->setAction(route('lead-advance-search-post'));
        $form->setTitle("Lead Advance Search Form");
        $form->disableReset();
        $form->disableViewCheck();
        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        return $form;
    }


    public function advanceSearchResult(Request $request,Content $content){
        return $content
        ->header('Lead Advance Search Result')
        ->description(' ')
        ->body($this->grid(false,false));
    }

    protected static function advanceSearchConditions($grid){
        if(request()->name && request()->name != null && trim(request()->name) != ""){
            $searchString = trim(request()->name);
            $grid->model()
            ->whereRaw('(first_name like ? or last_name like ? or first_driver_first_name like ? or first_driver_last_name like ? or second_driver_first_name like ? or second_driver_last_name like ? or third_driver_first_name like ? or third_driver_last_name like ? or fourth_driver_first_name like ? or fourth_driver_last_name like ? or fifth_driver_first_name like ? or fifth_driver_last_name like ?)' , ["%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%"]);
        }

        if(request()->street && request()->street != null && trim(request()->street) != ""){
            $searchString = trim(request()->street);
            $grid->model()
            ->where('street', 'like', "%{$searchString}%");
        }

        if(request()->email && request()->email != null){
            $searchString = trim(request()->email);
            $grid->model()
            ->where('email', $searchString);
        }

        if(request()->phone && request()->phone != null){
            $searchString = trim(request()->phone);
            $grid->model()
            ->where('phone', $searchString);
        }


        if(request()->street && request()->street != null && trim(request()->street) != ""){
            $searchString = trim(request()->street);
            $grid->model()
            ->where('street', 'like', "%{$searchString}%");
        }

        if(request()->city && request()->city != null && trim(request()->city) != ""){
            $searchString = trim(request()->city);
            $grid->model()
            ->where('city','like', "%{$searchString}%");
        }
        if(request()->state && request()->state != null && trim(request()->state) != ""){
            $searchString = trim(request()->state);
            $grid->model()
            ->where('state','like', "%{$searchString}%");
        }
        if(request()->zip && request()->zip != null && trim(request()->zip) != ""){
            $searchString = trim(request()->zip);
            $grid->model()
            ->where('zip','like', "%{$searchString}%");
        }
        if(request()->dob && request()->dob != null && trim(request()->dob) != ""){
            $searchString = trim(request()->dob);
            $grid->model()
            ->whereRaw('(first_driver_dob = ? or second_driver_dob = ? or third_driver_dob = ? or fourth_driver_dob = ? or fifth_driver_dob = ? )' , [$searchString,$searchString,$searchString,$searchString,$searchString]);
        }

        if(request()->dl && request()->dl != null && trim(request()->dl) != ""){
            $searchString = trim(request()->dl);
            $grid->model()
            ->whereRaw('(first_driver_dl = like or second_driver_dl = like or third_driver_dl = like or fourth_driver_dl = like or fifth_driver_dl = like )' , ["%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%"]);
        }

       if(request()->year && request()->year != null && trim(request()->year) != ""){
            $searchString = trim(request()->year);
            $grid->model()
            ->whereRaw('(first_vehicle_year like ? or second_vehicle_year like ? or third_vehicle_year like ? or fourth_vehicle_year like ? or fifth_vehicle_year like ? or sixth_vehicle_year like ? or seventh_vehicle_year like ? or eighth_vehicle_year like ? or ninth_vehicle_year like ? or tenth_vehicle_year like ?)' , ["%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%"]);
        }

       if(request()->make && request()->make != null && trim(request()->make) != ""){
            $searchString = trim(request()->make);
            $grid->model()
            ->whereRaw('(first_vehicle_make like ? or second_vehicle_make like ? or third_vehicle_make like ? or fourth_vehicle_make like ? or fifth_vehicle_make like ? or sixth_vehicle_make like ? or seventh_vehicle_make like ? or eighth_vehicle_make like ? or ninth_vehicle_make like ? or tenth_vehicle_make like ?)' , ["%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%"]);
        }
       if(request()->model && request()->model != null && trim(request()->model) != ""){
            $searchString = trim(request()->model);
            $grid->model()
            ->whereRaw('(first_vehicle_model like ? or second_vehicle_model like ? or third_vehicle_model like ? or fourth_vehicle_model like ? or fifth_vehicle_model like ? or sixth_vehicle_model like ? or seventh_vehicle_model like ? or eighth_vehicle_model like ? or ninth_vehicle_model like ? or tenth_vehicle_model like ?)' , ["%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%"]);
        }
        if(request()->trim && request()->trim != null && trim(request()->trim) != ""){
            $searchString = trim(request()->trim);
            $grid->model()
            ->whereRaw('(first_vehicle_trim like ? or second_vehicle_trim like ? or third_vehicle_trim like ? or fourth_vehicle_trim like ? or fifth_vehicle_trim like ? or sixth_vehicle_trim like ? or seventh_vehicle_trim like ? or eighth_vehicle_trim like ? or ninth_vehicle_trim like ? or tenth_vehicle_trim like ?)' , ["%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%"]);
        }
        if(request()->vin && request()->vin != null && trim(request()->vin) != ""){
            $searchString = trim(request()->vin);
            $grid->model()
            ->whereRaw('(first_vehicle_vin like ? or second_vehicle_vin like ? or third_vehicle_vin like ? or fourth_vehicle_vin like ? or fifth_vehicle_vin like ? or sixth_vehicle_vin like ? or seventh_vehicle_vin like ? or eighth_vehicle_vin like ? or ninth_vehicle_vin like ? or tenth_vehicle_vin like ?)' , ["%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%","%{$searchString}%"]);
        }
       if(request()->owenership && request()->owenership != null && trim(request()->owenership) != ""){
            $searchString = trim(request()->owenership);
            $grid->model()
            ->whereRaw('(first_vehicle_owenership = ? or second_vehicle_owenership = ? or third_vehicle_owenership = ? or fourth_vehicle_owenership = ? or fifth_vehicle_owenership = ? or sixth_vehicle_owenership = ? or seventh_vehicle_owenership = ? or eighth_vehicle_owenership = ? or ninth_vehicle_owenership = ? or tenth_vehicle_owenership = ?)' , [$searchString,$searchString,$searchString,$searchString,$searchString,$searchString,$searchString,$searchString,$searchString,$searchString]);
        }
       if(request()->uses && request()->uses != null && trim(request()->uses) != ""){
            $searchString = trim(request()->uses);
            $grid->model()
            ->whereRaw('(first_vehicle_uses = ? or second_vehicle_uses = ? or third_vehicle_uses = ? or fourth_vehicle_uses = ? or fifth_vehicle_uses = ? or sixth_vehicle_uses = ? or seventh_vehicle_uses = ? or eighth_vehicle_uses = ? or ninth_vehicle_uses = ? or tenth_vehicle_uses = ?)' , [$searchString,$searchString,$searchString,$searchString,$searchString,$searchString,$searchString,$searchString,$searchString,$searchString]);
        }
       if(request()->mileage && request()->mileage != null && trim(request()->mileage) != ""){
            $searchString = trim(request()->mileage);
            $grid->model()
            ->whereRaw('(first_vehicle_mileage = ? or second_vehicle_mileage = ? or third_vehicle_mileage = ? or fourth_vehicle_mileage = ? or fifth_vehicle_mileage = ? or sixth_vehicle_mileage = ? or seventh_vehicle_mileage = ? or eighth_vehicle_mileage = ? or ninth_vehicle_mileage = ? or tenth_vehicle_mileage = ?)' , [$searchString,$searchString,$searchString,$searchString,$searchString,$searchString,$searchString,$searchString,$searchString,$searchString]);
        }                

        if(request()->gender && request()->gender != null ){
            $searchString = trim(request()->gender);
            $grid->model()
            ->where('gender', $searchString);
        }        

        if(request()->married && request()->married != null ){
            $searchString = trim(request()->married);
            $grid->model()
            ->where('married', $searchString);
        }

        if(request()->children && request()->children != null ){
            $searchString = trim(request()->children);
            $grid->model()
            ->where('children', $searchString);
        }
        if(request()->homeowner && request()->homeowner != null ){
            $searchString = trim(request()->homeowner);
            $grid->model()
            ->where('homeowner', $searchString);
        }
        if(request()->bundled && request()->bundled != null ){
            $searchString = trim(request()->bundled);
            $grid->model()
            ->where('bundled', $searchString);
        }
        if(request()->body_injury && request()->body_injury != null ){
            $searchString = trim(request()->body_injury);
            $grid->model()
            ->where('body_injury', $searchString);
        }
        if(request()->deduct && request()->deduct != null ){
            $searchString = trim(request()->deduct);
            $grid->model()
            ->where('deduct', $searchString);
        }
        if(request()->medical && request()->medical != null ){
            $searchString = trim(request()->medical);
            $grid->model()
            ->where('medical', $searchString);
        }
        if(request()->towing && request()->towing != null ){
            $searchString = trim(request()->towing);
            $grid->model()
            ->where('towing', $searchString);
        }                                                     
        if(request()->uninsured && request()->uninsured != null ){
            $searchString = trim(request()->uninsured);
            $grid->model()
            ->where('uninsured', $searchString);
        }                                                     
        if(request()->rental && request()->rental != null ){
            $searchString = trim(request()->rental);
            $grid->model()
            ->where('rental', $searchString);
        }

        if(request()->previous_insurance && request()->previous_insurance != null ){
            $searchString = trim(request()->previous_insurance);
            $grid->model()
            ->where('previous_insurance', $searchString);
        }
        if(request()->duration && request()->duration != null ){
            $searchString = trim(request()->duration);
            $grid->model()
            ->where('duration', $searchString);
        }
        if(request()->current_insurance && request()->current_insurance != null && trim(request()->current_insurance) != ""){
            $searchString = trim(request()->current_insurance);
            $grid->model()
            ->where('current_insurance','like', "%{$searchString}%");
        }
        if(request()->at_fault && request()->at_fault != null ){
            $searchString = trim(request()->at_fault);
            $grid->model()
            ->where('at_fault', $searchString);
        }
        if(request()->tickets && request()->tickets != null ){
            $searchString = trim(request()->tickets);
            $grid->model()
            ->where('tickets', $searchString);
        }
        if(request()->dui && request()->dui != null ){
            $searchString = trim(request()->dui);
            $grid->model()
            ->where('dui', $searchString);
        }

        if(request()->quality_provides && request()->quality_provides != null && trim(request()->quality_provides) != ""){
            $searchString = trim(request()->quality_provides);
            $grid->model()
            ->where('quality_provides','like', "%{$searchString}%");
        }

        if(request()->agent_in_person && request()->agent_in_person != null ){
            $searchString = trim(request()->agent_in_person);
            $grid->model()
            ->where('agent_in_person', $searchString);
        }

        if(request()->referrer && request()->referrer != null && trim(request()->referrer) != ""){
            $searchString = trim(request()->referrer);
            $grid->model()
            ->whereRaw('(referrer like ? or referrer_name like ? )',["%{$searchString}%","%{$searchString}%"]);
        }
        return $grid;
    }

}
