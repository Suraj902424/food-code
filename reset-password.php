<?php
session_start();
require_once 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$token = $_GET['token'] ?? '';
$message = "";

// ✅ Verify token validity
$stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expiry > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("<div style='text-align:center; margin-top:100px; font-family:Poppins;'>Invalid or expired reset link.</div>");
}

// ✅ Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPass = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);

    if ($newPass === $confirm && strlen($newPass) >= 6) {
        $hash = password_hash($newPass, PASSWORD_BCRYPT);
        $update = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE id = ?");
        $update->bind_param("si", $hash, $user['id']);
        $update->execute();

        $message = "<div class='alert alert-success'>Password updated successfully. <a href='login.php'>Login now</a></div>";
    } else {
        $message = "<div class='alert alert-danger'>Passwords do not match or too short.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <?php include 'include/head.php'; ?>
    <style>
        body { background: #f5f7fa; font-family: 'Poppins', sans-serif; }
        .reset-box {
            max-width: 420px; margin: 100px auto; background: #fff;
            padding: 35px 40px; border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.08);
        }
        .reset-box h3 { text-align: center; color: #2c3e50; margin-bottom: 25px; font-weight: 700; }
        .form-control { height: 50px; border-radius: 10px; font-size: 15px; }
        .btn-primary { width: 100%; height: 50px; border-radius: 10px; background: #27ae60; border: none; font-weight: 600; }
        .btn-primary:hover { background: #1e8449; }
    </style>
</head>
<body>

<div class="reset-box">
    <h3>Reset Your Password</h3>
    <?= $message ?>
    <form method="post">
        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>
        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="confirm" class="form-control" required minlength="6">
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>

<?php include 'include/footer.php'; ?>
<?php include 'include/js.php'; ?>
</body>
</html>
