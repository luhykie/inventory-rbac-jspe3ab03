<?php

use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    return redirect()->route('inventory.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/inventory', [
        InventoryItemController::class,
        'index',
    ])
        ->middleware('can:can_view')
        ->name('inventory.index');

    Route::get('/inventory/create', [
        InventoryItemController::class,
        'create',
    ])
        ->middleware('can:can_create')
        ->name('inventory.create');

    Route::post('/inventory', [
        InventoryItemController::class,
        'store',
    ])
        ->middleware('can:can_create')
        ->name('inventory.store');

    Route::get('/inventory/{inventory}', [
        InventoryItemController::class,
        'show',
    ])
        ->middleware('can:can_view')
        ->name('inventory.show');

    Route::get('/inventory/{inventory}/edit', [
        InventoryItemController::class,
        'edit',
    ])
        ->middleware('can:can_update')
        ->name('inventory.edit');

    Route::match(
        ['put', 'patch'],
        '/inventory/{inventory}',
        [InventoryItemController::class, 'update']
    )
        ->middleware('can:can_update')
        ->name('inventory.update');

    Route::delete('/inventory/{inventory}', [
        InventoryItemController::class,
        'destroy',
    ])
        ->middleware('can:can_remove')
        ->name('inventory.destroy');

    Route::get('/reports/inventory', [
        ReportController::class,
        'index',
    ])
        ->middleware('can:can_print')
        ->name('reports.inventory');

    Route::prefix('admin')
        ->name('admin.')
        ->middleware('can:can_manage_users')
        ->group(function () {
            Route::get('/users', [
                UserManagementController::class,
                'index',
            ])->name('users.index');

            Route::patch('/users/{user}/role', [
                UserManagementController::class,
                'updateRole',
            ])->name('users.update-role');

            Route::patch('/users/{user}/permissions', [
                UserManagementController::class,
                'updatePermissions',
            ])->name('users.update-permissions');
        });
});