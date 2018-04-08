<?php
session_start();
$con=mysqli_connect("localhost","root","","pacific_freight");
$data = $_POST['mydoc'];
$query = "Select * from file_data left join
	(Select concat(fname,' ',lname) as fullname, user_id from users) as t2 on t2.user_id=file_data.uploader
	where doc = '{$data}' 
";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
?>
<table class="table">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>File</th>
			<th>Uploaded</th>
		</tr>
	</thead>
	<tbody>
<?php
	while($answer = mysqli_fetch_array($result)){
?>
	<tr>
		<td><a href="#" title="Delete" onclick="top.deleteFile('<?php echo $answer['file_id']; ?>');"><span class="glyphicon glyphicon-trash"></span></a></td>
		<td><a href="uploads/<?php echo $answer['file_id'].".".$answer['extension']; ?>" target="_blank"><?php echo $answer['orig_name'];?></a></td>
		<td><?php echo  $answer['fullname']." ({$answer['uploaded']})";?></td>
	</tr>
<?php
	}
?>
	</tbody>
</table>
<?php 
}
else{
	echo "<h4>Empty List</h2>";
}
mysqli_close($con);

?>
<hr>