@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">🧾 Order Bill</h3>

        <div class="card shadow-sm">
            <div class="card-body">

                <p><b>Customer:</b> {{ auth()->user()->name }}</p>
                <p><b>Date:</b> {{ date('d M Y') }}</p>

                <table class="table table-bordered mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach ($cart->items as $key => $item)
                            @php
                                $total = $item->qty * $item->price;
                                $grandTotal += $total;
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>₹ {{ number_format($item->price) }}</td>
                                <td>₹ {{ number_format($total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-end">
                    <h5>Grand Total: ₹ {{ number_format($grandTotal) }}</h5>
                </div>

                <form action="{{ route('place.order') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
