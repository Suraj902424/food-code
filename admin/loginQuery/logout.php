<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
	$cookie_name = 'menuNameListCookies';	
	unset($_COOKIE[$cookie_name]);
header("Location: ../index.php"); // Redirecting To Home Page
}
?>
