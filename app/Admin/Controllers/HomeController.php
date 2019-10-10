<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Table;
use App\Admin\Controllers\AdminLeadsController;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Encore\Admin\Facades\Admin as LoginAdmin;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
        ->header('Dashboard')
            // ->row(Dashboard::title())
        // ->row(function (Row $row) {

        //     $row->column(12, function (Column $column) {
        //         $column->append('<style>.title {font-size: 50px;color: #636b6f;font-family:"Raleway", sans-serif;font-weight: 100;display: block;text-align: center;margin: 20px 0 10px 0px;}</style><div class="title">Insurance</div>');
        //     });
        // })
        ->row(function (Row $row) {
            $row->column(12, function (Column $column) {
                $leads = AdminLeadsController::getLeadCounts(); 
                $infoRow =  new Row;
                $infoRow->column(1,"<style>.fa-sm{font-size:0.5em;}</style>");
                $infoRow->column(2, function (Column $infoColumn)  use($leads) {
                    $from =  $to = Carbon::today()->format('Y-m-d');
                    $infoBox = new InfoBox(trans('Today'), 'users fa-sm', 'purple', "/admin/leads/$from/$to", '<span>'.$leads['today']['total'].'</span>'.'<span class="text-black font-light">/</span><span class="text-green">'.$leads['today']['low'].'</span>'.'<span class="text-black font-light">/</span><span class="text-red">'.$leads['today']['high'].'</span>');
                    $infoColumn->append($infoBox->render());
                });
                $infoRow->column(2, function (Column $infoColumn)use($leads) {
                    $from = Carbon::today()->subDays(7)->format('Y-m-d');
                    $to = Carbon::today()->format('Y-m-d');
                    $infoBox = new InfoBox(trans('7 Days'), 'users fa-sm', 'purple', "/admin/leads/$from/$to", '<span>'.$leads['week']['total'].'</span>'.'<span class="text-black font-light">/</span><span class="text-green">'.$leads['week']['low'].'</span>'.'<span class="text-black font-light">/</span><span class="text-red">'.$leads['week']['high'].'</span>');
                    $infoColumn->append($infoBox->render());
                });
                $infoRow->column(2, function (Column $infoColumn)use($leads) {
                    $from = Carbon::today()->subDays(30)->format('Y-m-d');
                    $to = Carbon::today()->format('Y-m-d');
                    $infoBox = new InfoBox(trans('30 days'), 'users fa-sm', 'purple', "/admin/leads/$from/$to", '<span>'.$leads['month']['total'].'</span>'.'<span class="text-black font-light">/</span><span class="text-green">'.$leads['month']['low'].'</span>'.'<span class="text-black font-light">/</span><span class="text-red">'.$leads['month']['high'].'</span>');
                    $infoColumn->append($infoBox->render());
                });
                $infoRow->column(2, function (Column $infoColumn) use($leads){
                    $from =  Carbon::parse("first day of January ". Carbon::today()->format('Y'))->format('Y-m-d');
                    $to = Carbon::now()->format('Y-m-d');                    
                    $infoBox = new InfoBox(trans('YTD'), 'users fa-sm', 'purple', "/admin/leads/$from/$to", '<span>'.$leads['year']['total'].'</span>'.'<span class="text-black font-light">/</span><span class="text-green">'.$leads['year']['low'].'</span>'.'<span class="text-black font-light">/</span><span class="text-red">'.$leads['year']['high'].'</span>');
                    $infoColumn->append($infoBox->render());
                });
                $infoRow->column(2, function (Column $infoColumn)use($leads) {
                    $infoBox = new InfoBox(trans('Lifetime'), 'users fa-sm', 'purple', "/admin/leads", '<span>'.$leads['lifetime']['total'].'</span>'.'<span class="text-black font-light">/</span><span class="text-green">'.$leads['lifetime']['low'].'</span>'.'<span class="text-black font-light">/</span><span class="text-red">'.$leads['lifetime']['high'].'</span>');
                    $infoColumn->append($infoBox->render());
                });                                                

                $box = new Box('Lead Chart',$infoRow);
                $box->collapsable();
                $box->style('primary');
                $box->solid();                    
                $column->append($box);
            });
        })
        ->row(function (Row $row) {
            $row->column(4, function (Column $column) {
                $column->append($this->userProfile());
            });
            $row->column(8, function (Column $column) {

                $box = new Box('Group Members',"<p>Hey Admin</p>");
                $box->collapsable();
                $box->style('info');
                $box->solid();                    
                $column->append($box);                
            });            
        });

    }

    protected function userProfile(){

        $rows = [
            ['<b>First Name</b>',LoginAdmin::user()->name],
            ['<b>Last Name</b>',LoginAdmin::user()->last_name],
            ['<b>Email</b>',LoginAdmin::user()->email],
            ['<b>Phone</b>',LoginAdmin::user()->phone],
        ];
        $profilePic = (LoginAdmin::user()->avatar) ? LoginAdmin::user()->avatar : "/images/default-user.png";
        $userInfo = '<div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-blue">
              <div class="widget-user-image">
                <img class="img-circle" src="'.$profilePic.'" alt="User Avatar"/>
              </div>
              <h3 class="widget-user-username">'.LoginAdmin::user()->name.'</h3>
              <h5 class="widget-user-desc">Lead Developer</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="javascript:;"><strong>First Name</strong> <span class="pull-right">'.LoginAdmin::user()->name.'</span></a></li>
                <li><a href="javascript:;"> <strong>Last Name</strong> <span class="pull-right">'.LoginAdmin::user()->last_name.'</span></a></li>
                <li><a href="javascript:;"> <strong>Username</strong> <span class="pull-right">'.LoginAdmin::user()->username.'</span></a></li>
                <li><a href="javascript:;"> <strong>Email</strong> <span class="pull-right">'.LoginAdmin::user()->email.'</span></a></li>
                <li><a href="javascript:;"> <strong>Phone</strong> <span class="pull-right">'.LoginAdmin::user()->phone.'</span></a></li>
              </ul>
            </div>
          </div>
          <div class="text-center">
          <a href="'.route('admin.setting').'" class="btn btn-info"><i class="fa fa-pencil"></i> <span class="hidden-xs">Edit</span></a>
          </div>';
        if(LoginAdmin::user()->inRoles(['manager'])){
            $activeProfileClass ="info manger-box";
        }elseif(LoginAdmin::user()->inRoles(['associate'])){
            $activeProfileClass ="success";
        }else{
            $activeProfileClass = "primary";
        }          
        $box = new Box('My Profile',$userInfo);
        $box->collapsable();
        $box->style($activeProfileClass);
        $box->solid();
        return $box;
    }
    public function testMail(){
        $email = 'sgstest2505@gmail.com';
        $lead = Lead::findOrFail(5);
        $mailStatus = \Mail::send('Admin.Lead.email', ['lead' => $lead],
                function ($message) use($email){
                    $message->to($email)->subject('New Lead - Insurance');
        }); 

        dd($mailStatus);
    }
}
