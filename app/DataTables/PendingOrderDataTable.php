<?php

namespace App\DataTables;

use App\Models\Order;
use App\Models\PendingOrder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PendingOrderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('user_name', function ($query){
                return $query->user->name;
            })->addColumn('grand_total', function ($query){
                return $query->grand_total . ' '. strtoupper($query->currency_name);
            })
            ->addColumn('order_status', function ($query){
                if ($query->order_status === 'delivered'){
                    return '<span class="badge badge-success">Delivered</span>';
                }elseif($query->order_status === 'declined'){
                    return '<span class="badge badge-danger">Declined</span>';
                }else{
                    return '<span class="badge badge-warning">'.$query->order_status.'</span>';
                }
            })
            ->addColumn('payment_status', function ($query){
                if (strtoupper($query->payment_status) === 'COMPLETED'){
                    return '<span class="badge badge-success">Completed</span>';
                }elseif($query->payment_status === 'pending'){
                    return '<span class="badge badge-danger">Pending</span>';
                }else{
                    return '<span class="badge badge-warning">'.$query->order_status.'</span>';
                }
            })->addColumn('date', function ($query){
                return date('d-m-Y', strtotime($query->created_at));
            })
            ->addColumn('action', function ($query){
                $view = "<a href='".route('admin.order.show',$query->id)."' class='btn btn-sm btn-primary'><i class='fas fa-eye'></i></a>";
                $status = "<a href='javascript' class='btn btn-sm btn-warning ml-1 order_status_btn' data-id='$query->id' data-toggle='modal' data-target='#status_modal'><i class='fas fa-truck-loading'></i></a>";
                $delete = "<a href='".route('admin.order.destroy',$query->id)."' class='btn btn-sm btn-danger delete-item ml-1'><i class='fas fa-trash'></i></a>";
                return $view.$status.$delete;
            })
            ->rawColumns(['order_status', 'action', 'payment_status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model->where('order_status','pending')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pendingorder-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('invoice_id'),
            Column::make('user_name'),
            Column::make('product_qty'),
            Column::make('grand_total'),
            Column::make('order_status'),
            Column::make('payment_status'),
            Column::make('date'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PendingOrder_' . date('YmdHis');
    }
}
