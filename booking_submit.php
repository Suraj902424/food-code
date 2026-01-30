<?php
session_start();
require_once 'config.php';

/* ============================================================
   ✅ WhatsApp API Configuration (UltraMsg)
   Replace with your actual instance ID and token
============================================================ */
define('ULTRAMSG_INSTANCE_ID', 'instance148786'); // 🔁 your instance ID
define('ULTRAMSG_TOKEN', 'thgiaa26ngruenx9');    // 🔁 your API token

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
   ✅ Booking Logic
============================================================ */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Collect form data
$name     = trim($_POST['fullName'] ?? '');
$email    = trim($_POST['email'] ?? '');
$checkin  = trim($_POST['checkinDate'] ?? '');
$checkout = trim($_POST['checkoutDate'] ?? '');
$rooms    = $_POST['rooms'] ?? [];
$guests   = (int)($_POST['guests'] ?? 0);
$phone    = trim($_POST['phone'] ?? '');
$user_id  = $_SESSION['user_id'];

// Basic validation
if (empty($name) || empty($email) || empty($checkin) || empty($checkout) || empty($rooms) || empty($phone) || $guests < 1) {
    $_SESSION['error'] = "Please fill all fields.";
    header("Location: room.php");
    exit;
}

$rooms_str = implode(',', $rooms);

// Insert into database
$stmt = $conn->prepare("
    INSERT INTO tbl_room_booking 
    (name, email, checkin, checkout, rooms, guests, phone, user_id, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
");
$stmt->bind_param("sssssisi", $name, $email, $checkin, $checkout, $rooms_str, $guests, $phone, $user_id);

if ($stmt->execute()) {
    /* ============================================================
       ✅ Send WhatsApp Message (Customer + Admin)
    ============================================================= */

    // Customer message
    $msgCustomer = "
🏨 *Room Booking Request Received!*

Hello *$name*, 👋
Your room booking request has been submitted successfully.

📅 Check-in: $checkin
📆 Check-out: $checkout
🧍 Guests: $guests
🏠 Rooms: $rooms_str
📞 Contact: $phone

Our admin will confirm your room soon.
Thank you for choosing *Tasty Stay!* 🌟
";

    // Admin message
    $msgAdmin = "
📢 *New Room Booking Request!*

👤 Name: $name
📧 Email: $email
📞 Phone: $phone
🧍 Guests: $guests
🏠 Rooms Requested: $rooms_str
📅 Check-in: $checkin
📆 Check-out: $checkout

Login to admin panel to confirm room.
";

    // Send WhatsApp to user and admin
    sendWhatsApp("91$phone", $msgCustomer);
    sendWhatsApp("+918764480642", $msgAdmin); // 🔁 your admin number here

    $_SESSION['success'] = "Booking request sent! Admin will assign room soon. ✅";
} else {
    $_SESSION['error'] = "Booking failed. Please try again later.";
}

// Redirect
header("Location: room.php");
exit;
?>
