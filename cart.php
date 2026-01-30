<?php
session_start();
require_once 'config.php';

// Login Check
session_start();
if (empty($_SESSION['user_id'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// Handle POST Actions
if ($_POST) {
    $cart_id = (int)($_POST['cart_id'] ?? 0);

    // Update Plate Type
    if (isset($_POST['plate_type'])) {
        $plate = in_array($_POST['plate_type'], ['half', 'full']) ? $_POST['plate_type'] : 'full';
        $stmt = $conn->prepare("UPDATE cart SET plate_type = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $plate, $cart_id, $user_id);
        $stmt->execute();
    }

    // Quantity & Remove
    if (isset($_POST['action']) && in_array($_POST['action'], ['inc', 'dec', 'remove'])) {
        $action = $_POST['action'];
        if ($action === 'inc') {
            $sql = "UPDATE cart SET quantity = quantity + 1 WHERE id = ? AND user_id = ?";
        } elseif ($action === 'dec') {
            $sql = "UPDATE cart SET quantity = GREATEST(quantity - 1, 1) WHERE id = ? AND user_id = ?";
        } elseif ($action === 'remove') {
            $sql = "DELETE FROM cart WHERE id = ? AND user_id = ?";
        }
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $cart_id, $user_id);
        $stmt->execute();
    }

    header("Location: cart.php");
    exit;
}

// Fetch Cart Items
$stmt = $conn->prepare("
    SELECT 
        c.id AS cart_id,
        p.name,
        p.price_half,
        p.price_full,
        p.image1,
        c.quantity,
        c.plate_type
    FROM cart c
    JOIN tbl_product p ON c.product_id = p.id
    WHERE c.user_id = ?
    ORDER BY c.id DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Your Cart - Food Order</title> -->
    <?php include 'include/head.php'; ?>
    <style>
        :root {
            --primary: #e74c3c;
            --success: #27ae60;
            --info: #3498db;
            --gold: #f39c12;
            --light: #f8f9fa;
            --dark: #2c3e50;
            --gray: #95a5a6;
            --border: #dfe6e9;
        }

        body { font-family: 'Poppins', sans-serif; background: #f1f3f6; color: #333; }

        .container {
            /* max-width: 1000px; */
            margin: 20px auto;
            padding: 0 15px;
        }

        .page-title {
            text-align: center;
            margin: 0 0 30px;
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            position: relative;
        }
        .page-title::after {
            content: '';
            width: 80px;
            height: 4px;
            background: var(--primary);
            display: block;
            margin: 12px auto 0;
            border-radius: 2px;
        }

        /* Booking Options */
        .booking-options {
            display: flex;
            gap: 16px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .booking-btn {
            flex: 1;
            min-width: 180px;
            padding: 18px 20px;
            text-align: center;
            background: #fff;
            border: 2px solid var(--border);
            border-radius: 16px;
            font-weight: 600;
            font-size: 16px;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .booking-btn i { font-size: 22px; }
        .booking-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.12);
        }
        .home-btn { border-color: var(--success); }
        .home-btn:hover { background: #d5f5e0; border-color: #27ae60; color: #27ae60; }
        .hotel-btn { border-color: var(--info); }
        .hotel-btn:hover { background: #dbeeff; border-color: #3498db; color: #3498db; }

        /* Cart Item */
        .cart-item {
            background: #fff;
            border-radius: 18px;
            padding: 22px;
            margin-bottom: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .cart-item:hover {
            box-shadow: 0 12px 30px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .item-details {
            display: flex;
            gap: 20px;
            flex: 1;
        }
        .cart-item img {
            width: 110px;
            height: 90px;
            object-fit: cover;
            border-radius: 14px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .item-info h5 {
            margin: 0 0 10px;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
        }

        .plate-badge {
            display: inline-block;
            padding: 7px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .half-plate { background: #fff3cd; color: #d39e00; }
        .full-plate { background: #d1ecf1; color: #0c5460; }

        .price-info p {
            margin: 6px 0;
            font-size: 14.5px;
            color: #555;
        }
        .price-info strong { color: var(--gold); font-weight: 600; }

        .plate-select {
            margin-top: 12px;
        }
        .plate-select select {
            padding: 10px 16px;
            border: 1.8px solid var(--border);
            border-radius: 12px;
            background: #fff;
            font-size: 14px;
            min-width: 160px;
            transition: 0.3s;
        }
        .plate-select select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.15);
        }

        /* Actions */
        .actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }
        .qty-btn {
            background: var(--primary);
            color: #fff;
            border: none;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 3px 8px rgba(231, 76, 60, 0.3);
        }
        .qty-btn:hover {
            background: #c0392b;
            transform: scale(1.12);
            box-shadow: 0 5px 12px rgba(231, 76, 60, 0.4);
        }

        .quantity-display {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark);
            min-width: 40px;
            text-align: center;
        }

        .remove-btn {
            background: #e74c3c;
            color: #fff;
            border: none;
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 3px 8px rgba(231, 76, 60, 0.25);
        }
        .remove-btn:hover {
            background: #c0392b;
            transform: translateY(-1px);
        }

        /* Total Box */
        .total-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 25px;
            border-radius: 18px;
            text-align: center;
            font-size: 1.4rem;
            font-weight: 700;
            margin: 30px 0;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.25);
        }
        .total-box strong {
            font-size: 1.8rem;
            color: #ffd700;
        }

        /* Checkout Buttons */
        .checkout-buttons {
            display: flex;
            gap: 18px;
            margin-top: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .checkout-btn {
            flex: 1;
            min-width: 200px;
            padding: 18px 24px;
            text-align: center;
            border-radius: 16px;
            font-weight: 700;
            font-size: 17px;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }
        .checkout-btn i { font-size: 22px; }
        .home-checkout { background: var(--success); }
        .hotel-checkout { background: var(--info); }
        .checkout-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.22);
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 80px 20px;
            color: var(--gray);
        }
        .empty-cart i {
            font-size: 5rem;
            color: #ddd;
            margin-bottom: 20px;
            display: block;
        }
        .empty-cart h4 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--dark);
        }
        .empty-cart a {
            display: inline-block;
            margin-top: 20px;
            padding: 14px 32px;
            background: var(--primary);
            color: #fff;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: 0.3s;
        }
        .empty-cart a:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .item-details { flex-direction: column; }
            .actions { justify-content: center; margin-top: 15px; }
            .checkout-btn { min-width: 100%; }
        }
    </style>
</head>
<body>

<?php include 'include/preloader.php'; ?>
<?php include 'include/topbar.php'; ?>
<?php include 'include/header.php'; ?>

<div class="container">
    <h2 class="page-title">Your Cart</h2>

    <!-- Booking Options -->
    <div class="booking-options">
        <a href="checkout.php" class="booking-btn home-btn">
            <i class="fas fa-home"></i> Home Delivery
        </a>
        <a href="booking.php" class="booking-btn hotel-btn">
            <i class="fas fa-utensils"></i> Hotel Booking
        </a>
    </div>

    <?php if ($cart_items->num_rows === 0): ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h4>Your cart is empty</h4>
            <p>Add delicious items to get started!</p>
            <a href="shoping">Continue Shopping</a>
        </div>
    <?php else: ?>
        <?php 
        $grandTotal = 0;
        while ($item = $cart_items->fetch_assoc()):
            $img = !empty($item['image1']) 
                ? 'admin/uploads/products/' . htmlspecialchars($item['image1']) 
                : 'assets/img/food/default.jpg';
            $plate = $item['plate_type'] ?? 'full';
            $price = ($plate === 'half') ? $item['price_half'] : $item['price_full'];
            $total = $price * $item['quantity'];
            $grandTotal += $total;
        ?>
            <div class="cart-item">
                <div class="item-details">
                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="item-info">
                        <h5><?= htmlspecialchars($item['name']) ?></h5>
                        <span class="plate-badge <?= $plate === 'half' ? 'half-plate' : 'full-plate' ?>">
                            <?= ucfirst($plate) ?> Plate
                        </span>
                        <div class="price-info">
                            <p>Price: <strong>₹<?= number_format($price, 2) ?></strong> × <?= $item['quantity'] ?></p>
                            <p>Item Total: <strong>₹<?= number_format($total, 2) ?></strong></p>
                        </div>
                        <div class="plate-select">
                            <form method="post">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                <select name="plate_type" onchange="this.form.submit()">
                                    <option value="half" <?= $plate === 'half' ? 'selected' : '' ?>>
                                        Half (₹<?= number_format($item['price_half'], 2) ?>)
                                    </option>
                                    <option value="full" <?= $plate === 'full' ? 'selected' : '' ?>>
                                        Full (₹<?= number_format($item['price_full'], 2) ?>)
                                    </option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="actions">
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                        <button type="submit" name="action" value="dec" class="qty-btn">-</button>
                    </form>
                    <span class="quantity-display"><?= $item['quantity'] ?></span>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                        <button type="submit" name="action" value="inc" class="qty-btn">+</button>
                    </form>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                        <button type="submit" name="action" value="remove" class="remove-btn">
                            Remove
                        </button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>

        <!-- Grand Total -->
        <div class="total-box">
            Grand Total: <strong>₹<?= number_format($grandTotal, 2) ?></strong>
        </div>

        <!-- Checkout Buttons -->
        <div class="checkout-buttons">
            <a href="checkout" class="checkout-btn home-checkout">
                <i class="fas fa-truck"></i> Book Home Delivery
            </a>
            <a href="booking" class="checkout-btn hotel-checkout">
                <i class="fas fa-calendar-check"></i> Book Table Now
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include 'include/footer.php'; ?>
<?php include 'include/js.php'; ?>

</body>
</html>