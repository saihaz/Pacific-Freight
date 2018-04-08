<?php
$con=mysqli_connect("localhost","root","","pacific_freight");

$query1 = "Select cockpit_data from final_data where fd_id='{$_POST['todelete']}' where loc";
$result1 = mysqli_query($con,$query1);
if(mysqli_num_rows($result1)>0){
	$answer1 = mysqli_fetch_row($result1);
	$subquery1 = "Update cockpit set finalize = Null where c_id='{$answer1[0]}' ";
	mysqli_query($con,$subquery1);
}
mysqli_free_result($result1);

$query2 = "Delete from final_data where fd_id='{$_POST['todelete']}'";
echo $query2;
mysqli_query($con,$query2);

mysqli_close($con);
?>


<script language="javascript" type="text/javascript">
top.alert("Data Deleted");
top.location.reload();
</script>