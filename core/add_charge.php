<?php
session_start();
$con=mysqli_connect("localhost","root","","pacific_freight");
$charge = $_POST['mcharge'];
$amount = str_replace(",","",$_POST['mamount']);
$data = $_POST['mdata'];

$cols = "";
$vals = "";
$echo = "Charge Error!!!";

if(trim($charge)){
	$subquery = "Select charges, gl, costcentre, value2 from all_charges2 where ac_id='{$charge}'";
	$subresult = mysqli_query($con,$subquery);
	if(mysqli_num_rows($subresult)>0){
		$subanswer = mysqli_fetch_array($subresult);

		if(trim($subanswer['charges'])){
			$tmpp = mysqli_real_escape_string($con, $subanswer['charges']);
			$cols = $cols. "charge,";
			$vals = $vals. "'".$tmpp."',";	
		}
		if(trim($subanswer['gl'])){
			$tmpp = mysqli_real_escape_string($con, $subanswer['gl']);
			$cols = $cols. "gl,";
			$vals = $vals. "'".$tmpp."',";	
		}
		if(trim($subanswer['costcentre'])){
			$tmpp = mysqli_real_escape_string($con, $subanswer['costcentre']);
			$cols = $cols. "costcentre,";
			$vals = $vals. "'".$tmpp."',";	
		}
		if(trim($subanswer['value2'])){
			$tmpp = mysqli_real_escape_string($con, $subanswer['value2']);
			$cols = $cols. "value2,";
			$vals = $vals. "'".$tmpp."',";	
		}
		if(trim($amount)){
			$tmpp = mysqli_real_escape_string($con, $amount);
			$cols = $cols. "amount,";
			$vals = $vals. "'".$tmpp."',";	
		}
		if(trim($data)){
			$tmpp = mysqli_real_escape_string($con, $data);
			$cols = $cols. "doc,";
			$vals = $vals. "'".$tmpp."',";	
		}
		if(trim($cols)){
			$cols=substr($cols,0,-1);
			$vals=substr($vals,0,-1);
		}

		$query = "Insert into charges ({$cols}) values ({$vals})";
		mysqli_query($con,$query);
		$echo = "Charge Submitted";	
	}
	mysqli_free_result($subresult);
}
else{
	$echo = "Charge is missing!!<br>Data is not submitted.";
}

$bquery = "SELECT Round(Sum(amount),2) as sumnet, Netamount FROM charges LEFT JOIN
			(SELECT c_id, Netamount FROM cockpit) as t2 on t2.c_id=charges.doc 
 			WHERE doc='{$data}'";
$bresult = mysqli_query($con,$bquery);
if(mysqli_num_rows($bresult)>0){
	$bsubquery = "";
	$banswer = mysqli_fetch_array($bresult);
	if(round($banswer['Netamount'],2)==round($banswer['sumnet'],2)){
		$bsubquery = "Update cockpit set balanced='1' where c_id='{$data}' limit 1 ";
		echo $bsubquery;
		mysqli_query($con,$bsubquery);
	}
	else{
		$bsubquery = "Update cockpit set balanced=Null where c_id='{$data}' limit 1 ";
		echo $bsubquery;
		mysqli_query($con,$bsubquery);
	}
	if(round($banswer['sumnet'],2) > $banswer['Netamount']){
		$echo = $echo . "<br>(Charge Exceeded!)";
	}
}
mysqli_free_result($bresult);

mysqli_close($con);
//echo $query;
?>

<script>window.top.document.getElementById("mypopup").innerHTML = "<?php echo $echo;?>";</script>