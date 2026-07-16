@extends('layouts.app')

@section('title', 'Edit Inventory Item')

@section('content')
    <div class="card">
        <div class="page-header">
            <h1>Edit Inventory Item</h1>
        </div>

        <form method="POST" action="{{ route('inventory.update', $inventoryItem) }}">
            @csrf
            @method('PUT')
            @include('inventory._form', ['item' => $inventoryItem])

            <div class="form-actions">
                <button type="submit" class="btn">Update Item</button>
                <a href="{{ route('inventory.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
