<?php

namespace App\Http\Controllers\SuperAdmin\Reports;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use App\Models\TallyGroup;
use App\Models\TallyLedger;
use App\Models\TallyVoucherHead;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\DataTables\SuperAdmin\DayBookDataTable;
use App\DataTables\SuperAdmin\GeneralLedgerDataTable;
use App\DataTables\SuperAdmin\CashBankDataTable;
use Illuminate\Support\Facades\DB;

class ReportGeneralLedgerController extends Controller
{

    public function index(GeneralLedgerDataTable $dataTable)
    {
        return $dataTable->render('superadmin.reports.generalLedger.index');
    }

    public function AllGeneralLedgerReports($generalLedgerId)
    {
        $generalLedger = TallyGroup::findOrFail($generalLedgerId);

        $menuItems = TallyGroup::where('parent', '')->get();

        return view('superadmin.reports.generalLedger._general_ledger_details', [
            'generalLedger' => $generalLedger,
            'generalLedgerId' => $generalLedgerId ,
            'menuItems' => $menuItems
        ]);
    }

    public function getGeneralLedgerData($generalLedgerId)
    {
        $generalLedger = TallyGroup::findOrFail($generalLedgerId);
        $generalLedgerName = $generalLedger->name;
    
        $query = TallyGroup::select(
                'tally_groups.*', 
                \DB::raw('COUNT(tally_ledgers.id) as ledgers_count'),
                \DB::raw('SUM(CASE WHEN tally_voucher_heads.entry_type = "debit" THEN tally_voucher_heads.amount ELSE 0 END) as total_debit'),
                \DB::raw('SUM(CASE WHEN tally_voucher_heads.entry_type = "credit" THEN tally_voucher_heads.amount ELSE 0 END) as total_credit'),
                \DB::raw('tally_ledgers.opening_balance'),
                \DB::raw('(tally_ledgers.opening_balance + 
                           SUM(CASE WHEN tally_voucher_heads.entry_type = "debit" THEN tally_voucher_heads.amount ELSE 0 END) + 
                           SUM(CASE WHEN tally_voucher_heads.entry_type = "credit" THEN tally_voucher_heads.amount ELSE 0 END)) as closing_balance')
            )
            ->leftJoin('tally_ledgers', 'tally_groups.name', '=', 'tally_ledgers.parent')
            ->leftJoin('tally_voucher_heads', 'tally_ledgers.guid', '=', 'tally_voucher_heads.ledger_guid')
            ->where('tally_groups.parent', $generalLedgerName)
            ->groupBy('tally_groups.id', 'tally_groups.name', 'tally_groups.parent', 'tally_groups.created_at', 'tally_groups.updated_at', 'tally_ledgers.opening_balance');
    
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('total_debit', function ($row) {
                return $this->formatNumber($row->total_debit);
            })
            ->editColumn('total_credit', function ($row) {
                return $this->formatNumber($row->total_credit);
            })
            ->editColumn('opening_balance', function ($row) {
                return $this->formatNumber($row->opening_balance);
            })
            ->editColumn('closing_balance', function ($row) {
                return $this->formatNumber($row->closing_balance);
            })
            ->editColumn('created_at', function ($request) {
                return Carbon::parse($request->created_at)->format('Y-m-d H:i:s');
            })
            ->make(true);
    }
    


    // public function getGeneralLedgerData($generalLedgerId)
    // {
    //     $generalLedger = TallyGroup::findOrFail($generalLedgerId);
    //     $generalLedgerName = $generalLedger->name;
    
    //     $query = TallyGroup::select('tally_groups.*', \DB::raw('COUNT(tally_ledgers.id) as ledgers_count'))
    //         ->leftJoin('tally_ledgers', 'tally_groups.name', '=', 'tally_ledgers.parent')
    //         ->where('tally_groups.parent', $generalLedgerName)
    //         ->groupBy('tally_groups.id', 'tally_groups.name', 'tally_groups.parent', 'tally_groups.created_at', 'tally_groups.updated_at');
    
    //     return DataTables::of($query)
    //         ->addIndexColumn()
    //         ->editColumn('created_at', function ($request) {
    //             return Carbon::parse($request->created_at)->format('Y-m-d H:i:s');
    //         })
    //         ->make(true);
    // }
    

    // public function getGeneralLedgerData($generalLedgerId)
    // {
    //     $generalLedger = TallyGroup::findOrFail($generalLedgerId);
    //     $generalLedgerName = $generalLedger->name;

    //     $query = TallyGroup::where('parent', $generalLedgerName);

    //     return DataTables::of($query)
    //         ->addIndexColumn()
    //         ->editColumn('created_at', function ($request) {
    //             return Carbon::parse($request->created_at)->format('Y-m-d H:i:s');
    //         })
    //         ->make(true);
    // }

    public function AllGeneralGroupLedgerReports($generalLedgerId)
    {
        $generalLedger = TallyGroup::findOrFail($generalLedgerId);

        $menuItems = TallyGroup::where('parent', $generalLedger->parent)->get();

        return view('superadmin.reports.generalLedger._general_group_ledger_details', [
            'generalLedger' => $generalLedger,
            'generalLedgerId' => $generalLedgerId ,
            'menuItems' => $menuItems
        ]);
    }

    public function getGeneralGroupLedgerData($generalLedgerId)
    {
        $generalLedger = TallyGroup::findOrFail($generalLedgerId);
        $generalLedgerName = $generalLedger->name;
    
        $query = TallyLedger::where('parent', $generalLedgerName)
            ->leftJoin('tally_voucher_heads', 'tally_ledgers.guid', '=', 'tally_voucher_heads.ledger_guid')
            ->select(
                'tally_ledgers.language_name',
                'tally_ledgers.guid',
                'tally_ledgers.opening_balance',
                DB::raw('SUM(CASE WHEN tally_voucher_heads.entry_type = "debit" THEN tally_voucher_heads.amount ELSE 0 END) as debit'),
                DB::raw('SUM(CASE WHEN tally_voucher_heads.entry_type = "credit" THEN tally_voucher_heads.amount ELSE 0 END) as credit'),
                DB::raw('(tally_ledgers.opening_balance + 
                          SUM(CASE WHEN tally_voucher_heads.entry_type = "debit" THEN tally_voucher_heads.amount ELSE 0 END) + 
                          SUM(CASE WHEN tally_voucher_heads.entry_type = "credit" THEN tally_voucher_heads.amount ELSE 0 END)) as closing_balance')
            )
            ->groupBy('tally_ledgers.language_name', 'tally_ledgers.guid', 'tally_ledgers.opening_balance');
    
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('opening_balance', function ($row) {
                return $this->formatNumber($row->opening_balance);
            })
            ->editColumn('debit', function ($row) {
                return $this->formatNumber($row->debit);
            })
            ->editColumn('credit', function ($row) {
                return $this->formatNumber($row->credit);
            })
            ->editColumn('closing_balance', function ($row) {
                return $this->formatNumber($row->closing_balance);
            })
            ->make(true);
    }
    protected function formatNumber($value)
    {
        // Ensure the value is numeric
        if (!is_numeric($value) || $value == 0) {
            return '-';
        }
    
        // Convert to float, remove negative sign, and format
        $floatValue = (float) $value;
        return number_format(abs($floatValue), 2, '.', '');
    }
    

    


}
