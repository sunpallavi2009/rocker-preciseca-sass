<?php

namespace App\DataTables\SuperAdmin;

use Carbon\Carbon;
use App\Models\TallyLedger;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
{
    protected $topCustomerCount;
    protected $noSalesCount;

    public function __construct()
    {
        $this->topCustomerCount = TallyLedger::where('parent', 'Sundry Debtors')
            ->whereNotNull('opening_balance')
            ->where('opening_balance', '!=', 0)
            ->count();

        $this->noSalesCount = TallyLedger::where('parent', 'Sundry Debtors')
            ->where(function ($query) {
                $query->where('opening_balance', '=', 0)
                    ->orWhereNull('opening_balance');
            })
            ->count();
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return Carbon::parse($request->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('opening_balance', function ($data) {
                return $data->opening_balance ? number_format(abs($data->opening_balance), 2) : '0.00';
            })
            ->editColumn('language_name', function ($data) {
                $url = route('customers.show', ['customer' => $data->guid]); // Ensure 'customer' matches the route parameter name
                return '<a href="' . $url . '" style="color: #337ab7;">' . $data->language_name . '</a>';
            })
            ->editColumn('bill_credit_period', function ($data) {
                // Check if bill_credit_period is null or empty, then display "-"
                if (empty($data->bill_credit_period)) {
                    return '-';
                }
                // Extract numeric part from the bill_credit_period
                return preg_replace('/\D/', '', $data->bill_credit_period);
            })
            ->rawColumns(['language_name']);
    }

    public function query(TallyLedger $model)
    {
        $filter = request()->get('filter', 'all');

        if ($filter === 'top_customers') {
            return $model->newQuery()->where('parent', 'Sundry Debtors')
                ->whereNotNull('opening_balance')
                ->where('opening_balance', '!=', 0);
        } elseif ($filter === 'no_sales') {
            return $model->newQuery()->where('parent', 'Sundry Debtors')
                ->where(function ($query) {
                    $query->where('opening_balance', '=', 0)
                        ->orWhereNull('opening_balance');
                });
        }

        return $model->newQuery()->where('parent', 'Sundry Debtors');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('customer-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(3)
            ->language([
                "paginate" => [
                    "next" => '<i class="ti ti-chevron-right"></i>next',
                    "previous" => '<i class="ti ti-chevron-left"></i>Prev'
                ],
                'lengthMenu' => __('Show _MENU_ entries'),
                "searchPlaceholder" => __('Search...'), "search" => ""
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
                               <'dataTable-top row'<'dataTable-dropdown page-dropdown col-lg-3 col-sm-12'l><'dataTable-buttons col-lg-6 col-sm-12'B><'dataTable-search tb-search col-lg-3 col-sm-12'f>>
                             <'dataTable-container'<'col-sm-12'tr>>
                             <'dataTable-bottom row'<'col-sm-5'i><'col-sm-7'p>>
                               ",
                'buttons' => [
                    [
                        'text' => 'Top Customer (' . $this->topCustomerCount . ')',
                        'className' => 'btn btn-outline-secondary radius-30',
                        'action' => 'function () {
                            var table = $("#customer-table").DataTable();
                            table.ajax.url("' . route('customers.index') . '?filter=top_customers").load();
                        }'
                    ],
                    [
                        'text' => 'No Sales (' . $this->noSalesCount . ')',
                        'className' => 'btn btn-outline-secondary radius-30',
                        'action' => 'function () {
                            var table = $("#customer-table").DataTable();
                            table.ajax.url("' . route('customers.index') . '?filter=no_sales").load();
                        }'
                    ],
                    [
                        'text' => 'New Customers',
                        'className' => 'btn btn-outline-secondary radius-30',
                        'action' => 'function () {
                            // Define the action for New Customers button
                            console.log("New Customers button clicked");
                        }'
                    ],
                    [
                        
                        'text' => 'Reset <i class="bx bx-x"></i>',
                        'className' => 'btn btn-outline-warning radius-30',
                        'action'=> 'function () {
                            var table = $("#customer-table").DataTable();
                            table.ajax.url("' . route('customers.index') . '").load();
                        }'
                    ]
                ],
                "scrollX" => true,
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
                        return new bootstrap.Popover(tooltipTriggerEl);
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
            Column::make('No')->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            // Column::make('guid')->title(__('Guid')),
            Column::make('language_name')->title(__('Name')),
            Column::make('parent')->title(__('Group')),
            Column::make('opening_balance')->title(__('Sales (Last 30 days)'))->addClass('text-end'),
            Column::make('opening_balance')->title(__('Sales (Last 30 days)'))->addClass('text-end'),
            Column::make('opening_balance')->title(__('% Change (Last 30 days)'))->addClass('text-end'),
            Column::make('opening_balance')->title(__('&#8377 Net Outstanding (As of Today)'))->addClass('text-end'),
            Column::make('opening_balance')->title(__('&#8377 Overdue (Total)'))->addClass('text-end'),
            Column::make('opening_balance')->title(__('&#8377 Upcoming (Total)'))->addClass('text-end'),
            Column::make('opening_balance')->title(__('&#8377 Upcoming (Due in 7 days)'))->addClass('text-end'),
            Column::make('opening_balance')->title(__('&#8377 On Account (As of Today)'))->addClass('text-end'),
            Column::make('opening_balance')->title(__('&#8377 PDC (Total)'))->addClass('text-end'),
            Column::make('opening_balance')->title(__('&#8377 Payment Collection (Current FY)'))->addClass('text-end'),
            Column::make('opening_balance')->title(__('&#8377 Last Payment (Date)')),
            Column::make('opening_balance')->title(__('Avg Pay day'))->addClass('text-end'),
            Column::make('opening_balance')->title(__('&#8377 Credit Limit'))->addClass('text-end'),
            Column::make('bill_credit_period')->title(__('&#8377 Credit Period (Days)'))->addClass('text-end'),
        ];
    }

    protected function filename(): string
    {
        return 'Customer_' . date('YmdHis');
    }
}
