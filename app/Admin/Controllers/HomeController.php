<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;
use App\Admin\Controllers\AdminLeadsController;


class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
        ->header('Dashboard')
        ->description('Description...')
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
                $infoRow->column(3, function (Column $infoColumn)  use($leads) {
                    $infoBox = new InfoBox(trans('Today'), 'users', 'aqua', '/admin/leads', $leads['today']);
                    $infoColumn->append($infoBox->render());
                });
                $infoRow->column(3, function (Column $infoColumn)use($leads) {
                    $infoBox = new InfoBox(trans('7 Days'), 'users', 'aqua', '/admin/leads', $leads['week']);
                    $infoColumn->append($infoBox->render());
                });
                $infoRow->column(3, function (Column $infoColumn)use($leads) {
                    $infoBox = new InfoBox(trans('30 days'), 'users', 'aqua', '/admin/leads', $leads['month']);
                    $infoColumn->append($infoBox->render());
                });
                $infoRow->column(3, function (Column $infoColumn) use($leads){
                    $infoBox = new InfoBox(trans('YTD'), 'users', 'aqua', '/admin/leads', $leads['year']);
                    $infoColumn->append($infoBox->render());
                });
                $infoRow->column(3, function (Column $infoColumn)use($leads) {
                    $infoBox = new InfoBox(trans('Lifetime'), 'users', 'aqua', '/admin/leads', $leads['total']);
                    $infoColumn->append($infoBox->render());
                });                                                

                $box = new Box('Number of Lead submissions',$infoRow);
                $box->collapsable();
                $box->style('primary');
                $box->solid();                    
                $column->append($box);
            });
        });

    }
}
