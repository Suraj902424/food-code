<?php
require 'config.php';

// ✅ Validate input
$token = $_GET['token'] ?? '';
if (!$token) {
    die("<h3>❌ Invalid link.</h3>");
}

// ✅ Fetch all bookings with same confirm token
$sql = "SELECT b.*, p.name AS product_name 
        FROM tbl_booking b 
        JOIN tbl_product p ON b.product_id = p.id 
        WHERE b.confirm_token = ?
        ORDER BY b.id ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("<h3>❌ No booking found.</h3>");
}

// ✅ Collect customer + booking data
$bookings = [];
$total_amount = 0;
$customer = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
    $total_amount += $row['total_price'];
    $customer = [
        'id' => $row['id'],
        'name' => $row['customer_name'],
        'mobile' => $row['mobile'],
        'email' => $row['email'],
        'table' => $row['table_number'],
        'status' => ucfirst($row['status']),
        'created_at' => $row['created_at']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking Invoice - <?= htmlspecialchars($customer['name']); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #fff;
    color: #333;
    margin: 20px;
}
.invoice-box {
    max-width: 800px;
    margin: auto;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 25px 30px;
    background: #fafafa;
}
.header-title {
    text-align: center;
    border-bottom: 2px solid #222;
    margin-bottom: 20px;
    padding-bottom: 10px;
}
.header-title h2 {
    font-weight: 700;
    margin: 0;
}
.details p {
    margin: 2px 0;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}
table th, table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
}
table th {
    background: #f1f1f1;
}
.total {
    text-align: right;
    font-weight: 600;
}
.print-btn {
    display: block;
    width: 200px;
    margin: 20px auto;
    background: #28a745;
    color: #fff;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
    font-weight: 600;
    text-decoration: none;
}
.print-btn:hover {
    background: #218838;
    color: #fff;
}
@media print {
    .print-btn { display: none; }
    body { background: #fff; margin: 0; }
}
</style>
</head>
<body>

<div class="invoice-box">
    <div class="header-title">
        <h2>🍽️ Tasty Bite Restaurant</h2>
        <p>Booking Invoice</p>
    </div>

    <div class="details">
        <p><strong>Booking - ID:</strong> <?= htmlspecialchars($customer['id']); ?></p>
        <p><strong>Customer:</strong> <?= htmlspecialchars($customer['name']); ?></p>
        <p><strong>Mobile:</strong> <?= htmlspecialchars($customer['mobile']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($customer['email']); ?></p>
        <p><strong>Table No:</strong> <?= htmlspecialchars($customer['table']); ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($customer['status']); ?></p>
        <p><strong>Date:</strong> <?= date("d M Y, h:i A", strtotime($customer['created_at'])); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <!-- <th>id</th> -->
                <th>Product</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Price (₹)</th>
                <th>Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach ($bookings as $b): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= htmlspecialchars($b['product_name']); ?></td>
                <td><?= ucfirst($b['size']); ?></td>
                <td><?= $b['quantity']; ?></td>
                <td><?= number_format($b['price'], 2); ?></td>
                <td><?= number_format($b['total_price'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="5" class="total">Grand Total</td>
                <td><strong>₹<?= number_format($total_amount, 2); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <p class="text-center mt-4">Thank you for dining with us! 🍴<br><strong>Tasty Bite Restaurant</strong></p>

    <a href="#" class="print-btn" onclick="window.print()">🖨️ Print Bill</a>
</div>

</body>
</html>
