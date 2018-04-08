<?php
session_start();
$con=mysqli_connect("localhost","root","","pacific_freight");

$delegate = $_POST['delegation'];
$dated0 = date("Y-m-d");
$dated1 = date("Y-m-d");
if(trim($_POST['dated1'])){
	$dated1 = $_POST['dated1'];
}
if(trim($_POST['dated0'])){
	$dated0 = $_POST['dated0'];
}
$msg = "Delegation Updated";

$query = "Select email from approver where approver_id='{$delegate}'";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	$answer = mysqli_fetch_array($result);
	$subquery = "UPDATE approver set delegation='{$delegate}', deleg_mail='{$answer['email']}', deleg_bdate='{$dated0}', deleg_date='{$dated1}' where approver_id='{$_SESSION['pfreight_userid']}'";
	//echo $subquery;
	$msg = "Delegation Updated";
	mysqli_query($con,$subquery);
	//Update thru final data
	$fquery = "UPDATE final_data set approver='{$delegate}', delegated_on=Now(), delegated_by='{$_SESSION['pfreight_userid']}' where approver='{$_SESSION['pfreight_userid']}' and (approval!='Approved' or approval is NULL)";
	mysqli_query($con,$fquery);
	echo $fquery;
}
else{
	$msg = "Delegation Removed";
	//Update thru final data
	$fquery = "UPDATE final_data LEFT JOIN 
				(SELECT fd_id as fdid2, delegated_by as delby2 from final_data) as t2 on t2.fdid2=final_data.fd_id 
				SET approver = t2.delby2, delegated_by=NULL, delegated_on=NULL
				WHERE delegated_by='{$_SESSION['pfreight_userid']}' ";
	mysqli_query($con,$fquery);

	$subquery = "UPDATE approver set delegation=Null, deleg_mail=Null, deleg_bdate=Null, deleg_date=Null where approver_id='{$_SESSION['pfreight_userid']}'";
	mysqli_query($con,$subquery);

}
mysqli_free_result($result);
mysqli_close($con);

?>

<script language="javascript" type="text/javascript">
top.alert("<?php echo $msg; ?>");
top.location.reload();
</script>