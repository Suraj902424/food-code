<?php
include 'dbc.php';

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $tableName = "tbl_booking";
    $query = "DELETE FROM $tableName WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>
