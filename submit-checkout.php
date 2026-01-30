<?php
session_start();
include 'config.php'; // yahan aapka DB connection ho

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cart.php'); // agar direct open hua toh cart page pe bhejo
    exit;
}

// Validate required fields
$customer_name = trim($_POST['customer_name'] ?? '');
$mobile = trim($_POST['mobile'] ?? '');
$email = trim($_POST['email'] ?? '');
$address = trim($_POST['address'] ?? '');

$cart = $_SESSION['cart'] ?? [];

if (!$cart) {
    die("Cart is empty. Please add products before placing an order.");
}

if (!$customer_name || !$mobile || !$email || !$address) {
    die("Please fill all required fields.");
}

// Calculate grand total
$grandTotal = 0;
foreach ($cart as $item) {
    $grandTotal += $item['price'] * $item['quantity'];
}

// Insert order data
$stmt = $conn->prepare("INSERT INTO orders (customer_name, mobile, email, address, total_amount) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssd", $customer_name, $mobile, $email, $address, $grandTotal);
if (!$stmt->execute()) {
    die("Order insertion failed: " . $stmt->error);
}
$order_id = $stmt->insert_id;
$stmt->close();

// Insert order items
$stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity, total_price) VALUES (?, ?, ?, ?, ?, ?)");

foreach ($cart as $item) {
    $product_id = $item['id'];
    $product_name = $item['name'];
    $price = $item['price'];
    $quantity = $item['quantity'];
    $total_price = $price * $quantity;

    $stmt_item->bind_param("iisdid", $order_id, $product_id, $product_name, $price, $quantity, $total_price);
    if (!$stmt_item->execute()) {
        die("Order item insertion failed: " . $stmt_item->error);
    }
}

$stmt_item->close();

// Clear cart
unset($_SESSION['cart']);

// Redirect to thank you or order confirmation page
header("Location: thank_you.php?order_id=" . $order_id);
exit;
?>
