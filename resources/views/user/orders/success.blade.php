<!DOCTYPE html>
<html>
<head>
    <title>Order Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 text-center">
    <h1 class="text-success">🎉 Order Placed Successfully!</h1>
    <p>Thank you for your purchase.</p>

    @if($order)
       @if($order)
   <a href="{{ route('user.orders.download', $order->id) }}" class="btn btn-primary">Download Bill</a>


@endif


    @endif

    <a href="{{ url('/') }}" class="btn btn-secondary">Go to Home</a>
</div>
</body>
</html>
