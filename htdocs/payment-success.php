<?php
require 'config.php';
$order_id = intval($_GET['order_id']);
$payment_id = $_GET['payment_id'] ?? '';

if ($order_id && $payment_id) {
    $stmt = $conn->prepare("UPDATE tbl_booking SET status='paid' WHERE id=?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    echo "<h2>✅ Payment Successful!</h2>
          <p>Payment ID: $payment_id</p>
          <p>Your order has been confirmed and paid. Thank you!</p>";
} else {
    echo "Invalid payment details.";
}
?>
