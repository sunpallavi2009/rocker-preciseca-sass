<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\DataTables\SuperAdmin\SupplierDataTable;

class SupplierController extends Controller
{

    public function index(SupplierDataTable $dataTable)
    {
        return $dataTable->render('superadmin.suppliers.index');
    }

}
