<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InventoryItemController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', InventoryItem::class);

        $items = InventoryItem::orderBy('name')->paginate(10);

        return view('inventory.index', compact('items'));
    }

    public function create()
    {
        Gate::authorize('create', InventoryItem::class);

        return view('inventory.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', InventoryItem::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:50', 'unique:inventory_items,sku'],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
            'unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        InventoryItem::create($validated);

        return redirect()->route('inventory.index')
            ->with('status', 'Inventory item created successfully.');
    }

    public function show(InventoryItem $inventoryItem)
    {
        Gate::authorize('view', $inventoryItem);

        return view('inventory.show', compact('inventoryItem'));
    }

    public function edit(InventoryItem $inventoryItem)
    {
        Gate::authorize('update', $inventoryItem);

        return view('inventory.edit', compact('inventoryItem'));
    }

    public function update(Request $request, InventoryItem $inventoryItem)
    {
        Gate::authorize('update', $inventoryItem);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:50', 'unique:inventory_items,sku,' . $inventoryItem->id],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
            'unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        $inventoryItem->update($validated);

        return redirect()->route('inventory.index')
            ->with('status', 'Inventory item updated successfully.');
    }

    public function destroy(InventoryItem $inventoryItem)
    {
        Gate::authorize('delete', $inventoryItem);

        $inventoryItem->delete();

        return redirect()->route('inventory.index')
            ->with('status', 'Inventory item removed.');
    }
}