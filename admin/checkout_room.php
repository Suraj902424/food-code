<?php
include 'dbc.php';
include 'loginQuery/session_start.php';

// ✅ UltraMsg API Configuration
define('ULTRAMSG_INSTANCE_ID', 'instance148786');
define('ULTRAMSG_TOKEN', 'thgiaa26ngruenx9');

// ✅ Run only when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $booking_id = intval($_POST['booking_id'] ?? 0);
    $room_no    = trim($_POST['room_no'] ?? '');

    if ($booking_id > 0 && !empty($room_no)) {

        // ✅ Get Booking Details
        $bookingQuery = mysqli_query($conn, "SELECT * FROM tbl_room_booking WHERE id='$booking_id'");
        $booking = mysqli_fetch_assoc($bookingQuery);

        if (!$booking) {
            $_SESSION['error_msg'] = "Booking not found!";
            header("Location: booking-list.php");
            exit;
        }

        $name     = $booking['name'];
        $phone    = preg_replace('/\D/', '', $booking['phone']);
        $checkin  = $booking['checkin'];
        $checkout = $booking['checkout'];

        // ✅ Step 1: Mark booking as checked out
        $updateBooking = mysqli_query($conn, "UPDATE tbl_room_booking SET status='checkedout' WHERE id='$booking_id'");

        // ✅ Step 2: Mark the room as available again
        $updateRoom = mysqli_query($conn, "UPDATE rooms SET status='available' WHERE room_number='$room_no'");

        if ($updateBooking && $updateRoom) {

            // ✅ Step 3: Send WhatsApp message
            $message = "Hello $name 👋,\n\nWe hope you had a great stay!\n"
                     . "🏨 Room No: $room_no\n"
                     . "📅 Check-in: $checkin\n"
                     . "📅 Checkout: $checkout\n\n"
                     . "Your checkout has been completed successfully.\n"
                     . "Thank you for visiting! 😊";

            $apiUrl = "https://api.ultramsg.com/" . ULTRAMSG_INSTANCE_ID . "/messages/chat?token=" . ULTRAMSG_TOKEN;
            $payload = [
                "to"   => "91" . $phone,
                "body" => $message
            ];

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($payload),
            ]);
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                $_SESSION['success_msg'] = "Checkout done ✅ (WhatsApp failed to send)";
            } else {
                $_SESSION['success_msg'] = "Checkout done ✅ WhatsApp sent to $name.";
            }

        } else {
            $_SESSION['error_msg'] = "Error updating checkout or freeing room!";
        }

    } else {
        $_SESSION['error_msg'] = "Invalid booking or room number!";
    }

} else {
    $_SESSION['error_msg'] = "Invalid request!";
}

// ✅ Redirect back to correct page
header("Location: room_booking-list.php");
exit;
?>
