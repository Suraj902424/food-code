<?php
// delivery-bill.php
session_start();
require_once 'config.php';

if (!isset($_GET['order_id'])) {
    die("Invalid order");
}

$order_id = (int)$_GET['order_id'];
$user_id = (int)$_SESSION['user_id'];

// Fetch order + user
$stmt = $conn->prepare("
    SELECT o.*, u.name AS user_name 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    WHERE o.id = ? AND o.user_id = ?
");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    die("Order not found");
}

// Smart expected delivery text
$expectedText = 'ASAP';
if (!empty($order['expected_delivery_date'])) {
    $expDate = new DateTime($order['expected_delivery_date']);
    $today = new DateTime();
    $tomorrow = (clone $today)->modify('+1 day');

    if ($expDate->format('Y-m-d') === $today->format('Y-m-d')) {
        $expectedText = 'Today';
    } elseif ($expDate->format('Y-m-d') === $tomorrow->format('Y-m-d')) {
        $expectedText = 'Tomorrow';
    } else {
        $expectedText = $expDate->format('d M Y');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill #<?= $order['id']; ?> - FoodHub</title>

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #4361ee;
            --success: #06d6a0;
        }

        body {
            background: #f8f9ff;
            font-family: 'Segoe UI', sans-serif;
        }

        .bill-card {
            border-radius: 1.2rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            max-width: 500px;
            margin: 2rem auto;
        }

        .bill-header {
            border-bottom: 2px dashed #333;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            font-size: 0.9rem;
        }

        .info-value {
            font-size: 0.95rem;
        }

        .total-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--success);
        }

        @media print {
            body { background: white; margin: 0; padding: 20px; }
            .no-print { display: none; }
            .bill-card { box-shadow: none; border: 1px solid #ddd; }
        }

        @media (max-width: 576px) {
            .bill-card { margin: 1rem; border-radius: 1rem; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="bill-card card border-0">
        <div class="card-body p-4">

            <!-- Restaurant Header -->
            <div class="text-center bill-header">
                <h3 class="fw-bold text-primary mb-1">Tasty Bite Restaurant</h3>
                <p class="text-muted small mb-0">
                    123 Food Street, Jaipur • +91 98765 43210
                </p>
            </div>

            <!-- Bill Info -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6">
                    <div class="info-label">Bill To</div>
                    <div class="info-value">
                        <strong><?= htmlspecialchars($order['customer_name']); ?></strong><br>
                        <?= htmlspecialchars($order['phone']); ?><br>
                        <?= htmlspecialchars($order['address']); ?>,<br>
                        <?= htmlspecialchars($order['city']); ?> - <?= $order['pincode']; ?>
                    </div>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <div class="info-label">Order Details</div>
                    <div class="info-value">
                        <strong>#<?= $order['id']; ?></strong><br>
                        <?= date("d M Y", strtotime($order['created_at'])); ?><br>
                        <?= date("h:i A", strtotime($order['created_at'])); ?>
                    </div>
                </div>
            </div>

            <hr class="text-muted">

            <!-- Delivery Info -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="info-label">Expected Delivery</div>
                    <div class="info-value fw-bold text-warning">
                        <i class="bi bi-calendar-check me-1"></i> <?= $expectedText; ?>
                    </div>
                </div>
                <div class="text-end">
                    <div class="info-label">Status</div>
                    <span class="badge 
                        <?= $order['status'] == 'Delivered' ? 'bg-success' :
                           ($order['status'] == 'Confirmed' ? 'bg-primary' :
                           ($order['status'] == 'Pending' ? 'bg-warning text-dark' : 'bg-danger')) ?>">
                        <?= $order['status']; ?>
                    </span>
                </div>
            </div>

            <!-- Items Placeholder -->
            <div class="bg-light rounded-3 p-3 mb-3">
                <h6 class="mb-2">Order Items</h6>
                <p class="text-muted small mb-0">
                    <em>Items will be listed here from <code>order_items</code> table</em>
                </p>
            </div>

            <!-- Total -->
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <h5 class="mb-0">Total Amount</h5>
                <div class="total-amount">₹<?= number_format($order['total_amount'], 2); ?></div>
            </div>

            <div class="text-muted small text-end mt-1">
                Payment: <strong><?= ucfirst($order['payment_method']); ?></strong>
            </div>

            <!-- Print & Back -->
            <div class="text-center mt-4 no-print">
                <button onclick="window.print()" class="btn btn-success rounded-pill px-4">
                    <i class="bi bi-printer"></i> Print Bill
                </button>
                <a href="my-account" class="btn btn-outline-secondary rounded-pill px-4 ms-2">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>