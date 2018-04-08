<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
include "core/simplexlsx.class.php";

$data = new SimpleXLSX('files/materialvspc.xlsx');
list($num_cols, $num_rows) = $data->dimension();
$xlsx =  $data->rows();

$queryt = "Truncate Table mvp";
mysqli_query($con,$queryt);
for($i=1;$i<$num_rows;$i++){
	if(trim($xlsx[$i][0])==false and trim($xlsx[$i][1])==false)
		continue;
	//echo $xlsx[$i][0]."<br>";
	$cols =  "";
	$vals =  "";	
	if(trim($xlsx[$i][0])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][0]);
		$cols = $cols. "Material,";
		$vals = $vals. "'".$tmpp."',";	
	}	
	if(trim($xlsx[$i][1])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][1]);
		$cols = $cols. "PurchasingGroup,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][2])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][2]);
		$cols = $cols. "PurchasingGroup2,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][3])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][3]);
		$cols = $cols. "ProfitCenter,";
		$vals = $vals. "'".$tmpp."',";	
	}
	/*
	if(trim($xlsx[$i][4])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][4]);
		$cols = $cols. "SupplierLeader,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][5])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][5]);
		$cols = $cols. "SupplierLeader2,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][6])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][6]);
		$cols = $cols. "PGManager,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][7])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][7]);
		$cols = $cols. "POrg,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][8])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][8]);
		$cols = $cols. "Vendor,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][9])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][9]);
		$cols = $cols. "Plant,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][10])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][10]);
		$cols = $cols. "PCComponent,";
		$vals = $vals. "'".$tmpp."',";	
	}
	*/
	if(trim($xlsx[$i][11])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][11]);
		$cols = $cols. "Approver,";
		$vals = $vals. "'".$tmpp."',";	
	}
	$query = "Insert into mvp ({$cols}uploaded,uploader) values ({$vals}Now(),'1') ";
	mysqli_query($con,$query);
	//$delete_query = "Delete FROM `cn53n` where milestone_description not like 'mm0%' and milestone_description not like 'mm2%' and milestone_description not like 'mm5%' and milestone_description not like 'mm6%'";
	//mysqli_query($con,$query);
	echo $query."<br>";
}

mysqli_close($con);
?>