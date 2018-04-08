<?php
session_start();
$con=mysqli_connect("localhost","root","","pacific_freight");
$defa = "";
$bquery = "Select delegation from approver where approver_id='{$_SESSION['pfreight_userid']}'";
$bresult = mysqli_query($con,$bquery);
if(mysqli_num_rows($bresult)>0){
	$banswer = mysqli_fetch_row($bresult);
	$defa = $banswer[0];
}
mysqli_free_result($bresult);

$query = "Select * from approver";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
?>
	<select class="form-control" name="delegation">
		<option value-"">----------------------------------</option>
<?php
	while ($answer = mysqli_fetch_array($result)) {
?>
		<option value="<?php echo $answer['approver_id']; ?>" <?php if($answer['approver_id']==$defa) echo "selected"; ?>><?php echo $answer['fname']." ".$answer['lname'];?></option>
<?php
	}
?>
	</select>
	<table class="table">
		<thead>
		</thead>
		<tbody>
			<tr>
				<td><label>Date Range</label></td>
				<td><input type="date" class="form-control" name="dated0" placeholder="yyyy-mm-dd"></td>
				<td><input type="date" class="form-control" name="dated1" placeholder="yyyy-mm-dd"></td>
			</tr>
		</tbody>
	</table>
	
<?php
}
else{
?>
	<h1>Empty Approver</h1>
<?php
}

mysqli_close($con);
?>

(This will automatically delegate all your future documents to specific person)
<h6>**Note: Set to empty value to remove the delegation.</h6>