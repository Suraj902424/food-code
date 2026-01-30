<?php
include 'dbc.php';
include 'loginQuery/session_start.php';

// 🔹 UltraMsg WhatsApp API Configuration
define('ULTRAMSG_INSTANCE_ID', 'instance148786');
define('ULTRAMSG_TOKEN', 'thgiaa26ngruenx9');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $booking_id = intval($_POST['booking_id'] ?? 0);
    $room_no    = trim($_POST['room_no'] ?? '');

    // ✅ Validate input
    if ($booking_id <= 0 || empty($room_no)) {
        $_SESSION['error_msg'] = "Invalid booking or room number!";
        header("Location: booking-list.php");
        exit;
    }

    // ✅ Fetch booking details
    $stmt = mysqli_prepare($conn, "SELECT * FROM tbl_room_booking WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $booking_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $booking = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$booking) {
        $_SESSION['error_msg'] = "Booking not found!";
        header("Location: booking-list.php");
        exit;
    }

    $name     = $booking['name'];
    $email    = $booking['email'];
    $phone    = preg_replace('/\D/', '', $booking['phone']); // keep digits only
    $checkin  = $booking['checkin'];
    $checkout = $booking['checkout'];

    // ✅ Check if selected room is available or vacated
    $roomCheck = mysqli_prepare($conn, "SELECT * FROM rooms WHERE room_number = ? AND (status = 'available' OR status = 'vacated')");
    mysqli_stmt_bind_param($roomCheck, "s", $room_no);
    mysqli_stmt_execute($roomCheck);
    $roomResult = mysqli_stmt_get_result($roomCheck);
    $room = mysqli_fetch_assoc($roomResult);
    mysqli_stmt_close($roomCheck);

    if (!$room) {
        $_SESSION['error_msg'] = "Room #$room_no is not available for confirmation!";
        header("Location: booking-list.php");
        exit;
    }

    mysqli_begin_transaction($conn);
    try {
        // ✅ Step 1: Update booking details
        $updateBooking = mysqli_prepare($conn, "UPDATE tbl_room_booking SET status = 'confirmed', room_number = ? WHERE id = ?");
        mysqli_stmt_bind_param($updateBooking, "si", $room_no, $booking_id);
        mysqli_stmt_execute($updateBooking);
        mysqli_stmt_close($updateBooking);

        // ✅ Step 2: Mark the room as occupied
        $updateRoom = mysqli_prepare($conn, "UPDATE rooms SET status = 'occupied' WHERE room_number = ?");
        mysqli_stmt_bind_param($updateRoom, "s", $room_no);
        mysqli_stmt_execute($updateRoom);
        mysqli_stmt_close($updateRoom);

        mysqli_commit($conn);

        // ✅ Step 3: Send WhatsApp confirmation message
        $message = "Hello $name 👋,\n\nYour room booking has been *confirmed* successfully!\n"
                 . "🏨 Room No: $room_no\n"
                 . "📅 Check-in: $checkin\n"
                 . "📅 Check-out: $checkout\n\n"
                 . "Thank you for booking with us! 😊";

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
            $_SESSION['success_msg'] = "Room #$room_no confirmed ✅ (WhatsApp message failed to send)";
        } else {
            $_SESSION['success_msg'] = "Room #$room_no confirmed ✅ WhatsApp message sent to $name ($phone)";
        }

    } catch (Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['error_msg'] = "Error confirming booking: " . $e->getMessage();
    }

} else {
    $_SESSION['error_msg'] = "Invalid request method!";
}

// ✅ Redirect back to booking list
header("Location: room_booking-list.php");
exit;
?>
