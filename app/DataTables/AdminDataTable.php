<?php

namespace App\DataTables;

use App\Models\Admin;
use App\Services\DropdownService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminDataTable extends DataTable
{
    public $tableId = 'AdminTable';
    protected $dropdownServices;

    public function __construct() {
        
        $this->dropdownServices = new DropdownService();

    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('name', function ($model) {
                $alink = '<a class="open-form" data-action="edit" data-id="' . $model->id . '">' . $model->name . '</a>';
                return $alink;
            })
            ->editColumn('created_at', function ($model) {
                return Carbon::parse($model->created_at)->format('d M, Y');
            })
            ->editColumn('role', function ($model) {
                $adminList = $this->dropdownServices->adminList();
                return $adminList[$model->role] ?? "-";
            })
            ->addColumn('action', function ($model) {

                $deleteUrl = route('admin.staff.delete', $model->id);

                $show = '
                    <a class="btn btn-danger btn-sm" href="' . $deleteUrl . '"><i class="fa fa-trash"></i></a>
                ';

                return $show;
            })
            ->rawColumns(['name', 'department_id', 'created_at', 'action']);
    }

    public function query(Admin $model)
    {
        return
            $model->select(
                ...$model->qualifyColumns([
                    'id',
                    'name',
                    'email',
                    'role',
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
                Column::make('role')->title('Role'),
                Column::make('created_at')->title('Created At'),
                Column::computed('action')
                    ->title('Action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            ])
            ->orders([0, 1])
            ->orderBy(1, 'asc');
    }
}
