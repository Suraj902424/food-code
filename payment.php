<?php
require 'config.php';
$order_id = intval($_GET['order_id'] ?? 0);

$sql = "SELECT * FROM tbl_booking WHERE id=? AND status='confirmed'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) die("Invalid order or not confirmed yet.");

$total_amount = 100 * ($order['quantity'] * ($order['size'] == 'full' ? $order['price_full'] : $order['price_half'])); // in paise
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body style="text-align:center; margin-top:50px;">
<h2>💳 Pay for Your Order</h2>
<p>Total: ₹<?= number_format($total_amount/100, 2) ?></p>
<button id="rzp-button1">Pay Now</button>
<script>
var options = {
    "key": "YOUR_RAZORPAY_KEY_ID",
    "amount": "<?= $total_amount ?>",
    "currency": "INR",
    "name": "Food Order Payment",
    "description": "Payment for order #<?= $order_id ?>",
    "handler": function (response){
        window.location.href = "payment-success.php?order_id=<?= $order_id ?>&payment_id=" + response.razorpay_payment_id;
    },
    "theme": { "color": "#3399cc" }
};
var rzp1 = new Razorpay(options);
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>
</body>
</html>
