@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>All Products</h2>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary mb-3">Go to Dashboard</a>

        @if (session('success'))
            <p style="color:green">{{ session('success') }}</p>
        @endif

        <!-- Go to Dashboard Button
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
            Go to Dashboard -->
        </a>
        <table border="1" width="100%">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Sub-Category</th>
                <th>MRP</th>
                <th>Rate</th>
                <th>Batch No</th>
                <th>Image</th>
                <th>Action</th>
            </tr>

            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category_id }}</td>
                    <td>{{ $product->subcategory_id }}</td>
                    <td>{{ $product->mrp }}</td>
                    <td>{{ $product->sell_rate }}</td>
                    <td>{{ $product->batch_no }}</td>
                    <td>
                        <img src="{{ asset('images/products/' . $product->image) }}" width="50" />
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </table>
    </div>
@endsection
