<?php
session_start();

$id = $_POST['product_id'] ?? null;

if ($id !== null && isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($id) {
        return $item['id'] != $id;
    });
}

header("Location: cart.php");
exit;
