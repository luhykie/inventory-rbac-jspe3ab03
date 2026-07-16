@extends('layouts.app')

@section('title', 'Inventory Listing')

@section('content')
    <div class="card">
        <div class="page-header">
            <h1>Inventory Listing</h1>
            <a href="{{ route('inventory.create') }}" class="btn">+ Add Item</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Name</th>
                    <th class="num">Quantity</th>
                    <th class="num">Unit Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $item->sku }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="num">{{ $item->quantity }}</td>
                        <td class="num">{{ number_format($item->unit_price, 2) }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('inventory.show', $item) }}" class="btn btn-outline btn-sm">View</a>
                                <a href="{{ route('inventory.edit', $item) }}" class="btn btn-outline btn-sm">Edit</a>
                                <form method="POST" action="{{ route('inventory.destroy', $item) }}"
                                      onsubmit="return confirm('Remove this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No inventory items found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrap">
            {{ $items->links('pagination.default') }}
        </div>
    </div>
@endsection
