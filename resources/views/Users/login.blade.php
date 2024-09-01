@extends('layout.master')

@section('content')

    <!-- Include CSS file -->
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">

    <!-- Page Title -->

    <div class="container">
        <form method="POST" action="{{route('check_usar')}}">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sign In</h3>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="user_email" class="form-control" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="user_pass" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <a href="forgot-password.html" class="float-right small text-dark mt-1">Forgot Password?</a>
                            <input type="checkbox" class="custom-control-input" id="rememberMe">
                            <span class="custom-control-label text-dark" for="rememberMe">Remember Me</span>
                        </label>
                    </div>
                    <div class="form-footer mt-2">
                        <input type="submit" class="btn btn-primary btn-block" value="Sign In">
                    </div>
                    <div class="text-center mt-3 text-dark">
                        Don't have an account yet? <a href="{{ route('register') }}">Sign Up</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
