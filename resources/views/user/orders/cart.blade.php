@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">🛒 Your Cart</h3>

    @if(!$cart || $cart->items->count() == 0)
        <div class="alert alert-info">Your cart is empty</div>
    @else
        <div class="card shadow-sm">
            <div class="card-body">

                @php $grandTotal = 0; @endphp

                @foreach($cart->items as $item)
                    @php
                        $total = $item->qty * $item->price;
                        $grandTotal += $total;
                    @endphp

                    <div class="row align-items-center border-bottom py-3">

                        <!-- IMAGE + QTY + DELETE -->
                        <div class="col-md-2 text-center">
                            <img src="{{ asset('images/products/'.$item->product->image) }}"
                                 class="img-fluid mb-2"
                                 style="max-height:100px">

                            <!-- Qty controls -->
                            <form action="{{ route('cart.updateQty') }}" method="POST"
                                  class="d-flex justify-content-center mb-1">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">

                                <button class="btn btn-outline-secondary btn-sm"
                                        name="action" value="decrease">−</button>

                                <input type="text"
                                       value="{{ $item->qty }}"
                                       readonly
                                       class="form-control form-control-sm text-center mx-1"
                                       style="width:45px">

                                <button class="btn btn-outline-secondary btn-sm"
                                        name="action" value="increase">+</button>
                            </form>

                            <!-- Delete -->
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Remove this item from cart?')">
                                    🗑 Remove
                                </button>
                            </form>
                        </div>

                        <!-- PRODUCT -->
                        <div class="col-md-5">
                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                            <small class="text-success">In Stock</small>
                        </div>

                        <!-- PRICE -->
                        <div class="col-md-2 text-center">
                            <strong>₹ {{ number_format($item->price) }}</strong>
                        </div>

                        <!-- TOTAL -->
                        <div class="col-md-3 text-end">
                            <strong>₹ {{ number_format($total) }}</strong>
                        </div>
                    </div>
                @endforeach

                <!-- GRAND TOTAL -->
                <div class="row pt-3">
                    <div class="col-md-6">
                        <h5>Grand Total</h5>
                    </div>
                    <div class="col-md-6 text-end">
                        <h5>₹ {{ number_format($grandTotal) }}</h5>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <a href="{{ route('checkout') }}" class="btn btn-warning px-4">
                        Proceed To Checkout
                    </a>
                </div>

            </div>
        </div>
    @endif
</div>
@endsection
