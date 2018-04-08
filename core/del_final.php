<?php
session_start();
$con=mysqli_connect("localhost","root","","pacific_freight");
//$query = "";
if(isset($_POST['mycheck'])){
  $deletedoc = $_POST['mycheck'];
  if(empty($deletedoc)) 
  {
    echo("You didn't select any buildings.");
  } 
  else
  {
    $N = count($deletedoc);
 
    //echo("You selected $N door(s): ");
    for($i=0; $i < $N; $i++)
    {
      //echo($deletedoc[$i] . " ");
	  	$query1 = "Select cockpit_data from final_data where fd_id = '{$deletedoc[$i]}' and lock_edit is null";
	  	$result1 = mysqli_query($con,$query1);
	  	if(mysqli_num_rows($result1)>0){
	  		$answer1 = mysqli_fetch_row($result1);
	  		$query2 = "Update cockpit set finalize = Null where c_id = '{$answer1[0]}'";
	  		//echo $query2;
	  		mysqli_query($con,$query2);
	  	}
	  	mysqli_free_result($result1);
		$query="Delete from final_data where fd_id='{$deletedoc[$i]}' and lock_edit is null limit 1";

		echo $thequery;
		mysqli_query($con,$query);
    }
	?>
	<script>
		//alert("Sucessfully Deleted \nPlease Refresh Your Browser");
		window.top.location.alertRefresh();
	</script>
	<?php
  }
}
?>