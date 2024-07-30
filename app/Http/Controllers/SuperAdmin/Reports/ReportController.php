<?php

namespace App\Http\Controllers\SuperAdmin\Reports;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\TallyGroup;
use App\Models\TallyLedger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 

class ReportController extends Controller
{
    public function index()
    {
        return view ('superadmin.reports.index');
    }

    

    public function AllVoucherHeadReports($voucherHeadId)
    {
        $voucherHead = TallyLedger::where('guid', $voucherHeadId)->firstOrFail();
        $voucherHeadName = $voucherHead->language_name;

        $menuItems = TallyLedger::where('language_name', $voucherHead->language_name)->get();

        return view('superadmin.reports._voucher_heads', [
            'voucherHead' => $voucherHead,
            'voucherHeadId' => $voucherHeadId ,
            'menuItems' => $menuItems
        ]);
    }
    
    public function getVoucherHeadData($cashBankLedgerId)
    {
        $cashBankLedger = TallyLedger::where('guid', $cashBankLedgerId)->firstOrFail();
        $cashBankLedgerName = $cashBankLedger->name;
        $cashBankLadgerGuid = $cashBankLedger->guid;

        $query = TallyLedger::select('tally_ledgers.*', 
                                    'tally_voucher_heads.entry_type', 
                                    'tally_voucher_heads.amount',
                                    'tally_voucher_heads.ledger_name',  
                                    'tally_vouchers.voucher_type' , 
                                    'tally_vouchers.voucher_date', 
                                    'tally_vouchers.voucher_number')
            ->leftJoin('tally_voucher_heads', 'tally_ledgers.guid', '=', 'tally_voucher_heads.ledger_guid')
            ->leftJoin('tally_vouchers', 'tally_voucher_heads.tally_voucher_id', '=', 'tally_vouchers.id')
            ->where('tally_ledgers.guid', $cashBankLadgerGuid);

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($entry) {
                return Carbon::parse($entry->created_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('credit', function ($entry) {
                return $entry->entry_type == 'credit' ? number_format(abs($entry->amount), 2, '.', '') : '-';
            })
            ->addColumn('debit', function ($entry) {
                return $entry->entry_type == 'debit' ? number_format(abs($entry->amount), 2, '.', '') : '-';
            })
            ->addColumn('running_balance', function ($entry) {
                // Placeholder for running balance
                return '-';
            })
            ->make(true);
    }
}
