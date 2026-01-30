<?php
session_start();
require_once 'config.php';

// अगर order id session में नहीं है तो cart या home पर redirect कर दो
if (!isset($_SESSION['last_order_id'])) {
    header("Location: cart.php");
    exit;
}

$order_id = $_SESSION['last_order_id'];

// Order details निकाल लो
$query = "
    SELECT o.id, o.address, o.phone, o.payment_method, o.created_at, u.name 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// Order items निकाल लो
$itemQuery = "
    SELECT p.name, oi.quantity, oi.price
    FROM order_items oi
    JOIN tbl_product p ON oi.product_id = p.id
    WHERE oi.order_id = ?
";
$itemStmt = $conn->prepare($itemQuery);
$itemStmt->bind_param("i", $order_id);
$itemStmt->execute();
$items = $itemStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Success</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f9f9f9; margin:0; padding:0; }
    .success-box {
      max-width: 700px; margin: 50px auto; background: #fff; padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px; text-align:center;
    }
    h1 { color: #4CAF50; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
    th { background: #f4f4f4; }
    .btn {
      display: inline-block; margin-top: 20px; padding: 12px 20px;
      background: #4CAF50; color: #fff; text-decoration: none; border-radius: 5px;
    }
    .btn:hover { background: #388E3C; }
  </style>
</head>
<body>

<div class="success-box">
  <h1>🎉 Order Placed Successfully!</h1>
  <p>Thank you <b><?= htmlspecialchars($order['name']); ?></b>, your order has been placed.</p>
  <p><b>Order ID:</b> #<?= $order['id']; ?></p>
  <p><b>Delivery Address:</b> <?= htmlspecialchars($order['address']); ?></p>
  <p><b>Phone:</b> <?= htmlspecialchars($order['phone']); ?></p>
  <p><b>Payment Method:</b> <?= htmlspecialchars($order['payment_method']); ?></p>
  <p><b>Date:</b> <?= $order['created_at']; ?></p>

  <h3>Order Items</h3>
  <table>
    <tr>
      <th>Product</th>
      <th>Price (₹)</th>
      <th>Quantity</th>
      <th>Total</th>
    </tr>
    <?php 
    $grandTotal = 0;
    while ($item = $items->fetch_assoc()): 
      $total = $item['price'] * $item['quantity'];
      $grandTotal += $total;
    ?>
    <tr>
      <td><?= htmlspecialchars($item['name']); ?></td>
      <td><?= number_format($item['price'], 2); ?></td>
      <td><?= $item['quantity']; ?></td>
      <td><?= number_format($total, 2); ?></td>
    </tr>
    <?php endwhile; ?>
    <tr>
      <th colspan="3">Grand Total</th>
      <th>₹<?= number_format($grandTotal, 2); ?></th>
    </tr>
  </table>

  <a href="index.php" class="btn">Go to Home</a>
</div>

</body>
</html>
