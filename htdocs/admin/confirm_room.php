<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
include 'dbc.php';

// Replace with your WhatsApp API details
define('WHATSAPP_INSTANCE_ID', 'instance148786');
define('WHATSAPP_TOKEN', 'thgiaa26ngruenx9');
define('ADMIN_PHONE', '+918764480642');

function sendWhatsApp($to, $message) {
    $url = "https://api.ultramsg.com/".WHATSAPP_INSTANCE_ID."/messages/chat";
    $data = [
        'token' => WHATSAPP_TOKEN,
        'to'    => $to,
        'body'  => $message
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['booking_id']) && !empty($_POST['room_no'])) {

    $booking_id    = intval($_POST['booking_id']);
    $selected_room = intval($_POST['room_no']);

    // 1️⃣ Fetch booking details
    $stmt = $conn->prepare("SELECT * FROM tbl_room_booking WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $booking = $stmt->get_result()->fetch_assoc();

    if (!$booking) {
        echo "<script>alert('❌ Booking not found!'); window.history.back();</script>";
        exit;
    }

    // 2️⃣ Check if room is already booked
    $stmt_check = $conn->prepare("SELECT id FROM tbl_room_booking WHERE rooms = ? AND status = 'confirmed'");
    $stmt_check->bind_param("i", $selected_room);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<script>alert('❌ This room is already booked!'); window.history.back();</script>";
        exit;
    }

    // 3️⃣ Update booking status & assign room
    $stmt_update = $conn->prepare("UPDATE tbl_room_booking SET status='confirmed', rooms=? WHERE id=?");
    $stmt_update->bind_param("ii", $selected_room, $booking_id);

    if ($stmt_update->execute()) {
        // 4️⃣ Mark room as booked in rooms table
        $stmt_room = $conn->prepare("UPDATE rooms SET status='booked' WHERE room_number=?");
        $stmt_room->bind_param("i", $selected_room);
        $stmt_room->execute();
        $stmt_room->close();

        // 5️⃣ Send WhatsApp to customer and admin
        $whatsapp_msg = "✅ Hello {$booking['name']}, your booking is confirmed!\nRoom No: $selected_room\nCheck-in: {$booking['checkin']}\nCheck-out: {$booking['checkout']}";
        sendWhatsApp($booking['phone'], $whatsapp_msg); // Customer
        sendWhatsApp(ADMIN_PHONE, "New booking: {$booking['name']} - Room $selected_room"); // Admin

        // 6️⃣ Send stylish confirmation email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'surajfoujdar45@gmail.com';
            $mail->Password   = 'muez dqjd pqcw vwle'; // Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('surajfoujdar45@gmail.com', 'Hotel Booking');
            $mail->addAddress($booking['email'], $booking['name']);

            $mail->isHTML(true);
            $mail->Subject = '✅ Your Booking is Confirmed!';
            $mail->Body = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
                    .container { max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; }
                    .header { text-align: center; padding-bottom: 20px; }
                    .header img { width: 100px; }
                    .header h2 { margin: 10px 0 0; color: #333; }
                    .content { line-height: 1.6; color: #555; }
                    .booking-details { background: #f0f0f0; padding: 15px; border-radius: 5px; margin: 20px 0; }
                    .footer { text-align: center; font-size: 12px; color: #999; margin-top: 20px; }
                    .btn { display: inline-block; padding: 10px 20px; background: #007BFF; color: #fff; text-decoration: none; border-radius: 5px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <img src='https://i.ibb.co/2sWJH6L/logo.png' alt='Hotel Logo'>
                        <h2>Welcome to Our Hotel!</h2>
                    </div>
                    <div class='content'>
                        <p>Dear <strong>{$booking['name']}</strong>,</p>
                        <p>Thank you for booking with us. Your room has been successfully confirmed.</p>
                        <div class='booking-details'>
                            <p><strong>Room Number:</strong> {$selected_room}</p>
                            <p><strong>Check-in:</strong> {$booking['checkin']}</p>
                            <p><strong>Check-out:</strong> {$booking['checkout']}</p>
                        </div>
                        <p>We look forward to welcoming you! 😊</p>
                        <p><a href='#' class='btn'>View Booking</a></p>
                    </div>
                    <div class='footer'>
                        &copy; ".date('Y')." Our Hotel. All rights reserved.
                    </div>
                </div>
            </body>
            </html>
            ";
            $mail->send();

            echo "<script>alert('✅ Booking confirmed, WhatsApp sent, and stylish email delivered!'); window.location.href='room_booking-list.php';</script>";

        } catch (Exception $e) {
            echo "<script>alert('✅ Booking confirmed and WhatsApp sent, but email could not be sent.'); window.location.href='room_booking-list.php';</script>";
        }

    } else {
        echo "<script>alert('❌ Error updating booking.'); window.history.back();</script>";
    }

    // Close statements
    $stmt->close();
    $stmt_check->close();
    $stmt_update->close();

} else {
    echo "<script>alert('❌ Please select a room before confirming.'); window.history.back();</script>";
}
?>
