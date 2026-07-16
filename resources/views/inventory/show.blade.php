@extends('layouts.app')

@section('title', 'Inventory Item Details')

@section('content')
    <div class="card">
        <div class="page-header">
            <h1>Item Details</h1>
            <a href="{{ route('inventory.index') }}" class="btn btn-outline">Back to Listing</a>
        </div>

        <ul class="detail-list">
            <li><span>SKU</span><span>{{ $inventoryItem->sku }}</span></li>
            <li><span>Name</span><span>{{ $inventoryItem->name }}</span></li>
            <li><span>Description</span><span>{{ $inventoryItem->description ?? '—' }}</span></li>
            <li><span>Quantity</span><span>{{ $inventoryItem->quantity }}</span></li>
            <li><span>Unit Price</span><span>PHP {{ number_format($inventoryItem->unit_price, 2) }}</span></li>
            <li><span>Total Value</span><span>PHP {{ number_format($inventoryItem->quantity * $inventoryItem->unit_price, 2) }}</span></li>
            <li><span>Date Added</span><span>{{ $inventoryItem->created_at->format('F j, Y g:i A') }}</span></li>
            <li><span>Last Updated</span><span>{{ $inventoryItem->updated_at->format('F j, Y g:i A') }}</span></li>
        </ul>
    </div>
@endsection
