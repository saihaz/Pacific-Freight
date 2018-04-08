<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
$data = $_POST['mydoc'];
$query = "SELECT * FROM data_history 
 LEFT JOIN (SELECT user_id as uid2, fname, lname from users) as t2 on t2.uid2=data_history.user
 WHERE doc='{$data}' order by hist_id desc";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
?>
<div class="table-responsive" style="width:100%">
<table class="table">
	<thead>
		<tr>
			<th>User</th>
			<th>Column(s)</th>
			<th>Old Value(s)</th>
		</tr>
	</thead>
	<tbody>
<?php
	while($answer = mysqli_fetch_array($result)){
?>
	<tr>
		<td><?php echo $answer['fname']." ".$answer['lname']."({$answer['created']})"; ?></td>
		<td><?php echo $answer['action'];?></td>
		<td><?php echo $answer['avalue'];?></td>
	</tr>
<?php
	}
?>
	</tbody>
</table>
</div>
<?php 
}
mysqli_free_result($result);
mysqli_close($con);
?>