<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\App\JsonImportController;
use App\Http\Controllers\SuperAdmin\TallyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/ledgers/{token_id}/{company_id}', [JsonImportController::class, 'ledgerJsonImport'])
    ->name('jsonImport.ledgers.import')
    ->middleware('tenant');

Route::post('/tally_groups', [TallyController::class, 'tallyGroupJsonImport'])->name('tallyGroup.import');

Route::post('/tally_ledgers', [TallyController::class, 'tallyLedgerJsonImport'])->name('tallyLedger.import');

Route::post('/tally_other_ledgers', [TallyController::class, 'tallyOtherLedgerJsonImport'])->name('tallyOtherLedger.import');