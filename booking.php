<?php
session_start();
require_once 'config.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// Fetch logged-in user's details
$user_query = "SELECT name, email FROM users WHERE id = ? LIMIT 1";
$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    session_destroy();
    header("Location: login");
    exit;
}

$user_name = htmlspecialchars($user['name'] ?? '');
$user_email = htmlspecialchars($user['email'] ?? '');

// Fetch cart items with product details
$cart_query = "
    SELECT 
        c.id AS cart_id,
        p.id AS product_id,
        p.name,
        p.price_full,
        p.price_half,
        c.quantity,
        c.plate_type,
        p.image1,
        p.category_id
    FROM cart c
    JOIN tbl_product p ON c.product_id = p.id
    WHERE c.user_id = ?
    ORDER BY c.id ASC
";
$cart_stmt = $conn->prepare($cart_query);
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_items = $cart_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php'; ?>
    <title>Book Your Order - Food Delivery</title>
    <style>
        .booking-section { padding: 60px 0; background: #f8f9fa; }
        .form-box { 
            background: #fff; 
            border-radius: 12px; 
            padding: 35px; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.08); 
        }
        .cart-table img { 
            width: 60px; 
            height: 60px; 
            border-radius: 8px; 
            object-fit: cover; 
        }
        .cart-table th, .cart-table td { 
            padding: 12px; 
            text-align: center; 
            vertical-align: middle; 
        }
        .cart-table th { 
            background: #f2f2f2; 
            font-weight: 600; 
        }
        .btn-dark { 
            background: #c59d5f; 
            border: none; 
            padding: 12px 30px; 
            color: #fff; 
            font-weight: 600; 
            border-radius: 8px; 
            transition: 0.3s; 
        }
        .btn-dark:hover { 
            background: #a27d3b; 
        }
        .readonly-input {
            background-color: #f8f9fa !important;
            cursor: not-allowed;
            color: #555;
        }
        .form-control[readonly] {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<?php include 'include/topbar.php'; ?>
<?php include 'include/header.php'; ?>

<!-- Breadcrumb -->
<div class="breadcrumb-area bg-cover shadow dark text-center text-light" style="background-image:url(assets/img/shape/5.jpg);">
    <div class="container">
        <h1>Book Your Order</h1>
    </div>
</div>

<!-- Booking Section -->
<section class="booking-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-box">
                    <h4 class="mb-4 text-center text-dark">Complete Your Booking</h4>

                    <form action="submit_booking.php" method="POST" novalidate>
                        <!-- Customer Details -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <input type="text" name="customer_name" class="form-control" 
                                       placeholder="Your Name *" 
                                       value="<?= $user_name ?>" required>
                            </div>
                            <div class="col-md-6">
                                <input type="tel" name="mobile" class="form-control" 
                                       placeholder="Mobile Number *" 
                                       pattern="[0-9]{10}" 
                                       title="Enter 10-digit mobile number" 
                                       required>
                            </div>

                            <!-- Email - Readonly + Hidden -->
                            <div class="col-md-12">
                                <input type="email" class="form-control readonly-input" 
                                       value="<?= $user_email ?>" 
                                       readonly 
                                       title="Email is linked to your account">
                                <input type="hidden" name="email" value="<?= $user_email ?>">
                            </div>

                            <!-- Table Selection -->
                            <div class="col-md-12">
                                <select name="table_number" class="form-select" required>
                                    <option value="">Select Table</option>
                                    <?php for ($i = 1; $i <= 40; $i++): ?>
                                        <option value="<?= $i ?>">Table <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <h5 class="mb-3 text-dark">Your Order Summary</h5>
                        <div class="table-responsive">
                            <table class="cart-table table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Plate</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $grandTotal = 0;
                                    if ($cart_items->num_rows > 0):
                                        while ($item = $cart_items->fetch_assoc()):
                                            $plate = $item['plate_type'] ?? 'full';
                                            $price = ($plate === 'half') ? $item['price_half'] : $item['price_full'];
                                            $total = $price * $item['quantity'];
                                            $grandTotal += $total;
                                            $img = !empty($item['image1']) 
                                                ? 'admin/uploads/products/' . htmlspecialchars($item['image1']) 
                                                : 'assets/img/no-image.png';
                                    ?>
                                    <tr>
                                        <td><img src="<?= $img ?>" alt="<?= htmlspecialchars($item['name']) ?>"></td>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td><?= ucfirst($plate) ?> Plate</td>
                                        <td>₹<?= number_format($price, 2) ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>₹<?= number_format($total, 2) ?></td>
                                    </tr>

                                    <!-- Hidden Fields for Processing -->
                                    <input type="hidden" name="products[]" value="<?= $item['product_id'] ?>">
                                    <input type="hidden" name="categories[]" value="<?= $item['category_id'] ?>">
                                    <input type="hidden" name="sizes[]" value="<?= $plate ?>">
                                    <input type="hidden" name="quantities[]" value="<?= $item['quantity'] ?>">
                                    <input type="hidden" name="prices[]" value="<?= $price ?>">
                                    <?php 
                                        endwhile;
                                    ?>
                                    <tr>
                                        <th colspan="5" class="text-end">Grand Total</th>
                                        <th>₹<?= number_format($grandTotal, 2) ?></th>
                                    </tr>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            Your cart is empty. <a href="menu">Add items</a>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Submit Button -->
                        <?php if ($cart_items->num_rows > 0): ?>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn-dark px-5">
                                Confirm & Book Order
                            </button>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'include/footer.php'; ?>
<?php include 'include/js.php'; ?>

</body>
</html>