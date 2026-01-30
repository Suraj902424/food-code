<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name         = mysqli_real_escape_string($conn, trim($_POST['name'] ?? ''));
    $email        = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $phone        = mysqli_real_escape_string($conn, trim($_POST['phone'] ?? ''));
    $date         = mysqli_real_escape_string($conn, trim($_POST['date'] ?? ''));
    $table_number = mysqli_real_escape_string($conn, trim($_POST['table_number'] ?? ''));
    $message      = mysqli_real_escape_string($conn, trim($_POST['message'] ?? ''));

    if (!$name || !$email || !$phone || !$table_number || !$message) {
        echo "<script>alert('Please fill all required fields.'); window.history.back();</script>";
        exit;
    }

    $sql = "INSERT INTO tbl_enquiry (name, email, phone, date, table_number, message) VALUES ('$name', '$email', '$phone', '$date', '$table_number', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Thank you! Your enquiry has been submitted.'); window.location.href='contact.php';</script>";
    } else {
        echo "<script>alert('Something went wrong!'); window.history.back();</script>";
    }

} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
