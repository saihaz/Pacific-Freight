<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
$query = "Delete from charges where charge_id = '{$_POST['fd_charge']}'";
mysqli_query($con,$query);
mysqli_close($con);
?>
<script>
	window.top.document.getElementById("mypopup").innerHTML = "Charge has been deleted.";
</script>