@extends('layouts.app')

@section('content')
<h1>Edit Order #{{ $order->order_number }}</h1>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>
                    <select name="items[{{ $item->id }}][product_id]" class="form-control">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $product->id == ($item->product->id ?? $item->product_id) ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="items[{{ $item->id }}][quantity]" class="form-control" value="{{ $item->quantity }}" min="0">
                    <small>Set 0 to remove product</small>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn btn-success">Update Order</button>
</form>
@endsection
