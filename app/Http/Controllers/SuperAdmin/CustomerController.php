<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\DataTables\SuperAdmin\CustomerDataTable;

class CustomerController extends Controller
{

    public function index(CustomerDataTable $dataTable)
    {
        return $dataTable->render('superadmin.customers.index');
    }

    public function show()
    {
        return view ('superadmin.customers._customers-view');
    }

}
