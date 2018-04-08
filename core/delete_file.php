<?php
if(isset($_POST['fileDeletion'])){
$data = $_POST['fileDeletion'];
	if(trim($data)){
		$con=mysqli_connect("localhost","root","","pacific_freight");
		// get extension
		$ext = "";
		$dir = "../uploads/";
		$query = "Select extension from file_data where file_id='{$data}'";
		$result = mysqli_query($con,$query);
		if(mysqli_num_rows($result)>0){
			$answer = mysqli_fetch_array($result);
			$ext = $answer['extension'];
		}
		mysqli_free_result($result);

		$path_to_filename = "{$dir}{$data}.{$ext}";

		//delete from folder
		unlink($path_to_filename);

		//delete from db
		$query = "Delete from file_data where file_id='{$data}' limit 1";
		mysqli_query($con,$query);
		echo $query;
		mysqli_close($con);
	}
}
?>
<script>
	top.alert("File Deleted");
	top.hideModal("myModal4");
</script>