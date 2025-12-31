@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit User</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text"
                   name="name"
                   value="{{ $user->name }}"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email"
                   name="email"
                   value="{{ $user->email }}"
                   class="form-control"
                   required>
        </div>

        <button type="submit" class="btn btn-success">
            Update User
        </button>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary ms-2">
            Back
        </a>
    </form>
</div>
@endsection

