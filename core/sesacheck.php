<?php
	$con=mysqli_connect("localhost","root","","pacific_freight");
	$sesa = mysqli_real_escape_string($con, $_POST['sesa']);
	$query = "Select * from users where sesa='{$sesa}'";
	$result = mysqli_query($con,$query);
	$count = mysqli_num_rows($result);
	if($count>0){
		echo $count; 
	}
	mysqli_close($con);
?>