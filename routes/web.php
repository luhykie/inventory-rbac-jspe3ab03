<?php

use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('inventory.index'));

Route::middleware('auth')->group(function () {
    Route::get('/reports/inventory', [ReportController::class, 'index'])
        ->middleware('can:can_print')
        ->name('reports.inventory');

    Route::resource('inventory', InventoryItemController::class)
        ->parameters(['inventory' => 'inventoryItem']);
});