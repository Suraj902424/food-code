<?php
session_start();
require_once 'config.php';

// === SECURITY: Logged-in check ===
session_start();
if (empty($_SESSION['user_id'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login");
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// === Get User Info ===
$stmtUser = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$user = $stmtUser->get_result()->fetch_assoc();
$stmtUser->close();

if (!$user || empty($user['email'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$name = htmlspecialchars($user['name']);
$email = $user['email'];

// === Fetch Dine-In Bookings ===
$bookingStmt = $conn->prepare("
    SELECT confirm_token, MAX(created_at) AS created_at, MAX(status) AS status,
           MAX(customer_name) AS customer_name, MAX(mobile) AS mobile,
           MAX(table_number) AS table_number, SUM(total_price) AS total_amount
    FROM tbl_booking
    WHERE email = ?
    GROUP BY confirm_token
    ORDER BY created_at DESC
");
$bookingStmt->bind_param("s", $email);
$bookingStmt->execute();
$bookings = $bookingStmt->get_result();

// === Fetch Delivery Orders (using expected_delivery_date) ===
$deliveryStmt = $conn->prepare("
    SELECT id, customer_name, phone, address, city, pincode,
           payment_method, status, total_amount, created_at, expected_delivery_date
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

<div class="account-page">
    <div class="container pb-5">

        <!-- Welcome -->
        <div class="d-flex justify-content-between align-items-center mb-4 px-3 pt-4">
            <div>
                <h4 class="fw-bold text-dark mb-0">Hi, <?= $name; ?>!</h4>
                <small class="text-muted"><?= $email; ?></small>
            </div>
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>

        <!-- Dine-In Bookings -->
        <section class="mb-5">
            <h6 class="text-primary fw-bold px-3 mb-3 d-flex align-items-center">
                <i class="bi bi-cup-hot-fill me-2"></i> Dine-In Bookings
            </h6>

            <?php if ($bookings->num_rows > 0): ?>
                <div class="booking-list">
                    <?php $i = 1; while ($b = $bookings->fetch_assoc()): ?>
                        <?php
                        $statusClass = match($b['status'] ?? '') {
                            'confirmed' => 'bg-success',
                            'pending'   => 'bg-warning text-dark',
                            'cancelled' => 'bg-danger',
                            'delivered' => 'bg-primary',
                            default     => 'bg-secondary'
                        };
                        ?>
                        <div class="booking-card card shadow-sm border-0 mb-3 mx-3">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1 fw-bold">#<?= $i++; ?> • Table <?= $b['table_number']; ?></h6>
                                        <p class="mb-0 small text-muted">
                                            <?= date("d M Y • h:i A", strtotime($b['created_at'])); ?>
                                        </p>
                                    </div>
                                    <span class="badge <?= $statusClass; ?> rounded-pill px-3 py-1 small">
                                        <?= ucfirst($b['status']); ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-success fw-bold">₹<?= number_format($b['total_amount'], 2); ?></div>
                                    <a href="booking-bill.php?token=<?= urlencode($b['confirm_token']); ?>"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="bi bi-receipt"></i> Bill
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5 mx-3">
                    <img src="assets/img/empty-cart.svg" width="70" class="mb-3 opacity-50">
                    <p class="text-muted small">No dine-in bookings yet</p>
                    <a href="menu.php" class="btn btn-primary rounded-pill px-4">Order Now</a>
                </div>
            <?php endif; ?>
        </section>

        <!-- Delivery Orders -->
        <section class="mb-5">
            <h6 class="text-success fw-bold px-3 mb-3 d-flex align-items-center">
                <i class="bi bi-truck me-2"></i> Delivery Orders
            </h6>

            <?php if ($deliveryOrders->num_rows > 0): ?>
                <div class="delivery-list">
                    <?php $i = 1; while ($d = $deliveryOrders->fetch_assoc()): ?>
                        <?php
                        $statusClass = match($d['status']) {
                            'Pending'     => 'bg-warning text-dark',
                            'Confirmed'   => 'bg-primary',
                            'Delivered'   => 'bg-success',
                            default       => 'bg-danger'
                        };

                        // Smart expected delivery text
                        $expectedText = 'ASAP';
                        if (!empty($d['expected_delivery_date'])) {
                            $expDate = new DateTime($d['expected_delivery_date']);
                            $today = new DateTime();
                            $tomorrow = (clone $today)->modify('+1 day');

                            if ($expDate->format('Y-m-d') === $today->format('Y-m-d')) {
                                $expectedText = 'Today';
                            } elseif ($expDate->format('Y-m-d') === $tomorrow->format('Y-m-d')) {
                                $expectedText = 'Tomorrow';
                            } else {
                                $expectedText = $expDate->format('d M');
                            }
                        }
                        ?>
                        <div class="delivery-card card shadow-sm border-0 mb-3 mx-3">
                            <div class="card-body p-3">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1 fw-bold">#<?= $d['id']; ?></h6>
                                        <p class="mb-0 small text-muted">
                                            <?= date("d M • h:i A", strtotime($d['created_at'])); ?>
                                        </p>
                                    </div>
                                    <span class="badge <?= $statusClass; ?> rounded-pill px-3 py-1 small">
                                        <?= $d['status']; ?>
                                    </span>
                                </div>

                                <!-- Customer Info -->
                                <div class="small text-dark mb-2">
                                    <div><strong><?= htmlspecialchars($d['customer_name']); ?></strong></div>
                                    <div class="text-muted"><?= htmlspecialchars($d['phone']); ?></div>
                                    <div class="text-muted mt-1">
                                        <i class="bi bi-geo-alt-fill text-danger small"></i>
                                        <?= htmlspecialchars(substr($d['address'], 0, 50)); ?><?= strlen($d['address']) > 50 ? '...' : ''; ?>
                                    </div>
                                </div>

                                <!-- Expected Delivery -->
                                <div class="d-flex align-items-center mb-2 text-warning small fw-bold">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    Delivery: <span class="ms-1"><?= $expectedText; ?></span>
                                </div>

                                <!-- Footer -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-success fw-bold">₹<?= number_format($d['total_amount'], 2); ?></div>
                                    <a href="delivery-bill.php?order_id=<?= $d['id']; ?>"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-success rounded-pill px-3">
                                        <i class="bi bi-file-earmark-text"></i> Bill
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5 mx-3">
                    <img src="assets/img/empty-cart.svg" width="70" class="mb-3 opacity-50">
                    <p class="text-muted small">No delivery orders</p>
                    <a href="menu.php" class="btn btn-success rounded-pill px-4">Order Now</a>
                </div>
            <?php endif; ?>
        </section>

    </div>
</div>

<?php include 'include/footer.php'; ?>
<?php include 'include/js.php'; ?>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    :root {
        --primary: #4361ee;
        --success: #06d6a0;
        --danger: #ef476f;
        --warning: #ffd166;
    }

    .account-page {
        background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);
        /* min-height: 100vh; */
        font-family: 'Segoe UI', sans-serif;
        padding-bottom: 80px;
    }

    .card {
        border-radius: 1.2rem !important;
        transition: all 0.2s ease;
        background: #fff;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.1) !important;
    }

    .badge {
        font-size: 0.75rem;
        font-weight: 600;
    }

    .btn-sm {
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Responsive Grid */
    @media (min-width: 992px) {
        .booking-list, .delivery-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            padding: 0 1rem;
        }
        .booking-card, .delivery-card {
            max-width: 500px;
            margin: 0 auto;
        }
    }

    @media (min-width: 1200px) {
        .booking-list, .delivery-list {
            grid-template-columns: repeat(2, 1fr);
        }
        .booking-card, .delivery-card {
            margin: 0;
        }
    }
</style>

<?php
$bookingStmt->close();
$deliveryStmt->close();
$conn->close();
?>