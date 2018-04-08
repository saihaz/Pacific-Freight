<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
include "core/simplexlsx.class.php";

$data = new SimpleXLSX('files/charges.xlsx');
list($num_cols, $num_rows) = $data->dimension();
$xlsx =  $data->rows();

$queryt = "Truncate Table all_charges2";
mysqli_query($con,$queryt);
for($i=11;$i<$num_rows;$i++){
	//echo $xlsx[$i][0]."<br>";
	$cols =  "";
	$vals =  "";	
	if(trim($xlsx[$i][0])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][0]);
		$cols = $cols. "Code,";
		$vals = $vals. "'".$tmpp."',";	
	}	
	if(trim($xlsx[$i][1])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][1]);
		$cols = $cols. "Vendor,";
		$vals = $vals. "'".$tmpp."',";	
	}	
	if(trim($xlsx[$i][2])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][2]);
		$cols = $cols. "Charges,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][3])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][3]);
		$cols = $cols. "GL,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][4])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][4]);
		$cols = $cols. "CostCentre,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][6])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][6]);
		$cols = $cols. "value2,";
		$vals = $vals. "'".$tmpp."',";	
	}
	$query = "Insert into all_charges2 ({$cols}uploaded,uploader) values ({$vals}Now(),'1') ";
	mysqli_query($con,$query);
	echo $query."<br>";
}

mysqli_close($con);
?>