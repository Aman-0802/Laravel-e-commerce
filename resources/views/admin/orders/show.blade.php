@extends('layouts.app')

@section('content')

<h3>Order Details</h3>

<p><strong>Order Number:</strong> {{ $order->order_number }}</p>
<p><strong>User:</strong> {{ $order->user->name }}</p>
<p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
<p><strong>Total Amount:</strong> ₹{{ $order->total_amount }}</p>

<hr>

<h5>Items</h5>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
         @php $grandTotal = 0; @endphp
        @foreach ($order->orderItems as $item)

         @php
                $qty = $item->quantity ?? 1;
                $price = $item->price ?? 0;
                $subtotal = $qty * $price;
                $grandTotal += $subtotal;
            @endphp
         <tr>
                <td>{{ $item->product->name ?? $item->product_name }}</td>
                <td>{{ $qty }}</td>
                <td>₹{{ number_format($price, 2) }}</td>
                <td>₹{{ number_format($subtotal, 2) }}</td>
            </tr>
        @endforeach
        <tfoot>
        <tr>
            <th colspan="3" class="text-end">Grand Total</th>
            <th>₹{{ number_format($grandTotal, 2) }}</th>
        </tr>
    </tfoot>
    </tbody>
</table>

<a href="{{ url()->previous() }}" class="btn btn-secondary">
    Back
</a>

@endsection
