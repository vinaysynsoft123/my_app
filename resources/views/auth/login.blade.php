<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Login')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            border-radius: 16px;
            overflow: hidden;
        }

        .login-left {
            background: linear-gradient(160deg, #1e3a8a, #2563eb);
            color: #fff;
            padding: 40px;
        }

        .login-left h2 {
            font-weight: 700;
        }

        .login-left p {
            opacity: 0.9;
        }

        .form-control {
            padding-left: 40px;
            height: 48px;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #6b7280;
        }

        .btn-login {
            height: 48px;
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card login-card shadow-lg border-0">
                <div class="row g-0">

                    <!-- LEFT SIDE -->
                    <div class="col-md-5 d-none d-md-flex align-items-center login-left">
                        <div>
                            <h2>Admin Panel</h2>
                            <p class="mt-3">
                                Manage bookings, rooms, users and reports from one place.
                            </p>

                            <div class="mt-4">
                                <i class="bi bi-shield-lock fs-1"></i>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col-md-7">
                        <div class="card-body p-5">

                            <h4 class="fw-bold mb-2">Welcome Back 👋</h4>
                            <p class="text-muted mb-4">
                                Sign in to continue to your dashboard
                            </p>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Email -->
                                <div class="mb-3 position-relative">
                                    <i class="bi bi-envelope input-icon"></i>
                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           placeholder="Email address"
                                           value="{{ old('email') }}"
                                           required autofocus>
                                </div>

                                <!-- Password -->
                                <div class="mb-4 position-relative">
                                    <i class="bi bi-lock input-icon"></i>
                                    <input type="password"
                                           name="password"
                                           class="form-control"
                                           placeholder="Password"
                                           required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 btn-login">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>
                                    Sign In
                                </button>
                            </form>

                            <div class="text-center mt-4">
                                <small class="text-muted">
                                    Don’t have an account?
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">
                                        Register
                                    </a>
                                </small>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
@if (session('error'))
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast text-bg-danger show">
        <div class="toast-body">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ session('error') }}
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.toast').forEach(t => new bootstrap.Toast(t).show());
    });
</script>

</body>
</html>
