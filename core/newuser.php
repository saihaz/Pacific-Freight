<?php
	$con=mysqli_connect("localhost","root","","pacific_freight");
	$fname = mysqli_real_escape_string($con, $_POST['fname']);
	$lname = mysqli_real_escape_string($con, $_POST['lname']);
	$sesa = mysqli_real_escape_string($con, $_POST['sesa']);
	$semail = mysqli_real_escape_string($con, $_POST['semail']);
	$uname = mysqli_real_escape_string($con, $_POST['uname']);
	$pword = mysqli_real_escape_string($con, $_POST['pword']);

//mail funtion 1
	date_default_timezone_set("Asia/Taipei");
	$to = $semail;
	$subject = "Freight Account Creation";
	$message = "

	Hi {$fname},

	Good Day!

	We would like to inform you that your account has been created.

	Please remember your login info
	Username: {$uname}
	Password: {$pword}

	This is strictly confidential. Please do not share your account to others.
	Kindly wait for another e-mail regarding with the activation of your account.

	*Note: This is a system generated mail. Please don't hesitate to send a reply email 
	should you have questions and/or clarifications.
	";
	$from = "SEE.FiSS@Schneider-Electric.com";

	$headers = "From:" . $from;
	if(@mail($to,$subject,$message,$headers))
	{
	  echo "Mail Sent Successfully";
	}else{
	  echo "Mail Not Sent";
	}
// end mail

//mail funtion 2
	date_default_timezone_set("Asia/Taipei");
	$to = "SEE.FiSS@Schneider-Electric.com";
	$subject = "Account Activation Request";
	$message = "

	Good Day!

	You have a pending account to activate

	Please check the details below
	Username: {$uname}
	E-Mail Add: {$semail}

	*Note: This is a system generated mail.
	";
	$from = "SEE.FiSS@Schneider-Electric.com";

	$headers = "From:" . $from;
	if(@mail($to,$subject,$message,$headers))
	{
	  echo "Mail Sent Successfully";
	}else{
	  echo "Mail Not Sent";
	}
// end mail

	$query = "Insert into users (fname,lname,sesa,email,uname,pword,created) values 
	('{$fname}','{$lname}','{$sesa}','{$semail}','{$uname}','{$pword}',Now())";

	echo "<br>".$query;
	mysqli_query($con,$query);
	mysqli_close($con);
?>

	<script language="javascript" type="text/javascript">
		top.changeBodyVal("An account has been created");
		top.clear_form();
	</script>