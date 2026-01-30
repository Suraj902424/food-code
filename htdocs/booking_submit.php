<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and trim input
    $name     = trim($_POST['fullName'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $checkin  = $_POST['checkinDate'] ?? '';
    $checkout = $_POST['checkoutDate'] ?? '';
    $rooms    = isset($_POST['rooms']) ? implode(', ', $_POST['rooms']) : '';
    $guests   = isset($_POST['guests']) ? (int)$_POST['guests'] : 0;
    $phone    = trim($_POST['phone'] ?? '');

    // Basic validation
    if (empty($name) || empty($email) || empty($checkin) || empty($checkout) || empty($rooms) || $guests < 1 || empty($phone)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: rooms.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: rooms.php");
        exit;
    }

    if (strtotime($checkout) <= strtotime($checkin)) {
        $_SESSION['error'] = "Checkout date must be after check-in date.";
        header("Location: rooms.php");
        exit;
    }

    // Assign a room number (placeholder logic)
    $room_number = rand(101, 350);

    // Prepare and execute database insertion
    $stmt = $conn->prepare(
        "INSERT INTO tbl_room_booking 
        (name, email, checkin, checkout, rooms, guests, phone, room_number, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Confirmed')"
    );

    $stmt->bind_param("sssssiss", $name, $email, $checkin, $checkout, $rooms, $guests, $phone, $room_number);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Booking confirmed! Room No: $room_number";
    } else {
        $_SESSION['error'] = "Booking failed. Please try again.";
    }

    $stmt->close();
    header("Location: room.php");
    exit;
}
?>
