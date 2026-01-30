<?php
require 'config.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// ✅ Check for valid order ID
$order_id = intval($_GET['id'] ?? 0);
if (!$order_id) {
    die("<h3>❌ Invalid order ID.</h3>");
}

// ✅ Fetch order and user info
$orderSql = "
    SELECT o.*, u.full_name, u.email
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.id = ?
";
$stmt = $conn->prepare($orderSql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("<h3>❌ Order not found.</h3>");
}

// ✅ Fetch ordered items
$itemSql = "
    SELECT p.name, oi.price, oi.quantity
    FROM order_items oi
    JOIN tbl_product p ON oi.product_id = p.id
    WHERE oi.order_id = ?
";
$stmt2 = $conn->prepare($itemSql);
$stmt2->bind_param("i", $order_id);
$stmt2->execute();
$items = $stmt2->get_result();

// ✅ Build table rows
$total = 0;
$rows = '';
while ($i = $items->fetch_assoc()) {
    $lineTotal = $i['price'] * $i['quantity'];
    $total += $lineTotal;
    $rows .= "
        <tr>
            <td>{$i['name']}</td>
            <td align='center'>{$i['quantity']}</td>
            <td align='right'>₹" . number_format($i['price'], 2) . "</td>
            <td align='right'>₹" . number_format($lineTotal, 2) . "</td>
        </tr>
    ";
}

// ✅ HTML Template for Invoice
$html = "
<style>
body { font-family: DejaVu Sans, sans-serif; color: #333; font-size: 12px; }
h2 { text-align: center; margin-bottom: 8px; }
h4 { text-align: center; color: #666; margin-top: 0; }
table { width: 100%; border-collapse: collapse; margin-top: 12px; }
th, td { border: 1px solid #ccc; padding: 6px; }
th { background: #f4f4f4; }
.footer { text-align: center; font-size: 11px; margin-top: 20px; color: #555; }
.info { margin-bottom: 10px; }
</style>

<h2>🍽️ Tasty Bite Restaurant</h2>
<h4>Customer Order Invoice</h4>

<div class='info'>
  <strong>Invoice No:</strong> #{$order['id']}<br>
  <strong>Date:</strong> " . date('d M Y, h:i A', strtotime($order['created_at'])) . "<br>
  <strong>Customer:</strong> {$order['full_name']}<br>
  <strong>Email:</strong> {$order['email']}<br>
  <strong>Payment:</strong> {$order['payment_method']}<br>
  <strong>Status:</strong> {$order['status']}
</div>

<table>
  <thead>
    <tr>
      <th>Product</th>
      <th width='60'>Qty</th>
      <th width='90'>Price</th>
      <th width='100'>Total</th>
    </tr>
  </thead>
  <tbody>
    $rows
    <tr>
      <th colspan='3' align='right'>Grand Total</th>
      <th align='right'>₹" . number_format($total, 2) . "</th>
    </tr>
  </tbody>
</table>

<div class='footer'>
  Thank you for your order!<br>
  <strong>Tasty Bite Restaurant</strong> | tastybitefood.free.nf
</div>
";

// ✅ Generate PDF using Dompdf (if available)
if (class_exists('Dompdf')) {
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("TastyBite_Invoice_{$order['id']}.pdf", ["Attachment" => true]);
} else {
    // 🟡 Fallback — HTML print view
    echo "<script>window.print();</script>" . $html;
}
?>
