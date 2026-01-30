<?php
/* ============================================================
   🍽️ Tasty Bite - Booking Submission Handler
   Author: Suraj Foujdar
   Description: Processes booking, sends WhatsApp + Email confirmation.
============================================================ */

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require 'config.php';

// ✅ Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/PHPMailer/PHPMailer.php';
require 'includes/PHPMailer/SMTP.php';
require 'includes/PHPMailer/Exception.php';

/* ============================================================
   ✅ UltraMsg WhatsApp API Configuration
============================================================ */
define('ULTRAMSG_INSTANCE_ID', 'instance148786');
define('ULTRAMSG_TOKEN', 'thgiaa26ngruenx9');

/* ============================================================
   ✅ Send WhatsApp Function
============================================================ */
function sendWhatsApp($number, $message) {
    $url = "https://api.ultramsg.com/" . ULTRAMSG_INSTANCE_ID . "/messages/chat";
    $data = [
        'token' => ULTRAMSG_TOKEN,
        'to'    => $number,
        'body'  => $message
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($data),
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

/* ============================================================
   ✅ Process Booking Request
============================================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 🔒 Ensure user is logged in
    if (empty($_SESSION['user_id'])) {
        echo "<script>alert('Please login first!'); window.location='login.php';</script>";
        exit;
    }

    $user_id    = $_SESSION['user_id'];
    $name       = trim($_POST['customer_name'] ?? '');
    $mobile     = trim($_POST['mobile'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $table      = intval($_POST['table_number'] ?? 0);
    $created_at = date("Y-m-d H:i:s");

    // 🧩 Input Validation
    if (!$name || !$mobile || !$email || !$table) {
        echo "<script>alert('❌ All fields are required.'); window.history.back();</script>";
        exit;
    }

    /* ---------------------------------------------------------
       🛒 Fetch Cart Items
    ---------------------------------------------------------- */
    $cart_sql = "
        SELECT p.id AS product_id, p.category_id, p.name, 
               p.price_half, p.price_full, c.quantity, c.plate_type
        FROM cart c
        JOIN tbl_product p ON c.product_id = p.id
        WHERE c.user_id = ?
    ";
    $stmt = $conn->prepare($cart_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_items = $stmt->get_result();

    if ($cart_items->num_rows === 0) {
        echo "<script>alert('Your cart is empty!'); window.location='cart.php';</script>";
        exit;
    }

    /* ---------------------------------------------------------
       🧾 Insert Booking Records
    ---------------------------------------------------------- */
    $token         = bin2hex(random_bytes(16));
    $status        = 'pending';
    $total_amount  = 0;

    $orderDetails  = "🍽️ *New Order Received*\n";
    $orderDetails .= "-----------------------------------\n";
    $orderDetails .= "👤 *Name:* $name\n📞 *Mobile:* $mobile\n📧 *Email:* $email\n🪑 *Table:* $table\n📅 *Date:* $created_at\n";
    $orderDetails .= "-----------------------------------\n";

    while ($item = $cart_items->fetch_assoc()) {
        $product_id  = $item['product_id'];
        $category_id = $item['category_id'];
        $product_name = $item['name'];
        $quantity    = (int)$item['quantity'];
        $size        = strtolower($item['plate_type'] ?? 'full');
        $price       = ($size === 'half') ? $item['price_half'] : $item['price_full'];
        $total_price = $price * $quantity;
        $total_amount += $total_price;

        // ✅ Insert each product in booking table
        $insert = $conn->prepare("
            INSERT INTO tbl_booking 
            (table_number, category_id, product_id, size, quantity, price, total_price, created_at, 
             is_confirmed, customer_name, mobile, email, status, confirm_token)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?, ?, ?, ?)
        ");
        $insert->bind_param(
            "iiisdddssssss",
            $table, $category_id, $product_id, $size, $quantity,
            $price, $total_price, $created_at,
            $name, $mobile, $email, $status, $token
        );
        $insert->execute();

        // 🧾 Add to order summary
        $orderDetails .= "🍲 *{$product_name}* ({$size}) × {$quantity} = ₹" . number_format($total_price, 2) . "\n";
    }

    // ✅ Add total
    $totalLine = "-----------------------------------\n";
    $totalLine .= "💰 *Grand Total:* ₹" . number_format($total_amount, 2) . "\n";

    // Messages
    $confirmLink = "https://tastybitefood.free.nf/confirm-order.php?token=$token";

    $customerMessage = $orderDetails . $totalLine;              // No link
    $adminMessage    = $orderDetails . $totalLine . "✅ Confirm Order:\n$confirmLink"; // With link

    /* ---------------------------------------------------------
       🧹 Clear Cart
    ---------------------------------------------------------- */
    $conn->query("DELETE FROM cart WHERE user_id = '$user_id'");

    /* ---------------------------------------------------------
       📱 Send WhatsApp Notifications
    ---------------------------------------------------------- */
    sendWhatsApp("91$mobile", $customerMessage); // Customer
    sendWhatsApp("+918764480642", $adminMessage); // Admin

    /* ---------------------------------------------------------
       📧 Send Email Confirmation (Customer only, no link)
    ---------------------------------------------------------- */
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'surajfoujdar45@gmail.com';
        $mail->Password   = 'muez dqjd pqcw vwle';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('surajfoujdar45@gmail.com', 'Tasty Bite Orders');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = 'Your Order Received - Tasty Bite';

        $mail->Body = "
            <h2>🍽️ Order Received</h2>
            <p>Hello <strong>$name</strong>,</p>
            <p>Your order details are below:</p>
            <pre style='font-size:16px;background:#f6f6f6;padding:10px;border-radius:8px;'>$customerMessage</pre>
            <p>Thank you for ordering with Tasty Bite!</p>
        ";

        $mail->send();
    } catch (Exception $e) {
        // Optionally log the error
    }

    echo "<script>
            alert('✅ Order placed successfully! Admin will confirm your order.');
            window.location='shop.php';
          </script>";
    exit;
}
?>
