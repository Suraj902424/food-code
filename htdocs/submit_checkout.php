<?php
/* ============================================================
   Tasty Bite - Jaipur Home Delivery Checkout (Final Version)
   Author: Suraj Foujdar
   Features: Jaipur Only, WhatsApp + Email, Half/Full Plate
============================================================ */
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'config.php';

// Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'includes/PHPMailer/PHPMailer.php';
require 'includes/PHPMailer/SMTP.php';
require 'includes/PHPMailer/Exception.php';

/* ============================================================
   UltraMsg WhatsApp API
============================================================ */
define('ULTRAMSG_INSTANCE_ID', 'instance148786');
define('ULTRAMSG_TOKEN', 'thgiaa26ngruenx9');

function sendWhatsApp($to, $message) {
    $url = "https://api.ultramsg.com/" . ULTRAMSG_INSTANCE_ID . "/messages/chat";
    $data = [
        'token' => ULTRAMSG_TOKEN,
        'to' => $to,
        'body' => $message
    ];
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
    ]);
    curl_exec($ch);
    curl_close($ch);
}

/* ============================================================
   POST Check & Login
============================================================ */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: checkout.php");
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location='login';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

/* ============================================================
   Collect & Validate Form Data
============================================================ */
$customer_name = trim($_POST['customer_name'] ?? '');
$phone         = trim($_POST['phone'] ?? '');
$flat          = trim($_POST['flat'] ?? '');
$landmark      = trim($_POST['landmark'] ?? '');
$area          = trim($_POST['area'] ?? '');
$pincode       = trim($_POST['pincode'] ?? '');
$payment       = in_array($_POST['payment'] ?? '', ['COD', 'Online']) ? $_POST['payment'] : 'COD';

// Validation
if (!$customer_name || !$phone || !$flat || !$area || !$pincode) {
    echo "<script>alert('All fields are required!'); window.history.back();</script>";
    exit;
}
if (!preg_match('/^\d{10}$/', $phone)) {
    echo "<script>alert('Invalid phone number!'); window.history.back();</script>";
    exit;
}

// Build Full Address
$address = "$flat, $area";
if ($landmark) $address .= ", $landmark";
$address .= ", Jaipur, Rajasthan - $pincode";

/* ============================================================
   Fetch Cart Items with Half/Full Price
============================================================ */
$stmt = $conn->prepare("
    SELECT p.id AS product_id, p.name, c.plate_type, c.quantity,
           IF(c.plate_type='half', p.price_half, p.price_full) AS price
    FROM cart c
    JOIN tbl_product p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Your cart is empty!'); window.location='cart.php';</script>";
    exit;
}

/* ============================================================
   Calculate Total & Build WhatsApp Message
============================================================ */
$total_amount = 0;
$whatsapp_msg = "*New Order - Jaipur Delivery*\n\n";
$whatsapp_msg .= "Name: $customer_name\n";
$whatsapp_msg .= "Phone: $phone\n";
$whatsapp_msg .= "Address: $address\n";
$whatsapp_msg .= "Payment: $payment\n\n";
$whatsapp_msg .= "*Order Items:*\n";

$order_items = [];
while ($row = $result->fetch_assoc()) {
    $plate = $row['plate_type'] === 'half' ? 'Half Plate' : 'Full Plate';
    $subtotal = $row['price'] * $row['quantity'];
    $total_amount += $subtotal;

    $whatsapp_msg .= "• {$row['name']} ($plate) × {$row['quantity']} = ₹" . number_format($subtotal, 2) . "\n";

    $order_items[] = [
        'product_id' => $row['product_id'],
        'plate_type' => $row['plate_type'],
        'quantity'   => $row['quantity'],
        'price'      => $row['price'],
        'total'      => $subtotal
    ];
}

$whatsapp_msg .= "\n*Grand Total: ₹" . number_format($total_amount, 2) . "*\n";
$whatsapp_msg .= "Thank you for ordering with Tasty Bite!\n";
$whatsapp_msg .= "We'll deliver hot & fresh!";

