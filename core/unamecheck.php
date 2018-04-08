<?php
	$con=mysqli_connect("localhost","root","","pacific_freight");
	$uname = mysqli_real_escape_string($con, $_POST['uname']);
	$query = "Select * from users where uname='{$uname}'";
	$result = mysqli_query($con,$query);
	$count = mysqli_num_rows($result);
	if($count>0){
		echo $count; 
	}
	mysqli_close($con);
?>