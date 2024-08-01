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

        $ledgerData = TallyLedger::where('language_name', $saleItem->party_ledger_name)->get();
        $voucherHeads = TallyVoucherHead::where('tally_voucher_id', $saleItemId)->get();
        $totalRoundOff = $voucherHeads->filter(function ($head) {
            return $head->ledger_name === 'Round Off';
        })->sum('amount');
        $totalIGST18 = $voucherHeads->filter(function ($head) {
            return $head->ledger_name === 'IGST @18%';
        })->sum('amount');
       
        
        $voucherItems = TallyVoucherItem::where('tally_voucher_id', $saleItemId)->get();
        $uniqueGstLedgerSources = $voucherItems->pluck('gst_ledger_source')->unique();
        $totalCountItems = TallyVoucherItem::where('tally_voucher_id', $saleItemId)->count();
        $subtotalsamount = $voucherItems->sum('amount');

        $menuItems = TallyVoucher::where('voucher_type', 'Sales')->get();

        return view('superadmin.sales._sale_item_list', [
            'saleItem' => $saleItem,
            'ledgerData' => $ledgerData,
            'voucherHeads' => $voucherHeads,
            'totalRoundOff' => $totalRoundOff,
            'totalIGST18' => $totalIGST18,
            'totalCountItems' => $totalCountItems,
            'uniqueGstLedgerSources' => $uniqueGstLedgerSources,
            'subtotalsamount' => $subtotalsamount,
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
