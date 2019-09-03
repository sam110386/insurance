<?php

namespace App\Admin\Controllers;

use App\Models\Affiliate;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Admin;
use Illuminate\Http\Request;


class AffiliateController extends Controller
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
        ->header(trans('admin.affiliate'))
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
        ->header(trans('admin.affiliate'))
        ->description(' ')
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
        ->header(trans('admin.affiliate'))
        ->description('')
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
        ->header(trans('admin.affiliate'))
        ->description(' ')
        ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Affiliate);

        $grid->id('ID');
        $grid->company(trans('admin.company'));
        $grid->contact_person(trans('admin.contact_person'));
        // $grid->leads('Leads')->display(function($leads){
        //     return count($leads);
        // });
        $grid->phone(trans('admin.phone'));
        $grid->email(trans('admin.email'));
        $grid->created_at('Created at');
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
        $show = new Show(Affiliate::findOrFail($id));

        $show->id('ID');
        $show->company(trans('admin.company'));
        $show->contact_person(trans('admin.contact_person'));
        $show->phone(trans('admin.phone'));
        $show->email(trans('admin.email'));
        
        $show->campaign(trans('admin.campaign'))->as(function($campaign){
            return strtoupper($campaign);
        });
        $show->payout_amount(trans('admin.payout_amount'))->as(function($amount){
            return "$".$amount;
        });
        $show->postback_url(trans('admin.postback_url'));

        $show->s1(trans('S1'))->as(function(){
            return ($this->s1) ? $this->s1_value : 'No';
        });

        $show->s2(trans('S2'))->as(function(){
            return ($this->s2) ? $this->s2_value : 'No';
        });
        $show->s3(trans('S3'))->as(function(){
            return ($this->s3) ? $this->s3_value : 'No';
        });
        $show->s4(trans('S4'))->as(function(){
            return ($this->s4) ? $this->s4_value : 'No';
        });
        $show->s5(trans('S5'))->as(function(){
            return ($this->s5) ? $this->s5_value : 'No';
        });

        $show->notes(trans('admin.notes'))->as(function(){
            return nl2br($this->notes);
        })->setEscape(false);
        $show->column(trans('admin.affiliate_url'))->as(function(){
            return ($this->s1_value) ?  route('new-lead') . '?s1=' . $this->s1_value : "" ;
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
    protected function form($id=null)
    {

        if($id){
            Admin::script("
                if($('input.s1[type=hidden]').val()=='on'){
                    $('#s1_value').attr('required',true);
                    $('#s1_value').removeAttr('readonly');
                }else{
                    $('#s1_value').removeAttr('required');
                    $('#s1_value').attr({'readonly': true});
                }
                if($('input.s2[type=hidden]').val()=='on'){
                    $('#s2_value').attr('required',true);
                    $('#s2_value').removeAttr('readonly');
                }else{
                    $('#s2_value').removeAttr('required');
                    $('#s2_value').attr({'readonly': true});
                }
                
                if($('input.s3[type=hidden]').val()=='on'){
                    $('#s3_value').attr('required',true);
                    $('#s3_value').removeAttr('readonly');
                }else{   
                    $('#s3_value').removeAttr('required');
                    $('#s3_value').attr({'readonly': true});
                }

                if($('input.s4[type=hidden]').val()=='on'){
                    $('#s4_value').attr('required',true);
                    $('#s4_value').removeAttr('readonly');
                }else{
                    $('#s4_value').removeAttr('required');
                    $('#s4_value').attr({'readonly': true});
                }
                if($('input.s5[type=hidden]').val()=='on'){
                    $('#s5_value').attr('required',true);
                    $('#s5_value').removeAttr('readonly');
                }else{
                    $('#s5_value').removeAttr('required');
                    $('#s5_value').attr({'readonly': true});
                }
            ");
        }
        Admin::script("
            function randString(length) {
               var result = '';
               var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
               var charactersLength = characters.length;
               for ( var i = 0; i < length; i++ ) {
                  result += characters.charAt(Math.floor(Math.random() * charactersLength));
               }
               return result;
            }
            $('.generate-string').on('click',function(){ if (!$('#s1_value').is('[readonly]') ) { $('#s1_value').val(randString(32)); } });
                $('input.s1[type=hidden]').on('change',function(){
                    if($(this).val() == 'on'){
                        $('#s1_value').attr({'required':true});
                        $('#s1_value').removeAttr('readonly');
                    }else{
                        $('#s1_value').attr({'readonly': true});
                        $('#s1_value').val('').removeAttr('required');
                    }
                }); 
                 $('input.s2[type=hidden]').on('change',function(){
                    if($(this).val() == 'on'){
                        $('#s2_value').attr({'required':true});
                        $('#s2_value').removeAttr('readonly');
                    }else{
                        $('#s2_value').attr({'readonly': true});
                        $('#s2_value').val('').removeAttr('required');
                    }
                });
                 $('input.s3[type=hidden]').on('change',function(){
                    if($(this).val() == 'on'){
                        $('#s3_value').attr({'required':true});
                        $('#s3_value').removeAttr('readonly');
                    }else{
                        $('#s3_value').attr({'readonly': true});
                        $('#s3_value').val('').removeAttr('required');
                    }
                });
                 $('input.s4[type=hidden]').on('change',function(){
                    if($(this).val() == 'on'){
                        $('#s4_value').attr({'required':true});
                        $('#s4_value').removeAttr('readonly');
                    }else{
                        $('#s4_value').attr({'readonly': true});
                        $('#s4_value').val('').removeAttr('required');
                    }
                });
                 $('input.s5[type=hidden]').on('change',function(){
                    if($(this).val() == 'on'){
                        $('#s5_value').attr({'required':true});
                        $('#s5_value').removeAttr('readonly');
                    }else{
                        $('#s5_value').attr({'readonly': true});
                        $('#s5_value').val('').removeAttr('required');
                    }
                });
            ");
        $form = new Form(new Affiliate);


        $form->row(function ($row) use ( $form) {
            $row->width(5)->text('company', trans('admin.company'))->rules('required');
            $row->width(5)->text('contact_person', trans('admin.contact_person'))->rules('required');
        });
        $form->row(function ($row) use ( $form) {
            $row->width(5)->mobile('phone', trans('admin.phone'))->options(['mask' => '9999 999 999'])->attribute(['style' => 'width:100%;'])->rules('required');
            $row->width(5)->email('email', trans('admin.email'))->rules('required');
        });

        $form->row(function ($row) use ( $form) {
            $row->width(3)->radio('campaign', trans('admin.campaign'))->options(['cpl' => 'CPL' ,'cpa' => 'CPA', 'cpc' => 'CPC'])->rules('required');
            $row->width(2)->currency('payout_amount', trans('admin.payout_amount'))->attribute(['style' => 'width: 100%;'])->rules('required');
        });
        
        $form->row(function ($row) use ( $form) {
            $row->width(5)->url('postback_url', trans('admin.postback_url'))->rules('required');
        });

        $states = [
            'off' => ['value' => 0, 'text' => 'No', 'color' => 'danger'],
            'on'  => ['value' => 1, 'text' => 'Yes', 'color' => 'success']
        ];

        $form->row(function ($row) use ( $states,$id) {
            $readonly = (old('s1_value')) ? [] : ['readonly' => true];
            $row->width(1)->switch('s1', 'S1')->states($states);
            $row->width(4)->text('s1_value', '&nbsp;')->attribute($readonly)->rules('unique:affiliate,s1_value'.$id);
            $row->width(1)->html('<a href="javascript:;" class="btn generate-string btn-primary " style="margin-top:7px;">Generate</a>');
        });
        $form->row(function ($row) use ( $states) {
            $readonly = (old('s2_value')) ? [] : ['readonly' => true];
            $row->width(1)->switch('s2', 'S2')->states($states);
            $row->width(4)->text('s2_value', '&nbsp;')->attribute($readonly);
        });
        $form->row(function ($row) use ( $states) {
            $readonly = (old('s3_value')) ? [] : ['readonly' => true];
            $row->width(1)->switch('s3', 'S3')->states($states);
            $row->width(4)->text('s3_value', '&nbsp;')->attribute($readonly);
        });
        $form->row(function ($row) use ( $states) {
            $readonly = (old('s4_value')) ? [] : ['readonly' => true];
            $row->width(1)->switch('s4', 'S4')->states($states);
            $row->width(4)->text('s4_value', '&nbsp;')->attribute($readonly);
        });
        $form->row(function ($row) use ( $states) {
            $readonly = (old('s5_value')) ? [] : ['readonly' => true];
            $row->width(1)->switch('s5', 'S5')->states($states);
            $row->width(4)->text('s5_value', '&nbsp;')->attribute($readonly);
        });


        $form->row(function ($row) use ( $form) {
            $row->width(10)->textarea('notes', trans('admin.notes'));
        });
        if($id){            
            $form->row(function ($row) use ( $form) {
                $row->width(10)->display('key', trans('admin.key'));
            });
        }else{
            $form->row(function ($row){
                // $row->width(10)->display('key', trans('admin.key'));
                $row->width(1)->hidden('key')->value(str_random(32));
            });            
        }
        $form->row(function ($row){
            $states = [
                'off' => ['value' => 0, 'text' => 'Inactive', 'color' => 'danger'],
                'on'  => ['value' => 1, 'text' => 'Active', 'color' => 'success']
            ];            
            $row->width(1)->switch('status', 'Status')->states($states)->attribute(['checked' =>true]);
        });        
        return $form;
    }

    public function update($id,Request $request){
        $valid = request()->validate([
            's1_value' => "unique:affiliate,s1_value,{$id}",
        ]);
        $data = [];
        foreach ($request->all() as $key => $value) {
            
            $data[$key] = (in_array($key, ['s1','s2','s3','s4','s5','status'])) ? ($value=="on") ? 1 : 0  : $value;
        }
        unset($data['_token']);
        unset($data['_method']);
        unset($data['_previous_']);
        if(Affiliate::where('id', $id)->update($data)){
            admin_success('Success','Affiliate has been updated.');
            return redirect()->route('affiliates.index');
        }else{
            admin_error('Error','Affiliate not updated!Please try again.');
            return redirect()->back();
        }
    }
}
