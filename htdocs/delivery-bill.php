<?php
/* ============================================================
   Tasty Bite - Delivery Bill (Clean & Secure)
   Author: Suraj Foujdar
   Features: Secure, Print-ready, Responsive
============================================================ */
session_start();
require_once 'config.php';

// ✅ Login Check
if (!isset($_SESSION['user_id'])) {
    die("<h3 class='text-center text-danger mt-5'>Please login to view bill.</h3>");
}
$user_id = $_SESSION['user_id'];

// ✅ Get Order ID
$order_id = $_GET['id'] ?? 0;
if (!$order_id || !is_numeric($order_id)) {
    die("<h3 class='text-center text-danger mt-5'>Invalid Order ID</h3>");
}

// ✅ Fetch Order (Only for logged-in user)
$stmt = $conn->prepare("
    SELECT o.*, u.name AS user_name 
    FROM orders o 
    LEFT JOIN users u ON o.user_id = u.id 
    WHERE o.id = ? AND o.user_id = ?
");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    die("<h3 class='text-center text-danger mt-5'>Order not found or access denied!</h3>");
}

// ✅ Fetch Order Items
$stmt_items = $conn->prepare("
    SELECT oi.*, p.name 
    FROM order_items oi 
    JOIN tbl_product p ON oi.product_id = p.id 
    WHERE oi.order_id = ?
");
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items = $stmt_items->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bill - Order #<?= $order_id ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --gold: #D4AF37;
      --dark: #1a1a1a;
      --light: #f8f9fa;
    }
    @media print {
      body { background: white; margin: 0; padding: 15px; }
      .no-print { display: none !important; }
      .card { box-shadow: none; border: 1px solid #ddd; }
      .table { font-size: 14px; }
    }
    .bill-container { max-width: 800px; margin: 30px auto; }
    .bill-header {
      border-bottom: 3px double #000;
      padding-bottom: 18px;
      margin-bottom: 25px;
      text-align: center;
    }
    .bill-header h2 {
      color: var(--gold);
      font-weight: 700;
      margin: 0;
      font-size: 2rem;
    }
    .bill-header p {
      margin: 4px 0;
      color: #555;
      font-size: 0.95rem;
    }
    .info-row {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 20px;
      font-size: 0.95rem;
    }
    .info-box {
      flex: 1;
      min-width: 250px;
    }
    .info-box strong {
      color: var(--dark);
    }
    .address-box {
      background: #f8f9fa;
      padding: 12px;
      border-radius: 8px;
      border-left: 4px solid var(--gold);
      margin: 20px 0;
      font-size: 0.95rem;
    }
    .table {
      margin-top: 20px;
      font-size: 0.95rem;
    }
    .table thead {
      background: #f0f8ff;
    }
    .plate-badge {
      font-size: 0.75rem;
      padding: 4px 8px;
      border-radius: 12px;
    }
    .half { background: #fff3cd; color: #856404; }
    .full { background: #d1ecf1; color: #0c5460; }
    .total-row {
      font-weight: 700;
      font-size: 1.1rem;
    }
    .total-amount {
      color: var(--gold);
      font-size: 1.2rem;
    }
    .bill-footer {
      border-top: 2px dashed #000;
      padding-top: 18px;
      margin-top: 30px;
      text-align: center;
      font-size: 0.95rem;
    }
    .btn-print {
      background: linear-gradient(135deg, #28a745, #20c997);
      color: white;
      padding: 12px 30px;
      font-weight: 600;
      border-radius: 50px;
      text-decoration: none;
      display: inline-block;
      margin: 10px 8px;
      transition: 0.3s;
    }
    .btn-print:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(40,167,69,0.3);
    }
    .btn-back {
      background: #6c757d;
    }
    .status-badge {
      font-size: 0.8rem;
      padding: 5px 10px;
    }
  </style>
</head>
<body class="bg-light">

<div class="container bill-container">
  <div class="card shadow-lg border-0">
    <div class="card-body p-5">

      <!-- Header -->
      <div class="bill-header">
        <h2>Tasty Bite</h2>
        <p>Jaipur, Rajasthan</p>
        <p><i class="bi bi-telephone-fill"></i> +91 87644 80642</p>
      </div>

      <!-- Order Info -->
      <div class="info-row">
        <div class="info-box">
          <p><strong>Order ID:</strong> #<?= $order_id ?></p>
          <p><strong>Date:</strong> <?= date("d M Y, h:i A", strtotime($order['created_at'])) ?></p>
          <p><strong>Status:</strong>
            <span class="badge status-badge <?= 
              $order['status'] === 'Delivered' ? 'bg-success' : 
              ($order['status'] === 'Confirmed' ? 'bg-info' : 'bg-warning text-dark')
            ?>">
              <?= ucfirst($order['status']) ?>
            </span>
          </p>
        </div>
        <div class="info-box text-end">
          <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
          <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
          <p><strong>Payment:</strong>
            <span class="badge bg-<?= $order['payment_method'] === 'COD' ? 'warning' : 'primary' ?>">
              <?= $order['payment_method'] ?>
            </span>
          </p>
        </div>
      </div>

      <!-- Delivery Address -->
      <div class="address-box">
        <strong>Delivery Address:</strong><br>
        <?= nl2br(htmlspecialchars($order['address'])) ?>
      </div>

      <!-- Items Table -->
      <table class="table table-bordered align-middle">
        <thead>
          <tr>
            <th>Item</th>
            <th>Plate</th>
            <th class="text-center">Qty</th>
            <th class="text-end">Price</th>
            <th class="text-end">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($item = $items->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($item['name']) ?></td>
              <td>
                <span class="plate-badge <?= $item['plate_type'] === 'half' ? 'half' : 'full' ?>">
                  <?= ucfirst($item['plate_type']) ?> Plate
                </span>
              </td>
              <td class="text-center"><?= $item['quantity'] ?></td>
              <td class="text-end">₹<?= number_format($item['price'], 2) ?></td>
              <td class="text-end">₹<?= number_format($item['total'], 2) ?></td>
            </tr>
          <?php endwhile; ?>
          <tr class="total-row table-warning">
            <td colspan="4" class="text-end fw-bold">Grand Total</td>
            <td class="text-end total-amount">₹<?= number_format($order['total_amount'], 2) ?></td>
          </tr>
        </tbody>
      </table>

      <!-- Footer -->
      <div class="bill-footer">
        <p class="mb-1 fw-bold">Thank you for choosing Tasty Bite!</p>
        <p class="mb-0 text-muted">We hope to serve you again soon!</p>
      </div>

      <!-- Action Buttons -->
      <div class="text-center mt-4 no-print">
        <a href="javascript:window.print()" class="btn-print">
          <i class="bi bi-printer"></i> Print Bill
        </a>
        <a href="my-account.php" class="btn-print btn-back">
          <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
      </div>

    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>