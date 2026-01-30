<?php session_start(); // Starting Session
include'../../dbc.php';
	
//now validating the username and password
$sql=mysqli_query($conn,"select * from $tblAdmin") or die(mysqli_error($conn));

	$row=mysqli_fetch_array($sql);
	extract($row);
	
		$_SESSION['username'] = $email; 
		$_SESSION['name'] = $name; 
		$_SESSION['userid']   = $id;
		$_SESSION['role']     = $type;
		$_SESSION['master']     = $master;
		$_SESSION['menu']     = $menu;
		$_SESSION['add_status']     = $add_status;
		$_SESSION['edit_status']     = $edit_status;
		$_SESSION['delete_status']     = $delete_status;
		// $_SESSION['role']     = $user_role; 
	
?>