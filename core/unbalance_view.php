<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
//echo $_POST['mydoc'];
$query = "Select * from cockpit where c_id='{$_POST['mydoc']}'";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	$answer = mysqli_fetch_array($result);
	echo $answer['c_id']."!!".$answer['DocNo']."!!".$answer['Vendor']."!!".$answer['Vendordetails']."!!".$answer['Reference']."!!".$answer['Netamount']."!!".$answer['Text2'];
}
mysqli_free_result($result);
mysqli_close($con);
?>