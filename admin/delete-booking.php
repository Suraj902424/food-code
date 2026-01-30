<?php
include 'dbc.php';

header('Content-Type: application/json');

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
    exit;
}

$id = (int)$_POST['id'];
$table = "tbl_booking";

$sql = "DELETE FROM `$table` WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt === false) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Booking deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No booking found with this ID']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Delete failed: ' . mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>