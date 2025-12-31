<!DOCTYPE html>
<html>
<head>
    <title>Order Bill</title>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .table th, .table td {
            vertical-align: middle !important;
        }
    </style>
</head>
<body>

<div class="container mt-4">

    <div class="row">
        <div class="col-12 text-center">
            <h3 class="mb-0">ORDER BILL</h3>
            <small class="text-muted">Thank you for your purchase</small>
            <hr>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <p><strong>Order ID:</strong> {{ $order->order_number }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
        </div>
        <div class="col-6 text-right">
            <p><strong>Customer Name:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Product</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-right">{{ $item->qty }}</td>
                    <td class="text-right">₹ {{ number_format($item->price, 2) }}</td>
                    <td class="text-right">₹ {{ number_format($item->qty * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
       {{--  <div class="col-6">
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        </div> --}}
        <div class="col-6 text-right">
            <h5><strong>Grand Total:</strong> ₹ {{ number_format($order->total_amount, 2) }}</h5>
        </div>
    </div>

    <hr>
    <p class="text-center mb-0">
        <strong>Thank you for shopping with us 🙏</strong>
    </p>

</div>

</body>
</html>
