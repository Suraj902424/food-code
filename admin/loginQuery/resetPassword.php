<?php

include'../dbc.php';
 $email=$_POST['txteamil']; 

$sql=mysqli_query($conn,"select * from $tblAdmin where email='$email'") or die(mysqli_query($conn));


if(mysqli_num_rows($sql)>0)
{
$rows=mysqli_fetch_assoc($sql);
$emailID=$rows['email'];
$userID=$rows['id'];
$pass=rand(1,999999);

// $pass =md5( $_REQUEST['txtpassword']);
			/*-----------------------------------------------------------------------*/
	$sqli = mysqli_query($conn,"update $tblAdmin set  password = md5('$pass') where id = '$userID'") or die(mysqli_error($conn));
	if(mysqli_affected_rows($conn) >0)
	{
		/*sent mail query */ 
			$to = $emailID;
			$subject = 'Change Passoword';
			$message = "Hello,\n You have a email. Details are follwing:\n\n".
					"Your new password : $pass\n";
					$from = "San Manager";
					$headers = "From: $from\r\nReply-To: free.in";
					$headers .= "\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"_1_$boundary\"";
			//echo $message;
			$flgSend = @mail($to, $subject, $message, $headers);  // @ = No Show Error //  
			if($flgSend)  
			{  
				//header('Location: ../restpassword.php?m=1');
				echo "1";
			}  
			else  
			{  
				//header('Location: ../restpassword.php?m=0');
				echo "0";  
			}  
		/********************************/
		echo "1";
	
	}
}
else
{
	echo "Please enter regestered mail";
}
?>