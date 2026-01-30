<?php
session_start();
require_once "config.php";

// Initialize
$step = 1;
$msg = "";
$email_found = "";

// Step 1: Check Email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_email'])) {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $_SESSION['reset_user_id'] = $user['id'];
            $email_found = $email;
            $step = 2;
        } else {
            $msg = "No account found with this email.";
        }
        $stmt->close();
    }
}

// Step 2: Change Password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_pass'])) {
    if (empty($_SESSION['reset_user_id'])) {
        $msg = "Session expired. Please try again.";
        $step = 1;
    } else {
        $new_pass = $_POST['new_pass'] ?? '';
        $confirm_pass = $_POST['confirm_pass'] ?? '';

        if ($new_pass === '' || $confirm_pass === '') {
            $msg = "All fields are required.";
            $step = 2;
        } elseif ($new_pass !== $confirm_pass) {
            $msg = "Passwords do not match.";
            $step = 2;
        } elseif (strlen($new_pass) < 6) {
            $msg = "Password must be at least 8 characters.";
            $step = 2;
        } else {
            $hash = password_hash($new_pass, PASSWORD_BCRYPT);
            $user_id = $_SESSION['reset_user_id'];

            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hash, $user_id);

            if ($stmt->execute()) {
                unset($_SESSION['reset_user_id']);
                $msg = "Password changed successfully!";
                $step = 3;
            } else {
                $msg = "Failed to update password. Try again.";
                $step = 2;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | SecureLogin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="https://via.placeholder.com/32?text=S" type="image/x-icon">
    <style>
        :root {
            --primary: #4361ee;
            --success: #10b981;
            --danger: #ef4444;
            --dark: #1e293b;
            --light: #f8fafc;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .logo img {
            height: 50px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        .form-control {
            border-radius: 1rem;
            padding: 0.75rem 1rem;
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.2);
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 2rem;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }

        .btn-success {
            background: var(--success);
            border: none;
            border-radius: 2rem;
            padding: 0.75rem;
            font-weight: 600;
        }

        .alert {
            border-radius: 1rem;
            border: none;
            font-weight: 500;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .text-muted a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }

        .text-muted a:hover {
            color: white;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="glass-card p-4 p-md-5 fade-in">

                <!-- Logo & Title -->
                <div class="text-center mb-4">
                    <div class="logo mb-3">
                        <img src="https://via.placeholder.com/120x50?text=SecureLogin" alt="Logo" class="img-fluid">
                    </div>
                    <h4 class="text-white fw-bold">Forgot Password?</h4>
                    <p class="text-white-50 small">Enter your email to reset password</p>
                </div>

                <!-- Messages -->
                <?php if ($msg): ?>
                    <div class="alert <?= strpos($msg, 'success') !== false ? 'alert-success' : 'alert-danger' ?> text-center py-2 mb-3">
                        <small><?= htmlspecialchars($msg) ?></small>
                    </div>
                <?php endif; ?>

                <!-- Step 1: Email -->
                <?php if ($step === 1): ?>
                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label class="form-label text-white">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 text-white">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control" 
                                       placeholder="you@example.com" 
                                       value="<?= htmlspecialchars($email_found) ?>" required autofocus>
                            </div>
                        </div>
                        <button name="check_email" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-arrow-right"></i> Continue
                        </button>
                    </form>
                <?php endif; ?>

                <!-- Step 2: New Password -->
                <?php if ($step === 2): ?>
                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label class="form-label text-white">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 text-white">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="new_pass" class="form-control" 
                                       placeholder="••••••" required minlength="6">
                            </div>
                            <small class="text-white-50">Minimum 8 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 text-white">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="confirm_pass" class="form-control" 
                                       placeholder="••••••••" required minlength="8">
                            </div>
                        </div>

                        <button name="change_pass" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-check"></i> Change Password
                        </button>
                    </form>
                <?php endif; ?>

                <!-- Step 3: Success -->
                <?php if ($step === 3): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 3.5rem;"></i>
                        <h5 class="text-white mt-3">Password Updated!</h5>
                        <p class="text-white-50">You can now login with your new password.</p>
                        <a href="login.php" class="btn btn-primary px-5 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-sign-in-alt"></i> Go to Login
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Back Link -->
                <div class="text-center mt-4">
                    <p class="text-muted small">
                        <a href="login.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
// Auto-hide alerts after 5 seconds
setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }
}, 5000);
</script>

</body>
</html>