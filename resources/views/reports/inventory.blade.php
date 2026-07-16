@extends('layouts.app')

@section('title', 'Inventory Report')

@section('content')
    <div class="card">
        <div class="page-header no-print">
            <h1>Inventory Report</h1>
            <button type="button" class="btn" onclick="window.print()">Send to Printer</button>
        </div>

        <div class="report-header">
            <h1>Inventory Report</h1>
            <p>Generated on {{ now()->format('F j, Y g:i A') }} by {{ auth()->user()->name }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Name</th>
                    <th class="num">Quantity</th>
                    <th class="num">Unit Price</th>
                    <th class="num">Total Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->sku }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="num">{{ $item->quantity }}</td>
                        <td class="num">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="num">{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="report-summary">
            Total items: {{ $items->count() }} &nbsp;|&nbsp;
            Total quantity: {{ $totalQuantity }} &nbsp;|&nbsp;
            Total inventory value: PHP {{ number_format($totalValue, 2) }}
        </p>
    </div>
@endsection
