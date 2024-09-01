@extends('layout.master')

@section('content')
<link rel="stylesheet" href="{{ asset('styles/style.css') }}">

<div class="container">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4">
            <div class="card-header text-center">
                <h3 class="card-title">Register</h3>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger" id="feedback">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('save_user_old') }}" class="registration-form">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" name="user_name" class="form-control" placeholder="Enter your username" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="user_email" class="form-control" placeholder="Enter your email address" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="user_pass" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" required>
                            <span class="custom-control-label">I agree to the <a href="terms.html">terms and conditions</a></span>
                        </label>
                    </div>
                    <div class="form-footer mt-3">
                        <input type="submit" class="btn btn-primary btn-block" value="Create New Account">
                    </div>
                </form>
                <div class="text-center mt-3">
                    Already have an account? <a href="{{ route('login') }}">Log in</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
