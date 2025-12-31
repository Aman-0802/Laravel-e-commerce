@extends('layouts.app')

@section('content')
    <div class="container" style="max-width:600px; margin-top:20px;">

        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary mb-3">
            Go to Dashboard
        </a>

        <h3 class="mb-3">Add Product</h3>

        @if (session('success'))
            <div class="alert alert-success p-2">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger p-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <input type="text" name="name" value="{{ old('name') }}" placeholder="Product Name"
                class="form-control mb-2">

            <select name="category_id" class="form-control mb-2">
                <option value="">Select Category</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <select name="subcategory_id" class="form-control mb-2">
                <option value="">Select Sub Category</option>
                @foreach ($subcategories as $sub)
                    <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                @endforeach
            </select>


            <input type="file" name="image" class="form-control mb-2">

            <input type="number" name="mrp" value="{{ old('mrp') }}" placeholder="MRP" class="form-control mb-2">

            <input type="number" name="buy_rate" value="{{ old('buy_rate') }}" placeholder="Buy Rate"
                class="form-control mb-2">

            <input type="number" name="sell_rate" value="{{ old('sell_rate') }}" placeholder="Sell Rate"
                class="form-control mb-2">

            <input type="text" name="batch_no" value="{{ old('batch_no') }}" placeholder="Batch No"
                class="form-control mb-2">

            <textarea name="short_description" rows="2" class="form-control mb-2" placeholder="Short Description">{{ old('short_description') }}</textarea>

            <textarea name="description" rows="3" class="form-control mb-2" placeholder="Description">{{ old('description') }}</textarea>

            <button type="submit" class="btn btn-sm btn-success">
                Add Product
            </button>
        </form>
    </div>
@endsection
