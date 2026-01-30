<?php
include 'loginQuery/session_start.php';
include 'dbc.php';

if (isset($_GET['id']) && isset($_GET['table'])) {
    $id = intval($_GET['id']);
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['table']); // Prevent SQL injection
    $img = $_GET['img'] ?? '';
    $redirect = $_GET['redirect'] ?? 'index.php'; // Redirect URL after delete

    // Optional: Delete image
    if (!empty($img)) {
        $imagePath = $mainPath . $img;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete from database
    $query = "DELETE FROM `$table` WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: $redirect?msg=deleted");
        exit();
    } else {
        echo "❌ Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "⚠️ Invalid Request";
}
?>
