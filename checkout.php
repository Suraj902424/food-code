<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit;
}
$user_id = $_SESSION['user_id'];

// Fetch cart with plate_type
$stmt = $conn->prepare("
    SELECT c.id AS cart_id, p.id AS product_id, p.name, p.price_half, p.price_full, p.image1, 
           c.quantity, c.plate_type
    FROM cart c
    JOIN tbl_product p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cartResult = $stmt->get_result();
$cartItems = $cartResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout - Jaipur Only</title>
<?php include 'include/head.php'; ?>
<style>
    :root {
        --gold: #D4AF37;
        --dark: #1a1a1a;
        --light: #f8f9fa;
        --primary: #ff5722;
    }
    .checkout-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        margin: 50px auto;
        max-width: 1200px;
        padding: 0 15px;
    }
    .checkout-left, .checkout-right {
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .checkout-left { flex: 1.3; }
    .checkout-right { flex: 1; min-width: 350px; }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    .cart-item img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 12px;
        margin-right: 15px;
    }
    .item-info h5 { margin: 0 0 6px; font-weight: 600; }
    .plate-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 4px;
    }
    .half { background: #fff3cd; color: #856404; }
    .full { background: #d1ecf1; color: #0c5460; }

    .total-amount {
        text-align: right;
        font-size: 1.4rem;
        font-weight: 700;
        margin-top: 25px;
        color: var(--gold);
    }

    .form-group {
        margin-bottom: 18px;
    }
    label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        color: #333;
    }
    input, textarea, select {
        width: 100%;
        padding: 12px 14px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 15px;
        transition: 0.3s;
    }
    input:focus, textarea:focus, select:focus {
        border-color: var(--gold);
        outline: none;
        box-shadow: 0 0 0 3px rgba(212,175,55,0.15);
    }
    .pincode-suggest {
        font-size: 13px;
        color: #666;
        margin-top: 4px;
    }

    .btn-place-order {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, var(--gold), #b8942f);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 20px;
        transition: 0.3s;
    }
    .btn-place-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(212,175,55,0.3);
    }

    .jaipur-badge {
        background: #e3f2fd;
        color: #1976d2;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 15px;
    }

    @media (max-width: 900px) {
        .checkout-container { flex-direction: column; }
    }
</style>
</head>
<body>
<?php include 'include/preloader.php'; ?>
<?php include 'include/topbar.php'; ?>
<?php include 'include/header.php'; ?>

<div class="checkout-container">
    <!-- LEFT: Order Summary -->
    <div class="checkout-left">
        <h2 class="section-title">Order Summary</h2>
        <div class="jaipur-badge">Delivery in Jaipur Only</div>
        <?php if (!empty($cartItems)): ?>
            <?php $grandTotal = 0; ?>
            <?php foreach ($cartItems as $item):
                $plate = $item['plate_type'] ?? 'full';
                $price = ($plate === 'half') ? $item['price_half'] : $item['price_full'];
                $total = $price * $item['quantity'];
                $grandTotal += $total;
                $img = !empty($item['image1']) ? 'admin/uploads/products/'.$item['image1'] : 'assets/img/food/default.jpg';
            ?>
                <div class="cart-item">
                    <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="item-info">
                        <h5><?= htmlspecialchars($item['name']) ?></h5>
                        <span class="plate-badge <?= $plate === 'half' ? 'half' : 'full' ?>">
                            <?= $plate === 'half' ? 'Half Plate' : 'Full Plate' ?>
                        </span>
                        <p style="margin:6px 0;">₹<?= number_format($price,2) ?> × <?= $item['quantity'] ?></p>
                        <p style="font-weight:600;color:var(--gold);">Total: ₹<?= number_format($total,2) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="total-amount">Grand Total: ₹<?= number_format($grandTotal,2) ?></div>
        <?php else: ?>
            <p class="text-center text-muted">Your cart is empty!</p>
        <?php endif; ?>
    </div>

    <!-- RIGHT: Checkout Form -->
    <div class="checkout-right">
        <h2 class="section-title">Delivery Address (Jaipur)</h2>
        <form action="submit_checkout.php" method="post">
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="customer_name" required>
            </div>
            <div class="form-group">
                <label>Phone *</label>
                <input type="text" name="phone" pattern="[0-9]{10}" required placeholder="10-digit mobile">
            </div>
            <div class="form-group">
                <label>Flat / House No / Floor *</label>
                <input type="text" name="flat" required placeholder="e.g. A-12, Royal Apartment">
            </div>
            <div class="form-group">
                <label>Landmark (Optional)</label>
                <input type="text" name="landmark" placeholder="Near XYZ Mall">
            </div>
            <div class="form-group">
                <label>Area / Locality *</label>
                <select name="area" id="area" required onchange="updatePincode()">
                    <option value="">Select Area</option>
                    <option value="Malviya Nagar">Malviya Nagar (302017)</option>
                    <option value="C-Scheme">C-Scheme (302001)</option>
                    <option value="Vaishali Nagar">Vaishali Nagar (302021)</option>
                    <option value="Mansarovar">Mansarovar (302020)</option>
                    <option value="Jagatpura">Jagatpura (302017)</option>
                    <option value="Tonk Road">Tonk Road (302018)</option>
                    <option value="Raja Park">Raja Park (302004)</option>
                    <option value="Adarsh Nagar">Adarsh Nagar (302004)</option>
                </select>
                <div class="pincode-suggest" id="pincode-suggest"></div>
            </div>
            <input type="hidden" name="pincode" id="pincode" required>
            <input type="hidden" name="city" value="Jaipur">
            <input type="hidden" name="state" value="Rajasthan">

            <div class="form-group">
                <label>Payment Method *</label>
                <select name="payment" required>
                    <option value="COD">Cash on Delivery</option>
                    <option value="Online">Online Payment</option>
                </select>
            </div>

            <button type="submit" class="btn-place-order">
                Place Order & Send WhatsApp
            </button>
        </form>
    </div>
</div>

<script>
function updatePincode() {
    const area = document.getElementById('area').value;
    const pinMap = {
        'Malviya Nagar': '302017',
        'C-Scheme': '302001',
        'Vaishali Nagar': '302021',
        'Mansarovar': '302020',
        'Jagatpura': '302017',
        'Tonk Road': '302018',
        'Raja Park': '302004',
        'Adarsh Nagar': '302004'
    };
    const pin = pinMap[area] || '';
    document.getElementById('pincode').value = pin;
    document.getElementById('pincode-suggest').innerText = pin ? `Pincode: ${pin}` : '';
}
</script>

<?php include 'include/footer.php'; ?>
<?php include 'include/js.php'; ?>
</body>
</html>