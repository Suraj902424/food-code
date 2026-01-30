<?php
session_start();
require_once 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// Fetch user email
$stmtUser = $conn->prepare("SELECT email FROM users WHERE id = ?");
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();
$user_email = $user['email'] ?? '';
$stmtUser->close();

if (empty($user_email)) {
    $_SESSION = [];
    session_destroy();
    header("Location: login.php");
    exit;
}

// Fetch grouped bookings by confirm_token
$bookingStmt = $conn->prepare("
    SELECT
        b.confirm_token,
        b.created_at,
        b.status,
        b.customer_name,
        b.mobile,
        b.email,
        b.table_number,
        SUM(b.total_price) AS total_amount
    FROM tbl_booking b
    WHERE b.email = ?
    GROUP BY b.confirm_token
    ORDER BY b.created_at DESC
");
$bookingStmt->bind_param("s", $user_email);
$bookingStmt->execute();
$bookings = $bookingStmt->get_result();

// Fetch Delivery Orders
$deliveryStmt = $conn->prepare("
    SELECT id, customer_name, phone, address, city, state, pincode,
           payment_method, status, total_amount, created_at
    FROM orders
    WHERE user_id = ?
    ORDER BY created_at DESC
");
$deliveryStmt->bind_param("i", $user_id);
$deliveryStmt->execute();
$deliveryOrders = $deliveryStmt->get_result();
?>

<?php include 'include/head.php'; ?>
<?php include 'include/topbar.php'; ?>
<?php include 'include/header.php'; ?>

<div class="account-page py-5">
    <div class="container">
        <!-- Welcome & Logout -->
        <div class="row mb-4 align-items-center">
            <div class="col-12 col-sm-8">
                <h2 class="mb-0 fw-bold text-primary">
                    Welcome, <?= htmlspecialchars($name); ?>
                </h2>
                <small class="text-muted">Yahan aap apne saare food bookings dekh sakte hain.</small>
            </div>
            <div class="col-12 col-sm-4 text-sm-end mt-3 mt-sm-0">
                <a href="logout.php" class="btn btn-outline-danger btn-sm px-4">
                    Logout
                </a>
            </div>
        </div>

        <!-- ========== DINE-IN BOOKINGS ========== -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-gradient text-white" style="background: линейный градиент(135deg, #667eea 0%, #764ba2 100%);">
                <h4 class="mb-0">Your Food Orders (Dine-In)</h4>
            </div>
            <div class="card-body p-0">

                <?php if ($bookings->num_rows > 0): ?>
                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Customer</th>
                                    <th>Mobile</th>
                                    <th>Table</th>
                                    <th>Date & Time</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sr = 1; while ($b = $bookings->fetch_assoc()): ?>
                                    <?php
                                    $status = $b['status'];
                                    $badge = match($status) {
                                        'confirmed' => 'bg-success',
                                        'pending' => 'bg-warning text-dark',
                                        'cancelled' => 'bg-danger',
                                        'delivered' => 'bg-primary',
                                        default => 'bg-secondary'
                                    };
                                    $text = ucfirst($status);
                                    ?>
                                    <tr>
                                        <td class="text-center fw-bold"><?= $sr++; ?></td>
                                        <td>
                                            <div class="fw-semibold"><?= htmlspecialchars($b['customer_name']); ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($b['email']); ?></small>
                                        </td>
                                        <td><?= htmlspecialchars($b['mobile']); ?></td>
                                        <td><span class="badge bg-info text-dark">Table <?= $b['table_number']; ?></span></td>
                                        <td>
                                            <div><?= date("d M Y", strtotime($b['created_at'])); ?></div>
                                            <small class="text-muted"><?= date("h:i A", strtotime($b['created_at'])); ?></small>
                                        </td>
                                        <td><span class="badge <?= $badge; ?>"><?= $text; ?></span></td>
                                        <td class="fw-bold text-success">₹<?= number_format((float)$b['total_amount'], 2); ?></td>
                                        <td>
                                            <a href="booking-bill.php?token=<?= urlencode($b['confirm_token']); ?>"
                                               class="btn btn-sm btn-outline-primary" target="_blank">
                                                Bill
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="d-md-none">
                        <?php 
                        $bookings->data_seek(0); // Reset pointer
                        $sr = 1; 
                        while ($b = $bookings->fetch_assoc()): 
                            $status = $b['status'];
                            $badge = match($status) {
                                'confirmed' => 'bg-success',
                                'pending' => 'bg-warning text-dark',
                                'cancelled' => 'bg-danger',
                                'delivered' => 'bg-primary',
                                default => 'bg-secondary'
                            };
                            $text = ucfirst($status);
                        ?>
                            <div class="p-3 border-bottom bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>#<?= $sr++; ?></strong>
                                    <span class="badge <?= $badge; ?>"><?= $text; ?></span>
                                </div>
                                <div class="fw-semibold"><?= htmlspecialchars($b['customer_name']); ?></div>
                                <small class="text-muted"><?= htmlspecialchars($b['email']); ?></small>

                                <div class="mt-2 small">
                                    <strong>Mobile:</strong> <?= htmlspecialchars($b['mobile']); ?><br>
                                    <strong>Table:</strong> 
                                    <span class="badge bg-info text-dark">Table <?= $b['table_number']; ?></span>
                                </div>

                                <div class="mt-2 small">
                                    <strong>Date:</strong> <?= date("d M Y", strtotime($b['created_at'])); ?><br>
                                    <strong>Time:</strong> <?= date("h:i A", strtotime($b['created_at'])); ?>
                                </div>

                                <div class="mt-2 fw-bold text-success">
                                    ₹<?= number_format((float)$b['total_amount'], 2); ?>
                                </div>

                                <div class="mt-3">
                                    <a href="booking-bill.php?token=<?= urlencode($b['confirm_token']); ?>"
                                       class="btn btn-sm btn-outline-primary w-100" target="_blank">
                                        View Bill
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <img src="assets/img/empty-cart.svg" alt="No Bookings" class="mb-3" style="width: 80px; opacity: 0.6;">
                        <h5 class="text-muted">No dine-in bookings yet!</h5>
                        <p class="text-muted">Jaldi se kuch order karo!</p>
                        <a href="menu.php" class="btn btn-primary mt-2">Browse Menu</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ========== DELIVERY ORDERS ========== -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Your Delivery Orders</h4>
            </div>
            <div class="card-body p-0">

                <?php if ($deliveryOrders->num_rows > 0): ?>
                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; while ($d = $deliveryOrders->fetch_assoc()): ?>
                                    <tr>
                                        <td class="text-center fw-bold"><?= $i++; ?></td>
                                        <td><strong>#<?= $d['id']; ?></strong></td>
                                        <td><?= htmlspecialchars($d['customer_name']); ?></td>
                                        <td><?= htmlspecialchars($d['phone']); ?></td>
                                        <td>
                                            <small>
                                                <?= htmlspecialchars(substr($d['address'], 0, 40)); ?>...<br>
                                                <span class="text-muted"><?= $d['city']; ?>, <?= $d['pincode']; ?></span>
                                            </small>
                                        </td>
                                        <td class="fw-bold text-success">₹<?= number_format((float)$d['total_amount'], 2); ?></td>
                                        <td>
                                            <span class="badge <?= 
                                                $d['status']=='Pending' ? 'bg-warning text-dark' :
                                                ($d['status']=='Confirmed' ? 'bg-primary' :
                                                ($d['status']=='Delivered' ? 'bg-success' : 'bg-danger'))
                                            ?>">
                                                <?= $d['status']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div><?= date("d M Y", strtotime($d['created_at'])); ?></div>
                                            <small class="text-muted"><?= date("h:i A", strtotime($d['created_at'])); ?></small>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="d-md-none">
                        <?php 
                        $deliveryOrders->data_seek(0);
                        $i = 1; 
                        while ($d = $deliveryOrders->fetch_assoc()): 
                            $statusBadge = match($d['status']) {
                                'Pending' => 'bg-warning text-dark',
                                'Confirmed' => 'bg-primary',
                                'Delivered' => 'bg-success',
                                default => 'bg-danger'
                            };
                        ?>
                            <div class="p-3 border-bottom bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>#<?= $i++; ?> | ID: #<?= $d['id']; ?></strong>
                                    <span class="badge <?= $statusBadge; ?>"><?= $d['status']; ?></span>
                                </div>

                                <div class="fw-semibold"><?= htmlspecialchars($d['customer_name']); ?></div>
                                <div><strong>Phone:</strong> <?= htmlspecialchars($d['phone']); ?></div>

                                <div class="mt-2 small">
                                    <strong>Address:</strong><br>
                                    <small>
                                        <?= nl2br(htmlspecialchars($d['address'])); ?><br>
                                        <span class="text-muted"><?= $d['city']; ?>, <?= $d['pincode']; ?></span>
                                    </small>
                                </div>

                                <div class="mt-2 fw-bold text-success">
                                    ₹<?= number_format((float)$d['total_amount'], 2); ?>
                                </div>

                                <div class="mt-2 text-muted small">
                                    <?= date("d M Y, h:i A", strtotime($d['created_at'])); ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <img src="assets/img/empty-cart.svg" alt="No Delivery" class="mb-3" style="width: 80px; opacity: 0.6;">
                        <h5 class="text-muted">No delivery orders yet!</h5>
                        <p class="text-muted">Ghar baithe order karo!</p>
                        <a href="menu.php" class="btn btn-success mt-2">Order Now</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'include/footer.php'; ?>
<?php include 'include/js.php'; ?>

<!-- Custom Styles -->
<style>
    .account-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 80vh;
    }
    .card {
        border-radius: 1rem;
        overflow: hidden;
    }
    .table th {
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
    }

    /* Mobile Card Styling */
    @media (max-width: 767px) {
        .d-md-none > div {
            background: #fff;
        }
        .d-md-none > div:first-child {
            border-radius: 0.5rem 0.5rem 0 0;
        }
        .d-md-none > div:last-child {
            border-radius: 0 0 0.5rem 0.5rem;
            border-bottom: none !important;
        }
        .d-md-none > div + div {
            border-top: 1px solid #eee;
        }
        .table-responsive {
            border: none;
        }
    }
</style>

<?php
// Close connections
$bookingStmt->close();
$deliveryStmt->close();
$conn->close();
?>