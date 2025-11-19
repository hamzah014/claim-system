<?php

namespace App\DataTables;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DepartmentDataTable extends DataTable
{
    public $tableId = 'DepartmentTable';

    public function __construct()
    {

    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('name', function ($model) {
                $alink = '<a class="open-form" data-action="edit" data-depart="'.$model->id.'">'.$model->name.'</a>';
                return $alink;
                
            })
            ->editColumn('created_at', function ($model) {
                return Carbon::parse($model->created_at)->format('d M, Y');
            })
            ->addColumn('action', function ($model) {

                $deleteUrl = route('admin.department.delete', $model->id);

                $show = '
                    <a class="btn btn-danger btn-sm" href="'.$deleteUrl.'"><i class="fa fa-trash"></i></a>
                ';

                return $show;
            })
            ->rawColumns(['name','created_at','action']);
    }

    public function query(Department $model)
    {
        return
            $model->select(
                ...$model->qualifyColumns([
                    'id',
                    'name',
                    'manager_name',
                    'manager_email',
                    'manager_phone',
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
                
                Column::make('manager_name')->title('Manager Name'),
                Column::make('manager_email')->title('Manager Email'),
                
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