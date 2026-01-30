<?php include'../dbc.php';
 $emailID = $_REQUEST['txtuseremail'];
$pass = md5( $_REQUEST['txtpassword']);
session_start(); // Starting Session
//now validating the username and password
$sql=mysqli_query($conn,"select * from $tblAdmin where email='$emailID' and password='$pass'") or die(mysqli_error($conn));
if(mysqli_num_rows($sql)>0){
	$row=mysqli_fetch_array($sql);
	extract($row);
	if(strtolower($email) == strtolower($emailID) && $pass == $password){
		echo "1";
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
	}else{
		echo	"Username or Password is invalid";	
	}
}else{
	echo	"Username or Password is invalid";
}
?>