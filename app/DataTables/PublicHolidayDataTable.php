<?php

namespace App\DataTables;

use App\Models\PublicHoliday;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PublicHolidayDataTable extends DataTable
{
    public $tableId = 'PublicHolidayTable';

    public function __construct()
    {

    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('name', function ($model) {
                $alink = '<a class="open-form" data-action="edit" data-id="'.$model->id.'">'.$model->name.'</a>';
                return $alink;
                
            })
            ->editColumn('assign_date', function ($model) {
                return Carbon::parse($model->assign_date)->format('d M, Y');
            })
            ->editColumn('created_at', function ($model) {
                return Carbon::parse($model->created_at)->format('d M, Y');
            })
            ->addColumn('action', function ($model) {

                $deleteUrl = route('admin.holiday.delete', $model->id);

                $show = '
                    <a class="btn btn-danger btn-sm" href="'.$deleteUrl.'"><i class="fa fa-trash"></i></a>
                ';

                return $show;
            })
            ->rawColumns(['name','assign_date','created_at','action']);
    }

    public function query(PublicHoliday $model)
    {
        return
            $model->select(
                ...$model->qualifyColumns([
                    'id',
                    'name',
                    'assign_date',
                    'created_at',
                ])
            );
    }

    public function html()
    {
        return $this->builder()
            ->setTableId($this->tableId)
            ->columns([

                Column::make('name')->title('Name'),
                Column::make('assign_date')->title('Holiday Date'),
                
                Column::make('created_at')->title('Created At'),
                Column::computed('action')
                    ->title('Action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            ])
            ->orders([0,1])
            ->orderBy(0, 'asc');
    }
    
}