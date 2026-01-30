<?php
session_start();
require_once 'config.php';

// Redirect if already logged in
if (!empty($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == "" || $password == "") {
        $error = "Email and Password required!";
    } else {
        $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            $redirect = $_SESSION['redirect_url'] ?? 'my-account.php';
            unset($_SESSION['redirect_url']);
            header("Location: $redirect");
            exit;
        } else {
            $error = $user ? "Incorrect Password!" : "No account found with this email!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | YourBrand</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .login-card:hover {
            transform: translateY(-10px);
        }
        .brand-logo {
            width: 80px;
            height: 80px;
            background: #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -40px auto 20px;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
            font-size: 36px;
            font-weight: bold;
            position: relative;
            z-index: 1;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1.5px solid #e0e0e0;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .input-group-text {
            border-radius: 12px 0 0 12px;
            background: #f8f9fa;
            border: 1.5px solid #e0e0e0;
            border-right: none;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .password-toggle {
            cursor: pointer;
            color: #667eea;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: #aaa;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #eee;
        }
        .divider::before { margin-right: 10px; }
        .divider::after { margin-left: 10px; }
        .social-btn {
            border: 1.5px solid #ddd;
            border-radius: 12px;
            padding: 10px;
            transition: all 0.3s;
        }
        .social-btn:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
        }
        @media (max-width: 480px) {
            .container { padding: 0 15px; }
            .brand-logo { width: 70px; height: 70px; font-size: 30px; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="login-card p-4 p-md-5">

                <!-- Logo -->
                <div class="brand-logo mx-auto">
                    <i class="fas fa-shield-alt"></i>  
                    <!-- <img src="admin/uploads/products/<?= $row['image1'] ?>" alt="Logo">  -->
                </div>

                <h4 class="text-center fw-bold mb-4" style="color: #333;">Welcome Back!</h4>
                <p class="text-center text-muted mb-4">Login to continue to your account</p>

                <!-- Error Alert -->
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show small">
                        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                            <span class="input-group-text password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label text-muted" for="remember">Remember me</label>
                        </div>
                        <a href="forgot-password.php" class="text-decoration-none" style="color: #667eea;">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-login w-100 text-white">
                        <i class="fas fa-sign-in-alt"></i> Login Securely
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider">or continue with</div>

                <!-- Social Login (Optional) -->
                <div class="row g-2">
                    <!-- <div class="col-6">
                        <button class="btn social-btn w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="fab fa-google text-danger"></i>
                            <span class="d-none d-sm-inline">Google</span>
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn social-btn w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="fab fa-github text-dark"></i>
                            <span class="d-none d-sm-inline">GitHub</span>
                        </button>
                    </div>
                </div> -->

                <p class="mt-4 text-center text-muted small">
                    Don't have an account?
                    <a href="register.php" class="fw-bold" style="color: #667eea; text-decoration: none;">Sign up free</a>
                </p>

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            password.type = 'password';
            eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>

</body>
</html>