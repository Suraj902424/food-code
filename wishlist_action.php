<?php
session_start();
require_once 'include/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Login karo pehle!']);
    exit;
}

$user_id    = (int)$_SESSION['user_id'];
$product_id = (int)$_POST['product_id'];
$action     = $_POST['action']; // 'add' or 'remove'

if ($action === 'add') {
    // Agar pehle se nahi hai to add karo
    $check = mysqli_query($conn, "SELECT id FROM wishlist WHERE user_id = $user_id AND product_id = $product_id");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO wishlist (user_id, product_id) VALUES ($user_id, $product_id)");
        echo json_encode(['status' => 'success', 'message' => 'added']);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'already']);
    }
}
else if ($action === 'remove') {
    mysqli_query($conn, "DELETE FROM wishlist WHERE user_id = $user_id AND product_id = $product_id");
    echo json_encode(['status' => 'success', 'message' => 'removed']);
}
else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>