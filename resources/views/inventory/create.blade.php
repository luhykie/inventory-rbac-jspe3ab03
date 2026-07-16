@extends('layouts.app')

@section('title', 'Add Inventory Item')

@section('content')
    <div class="card">
        <div class="page-header">
            <h1>Add Inventory Item</h1>
        </div>

        <form method="POST" action="{{ route('inventory.store') }}">
            @csrf
            @include('inventory._form', ['item' => null])

            <div class="form-actions">
                <button type="submit" class="btn">Save Item</button>
                <a href="{{ route('inventory.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
