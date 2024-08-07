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
    private $normalizedNames = [
        'Direct Expenses, Expenses (Direct)' => 'Direct Expenses',
        'Direct Incomes, Income (Direct)' => 'Direct Incomes',
        'Indirect Expenses, Expenses (Indirect)' => 'Indirect Expenses',
        'Indirect Incomes, Income (Indirect)' => 'Indirect Incomes',
    ];

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
                $name = $data->name;
                $normalizedNames = $this->normalizedNames;
                
                if (isset($normalizedNames[$name])) {
                    $name = $normalizedNames[$name];
                }
                // Log::info('normalizedNames:', ['normalizedNames' => $normalizedNames]);
                $groupCount = TallyGroup::where('parent', $name)->count();
                if ($groupCount == 0) {
                    return Tallyledger::where('parent', $name)->count();
                }
                return $groupCount;
            })


            ->editColumn('total_credit', function ($data) {
                $name = $data->name;

                foreach ($this->normalizedNames as $pattern => $normalized) {
                    if (strpos($name, $pattern) !== false) {
                        $name = $normalized;
                        break;
                    }
                }
                
                $groupLedgerIdsQuery = TallyGroup::where('parent', $name);
                $groupLedgerIds = $groupLedgerIdsQuery->pluck('name');
            
                if ($groupLedgerIds->isNotEmpty()) {
                    $ledgerIds = Tallyledger::whereIn('parent', $groupLedgerIds)
                        ->pluck('guid');
                } else {
                    $ledgerIds = Tallyledger::where('parent', $name)->pluck('guid');
                }
            
                $allLedgerIds = $ledgerIds->unique();
            
                if ($allLedgerIds->isEmpty()) {
                    return '-';  
                }
            
                $totalCredit = TallyVoucherHead::whereIn('ledger_guid', $allLedgerIds)
                    ->where('entry_type', 'credit')
                    ->sum('amount');
            
                if ($totalCredit == 0) {
                    return '-';  
                }
            
                return number_format($totalCredit, 2);
            })

            ->editColumn('total_debit', function ($data) {
                $name = $data->name;
                
                foreach ($this->normalizedNames as $pattern => $normalized) {
                    if (strpos($name, $pattern) !== false) {
                        $name = $normalized;
                        break;
                    }
                }
                
                $groupLedgerIdsQuery = TallyGroup::where('parent', $name);
                $groupLedgerIds = $groupLedgerIdsQuery->pluck('name');
                
                if ($groupLedgerIds->isNotEmpty()) {
                    $ledgerIds = Tallyledger::whereIn('parent', $groupLedgerIds)
                        ->pluck('guid');
                } else {
                    $ledgerIds = Tallyledger::where('parent', $name)->pluck('guid');
                }
                
                $allLedgerIds = $ledgerIds->unique();
                
                if ($allLedgerIds->isEmpty()) {
                    return '-';  // Return empty string instead of '-'
                }
                
                $totalDebit = TallyVoucherHead::whereIn('ledger_guid', $allLedgerIds)
                    ->where('entry_type', 'debit')
                    ->sum('amount');
                
                if ($totalDebit == 0) {
                    return '-';  // Return empty string instead of '-'
                }
                
                return number_format(abs($totalDebit), 2);  // Remove negative sign using abs()
            })
            
            ->editColumn('opening_balance', function ($data) {
                $name = $data->name;
                
                foreach ($this->normalizedNames as $pattern => $normalized) {
                    if (strpos($name, $pattern) !== false) {
                        $name = $normalized;
                        break;
                    }
                }
                
                $groupLedgerIdsQuery = TallyGroup::where('parent', $name);
                $groupLedgerIds = $groupLedgerIdsQuery->pluck('name');
                
                if ($groupLedgerIds->isNotEmpty()) {
                    $ledgerIds = Tallyledger::whereIn('parent', $groupLedgerIds)
                        ->pluck('guid');
                } else {
                    $ledgerIds = Tallyledger::where('parent', $name)->pluck('guid');
                }
                
                $allLedgerIds = $ledgerIds->unique();
                
                if ($allLedgerIds->isEmpty()) {
                    return '-';  // Return empty string instead of '-'
                }
                
                $openingBalance = TallyVoucherHead::whereIn('ledger_guid', $allLedgerIds)
                    ->where('entry_type', 'opening')
                    ->sum('amount');
                
                if ($openingBalance == 0) {
                    return '-';  // Return empty string instead of '-'
                }
                
                return number_format(abs($openingBalance), 2);  // Remove negative sign using abs()
            })
            
            ->editColumn('closing_balance', function ($data) {
                $name = $data->name;
                
                foreach ($this->normalizedNames as $pattern => $normalized) {
                    if (strpos($name, $pattern) !== false) {
                        $name = $normalized;
                        break;
                    }
                }
                
                $groupLedgerIdsQuery = TallyGroup::where('parent', $name);
                $groupLedgerIds = $groupLedgerIdsQuery->pluck('name');
                
                if ($groupLedgerIds->isNotEmpty()) {
                    $ledgerIds = Tallyledger::whereIn('parent', $groupLedgerIds)
                        ->pluck('guid');
                } else {
                    $ledgerIds = Tallyledger::where('parent', $name)->pluck('guid');
                }
                
                $allLedgerIds = $ledgerIds->unique();
                
                if ($allLedgerIds->isEmpty()) {
                    return '-';  
                }
                
                $totalDebit = TallyVoucherHead::whereIn('ledger_guid', $allLedgerIds)
                    ->where('entry_type', 'debit')
                    ->sum('amount');
                
                $totalCredit = TallyVoucherHead::whereIn('ledger_guid', $allLedgerIds)
                    ->where('entry_type', 'credit')
                    ->sum('amount');

                
                $openingBalance = TallyVoucherHead::whereIn('ledger_guid', $allLedgerIds)
                    ->where('entry_type', 'opening')
                    ->sum('amount');

                $total = $totalDebit + $totalCredit;
                
                // $closingBalance = $openingBalance + $totalDebit + $totalCredit;
                $closingBalance = $openingBalance + $total;
                
                if ($closingBalance == 0) {
                    return '-'; 
                }
                
                return number_format(abs($closingBalance), 2); 
            })

            ->rawColumns(['name']);
    }

    public function query(TallyGroup $model)
    {
        return $model->newQuery()->where('parent', '');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('general-ledger-table')
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
            Column::make('opening_balance')->title(__('Opening Balance'))->addClass('text-end'),
            Column::make('total_debit')->title(__('Debit'))->addClass('text-end'),
            Column::make('total_credit')->title(__('Credit'))->addClass('text-end'),
            Column::make('closing_balance')->title(__('Closing Balance'))->addClass('text-end'),
        ];
    }

    protected function filename(): string
    {
        return 'GeneralLedger_' . date('YmdHis');
    }
}
