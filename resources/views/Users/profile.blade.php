
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment and Review System</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('layout/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="{{ route('index') }}" class="nav-link px-2 link-secondary">Home</a></li>
          <li><a href="{{ route('profile') }}" class="nav-link px-2 link-body-emphasis">Profile</a></li>

        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="	https://avatars.githubusercontent.com/u/129229836?v=4" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small" style="">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="{{ route('profile') }}">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
</header>
<body>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="card-title mb-0">User Name Profile : {{ $user->name}}</h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="form-group mb-4">
                        <label for="username" class="form-label">Username</label>
                        <p class="form-control-plaintext">{{ $user->name}}</p>
                    </div>

                    <div class="form-group mb-4">
                        <label for="full_name" class="form-label">Full Name</label>
                        <p class="form-control-plaintext">{{ $user->full_name }}</p>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email" class="form-label">Email</label>
                        <p class="form-control-plaintext">{{ $user->email }}</p>
                    </div>

                    <div class="form-group mb-4">
                        <label for="address" class="form-label">Address</label>
                        <p class="form-control-plaintext">{{ $user->address }}</p>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('edit.profile', $user->id) }}" class="btn btn-secondary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
