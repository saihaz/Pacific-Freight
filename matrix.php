<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
include "core/simplexlsx.class.php";

$data = new SimpleXLSX('files/matrix.xlsx');
list($num_cols, $num_rows) = $data->dimension();
$xlsx =  $data->rows();

$queryt = "Truncate Table matrix";
mysqli_query($con,$queryt);
for($i=1;$i<$num_rows;$i++){
	if(trim($xlsx[$i][0])==false)
		continue;
	//echo $xlsx[$i][0]."<br>";
	$cols =  "";
	$vals =  "";	
	if(trim($xlsx[$i][0])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][0]);
		$cols = $cols. "Ctry,";
		$vals = $vals. "'".$tmpp."',";	
	}	
	if(trim($xlsx[$i][1])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][1]);
		$cols = $cols. "Vendor,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][2])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][2]);
		$cols = $cols. "VendorName,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][3])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][3]);
		$cols = $cols. "AcctNo,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][4])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][4]);
		$cols = $cols. "Lane,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][5])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][5]);
		$cols = $cols. "Flow,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][6])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][6]);
		$cols = $cols. "TransportMode,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][7])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][7]);
		$cols = $cols. "BusinessUnit,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][8])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][8]);
		$cols = $cols. "SiteType,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][9])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][9]);
		$cols = $cols. "Plant,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][10])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][10]);
		$cols = $cols. "SiteName,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][11])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][11]);
		$cols = $cols. "Address1,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][12])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][12]);
		$cols = $cols. "City,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][13])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][13]);
		$cols = $cols. "State1,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][14])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][14]);
		$cols = $cols. "Postcode,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][15])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][15]);
		$cols = $cols. "Approver,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][16])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][16]);
		$cols = $cols. "Contact,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][17])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][17]);
		$cols = $cols. "Controllers,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][18])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][18]);
		$cols = $cols. "POType,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][19])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][19]);
		$cols = $cols. "OutboundPO,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][20])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][20]);
		$cols = $cols. "InboundBPO,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][21])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][21]);
		$cols = $cols. "CostCentre,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][22])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][22]);
		$cols = $cols. "STARScode,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][23])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][23]);
		$cols = $cols. "DataTransfer,";
		$vals = $vals. "'".$tmpp."',";	
	}
	if(trim($xlsx[$i][24])){
		$tmpp = mysqli_real_escape_string($con, $xlsx[$i][24]);
		$cols = $cols. "Comments,";
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
	
	$query = "Insert into matrix ({$cols}uploaded,uploader) values ({$vals}Now(),'1') ";
	mysqli_query($con,$query);
	//$delete_query = "Delete FROM `cn53n` where milestone_description not like 'mm0%' and milestone_description not like 'mm2%' and milestone_description not like 'mm5%' and milestone_description not like 'mm6%'";
	//mysqli_query($con,$query);
	echo $query."<br>";
}

mysqli_close($con);
?>