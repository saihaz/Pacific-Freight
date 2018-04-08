<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
include "core/simplexlsx.class.php";

$data = new SimpleXLSX('files/podata.xlsx');
list($num_cols, $num_rows) = $data->dimension();
$xlsx =  $data->rows();

$queryt = "Truncate Table po_data";
mysqli_query($con,$queryt);
for($i=1;$i<$num_rows;$i++){
	//echo $xlsx[$i][0]."<br>";
	$cols =  "";
	$vals =  "";	
	if(trim($xlsx[$i][0])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][0]);
		$cols = $cols. "purchdoc,";
		$vals = $vals. "'".$tmpp."',";	
	}	
	if(trim($xlsx[$i][1])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][1]);
		$cols = $cols. "Material,";
		$vals = $vals. "'".$tmpp."',";	
	}	
	if(trim($xlsx[$i][2])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][2]);
		$cols = $cols. "Plant,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][3])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][3]);
		$cols = $cols. "Purchasinggroup,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][4])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][4]);
		$cols = $cols. "PurchOrg,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][5])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][5]);
		$cols = $cols. "supplyingplant,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][6])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][6]);
		$cols = $cols. "Currency,";
		$vals = $vals. "'".$tmpp."',";	
	}
	$query = "Insert into po_data ({$cols}uploaded,uploader) values ({$vals}Now(),'1') ";
	mysqli_query($con,$query);
	echo $query."<br>";
}

mysqli_close($con);
?>