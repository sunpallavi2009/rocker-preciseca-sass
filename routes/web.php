<?php

use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\SuperAdmin\CustomerController;
use App\Http\Controllers\SuperAdmin\SupplierController;
use App\Http\Controllers\SuperAdmin\StockItemController;
use App\Http\Controllers\SuperAdmin\SalesController;
use App\Http\Controllers\SuperAdmin\Reports\ReportController;
use App\Http\Controllers\SuperAdmin\Reports\ReportCashBankController;
use App\Http\Controllers\SuperAdmin\Reports\ReportGeneralLedgerController;
use App\Http\Controllers\SuperAdmin\Reports\ReportDayBookController;
use App\Http\Controllers\SuperAdmin\Reports\ReportPaymentRegisterController;
use App\Http\Controllers\SuperAdmin\Reports\ReportReceiptRegisterController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\TallyController;
use Laravel\Jetstream\Http\Controllers\CurrentTeamController;
use Laravel\Jetstream\Http\Controllers\Inertia\TeamController;
use Laravel\Jetstream\Http\Controllers\TeamInvitationController;
use Laravel\Jetstream\Http\Controllers\Inertia\ApiTokenController;
use Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::group(['prefix' => config('sanctum.prefix', 'sanctum')], static function () {
//     Route::get('/csrf-cookie', [CsrfCookieController::class, 'show'])
//         ->middleware([
//             'web',
//             InitializeTenancyByDomain::class // Use tenancy initialization middleware of your choice
//         ])->name('sanctum.csrf-cookie');
// });

Route::get('/home',function(){
    return view('welcome');
});

Route::get('/',function(){
  return redirect('/login');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
]
)->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // });
    // ->name('dashboard');

    Route::get('/dashboard', [HomeController::class, 'index']);
    Route::post('/update-user-status', [UserController::class, 'updateStatus'])->name('update.user.status');

    Route::resource('tenants', TenantController::class);

    Route::resource('customers', CustomerController::class);
    Route::get('customers/{customer}/vouchers', [CustomerController::class, 'getVoucherEntries'])->name('customers.vouchers');

    Route::get('otherCustomers', [CustomerController::class, 'otherCustomers'])->name('otherCustomers.index');


    Route::resource('suppliers', SupplierController::class);
    Route::resource('stock-items', StockItemController::class);

    
    Route::resource('reports', ReportController::class)->except(['show']);


    Route::get('reports/DayBook', [ReportDayBookController::class, 'index'])->name('reports.daybook');


    Route::get('reports/GeneralLedger', [ReportGeneralLedgerController::class, 'index'])->name('reports.GeneralLedger');
    Route::get('reports/GeneralLedger/{GeneralLedger}', [ReportGeneralLedgerController::class, 'AllGeneralLedgerReports'])->name('reports.GeneralLedger.details');
    Route::get('reports/GeneralLedger/data/{generalLedgerId}', [ReportGeneralLedgerController::class, 'getGeneralLedgerData'])->name('reports.GeneralLedger.data');
    Route::get('reports/GeneralGroupLedger/{GeneralLedger}', [ReportGeneralLedgerController::class, 'AllGeneralGroupLedgerReports'])->name('reports.GeneralGroupLedger.details');
    Route::get('reports/GeneralGroupLedger/data/{generalLedgerId}', [ReportGeneralLedgerController::class, 'getGeneralGroupLedgerData'])->name('reports.GeneralGroupLedger.data');

    Route::get('reports/CashBank', [ReportCashBankController::class, 'index'])->name('reports.CashBank');
    Route::get('reports/CashBank/{CashBank}', [ReportCashBankController::class, 'AllCashBankReports'])->name('reports.CashBank.details');
    Route::get('reports/CashBank/data/{cashBankId}', [ReportCashBankController::class, 'getCashBankData'])->name('reports.CashBank.data');


    Route::get('reports/PaymentRegister', [ReportPaymentRegisterController::class, 'index'])->name('reports.PaymentRegister');
    

    Route::get('reports/ReceiptRegister', [ReportReceiptRegisterController::class, 'index'])->name('reports.ReceiptRegister');



    Route::get('reports/VoucherHead/{VoucherHead}', [ReportController::class, 'AllVoucherHeadReports'])->name('reports.VoucherHead');
    Route::get('reports/VoucherHead/data/{VoucherHeadId}', [ReportController::class, 'getVoucherHeadData'])->name('reports.VoucherHead.data');

    Route::get('reports/VoucherItem/{VoucherItem}', [ReportController::class, 'AllVoucherItemReports'])->name('reports.VoucherItem');
    Route::get('reports/VoucherItem/data/{VoucherItemId}', [ReportController::class, 'getVoucherItemData'])->name('reports.VoucherItem.data');
    Route::get('reports/VoucherItemPayment/{VoucherItem}', [ReportController::class, 'AllVoucherItemPaymentReports'])->name('reports.VoucherItemPayment');
    Route::get('reports/VoucherItemReceipt/{VoucherItem}', [ReportController::class, 'AllVoucherItemReceiptReports'])->name('reports.VoucherItemReceipt');


    Route::resource('sales', SalesController::class);
    Route::get('sales/Item/{SaleItem}', [SalesController::class, 'AllSaleItemReports'])->name('sales.items');
    Route::get('sales/SaleItem/data/{SaleItemId}', [SalesController::class, 'getSaleItemData'])->name('sales.SaleItem.data');


    Route::resource('users', UserController::class);

    
    //  JET STREAM
    require __DIR__ . '/auth.php';
});


