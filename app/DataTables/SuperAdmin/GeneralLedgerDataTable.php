<?php

namespace App\DataTables\SuperAdmin;

use Carbon\Carbon;
use App\Models\TallyGroup;
use App\Models\Tallyledger;
use App\Models\TallyVoucherHead;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GeneralLedgerDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return Carbon::parse($request->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('name', function ($data) {
                $url = route('reports.GeneralLedger.details', ['GeneralLedger' => $data->id]);
                return '<a href="' . $url . '" style="color: #337ab7;">' . $data->name . '</a>';
            })
            ->editColumn('account_type', function ($data) {
                $name = strtolower($data->name);
                if (strpos($name, 'assets') !== false || strpos($name, 'asset') !== false || strpos($name, 'investments') !== false) {
                    return 'Asset';
                } elseif (strpos($name, 'income') !== false || strpos($name, 'revenue') !== false || strpos($name, 'sales accounts') !== false) {
                    return 'Revenue';
                } elseif (strpos($name, 'liabilities') !== false || strpos($name, 'liability') !== false || strpos($name, 'branch / divisions') !== false || strpos($name, 'suspense a/c') !== false || strpos($name, 'capital account') !== false) {
                    return 'Liability';
                } elseif (strpos($name, 'expense') !== false || strpos($name, 'purchase') !== false) {
                    return 'Expense';
                }
                return $data->account_type;
            })
            ->editColumn('ledger_count', function ($data) {
                $groupCount = TallyGroup::where('parent', $data->name)->count();
                if ($groupCount == 0) {
                    return Tallyledger::where('parent', $data->name)->count();
                }
                return $groupCount;
            })
            // ->editColumn('total_debit', function ($data) {
            //     $totalDebit = Tallyledger::where('parent', $data->name)
            //         ->leftJoin('tally_voucher_heads', 'tally_ledgers.guid', '=', 'tally_voucher_heads.ledger_guid')
            //         ->where('tally_voucher_heads.entry_type', 'debit')
            //         ->sum('tally_voucher_heads.amount');
            //     Log::info('totalDebit:', ['totalDebit' => $totalDebit]);
            //     return $totalDebit;
            // })
            // ->editColumn('total_credit', function ($data) {
            //     $totalCredit = Tallyledger::where('parent', $data->name)
            //         ->leftJoin('tally_voucher_heads', 'tally_ledgers.guid', '=', 'tally_voucher_heads.ledger_guid')
            //         ->where('tally_voucher_heads.entry_type', 'credit')
            //         ->sum('tally_voucher_heads.amount');
                  

            //     // Log::info('totalCredit:', ['totalCredit' => $totalCredit]);
            //     return $totalCredit;
            // })
            
            // ->editColumn('total_credit', function ($data) {
            //     // Check if there are any TallyGroup records with parent matching $data->name
            //     $groupCount = TallyGroup::where('parent', $data->name)->count();
            
            //     // Log group count for debugging
            //     Log::info('groupCount:', ['groupCount' => $groupCount]);
            
            //     if ($groupCount == 0) {
            //         // If no TallyGroup records are found, use Tallyledger records
            //         // Fetch ledger IDs from Tallyledger
            //         $ledgerIds = Tallyledger::where('parent', $data->name)->pluck('guid');
                    
            //         // Log ledger IDs
            //         Log::info('ledgerIds:', ['ledgerIds' => $ledgerIds->toArray()]);
                
            //         if ($ledgerIds->isEmpty()) {
            //             Log::info('No ledgers found for parent:', ['parentName' => $data->name]);
            //             return 0;
            //         }
            
            //         // Sum credits from TallyVoucherHead based on Tallyledger IDs
            //         $totalCredit = TallyVoucherHead::whereIn('ledger_guid', $ledgerIds)
            //             ->where('entry_type', 'credit')
            //             ->sum('amount');
                    
            //         // Log total credit
            //         Log::info('totalCredit from Tallyledger:', ['totalCredit' => $totalCredit]);
                    
            //         return $totalCredit;
            //     } else {
            //         // If TallyGroup records are found, use TallyGroup count
            //         Log::info('Using TallyGroup count:', ['totalCredit' => $groupCount]);
            //         return $groupCount;
            //     }
            // })

            ->editColumn('total_credit', function ($data) {
                // Fetch ledger IDs from TallyGroup where 'parent' matches $data->name
                $groupLedgerIdsQuery = TallyGroup::where('parent', $data->name);
                
                // Execute the query to get a collection
                $groupLedgerIds = $groupLedgerIdsQuery->pluck('guid');
                
                Log::info('Fetched Group Ledger IDs:', ['groupLedgerIds' => $groupLedgerIds->toArray()]);
                
                if ($groupLedgerIds->isNotEmpty()) {
                    // Fetch ledger IDs from Tallyledger where 'guid' matches the ones from TallyGroup
                    $ledgerIds = Tallyledger::whereIn('guid', $groupLedgerIds)
                        ->pluck('guid');
                    
                    Log::info('Fetched Ledger IDs from Tallyledger (filtered by group IDs):', ['ledgerIds' => $ledgerIds->toArray()]);
                } else {
                    // If no group ledger IDs found, use Tallyledger directly
                    $ledgerIds = Tallyledger::where('parent', $data->name)->pluck('guid');
                    
                    Log::info('Fetched Ledger IDs from Tallyledger (directly):', ['ledgerIds' => $ledgerIds->toArray()]);
                }
                
                // Combine all ledger IDs
                $allLedgerIds = $ledgerIds->unique(); // Ensure unique IDs
                
                Log::info('Combined Ledger IDs:', ['allLedgerIds' => $allLedgerIds->toArray()]);
                
                // If no ledger IDs are found, return 0
                if ($allLedgerIds->isEmpty()) {
                    return 0;
                }
                
                // Sum credits from TallyVoucherHead based on the combined ledger IDs
                $totalCredit = TallyVoucherHead::whereIn('ledger_guid', $allLedgerIds)
                    ->where('entry_type', 'credit')
                    ->sum('amount');
                
                Log::info('Total Credit Calculation:', [
                    'ledger_guids' => $allLedgerIds->toArray(),
                    'totalCredit' => $totalCredit
                ]);
                
                return $totalCredit;
            })
            
            
            
            
            
            
            
            // ->editColumn('closing_balance', function ($data) {
            //     $openingBalance = Tallyledger::where('parent', $data->name)->sum('opening_balance');
            //     $totalDebit = Tallyledger::where('parent', $data->name)
            //         ->leftJoin('tally_voucher_heads', 'tally_ledgers.guid', '=', 'tally_voucher_heads.ledger_guid')
            //         ->where('tally_voucher_heads.entry_type', 'debit')
            //         ->sum('tally_voucher_heads.amount');
            //     $totalCredit = Tallyledger::where('parent', $data->name)
            //         ->leftJoin('tally_voucher_heads', 'tally_ledgers.guid', '=', 'tally_voucher_heads.ledger_guid')
            //         ->where('tally_voucher_heads.entry_type', 'credit')
            //         ->sum('tally_voucher_heads.amount');
            //     $closingBalance = $openingBalance + $totalDebit - $totalCredit;
            //     Log::info('closingBalance:', ['closingBalance' => $closingBalance]);
            //     return $closingBalance;
            // })
            ->rawColumns(['name']);
    }

    public function query(TallyGroup $model)
    {
        return $model->newQuery()->where('parent', '');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('generalledger-table')
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
            Column::make('account_type')->title(__('Account Type')),
            Column::make('ledger_count')->title(__('Count')),
            // Column::make('opening_balance')->title(__('Opening Balance')),
            // Column::make('total_debit')->title(__('Debit')),
            Column::make('total_credit')->title(__('Credit')),
            // Column::make('closing_balance')->title(__('Closing Balance')),
        ];
    }

    protected function filename(): string
    {
        return 'GeneralLedger_' . date('YmdHis');
    }
}
