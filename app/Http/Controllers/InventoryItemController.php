<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    public function index()
    {
        $items = InventoryItem::query()
            ->orderBy('name')
            ->paginate(10);

        return view('inventory.index', compact('items'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => [
                'required',
                'string',
                'max:50',
                'unique:inventory_items,sku',
            ],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
            'unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        InventoryItem::create($validated);

        return redirect()
            ->route('inventory.index')
            ->with('status', 'Inventory item created successfully.');
    }

    public function show(InventoryItem $inventory)
    {
        return view('inventory.show', [
            'inventoryItem' => $inventory,
        ]);
    }

    public function edit(InventoryItem $inventory)
    {
        return view('inventory.edit', [
            'inventoryItem' => $inventory,
        ]);
    }

    public function update(
        Request $request,
        InventoryItem $inventory
    ) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => [
                'required',
                'string',
                'max:50',
                'unique:inventory_items,sku,' . $inventory->id,
            ],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
            'unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        $inventory->update($validated);

        return redirect()
            ->route('inventory.index')
            ->with('status', 'Inventory item updated successfully.');
    }

    public function destroy(InventoryItem $inventory)
    {
        $inventory->delete();

        return redirect()
            ->route('inventory.index')
            ->with('status', 'Inventory item removed successfully.');
    }
}