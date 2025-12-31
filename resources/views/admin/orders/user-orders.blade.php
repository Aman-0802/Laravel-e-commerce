@extends('layouts.app')

@section('content')

<h3>
    Orders of <strong>{{ $orders->first()->user->name ?? '' }}</strong>
</h3>

<div class="mb-3 text-end">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
        Go To Dashboard
    </a>
</div>


@if ($orders->count() > 0)
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Bill Number</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->order_number }}</td>
            <td>₹{{ $order->total_amount }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>{{ $order->created_at }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order->id) }}"
                   class="btn btn-sm btn-primary">
                   View
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No orders found.</p>
@endif

@endsection
