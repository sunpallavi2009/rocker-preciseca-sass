<?php

namespace App\DataTables\SuperAdmin;

use Carbon\Carbon;
use App\Models\TallyGroup;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CashBankDataTable extends DataTable
{

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return Carbon::parse($request->created_at)->format('Y-m-d H:i:s');
            })
            // ->editColumn('name', function ($model) {
            //     // Create a link to the detailed page for this account
            //     return '<a href="' . route('reports.GeneralLedger.details', ['id' => $model->id]) . '">' . $model->name . '</a>';
            // })
            ->editColumn('name', function ($data) {
                $url = route('reports.CashBank.details', ['CashBank' => $data->id]); // Ensure 'customer' matches the route parameter name
                return '<a href="' . $url . '" style="color: #337ab7;">' . $data->name . '</a>';
            })
            ->rawColumns(['name']); 
    }

    public function query(TallyGroup $model)
    {
        $names = ['Bank Accounts', 'Bank OD A/c, Bank OCC A/c', 'Cash-in-Hand'];
        return $model->newQuery()->whereIn('name', $names);
        // return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('cashbank-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->language([
                'lengthMenu' => __('Show _MENU_ entries'),
                "searchPlaceholder" => __('Search...'), 
                "search" => ""
            ])
            ->initComplete('function() {
                var table = this;
                var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
                searchInput.removeClass(\'form-control form-control-sm\').addClass(\'form-control ps-5 radius-30\').attr(\'placeholder\', \'Search Order\');
                searchInput.wrap(\'<div class="position-relative pt-1"></div>\');
                searchInput.parent().append(\'<span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>\');
                
                var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'form-select form-select-sm\');
            }')
            ->parameters([
                "dom" =>  "
                    <'dataTable-top row'<'dataTable-dropdown page-dropdown col-lg-3 col-sm-12'l><'dataTable-botton table-btn col-lg-6 col-sm-12'B><'dataTable-search tb-search col-lg-3 col-sm-12'f>>
                    <'dataTable-container'<'col-sm-12'tr>>
                ",
                'buttons' => [
                    // Define buttons here if needed
                ],
                "scrollX" => true,
                "paging" => false,
                "drawCallback" => 'function( settings ) {
                    var tooltipTriggerList = [].slice.call(
                        document.querySelectorAll("[data-bs-toggle=tooltip]")
                    );
                    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                    var popoverTriggerList = [].slice.call(
                        document.querySelectorAll("[data-bs-toggle=popover]")
                    );
                    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                        return new bootstrap.Popover(popoverTriggerEl);
                    });
                    var toastElList = [].slice.call(document.querySelectorAll(".toast"));
                    var toastList = toastElList.map(function (toastEl) {
                        return new bootstrap.Toast(toastEl);
                    });
                }'
            ])->language([
                'buttons' => [
                    'create' => __('Create'),
                    'export' => __('Export'),
                    'print' => __('Print'),
                    'reset' => __('Reset'),
                    'reload' => __('Reload'),
                    'excel' => __('Excel'),
                    'csv' => __('CSV'),
                ]
            ]);
    }

    protected function getColumns()
    {
        return [
            Column::make('name')->title(__('Account')),
            Column::make('parent')->title(__('Account Type')),
            Column::make('parent')->title(__('Opening Balance')), // Adjust as needed
            Column::make('parent')->title(__('Debit')), // Adjust as needed
            Column::make('parent')->title(__('Credit')), // Adjust as needed
            Column::make('parent')->title(__('Closing Balance')), // Adjust as needed
        ];
    }

    protected function filename(): string
    {
        return 'Faq_' . date('YmdHis');
    }
}
