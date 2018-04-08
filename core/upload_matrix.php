<?php
$mymsg = "";
// Check if a file has been uploaded
if(isset($_FILES['myfile'])) {
    // Make sure the file was sent without errors
    if($_FILES['myfile']['error'] == 0) {		
        // Gather all required data
        $name = $_FILES['myfile']['name'];
		$mytmp = explode(".", $name);
		if(end($mytmp)=="xlsx"){
			$con=mysqli_connect("localhost","root","","pacific_freight");
			include "simplexlsx.class.php";
			$data = new SimpleXLSX($_FILES['myfile']['tmp_name']);
			$ctry = "AU";
			if(isset($_POST['myctry']) and trim($_POST['myctry'])){
				$ctry = $_POST['myctry'];
			}
			list($num_cols, $num_rows) = $data->dimension();
			$xlsx =  $data->rows();
			$queryt = "Delete from matrix where ctry like '{$ctry}'";
			mysqli_query($con,$queryt);
			for($i=1;$i<$num_rows;$i++){
				if(trim($xlsx[$i][0])==false)
					continue;
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
				$query = "Insert into matrix ({$cols}uploaded,uploader) values ({$vals}Now(),'1') ";
				mysqli_query($con,$query);
			}
			$mymsg="Matrix Successfully Uploaded";
		}
		else{
			$mymsg = "Invalid File";
		}
    }
    else {
		$mymsg = "An error occured while the file was being uploaded. Error code: ". intval($_FILES['myfile']['error']);
    }
}
else {
    //echo 'Error! A file was not sent!';
	$mymsg = "Error! A file was not sent!";
}

?>
<script language="javascript" type="text/javascript">window.top.window.changeBodyVal("<?php echo $mymsg;?>");</script>