<?php
include 'config.php';

if (isset($_GET['cat_id'])) {
    $cat_id = intval($_GET['cat_id']);

    $result = mysqli_query($conn, "SELECT id, name, price_half, price_full FROM tbl_product WHERE category_id = $cat_id AND status = 1");

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    

    echo json_encode($products);
} else {
    echo json_encode([]);
}
