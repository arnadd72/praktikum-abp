@extends('template')
@section('title', 'Login')

@section('content')
<div class="col-md-4 mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white text-center">
            <h5 class="mb-0">Secure Login</h5>
        </div>
        <div class="card-body">
            @if (session('msg'))
                <div class="alert alert-danger" role="alert">
                    {{ session('msg') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection
