<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\DataTables\SuperAdmin\DayBookDataTable;

class ReportController extends Controller
{

    public function index()
    {
        return view ('superadmin.reports.index');
    }

    public function DayBookReports(DayBookDataTable $dataTable)
    {
        return $dataTable->render('superadmin.reports._dayBook');
    }

    public function show($id)
    {
        // Handle the show method or leave it empty
    }

}
