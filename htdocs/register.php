<?php
session_start();
include 'config.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $msg = "<span style='color:#ff8080;'>⚠️ This email is already registered. Please <a href='login.php'>login</a>.</span>";
    } else {
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $msg = "<span style='color:#b3ffb3;'>✅ Registered Successfully! Please <a href='login.php'>Login</a></span>";
        } else {
            $msg = "<span style='color:#ff8080;'>❌ Something went wrong. Please try again.</span>";
        }
        $stmt->close();
    }

    $check->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | MyShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg,#1f4037,#99f2c8);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 15px;
      font-family: 'Segoe UI',sans-serif;
      position: relative;
    }
    .brand-logo {
      position: absolute;
      top: 30px;
      left: 50%;
      transform: translateX(-50%);
      text-align: center;
    }
    .brand-logo img {
      max-height: 70px;
      filter: drop-shadow(0 3px 5px rgba(0,0,0,0.4));
    }
    .register-box {
      backdrop-filter: blur(14px);
      background: rgba(255,255,255,0.07);
      padding: 40px 30px;
      border-radius: 20px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.5);
      color: #fff;
      margin-top: 100px;
    }
    .register-box h2 {
      font-weight: bold;
      margin-bottom: 25px;
      text-align: center;
      font-size: 1.8rem;
      color: #fff;
    }
    .form-control {
      border-radius: 50px;
      padding: 12px 20px;
      background-color: rgba(255,255,255,0.1);
      color: #fff;
      border: 1px solid rgba(255,255,255,0.3);
    }
    .form-control::placeholder {color:#ddd;}
    .form-control:focus {
      background-color: rgba(255,255,255,0.2);
      box-shadow: none;
      border-color: #0d6efd;
    }
    .btn-custom {
      border-radius: 50px;
      padding: 12px;
      font-weight: bold;
      font-size: 1rem;
      background: linear-gradient(45deg,#ff6a00,#ee0979);
      border: none;
      transition: all .3s ease;
    }
    .btn-custom:hover {
      background: linear-gradient(45deg,#ee0979,#ff6a00);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.3);
    }
    .msg {
      text-align: center;
      margin-bottom: 10px;
      font-size: .9rem;
    }
  </style>
</head>
<body>
  <!-- brand logo top -->
  <div class="brand-logo">
    <a class="navbar-brand" href="index.php">
      <img src="admin/uploads/products/logo.png" alt="MyShop Logo">
    </a>
  </div>

  <div class="register-box">
    <h2>📝 Create Account</h2>
    <?php if($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="Full Name" required>
      </div>
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-custom w-100">Register</button>
      <p class="mt-3 text-center text-light">Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>
</body>
</html>
