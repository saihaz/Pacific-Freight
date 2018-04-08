<?php
	$con=mysqli_connect("localhost","root","","pacific_freight");
	date_default_timezone_set("Asia/Taipei");

	$semail = mysqli_real_escape_string($con, $_POST['semail']);

	$subject = "Freight Account Reset";
	$to = $semail;
	$message ="";
	$from = "SEE.FiSS@Schneider-Electric.com";

	$headers .= 'MIME-Version: 1.0' . "\r\n";  
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  

	$headers .= "From: $from \r\n" .  
	       "Reply-To: $from \r\n" .  
	       "X-Mailer: PHP/" . phpversion();  


	$res = "";

	$query = "Select * from users where email like '{$semail}'";
	$result = mysqli_query($con,$query);
	if(mysqli_num_rows($result)>0){
		$answer = mysqli_fetch_array($result);
		$pin;
		if(trim($answer['reset_pin'])){
			$pin = $answer['reset_pin'];
		}
		else{
			$pin = generateRandomString();
			$subquery = "Update users set reset_pin='{$pin}' where user_id='{$answer['user_id']}' limit 1";
			mysqli_query($con,$subquery);
		}
		$message = "
<html>
<body>
<br>
<br>
	Hi {$answer['fname']},
<br>
<br>
<br>
	Good Day!	
<br>
<br>
	You are requesting for a password reset.
<br>
<br>
	To reset your password, please use the details below
<br>
	Username: <strong>{$answer['uname']}</strong>
<br>
	Reset PIN: <strong>{$pin}</strong>
<br>
<br>
	Then follow the link
<br>
	<a href='http://localhost/pacific2/?page=reset'>http://localhost/pacific2/?page=reset</a>
<br>
<br>
	*Note: This is a system generated mail. Please don't hesitate to send a reply email 
<br>
	should you have questions and/or clarifications.
<br>
<br>
</body>
</html>
		";
	}
	else{
		$message="
<html>
<body>
<br>
<br>
	Hi,
<br>
<br>
	Good Day!
<br>
<br>
	You have requested a password reset but it seems that 
<br>you do not have an existing account in the system.
<br>
<br>
<br>
	*If you think this is an error message. Kindly notify us by replying in this email.
<br>
	**Note: This is a system generated mail.
<br>

		";
	}
	mysqli_free_result($result);

//mail funtion 1

	//------$headers = "From:" . $from;
	if(@mail($to,$subject,$message,$headers))
	{
	  $res = "Mail Sent Successfully";
	}else{
	  $res = "Mail Not Sent";
	}
// end mail
/*
	$query = "Insert into users (fname,lname,sesa,email,uname,pword,created) values 
	('{$fname}','{$lname}','{$sesa}','{$semail}','{$uname}','{$pword}',Now())";

	echo "<br>".$query;
	//mysqli_query($con,$query);
	*/
	mysqli_close($con);


	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
?>

	<script language="javascript" type="text/javascript">
		top.changeBodyVal("<?php echo $res;?>");
	</script>