<?php
//session_start();
$con=mysqli_connect("localhost","root","","pacific_freight");

$uname = mysqli_real_escape_string($con, $_POST['username']);
$pword = mysqli_real_escape_string($con, $_POST['password']);

$query = "Select * from users where uname='{$uname}' and pword='{$pword}'";
$result = mysqli_query($con,$query);
$error = "";
if(mysqli_num_rows($result)>0){
	$answer = mysqli_fetch_array($result);
	if($answer['active']=="1"){
		//successful log
		//$_SESSION["pfreight_userid"] = $answer['useri_id'];
		//$_SESSION["pfreight_fname"] = $answer['fname'];
		//$_SESSION["pfreight_lname"] = $answer['lname'];
		//$_SESSION["pfreight_email"] = $answer['email'];
		$tmpid = intval($answer['user_id'])*14344;
		$longlink = "../?page=prelog&rhj=".$tmpid."&fname=".$answer['fname']."&lname=".$answer['lname']."&email=".$answer['email']."&ad=".$answer['admin'];
?>
	<script language="javascript" type="text/javascript">
		window.top.location.href="<?php echo $longlink; ?>";
	</script>
<?php
	}
	else{
		$error = "Inactive Account!<br>Please Contact Your Administrator";
	}
}
else{
	$error = "Invalid Username/Password";
}

if(trim($error)){
?>
	<script language="javascript" type="text/javascript">
		//alert("jhi");
		top.error_prompt("<?php echo $error; ?>");
	</script>
<?php
}

mysqli_free_result($result);
mysqli_close($con);
?>