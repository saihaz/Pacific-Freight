<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
include "core/simplexlsx.class.php";

$data = new SimpleXLSX('files/cockpit.xlsx');
list($num_cols, $num_rows) = $data->dimension();
$xlsx =  $data->rows();

//$queryt = "Truncate Table cockpit";
//mysqli_query($con,$queryt);
for($i=1;$i<$num_rows;$i++){
	if(trim($xlsx[$i][0])==false)
		continue;
	//echo $xlsx[$i][0]."<br>";
	$cols =  "";
	$vals =  "";	
	if(trim($xlsx[$i][0])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][0]);
		$cols = $cols. "CCode,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][1])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][1]);
		$cols = $cols. "DocNo,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][2])){
		$datethiss1 = new DateTime("1899-12-30");
		date_add($datethiss1,date_interval_create_from_date_string("{$xlsx[$i][2]} days"));
		$tmpp = date_format($datethiss1, 'Y-m-d');
		$cols = $cols. "DocDate,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][3])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][3]);
		$cols = $cols. "Vendor,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][4])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][4]);
		$cols = $cols. "Vendordetails,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][5])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][5]);
		$cols = $cols. "Invoice,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][6])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][6]);
		$cols = $cols. "Reference,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][7])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][7]);
		$cols = $cols. "Currency,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][8])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][8]);
		$cols = $cols. "Grossamount,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][9])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][9]);
		$cols = $cols. "Netamount,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][10])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][10]);
		$cols = $cols. "Text1,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][11])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][11]);
		$cols = $cols. "Text2,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][12])){
		$datethiss1 = new DateTime("1899-12-30");
		date_add($datethiss1,date_interval_create_from_date_string("{$xlsx[$i][12]} days"));
		$tmpp = date_format($datethiss1, 'Y-m-d');
		$cols = $cols. "DueDate,";
		$vals = $vals. "'".$tmpp."',";	
	}
	/*
	if(trim($xlsx[$i][9])){
		$datethiss1 = new DateTime("1899-12-30");
		date_add($datethiss1,date_interval_create_from_date_string("{$xlsx[$i][9]} days"));
		
		$cols = $cols. "finish_date,";
		$vals = $vals. "'".date_format($datethiss1, 'Y-m-d')."',";	
	}
	
		$datethiss = new DateTime("1899-12-30");
		date_add($datethiss,date_interval_create_from_date_string("{$xlsx[$i][8]} days"));
		
		$project_definition = $xlsx[$i][0];
		$project_name = $xlsx[$i][1];
		$status = $xlsx[$i][5];
		$project_definition = mysqli_real_escape_string($con, $project_definition);
		$project_name = mysqli_real_escape_string($con, $project_name);
		$status = mysqli_real_escape_string($con, $status);
		
		$cols = $cols. $cols . "project_definition,project_name,status,start_date,";
		$vals = $vals. $vals . "'" . $project_definition . "','" . $project_name . "','" . $status . "','" . date_format($datethiss, 'Y-m-d') . "',";
		
	
	if(trim($xlsx[$i][4])){
		$person = $xlsx[$i][4];
		$person = mysqli_real_escape_string($con, $person);
		$cols = $cols. $cols . "resp_person,";
		$vals = $vals. $vals . "'" . $person . "',";
	}
	if(trim($xlsx[$i][6])){
		$createdby = $xlsx[$i][6];
		$createdby = mysqli_real_escape_string($con, $createdby);
		$cols = $cols. $cols . "createdby,";
		$vals = $vals. $vals . "'" . $createdby . "',";
	}
	*/
	
	$query = "Insert into cockpit ({$cols}uploaded,uploader) values ({$vals}Now(),'1') ";
	mysqli_query($con,$query);
	//$delete_query = "Delete FROM `cn53n` where milestone_description not like 'mm0%' and milestone_description not like 'mm2%' and milestone_description not like 'mm5%' and milestone_description not like 'mm6%'";
	//mysqli_query($con,$query);
	echo $query."<br>";
}

mysqli_close($con);
?>