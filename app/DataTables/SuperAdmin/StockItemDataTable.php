<?php

namespace App\DataTables\SuperAdmin;

use Carbon\Carbon;
use App\Models\TallyItem;
use App\Facades\UtilityFacades;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StockItemDataTable extends DataTable
{

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return Carbon::parse($request->created_at)->format('Y-m-d H:i:s');
            });
    }

    public function query(TallyItem $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('stock-item-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
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
                               <'dataTable-top row'<'dataTable-dropdown page-dropdown col-lg-3 col-sm-12'l><'dataTable-botton table-btn col-lg-6 col-sm-12'B><'dataTable-search tb-search col-lg-3 col-sm-12'f>>
                             <'dataTable-container'<'col-sm-12'tr>>
                             <'dataTable-bottom row'<'col-sm-5'i><'col-sm-7'p>>
                               ",
                'buttons'   => [
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
            Column::make('language_name')->title(__('Name')),
            Column::make('parent')->title(__('Stock Group')),
            Column::make('opening_balance')->title(__('Stock On Hand (qty)')),
            Column::make('opening_value')->title(__('Stock On Hand (value)')),
            // Column::make('parent')->title(__('&#8377 Total Sales Value (Last 30 days)')),
            // Column::make('parent')->title(__('&#8377 Total Sales Qty (Last 30 days)')),
            Column::make('parent')->title(__('Total Sales Qty')),
            Column::make('parent')->title(__('GST Total Sales Value')),
            Column::make('parent')->title(__('&#8377 Last Sale (value)')),
            Column::make('parent')->title(__('Last Sale (Date)')),
            Column::make('parent')->title(__('GST Rate')),
            Column::make('category')->title(__('Stock Category')),
            Column::make('alias')->title(__('Alias')),
            Column::make('parent')->title(__('Supplier Item No.')),
        ];
        // return [
        //     Column::make('No')->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
        //     Column::make('language_name')->title(__('Name')),
        //     Column::make('parent')->title(__('Stock Group')),
        //     Column::make('opening_balance')->title(__('Stock On Hand (qty)')),
        //     Column::make('opening_value')->title(__('Stock On Hand (value)')),
        //     Column::make('parent')->title(__('Ordered Qty (Purchase Pending)')),
        //     Column::make('parent')->title(__('Committed Qty (For Sale)')),
        //     Column::make('parent')->title(__('Stock Available (For Sale)')),
        //     Column::make('parent')->title(__('&#8377 Total Sales Value (Last 30 days)')),
        //     Column::make('parent')->title(__('&#8377 Total Sales Qty (Last 30 days)')),
        //     Column::make('parent')->title(__('&#8377 Last Sale (value)')),
        //     Column::make('parent')->title(__('Last Sale (Date)')),
        //     Column::make('parent')->title(__('&#8377 Total Purchase Value (Last 30 days)')),
        //     Column::make('parent')->title(__('&#8377 Total Purchase Qty (Last 30 days)')),
        //     Column::make('parent')->title(__('&#8377 Last Purchase (value)')),
        //     Column::make('parent')->title(__('Last Purchase (Date)')),
        //     Column::make('parent')->title(__('&#8377 Std Sell Price')),
        //     Column::make('parent')->title(__('&#8377 Std Cost Price')),
        //     Column::make('parent')->title(__('GST Rate')),
        //     Column::make('parent')->title(__('Likely To Run Out (In Days)')),
        //     Column::make('parent')->title(__('Reorder Level')),
        //     Column::make('category')->title(__('Stock Category')),
        //     Column::make('alias')->title(__('Alias')),
        //     Column::make('parent')->title(__('Supplier Item No.')),
        // ];
    }

    protected function filename(): string
    {
        return 'Faq_' . date('YmdHis');
    }
}
