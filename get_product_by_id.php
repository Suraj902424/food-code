<?php
include 'config.php';
header('Content-Type: application/json');

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT id, name, category_id, price_half, price_full FROM tbl_product WHERE id=$id AND status=1 LIMIT 1");

if (mysqli_num_rows($result) > 0) {
    echo json_encode(mysqli_fetch_assoc($result));
} else {
    echo json_encode(null);
}
?>
