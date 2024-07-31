<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\TallyVoucherHead;
use App\Models\TallyVoucherItem;
use App\Models\TallyVoucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\DataTables\SuperAdmin\SalesDataTable;

class SalesController extends Controller
{

    public function index(SalesDataTable $dataTable)
    {
        return $dataTable->render('superadmin.sales.index');
    }

    public function AllSaleItemReports($itemId)
    {
        $item = TallyVoucher::findOrFail($itemId);
        // dd($item);

        $voucherHeads = TallyVoucherHead::where('tally_voucher_id', $itemId)->get();
        $voucherItems = TallyVoucherItem::where('tally_voucher_id', $itemId)->get();
        // dd($voucherItems);

        $menuItems = TallyVoucher::where('voucher_type', 'Sales')->get();
        // dd($menuItems);

        return view('superadmin.sales._sale_item_list', [
            'item' => $item,
            'itemId' => $itemId ,
            'menuItems' => $menuItems
        ]);
    }


    public function getCashBankData($cashBankId)
    {
        $cashBank = TallyGroup::findOrFail($cashBankId);
        $cashBankName = $cashBank->name;

        $query = TallyLedger::where('parent', $cashBankName);

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return Carbon::parse($request->created_at)->format('Y-m-d H:i:s');
            })
            ->make(true);
    }

}
