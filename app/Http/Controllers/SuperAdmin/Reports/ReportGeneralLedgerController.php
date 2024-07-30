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
use App\DataTables\SuperAdmin\DayBookDataTable;
use App\DataTables\SuperAdmin\GeneralLedgerDataTable;
use App\DataTables\SuperAdmin\CashBankDataTable;

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

        $query = TallyGroup::where('parent', $generalLedgerName);

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return Carbon::parse($request->created_at)->format('Y-m-d H:i:s');
            })
            ->make(true);
    }

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

        $query = TallyLedger::where('parent', $generalLedgerName);

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return Carbon::parse($request->created_at)->format('Y-m-d H:i:s');
            })
            ->make(true);
    }

}
