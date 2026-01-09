<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard')</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('asset/css/main.css') }}" rel="stylesheet">

  
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.toast').forEach(t => new bootstrap.Toast(t).show());
});
</script>
<body>
<div class="container-fluid">
<div class="row justify-content-center mt-5">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white text-center py-4">
                <h4 class="mb-0">Welcome Back</h4>
            </div>
            <div class="card-body p-4">

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        Sign In
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-0">Don't have an account?
                        <a href="{{ route('register') }}" class="text-decoration-none">Register here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@if (session('error'))
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast text-bg-danger show">
        <div class="toast-body">
            {{ session('error') }}
        </div>
    </div>
</div>
@endif

</body>
</html>
