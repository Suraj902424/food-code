<?php

include'../dbc.php';
session_start();// Starting Session

 $username=$_SESSION['username']; 
 
 $oldpass =md5( $_REQUEST['txtoldpassword']);
 $pass =md5( $_REQUEST['txtpassword']);
			/*-----------------------------------------------------------------------*/
	
	$csql = mysqli_query($conn,"select * from $tblAdmin where email = '$username' and password = '$oldpass'");
	if(mysqli_num_rows($csql)>0)
	{
		//echo "change password";
		$sqladd = mysqli_query($conn,"update $tblAdmin set password = '$pass' where email = '$username'") or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn) > 0)
		{
			//header('Location: ../dashboard.php?option=chngpswd&m=1');
			echo "yes";
		}
		else
		{
			//header('Location: ../dashboard.php?option=chngpswd&m=2');
			echo "not update";
		}
	}
	else
	{
		echo "current password wrong.";
		//header('Location: ../dashboard.php?option=chngpswd&m=3');
	}			
	
?>