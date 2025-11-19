<?php

namespace App\DataTables;

use App\Models\Admin;
use App\Models\Claim;
use App\Models\User;
use App\Services\DropdownService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClaimDataTable extends DataTable
{

    public $tableId = 'ClaimTable';
    public $dropdownService;

    public function __construct()
    {
        $this->dropdownService = new DropdownService();
    }

    public function dataTable($query)
    {
        return datatables()
        ->eloquent($query)
        ->editColumn('reference_no', function ($model) {
            $viewUrl = route('admin.claim.view', $model->id);
            return '<a href="'.$viewUrl.'">'.$model->reference_no.'</a>';
        })
        ->editColumn('staff_id', function ($model) {
            $staff = $model->staff;
            if ($staff) {
                return $staff->name;
            }
            return 'N/A';
        })
        ->editColumn('type', function ($model) {
            return ucwords($this->dropdownService->claimType()[$model->type] ?? $model->type);
        })
        ->editColumn('work_location', function ($model) {
            return ucwords($this->dropdownService->workLocation()[$model->work_location] ?? $model->work_location);
        })
        ->editColumn('duty_date', function ($model) {
            
            $duty = "<b>Duty Date :</b> " . Carbon::parse($model->duty_date)->format('d M, Y') . "<br>";
            $duty .= "<b>Duty Time :</b> " . Carbon::parse($model->duty_start_time)->format('h:i A') . " - " . Carbon::parse($model->duty_end_time)->format('h:i A');
            $duty .= "<br><b>Location:</b> " . ucwords($this->dropdownService->workLocation()[$model->work_location] ?? $model->work_location);

            return $duty;

        })
        ->editColumn('status', function ($model) {
            return ucwords($this->dropdownService->claimStatus()[$model->status] ?? $model->status); 
        })
        ->editColumn('created_at', function ($model) {
            return Carbon::parse($model->created_at)->format('d M, Y');
        })
        ->addColumn('action', function ($model) {

            $show = '';

            $deleteUrl = route('claims.delete', $model->id);
            if(in_array($model->status, ['draft','pending'])) {
                $show .= '
                    <a class="btn btn-danger btn-sm" href="'.$deleteUrl.'"><i class="fa fa-trash"></i></a>
                ';
            }

            return $show;
        })
        ->rawColumns(['reference_no','staff_id','duty_date','created_at','action']);
    }

    public function query(Claim $model)
    {
        $que = $model->select(
                ...$model->qualifyColumns([
                    'id',
                    'reference_no',
                    'staff_id',
                    'type',
                    'duty_date',
                    'duty_start_time',
                    'duty_end_time',
                    'work_location',
                    'status',
                    'created_at',
                ])
            );

        if($this->status && ($this->status !== null && $this->status !== 'all'))
        {
            $que->where(function ($query) {
                $query->where('status', $this->status);
                if (Gate::allows('menu-approver'))
                {
                    $manager = Auth::guard('admin')->user();
                    $query->where('manager_id', $manager->id);
                }
            });
        }
        else{
            
            $que->where(function ($query) {
                if (Gate::allows('menu-approver'))
                {
                    $manager = Auth::guard('admin')->user();
                    $query->where('manager_id', $manager->id);
                }
            });
        }

        return $que;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId($this->tableId)
            ->columns([

                Column::make('id')->hidden(),
                Column::make('reference_no')->title('Reference No'),
                Column::make('staff_id')->title('Staff'),
                Column::make('type')->title('Claim Type'),
                Column::make('duty_date')->title('Duty Info'),
                Column::make('work_location')->title('Work Location'),
                Column::make('status')->title('Status'),
                Column::make('created_at')->title('Submitted At'),
                // Column::computed('action')
                //     ->title('Action')
                //     ->exportable(false)
                //     ->printable(false)
                //     ->width(60)
                //     ->addClass('text-center'),
            ])
            ->orders([0,1])
            ->orderBy(0, 'desc');
    }
    
}