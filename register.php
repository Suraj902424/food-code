<?php
session_start();
include 'config.php';

$msg = "";
$msg_type = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (empty($name) || empty($email) || empty($_POST['password'])) {
        $msg = "All fields are required!";
        $msg_type = "danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email format!";
        $msg_type = "danger";
    } else {
        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $msg = "This email is already registered. Please <a href='login.php' class='alert-link'>login</a>.";
            $msg_type = "warning";
        } else {
            $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {
                $msg = "Account created successfully! Please <a href='login.php' class='alert-link'>login</a>.";
                $msg_type = "success";
            } else {
                $msg = "Something went wrong. Please try again.";
                $msg_type = "danger";
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | YourBrand</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts: Poppins -->
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
        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .register-card:hover {
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
        .btn-register {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-register:hover {
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
            <div class="register-card p-4 p-md-5">

                <!-- Logo -->
                <div class="brand-logo mx-auto">
                    <i class="fas fa-user-plus"></i>
                    <!-- या अपना लोगो: <img src="images/logo.png" alt="Logo" style="width:60px; border-radius:50%;"> -->
                </div>

                <h4 class="text-center fw-bold mb-4" style="color: #333;">Create Account</h4>
                <p class="text-center text-muted mb-4">Join us today — it's free and fast!</p>

                <!-- Message Alert -->
                <?php if ($msg): ?>
                    <div class="alert alert-<?= $msg_type ?> alert-dismissible fade show small">
                        <i class="fas <?= $msg_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle' ?>"></i>
                        <?= $msg ?>
                        <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Register Form -->
                <form method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                        </div>
                    </div>

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
                            <input type="password" name="password" id="password" class="form-control" placeholder="Create a strong password" required>
                            <span class="input-group-text password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label text-muted small" for="terms">
                            I agree to the <a href="#" style="color: #667eea;">Terms</a> and <a href="#" style="color: #667eea;">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-register w-100 text-white">
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider">or sign up with</div>

                <!-- Social Buttons -->
                <!-- <div class="row g-2">
                    <div class="col-6">
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
                    Already have an account?
                    <a href="login.php" class="fw-bold" style="color: #667eea; text-decoration: none;">Login here</a>
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