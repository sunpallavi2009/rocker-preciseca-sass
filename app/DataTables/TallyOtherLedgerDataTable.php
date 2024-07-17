<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\TallyOtherLedger;
use App\Facades\UtilityFacades;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TallyOtherLedgerDataTable extends DataTable
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

    public function query(TallyOtherLedger $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('tallyOtherLedger-table')
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
            Column::make('guid')->title(__('Guid')),
            Column::make('currency_name')->title(__('Currency Name')),
            Column::make('prior_state_name')->title(__('PRIORSTATENAME')),
            Column::make('income_tax_number')->title(__('INCOMETAXNUMBER')),
            Column::make('parent')->title(__('Parent')),
            // Column::make('tcs_applicable')->title(__('TCSAPPLICABLE')),
            Column::make('tax_classification_name')->title(__('TAXCLASSIFICATIONNAME')),
            Column::make('tax_type')->title(__('TAXTYPE')),
            // Column::make('country_of_residence')->title(__('COUNTRYOFRESIDENCE')),
            // Column::make('ledger_country_isd_code')->title(__('LEDGERCOUNTRYISDCODE')),
            Column::make('gst_type')->title(__('GSTTYPE')),
            Column::make('appropriate_for')->title(__('APPROPRIATEFOR')),
            // Column::make('gst_nature_of_supply')->title(__('GSTNATUREOFSUPPLY')),
            Column::make('service_category')->title(__('SERVICECATEGORY')),
            // Column::make('party_business_style')->title(__('PARTYBUSINESSSTYLE')),
            Column::make('is_bill_wise_on')->title(__('ISBILLWISEON')),
            Column::make('is_cost_centres_on')->title(__('ISCOSTCENTRESON')),
            Column::make('alter_id')->title(__('Alter Id')),
            // Column::make('opening_balance')->title(__('OPENINGBALANCE')),
            Column::make('address')->title(__('Address')),
        ];
    }

    protected function filename(): string
    {
        return 'Faq_' . date('YmdHis');
    }
}
