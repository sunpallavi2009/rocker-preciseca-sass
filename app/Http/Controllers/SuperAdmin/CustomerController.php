<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\TallyLedger;
use App\Models\TallyVoucherHead;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\DataTables\SuperAdmin\CustomerDataTable;
use App\DataTables\SuperAdmin\OtherCustomerDataTable;
use Stancl\Tenancy\Facades\Tenancy;

class CustomerController extends Controller
{
    public function index(CustomerDataTable $dataTable)
    {
        return $dataTable->render('superadmin.customers.index');
    }

    public function otherCustomers(OtherCustomerDataTable $dataTable)
    {
        return $dataTable->render('superadmin.customers.index');
    }

    public function show($customer)
    {
        $ledger = TallyLedger::where('guid', $customer)->firstOrFail();
        // dd($data);
        return view('superadmin.customers._customers-view', compact('ledger'));
    }

    public function getVoucherEntries($customer)
    {
        $ledger = TallyLedger::where('guid', $customer)->firstOrFail();
        $voucherHeads = TallyVoucherHead::where('ledger_guid', $ledger->guid)
            ->with('voucherHead') // Load the related TallyVoucher entries
            ->get();
        
        return datatables()->of($voucherHeads)
            ->addColumn('credit', function ($entry) {
                return $entry->entry_type == 'credit' ? number_format(abs($entry->amount), 2, '.', '') : '0.00';
            })
            ->addColumn('debit', function ($entry) {
                return $entry->entry_type == 'debit' ? number_format(abs($entry->amount), 2, '.', '') : '0.00';
            })
            ->addColumn('voucher_number', function ($entry) {
                return $entry->voucherHead ? $entry->voucherHead->voucher_number : '';
            })
            ->addColumn('voucher_type', function ($entry) {
                return $entry->voucherHead ? $entry->voucherHead->voucher_type : '';
            })
            ->addColumn('voucher_date', function ($entry) {
                return $entry->voucherHead ? $entry->voucherHead->voucher_date : '';
            })
            ->make(true);
    }

}
