<?php
session_start();
require 'include/config.php';
if(isset($_POST['id']) && isset($_SESSION['USER_ID'])){
    $pid = (int)$_POST['id'];
    $uid = $_SESSION['USER_ID'];
    mysqli_query($conn, "DELETE FROM wishlist WHERE product_id='$pid' AND user_id='$uid'");
    echo "success";
}
?>
