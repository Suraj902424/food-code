<?php 
session_start();// Starting Session
if(!isset($_SESSION['username'])){
header('Location: index.php'); // Redirecting To Home Page
}
?>