/* ============================================================
   Insert into `orders` Table (With customer_name & total_amount)
============================================================ */
$insert_order = $conn->prepare("
    INSERT INTO orders 
    (user_id, customer_name, address, phone, payment_method, 
     state, city, pincode, total_amount, status, created_at)
    VALUES (?, ?, ?, ?, ?, 'Rajasthan', 'Jaipur', ?, ?, 'Pending', NOW())
");
$insert_order->bind_param(
    "isssssd",
    $user_id, $customer_name, $address, $phone, $payment, $pincode, $total_amount
);

if (!$insert_order->execute()) {
    echo "<script>alert('Order failed! Try again.'); window.history.back();</script>";
    exit;
}

$order_id = $conn->insert_id;

/* ============================================================
   Insert into `order_items` Table (With plate_type)
============================================================ */
$insert_item = $conn->prepare("
    INSERT INTO order_items 
    (order_id, product_id, plate_type, quantity, price, total)
    VALUES (?, ?, ?, ?, ?, ?)
");

foreach ($order_items as $item) {
    $insert_item->bind_param(
        "iisidd",
        $order_id,
        $item['product_id'],
        $item['plate_type'],
        $item['quantity'],
        $item['price'],
        $item['total']
    );
    $insert_item->execute();
}

/* ============================================================
   Clear Cart
============================================================ */
$conn->query("DELETE FROM cart WHERE user_id = $user_id");

/* ============================================================
   Send WhatsApp (Customer + Admin)
============================================================ */
sendWhatsApp("91$phone", $whatsapp_msg);                    // Customer
sendWhatsApp("+918764480642", "New Jaipur Order!\n\n" . $whatsapp_msg); // Admin

/* ============================================================
   Send Email Confirmation
============================================================ */
try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'surajfoujdar45@gmail.com';
    $mail->Password   = 'muez dqjd pqcw vwle';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('surajfoujdar45@gmail.com', 'Tasty Bite Jaipur');
    $mail->addAddress("$customer_name <$phone@nomail.com>");

    $mail->isHTML(true);
    $mail->Subject = "Order #$order_id Confirmed - Jaipur Delivery";

    $items_html = "";
    foreach ($order_items as $item) {
        $plate = $item['plate_type'] === 'half' ? 'Half Plate' : 'Full Plate';
        $items_html .= "
            <tr>
                <td style='padding:8px;border-bottom:1px solid #eee;'>{$item['name']}</td>
                <td style='padding:8px;border-bottom:1px solid #eee;'>$plate</td>
                <td style='padding:8px;border-bottom:1px solid #eee;'>{$item['quantity']}</td>
                <td style='padding:8px;border-bottom:1px solid #eee;'>₹" . number_format($item['price'], 2) . "</td>
                <td style='padding:8px;border-bottom:1px solid #eee;'>₹" . number_format($item['total'], 2) . "</td>
            </tr>
        ";
    }

    $mail->Body = "
        <div style='font-family:Arial,sans-serif;max-width:600px;margin:auto;'>
            <h2 style='color:#4CAF50;'>Order Confirmed!</h2>
            <p>Hi <strong>$customer_name</strong>,</p>
            <p>Your order has been placed successfully!</p>
            <p><strong>Order ID:</strong> #$order_id</p>
            <p><strong>Delivery Address:</strong><br>$address</p>
            <h3>Order Summary</h3>
            <table style='width:100%;border-collapse:collapse;'>
                <tr style='background:#f0f8ff;'><th style='padding:10px;text-align:left;'>Item</th>
                    <th style='padding:10px;text-align:left;'>Plate</th>
                    <th style='padding:10px;text-align:left;'>Qty</th>
                    <th style='padding:10px;text-align:left;'>Price</th>
                    <th style='padding:10px;text-align:left;'>Total</th>
                </tr>
                $items_html
                <tr>
                    <td colspan='4' style='text-align:right;font-weight:bold;padding:10px;'>Grand Total</td>
                    <td style='font-weight:bold;color:#D4AF37;padding:10px;'>₹" . number_format($total_amount, 2) . "</td>
                </tr>
            </table>
            <p style='margin-top:20px;'><em>We'll deliver hot & fresh within 45 mins!</em></p>
            <hr>
            <small>Tasty Bite Jaipur | Call: +91 87644 80642</small>
        </div>
    ";

    $mail->send();
} catch (Exception $e) {
    // Optional: log error
}

/* ============================================================
   Success Redirect
============================================================ */
$_SESSION['order_success'] = "Order #$order_id placed! Check WhatsApp & Email.";
header("Location: order_success.php");
exit;
?>