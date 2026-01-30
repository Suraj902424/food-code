<?php
require 'dbc.php';

if (!empty($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "UPDATE tbl_booking SET status='confirmed' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
