<?php
session_start();
require_once 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Validate order ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("Invalid Order ID");
}
$order_id = intval($_GET['id']);

// Check if the order belongs to this user
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if(!$order){
    die("Order not found!");
}

// Fetch order items
$itemStmt = $conn->prepare("
    SELECT p.name, oi.quantity, oi.price, oi.total
    FROM order_items oi
    JOIN tbl_product p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$itemStmt->bind_param("i", $order_id);
$itemStmt->execute();
$items = $itemStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include 'include/head.php'; ?>
</head>
<body>
    <?php include 'include/preloader.php'; ?>
<?php include 'include/topbar.php'; ?>
<?php include 'include/header.php'; ?>

<div class="page-content pt-5 pb-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Order Details - #<?= $order_id ?></h2>
            <a href="my-account.php" class="btn btn-outline-dark">Back to My Account</a>
        </div>

        <div class="order-info mb-4">
            <p><strong>Order Date:</strong> <?= date("d M Y, h:i A", strtotime($order['created_at'])); ?></p>
            <p><strong>Delivery Address:</strong> <?= htmlspecialchars($order['address']); ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']); ?></p>
            <p><strong>Payment Method:</strong> <?= htmlspecialchars($order['payment_method']); ?></p>
        </div>

        <h4>Items</h4>
        <div class="order-items">
            <?php 
            $grandTotal = 0;
            while($item = $items->fetch_assoc()):
                $grandTotal += $item['total'];
            ?>
            <div class="order-item d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                <div class="item-name"><?= htmlspecialchars($item['name']); ?></div>
                <div class="item-price">₹<?= number_format($item['price'], 2); ?></div>
                <div class="item-qty">Qty: <?= $item['quantity']; ?></div>
                <div class="item-total">₹<?= number_format($item['total'], 2); ?></div>
            </div>
            <?php endwhile; ?>
        </div>

        <div class="grand-total mt-4 text-end">
            <h5>Grand Total: ₹<?= number_format($grandTotal, 2); ?></h5>
        </div>

    </div>
</div>

<?php include 'include/footer.php'; ?>
<?php include 'include/js.php'; ?>

</body>
</html>
