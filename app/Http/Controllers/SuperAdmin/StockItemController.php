<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\DataTables\SuperAdmin\StockItemDataTable;

class StockItemController extends Controller
{
    
    public function index(StockItemDataTable $dataTable)
    {
        return $dataTable->render('superadmin.stock-items.index');
    }

}
