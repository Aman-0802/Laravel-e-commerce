@extends('layouts.app')

@section('content')

    {{-- TOP NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <span class="navbar-brand fw-bold text-uppercase">
                Admin Panel
            </span>

            <div class="d-flex align-items-center">
                <span class="me-3 fw-semibold">
                    {{ Auth::guard('admin')->user()->name }}
                </span>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- ACTION BUTTONS --}}
    <div class="container my-4">
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm">
                + Add Product
            </a>

            <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm">
                View Products
            </a>
        </div>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if (session('success'))
        <div class="container">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- DASHBOARD CARD --}}
    <div class="container mb-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Admin Dashboard</h5>
            </div>

            <div class="card-body">

                <h6 class="mb-3 text-secondary">Users</h6>

                @if ($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td class="fw-semibold">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="text-center">

                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Are you sure?')"
                                                    class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </form>


                                            <a href="{{ route('admin.user.orders', $user->id) }}"
                                                class="btn btn-sm btn-info text-white">
                                                Orders
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No users found.</p>
                @endif

            </div>
        </div>
    </div>

@endsection
