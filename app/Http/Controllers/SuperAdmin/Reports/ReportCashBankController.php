<?php

namespace App\Http\Controllers\SuperAdmin\Reports;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use App\Models\TallyGroup;
use App\Models\TallyLedger;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\DataTables\SuperAdmin\CashBankDataTable;

class ReportCashBankController extends Controller
{

    public function index(CashBankDataTable $dataTable)
    {
        return $dataTable->render('superadmin.reports.cashBank.index');
    }

    public function AllCashBankReports($cashBankId)
    {
        $cashBank = TallyGroup::findOrFail($cashBankId);

        $names = ['Bank Accounts', 'Bank OD A/c, Bank OCC A/c', 'Cash-in-Hand'];
        $menuItems = TallyGroup::whereIn('name', $names)->get();
        // dd($menuItems);

        return view('superadmin.reports.cashBank._cash_bank_details', [
            'cashBank' => $cashBank,
            'cashBankId' => $cashBankId ,
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
