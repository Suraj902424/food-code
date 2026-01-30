<?php
session_start();
require_once 'config.php';

// अगर user login नहीं है तो redirect
if (empty($_SESSION['user_id'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login");
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die("Invalid request!");
}

$user_id    = $_SESSION['user_id'];
$product_id = intval($_GET['id']);
$type       = $_GET['type'];

// Product निकालो
$stmt = $conn->prepare("SELECT * FROM tbl_product WHERE id=? AND status=1");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die("Product not found!");
}

// Cart में डालना
$check = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id=? AND product_id=?");
$check->bind_param("ii", $user_id, $product_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $newQty = $row['quantity'] + 1;
    $update = $conn->prepare("UPDATE cart SET quantity=? WHERE id=?");
    $update->bind_param("ii", $newQty, $row['id']);
    $update->execute();
} else {
    $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?,?,1)");
    $insert->bind_param("ii", $user_id, $product_id);
    $insert->execute();
}

// Redirect after success
header("Location: cart");
exit;
?>





