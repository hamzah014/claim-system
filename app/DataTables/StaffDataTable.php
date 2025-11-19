<?php

namespace App\DataTables;

use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StaffDataTable extends DataTable
{

    public $tableId = 'StaffTable';

    public function __construct()
    {

    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('name', function ($model) {
                $route = route('admin.staff.edit', $model->id);
                $alink = '<a href="'.$route.'">'.$model->name.'</a>';
                return $alink;
                
            })
            ->editColumn('created_at', function ($model) {
                return Carbon::parse($model->created_at)->format('d M, Y');
            })
            ->editColumn('department_id', function ($model) {
                return $model->department ? $model->department->name : "-";
            })
            ->editColumn('department_id', function ($model) {
                return $model->department ? $model->department->name : "-";
            })
            ->editColumn('req_driving', function ($model) {
                return $model->req_driving == 1 ? 'Yes' : "No";
            })
            ->addColumn('action', function ($model) {

                $deleteUrl = route('admin.staff.delete', $model->id);

                $show = '
                    <a class="btn btn-danger btn-sm" href="'.$deleteUrl.'"><i class="fa fa-trash"></i></a>
                ';

                return $show;
            })
            ->rawColumns(['name','department_id','created_at','action']);
    }

    public function query(User $model)
    {
        return
            $model->select(
                ...$model->qualifyColumns([
                    'id',
                    'name',
                    'email',
                    'department_id',
                    'req_driving',
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
                Column::make('email')->title('Email'),
                Column::make('department_id')->title('Department'),
                Column::make('req_driving')->title('Involved Driving'),
                Column::make('created_at')->title('Created At'),
                Column::computed('action')
                    ->title('Action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            ])
            ->orders([0,1])
            ->orderBy(1, 'asc');
    }

}