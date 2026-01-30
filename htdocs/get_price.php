<?php
require_once 'config.php';
$sql = mysqli_query($conn, "SELECT price FROM tbl_products WHERE id = 1"); // Adjust as needed
$row = mysqli_fetch_assoc($sql);
echo json_encode(['price' => $row['price']]);
?>
