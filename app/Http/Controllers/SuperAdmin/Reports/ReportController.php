<?php

namespace App\Http\Controllers\SuperAdmin\Reports;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\TallyGroup;
use App\Models\TallyLedger;
use App\Models\TallyVoucher;
use App\Models\TallyVoucherHead;
use App\Models\TallyVoucherItem;
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

    public function AllVoucherItemReports($voucherItemId)
    {
        $voucherItem = TallyVoucher::findOrFail($voucherItemId);
    
        $voucherItemName = TallyVoucher::where('party_ledger_name', $voucherItem->party_ledger_name)->get();
        $saleReceiptItem = $voucherItemName->firstWhere('voucher_type', 'Receipt');

        // Check if $saleReceiptItem is not null
        if ($saleReceiptItem) {
            $voucherHeadsSaleReceipt = TallyVoucherHead::where('tally_voucher_id', $saleReceiptItem->id)
                ->where('entry_type', 'credit')
                ->get();
        } else {
            // Handle the case where $saleReceiptItem is null
            $voucherHeadsSaleReceipt = collect(); // Or any default value you prefer
        }

        $ledgerData = TallyLedger::where('language_name', $voucherItem->party_ledger_name)->get();
        if ($ledgerData instanceof \Illuminate\Support\Collection) {
            $ledgerItem = $ledgerData->first();
        } else {
            $ledgerItem = $ledgerData; 
        }

        $creditPeriod = intval($ledgerItem->bill_credit_period ?? 0);
        $voucherDate = \Carbon\Carbon::parse($voucherItem->voucher_date);
        $dueDate = $voucherDate->copy()->addDays($creditPeriod);
        
        $voucherHeads = TallyVoucherHead::where('tally_voucher_id', $voucherItemId)->get();
        $totalRoundOff = $voucherHeads->filter(function ($head) {
            return $head->ledger_name === 'Round Off';
        })->sum('amount');
        $totalIGST18 = $voucherHeads->filter(function ($head) {
            return $head->ledger_name === 'IGST @18%';
        })->sum('amount');
        
        $voucherItems = TallyVoucherItem::where('tally_voucher_id', $voucherItemId)->get();
        $uniqueGstLedgerSources = $voucherItems->pluck('gst_ledger_source')->unique();
        $totalCountItems = TallyVoucherItem::where('tally_voucher_id', $voucherItemId)->count();
        $subtotalsamount = $voucherItems->sum('amount');

        $menuItems = TallyVoucher::get();

        return view('superadmin.reports._voucher_items', [
            'voucherItem' => $voucherItem,
            'ledgerData' => $ledgerData,
            'voucherHeads' => $voucherHeads,
            'totalRoundOff' => $totalRoundOff,
            'totalIGST18' => $totalIGST18,
            'totalCountItems' => $totalCountItems,
            'uniqueGstLedgerSources' => $uniqueGstLedgerSources,
            'subtotalsamount' => $subtotalsamount,
            'saleReceiptItem' => $saleReceiptItem,
            'voucherHeadsSaleReceipt' => $voucherHeadsSaleReceipt,
            'dueDate' => $dueDate,
            'voucherItemId' => $voucherItemId,
            'menuItems' => $menuItems
        ]);
    }



    public function getVoucherItemData($voucherItemId)
    {
        $voucherItem = TallyVoucher::findOrFail($voucherItemId);
        // dd($saleItem);
        $voucherItemName = $voucherItem->party_ledger_name;
        // dd($saleItemName);
        $query = TallyVoucherItem::where('tally_voucher_id', $voucherItemId)->get();
        // dd($query);
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return Carbon::parse($request->created_at)->format('Y-m-d H:i:s');
            })
            ->make(true);
    }


    public function AllVoucherItemPaymentReports($voucherItemId)
    {
        $voucherItem = TallyVoucher::findOrFail($voucherItemId);
    
        $voucherItemName = TallyVoucher::where('party_ledger_name', $voucherItem->party_ledger_name)->get();
        $saleReceiptItem = $voucherItemName->firstWhere('voucher_type', 'Receipt');

        // Check if $saleReceiptItem is not null
        if ($saleReceiptItem) {
            $voucherHeadsSaleReceipt = TallyVoucherHead::where('tally_voucher_id', $saleReceiptItem->id)
                ->where('entry_type', 'credit')
                ->get();
        } else {
            // Handle the case where $saleReceiptItem is null
            $voucherHeadsSaleReceipt = collect(); // Or any default value you prefer
        }

        $ledgerData = TallyLedger::where('language_name', $voucherItem->party_ledger_name)->get();
        if ($ledgerData instanceof \Illuminate\Support\Collection) {
            $ledgerItem = $ledgerData->first();
        } else {
            $ledgerItem = $ledgerData; 
        }

        $creditPeriod = intval($ledgerItem->bill_credit_period ?? 0);
        $voucherDate = \Carbon\Carbon::parse($voucherItem->voucher_date);
        $dueDate = $voucherDate->copy()->addDays($creditPeriod);
        
        $voucherHeads = TallyVoucherHead::where('tally_voucher_id', $voucherItemId)->get();
        $totalRoundOff = $voucherHeads->filter(function ($head) {
            return $head->ledger_name === 'Round Off';
        })->sum('amount');
        $totalIGST18 = $voucherHeads->filter(function ($head) {
            return $head->ledger_name === 'IGST @18%';
        })->sum('amount');
        
        $voucherItems = TallyVoucherItem::where('tally_voucher_id', $voucherItemId)->get();
        $uniqueGstLedgerSources = $voucherItems->pluck('gst_ledger_source')->unique();
        $totalCountItems = TallyVoucherItem::where('tally_voucher_id', $voucherItemId)->count();
        $subtotalsamount = $voucherItems->sum('amount');

        $menuItems = TallyVoucher::where('voucher_type', 'Payment')->get();

        return view('superadmin.reports._voucher_payment_items', [
            'voucherItem' => $voucherItem,
            'ledgerData' => $ledgerData,
            'voucherHeads' => $voucherHeads,
            'totalRoundOff' => $totalRoundOff,
            'totalIGST18' => $totalIGST18,
            'totalCountItems' => $totalCountItems,
            'uniqueGstLedgerSources' => $uniqueGstLedgerSources,
            'subtotalsamount' => $subtotalsamount,
            'saleReceiptItem' => $saleReceiptItem,
            'voucherHeadsSaleReceipt' => $voucherHeadsSaleReceipt,
            'dueDate' => $dueDate,
            'voucherItemId' => $voucherItemId,
            'menuItems' => $menuItems
        ]);
    }


    public function AllVoucherItemReceiptReports($voucherItemId)
    {
        $voucherItem = TallyVoucher::findOrFail($voucherItemId);
    
        $voucherItemName = TallyVoucher::where('party_ledger_name', $voucherItem->party_ledger_name)->get();
        $saleReceiptItem = $voucherItemName->firstWhere('voucher_type', 'Receipt');

        // Check if $saleReceiptItem is not null
        if ($saleReceiptItem) {
            $voucherHeadsSaleReceipt = TallyVoucherHead::where('tally_voucher_id', $saleReceiptItem->id)
                ->where('entry_type', 'credit')
                ->get();
        } else {
            // Handle the case where $saleReceiptItem is null
            $voucherHeadsSaleReceipt = collect(); // Or any default value you prefer
        }

        $ledgerData = TallyLedger::where('language_name', $voucherItem->party_ledger_name)->get();
        if ($ledgerData instanceof \Illuminate\Support\Collection) {
            $ledgerItem = $ledgerData->first();
        } else {
            $ledgerItem = $ledgerData; 
        }

        $creditPeriod = intval($ledgerItem->bill_credit_period ?? 0);
        $voucherDate = \Carbon\Carbon::parse($voucherItem->voucher_date);
        $dueDate = $voucherDate->copy()->addDays($creditPeriod);
        
        $voucherHeads = TallyVoucherHead::where('tally_voucher_id', $voucherItemId)->get();
        $totalRoundOff = $voucherHeads->filter(function ($head) {
            return $head->ledger_name === 'Round Off';
        })->sum('amount');
        $totalIGST18 = $voucherHeads->filter(function ($head) {
            return $head->ledger_name === 'IGST @18%';
        })->sum('amount');
        
        $voucherItems = TallyVoucherItem::where('tally_voucher_id', $voucherItemId)->get();
        $uniqueGstLedgerSources = $voucherItems->pluck('gst_ledger_source')->unique();
        $totalCountItems = TallyVoucherItem::where('tally_voucher_id', $voucherItemId)->count();
        $subtotalsamount = $voucherItems->sum('amount');

        $menuItems = TallyVoucher::where('voucher_type', 'Receipt')->get();

        return view('superadmin.reports._voucher_receipt_items', [
            'voucherItem' => $voucherItem,
            'ledgerData' => $ledgerData,
            'voucherHeads' => $voucherHeads,
            'totalRoundOff' => $totalRoundOff,
            'totalIGST18' => $totalIGST18,
            'totalCountItems' => $totalCountItems,
            'uniqueGstLedgerSources' => $uniqueGstLedgerSources,
            'subtotalsamount' => $subtotalsamount,
            'saleReceiptItem' => $saleReceiptItem,
            'voucherHeadsSaleReceipt' => $voucherHeadsSaleReceipt,
            'dueDate' => $dueDate,
            'voucherItemId' => $voucherItemId,
            'menuItems' => $menuItems
        ]);
    }
}
