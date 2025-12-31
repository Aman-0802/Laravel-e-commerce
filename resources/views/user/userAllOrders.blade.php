@extends('layouts.app')

@section('content')
<h2>Your Orders</h2>

@if($orders->isEmpty())
    <p>You have not placed any orders yet.</p>
@else
    @foreach($orders as $order)
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <h4>Order Number: {{ $order->order_number }}</h4>
            <p>Purchased At: {{ $order->created_at->format('d-m-Y H:i') }}</p>
            <p>Status: {{ ucfirst($order->status) }}</p>

            <table border="1" cellpadding="5" style="width:100%; margin-top:5px;">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>₹{{ $item->price }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('user.orders.download', $order->id) }}" style="margin-top:5px; display:inline-block;">Download Bill</a>
        </div>
    @endforeach
@endif
@endsection
