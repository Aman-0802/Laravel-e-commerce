{{--  @extends('layouts.app')

@section('content')
<div class="container mt-4">

    <!-- Greeting + Logout + Cart -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="fw-bold text-primary" style="font-size:2rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
            Hello, <span class="text-success">{{ auth('web')->user()->name ?? '' }}</span>
        </h2>

        <div class="mt-2">
            <a href="{{ url('cart') }}" class="btn btn-outline-primary me-2">Go To Cart</a>
            <form method="POST" action="{{ route('account.logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <!-- Success message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Products grid -->
    <div class="row">
        @foreach ($products as $product)
            <div class="col-6 col-md-3 mb-4">
                <div class="card h-100 text-center shadow-sm border-0" style="transition: transform 0.2s;">
                    <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" 
                        class="card-img-top p-3" 
                        style="height:150px; object-fit:contain;">

                    <div class="card-body p-2">
                        <h6 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
                        <p class="card-text fw-bold mb-2">₹ {{ $product->sell_rate }}</p>
                        <form method="POST" action="{{ url('cart/add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-sm btn-primary w-100">Add To Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

<!-- Card hover effect -->
<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
</style>
@endsection
 --}}


 {{-- @extends('layouts.app')

@section('content')
<!-- Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">

    <!-- Greeting + Logout + Cart -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="fw-bold text-primary">
            Hello, <span class="text-success">{{ auth('web')->user()->name ?? '' }}</span>
        </h2>

        <div class="mt-2">
            <a href="{{ url('cart') }}" class="btn btn-outline-primary me-2">Go To Cart</a>
            <form method="POST" action="{{ route('account.logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <!-- Success message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Products grid -->
    <div class="row">
        @foreach ($products as $product)
            <div class="col-6 col-md-3 mb-4">
                <div class="card h-100 text-center shadow-sm border-0 position-relative">
                    
                    <!-- Image container -->
                    <div class="position-relative">
                        <img src="{{ asset('images/products/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid product-thumb p-3 rounded" 
                             style="height:150px; object-fit:contain; cursor:pointer;">

                        <!-- Hidden popup image -->
                        <div class="popup-image position-absolute rounded border bg-white shadow p-2">
                            <img src="{{ asset('images/products/' . $product->image) }}" 
                                 alt="{{ $product->name }}" class="img-fluid">
                        </div>
                    </div>

                    <div class="card-body p-2">
                        <h6 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
                        <p class="card-text fw-bold mb-2">₹ {{ $product->sell_rate }}</p>
                        <form method="POST" action="{{ url('cart/add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-sm btn-primary w-100">Add To Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- CSS for Bootstrap + hover popup -->
<style>
.product-thumb {
    transition: all 0.2s ease-in-out;
}

.popup-image {
    display: none;
    top: 0;
    left: 105%; /* show on right of thumbnail */
    width: 300px;
    z-index: 1050; /* above other cards */
}

.product-thumb:hover + .popup-image,
.popup-image:hover {
    display: block;
}

@media (max-width: 768px) {
    .popup-image {
        left: 50%; /* center on small screens */
        top: 100%;
        transform: translateX(-50%);
    }
}
</style>
@endsection
 --}}

 @extends('layouts.app')

@section('content')
<!-- Bootstrap 5 CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">

    <!-- Greeting + Logout + Cart -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="fw-bold text-primary">
            Hello, <span class="text-success">{{ auth('web')->user()->name ?? '' }}</span>
        </h2>

        <a href="{{ route('user.orders') }}" class="btn btn-primary">Your Orders</a>


        <div class="mt-2">
            <a href="{{ url('cart') }}" class="btn btn-outline-primary me-2">Go To Cart</a>
            <form method="POST" action="{{ route('account.logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <!-- Success message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Products grid -->
    <div class="row">
        @foreach ($products as $product)
            <div class="col-6 col-md-3 mb-4 text-center">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ asset('images/products/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid p-3 product-thumb" 
                         style="height:150px; object-fit:contain; cursor:pointer;"
                         data-bs-toggle="modal" 
                         data-bs-target="#productModal{{ $product->id }}">

                    <div class="card-body p-2">
                        <h6 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
                        <p class="card-text fw-bold mb-2">₹ {{ $product->sell_rate }}</p>
                        <form method="POST" action="{{ url('cart/add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-sm btn-primary w-100">Add To Cart</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0">
                        <div class="modal-body p-0">
                            <img src="{{ asset('images/products/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid w-100">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
