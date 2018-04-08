<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
$error = "Password Has Been Changed<br>You may now login to your account.";
$password = mysqli_real_escape_string($con,$_POST['senpword']);
$senpin = mysqli_real_escape_string($con,$_POST['senpin']);

$query0 = "Select * from users where reset_pin = '$senpin' ";
$result0 = mysqli_query($con,$query0);
if(mysqli_num_rows($result0)>0){
	$query = "Update users set pword = '{$password}', reset_pin=Null where reset_pin = '{$senpin}' limit 1";
	mysqli_query($con,$query);
}
else{
	$error = "PIN Error";
}
mysqli_free_result($result0);


mysqli_close($con);
?>
<script language="javascript" type="text/javascript">
top.changeBodyVal2("<?php echo $error; ?>");
top.clear_form();
</script>