<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function index()
    {
        Gate::authorize('can_print');

        $items = InventoryItem::orderBy('name')->get();
        $totalQuantity = $items->sum('quantity');
        $totalValue = $items->sum(fn ($item) => $item->quantity * $item->unit_price);

        return view('reports.inventory', compact('items', 'totalQuantity', 'totalValue'));
    }
}