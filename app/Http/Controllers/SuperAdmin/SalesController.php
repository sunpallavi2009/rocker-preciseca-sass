<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\TallyVoucherHead;
use App\Models\TallyVoucherItem;
use App\Models\TallyVoucher;
use App\Models\TallyLedger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Collection;
use App\DataTables\SuperAdmin\SalesDataTable;

class SalesController extends Controller
{

    public function index(SalesDataTable $dataTable)
    {
        return $dataTable->render('superadmin.sales.index');
    }

    public function AllSaleItemReports($saleItemId)
    {
        $saleItem = TallyVoucher::findOrFail($saleItemId);
       
        $saleItemName = TallyVoucher::where('party_ledger_name', $saleItem->party_ledger_name)->get();
        $saleReceiptItem = $saleItemName->firstWhere('voucher_type', 'Receipt');
    
         // Check if $saleReceiptItem is not null
         if ($saleReceiptItem) {
            $voucherHeadsSaleReceipt = TallyVoucherHead::where('tally_voucher_id', $saleReceiptItem->id)
                ->where('entry_type', 'credit')
                ->get();
        } else {
            // Handle the case where $saleReceiptItem is null
            $voucherHeadsSaleReceipt = collect(); // Or any default value you prefer
        }
        // dd($voucherHeadsSaleReceipt);

        $ledgerData = TallyLedger::where('language_name', $saleItem->party_ledger_name)->get();
        if ($ledgerData instanceof \Illuminate\Support\Collection) {
            $ledgerItem = $ledgerData->first();
        } else {
            $ledgerItem = $ledgerData; 
        }
        // dd($ledgerItem);

        $creditPeriod = intval($ledgerItem->bill_credit_period ?? 0);
        $voucherDate = \Carbon\Carbon::parse($saleItem->voucher_date);
        $dueDate = $voucherDate->copy()->addDays($creditPeriod);
        // dd($dueDate);

        
        $voucherHeads = TallyVoucherHead::where('tally_voucher_id', $saleItemId)->get();
        $gstVoucherHeads = $voucherHeads->filter(function ($voucherHead) use ($saleItem) {
            return $voucherHead->ledger_name !== $saleItem->party_ledger_name;
        });

        // dd($voucherHeads);
       
        
        $voucherItems = TallyVoucherItem::where('tally_voucher_id', $saleItemId)->get();
        $uniqueGstLedgerSources = $voucherItems->pluck('gst_ledger_source')->unique();
        $totalCountItems = TallyVoucherItem::where('tally_voucher_id', $saleItemId)->count();
        $subtotalsamount = $voucherItems->sum('amount');

        $menuItems = TallyVoucher::where('voucher_type', 'Sales')->get();

        return view('superadmin.sales._sale_item_list', [
            'saleItem' => $saleItem,
            'ledgerData' => $ledgerData,
            'voucherHeads' => $voucherHeads,
            'gstVoucherHeads' => $gstVoucherHeads,
            'totalCountItems' => $totalCountItems,
            'uniqueGstLedgerSources' => $uniqueGstLedgerSources,
            'subtotalsamount' => $subtotalsamount,
            'saleReceiptItem' => $saleReceiptItem,
            'voucherHeadsSaleReceipt' => $voucherHeadsSaleReceipt,
            'dueDate' => $dueDate,
            'saleItemId' => $saleItemId ,
            'menuItems' => $menuItems
        ]);
    }


    public function getSaleItemData($saleItemId)
    {
        $saleItem = TallyVoucher::findOrFail($saleItemId);
        // dd($saleItem);
        $saleItemName = $saleItem->party_ledger_name;
        // dd($saleItemName);
        $query = TallyVoucherItem::where('tally_voucher_id', $saleItemId)->get();
        // dd($query);
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return Carbon::parse($request->created_at)->format('Y-m-d H:i:s');
            })
            ->make(true);
    }

}
