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
			$queryt = "Delete from master_file where ctry like '{$ctry}'";
			//mysqli_query($con,$queryt);
			for($i=1;$i<$num_rows;$i++){
				$cols =  "";
				$vals =  "";
				$update = "";	
				if(trim($xlsx[$i][0])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][0]);
					$cols = $cols. "data_from,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", data_from='{$tmpp}'";
				}	
				if(trim($xlsx[$i][1])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][1]);
					$cols = $cols. "material,";
					$vals = $vals. "'".$tmpp."',";	
				}	
				if(trim($xlsx[$i][2])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][2]);
					$cols = $cols. "material_trim,";
					$vals = $vals. "'".$tmpp."',";	
				}
				if(trim($xlsx[$i][3])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][3]);
					$cols = $cols. "plant,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", plant='{$tmpp}'";
				}
				if(trim($xlsx[$i][4])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][4]);
					$cols = $cols. "POrg,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", POrg='{$tmpp}'";
				}
				if(trim($xlsx[$i][5])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][5]);
					$cols = $cols. "purchasing_group,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", purchasing_group='{$tmpp}'";
				}
				if(trim($xlsx[$i][6])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][6]);
					$cols = $cols. "purchasing_group2,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", purchasing_group2='{$tmpp}'";
				}
				if(trim($xlsx[$i][7])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][7]);
					$cols = $cols. "purchasing_group_m,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", purchasing_group_m='{$tmpp}'";
				}
				if(trim($xlsx[$i][8])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][8]);
					$cols = $cols. "approver_n,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", approver_n='{$tmpp}'";
				}
				if(trim($xlsx[$i][9])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][9]);
					$cols = $cols. "supplier_leader,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", supplier_leader='{$tmpp}'";
				}
				if(trim($xlsx[$i][10])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][10]);
					$cols = $cols. "supplier_leader2,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", supplier_leader2='{$tmpp}'";
				}
				if(trim($xlsx[$i][11])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][11]);
					$cols = $cols. "vendor_no,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", vendor_no='{$tmpp}'";
				}
				if(trim($xlsx[$i][12])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][12]);
					$cols = $cols. "vendor_details,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", vendor_details='{$tmpp}'";
				}
				if(trim($xlsx[$i][13])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][13]);
					$cols = $cols. "profit_center,";
					$vals = $vals. "'".$tmpp."',";	
				}
				if(trim($xlsx[$i][14])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][14]);
					$cols = $cols. "business_level,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", business_level='{$tmpp}'";
				}
				if(trim($ctry)){
					$tmpp = mysqli_real_escape_string($con, $ctry);
					$cols = $cols. "ctry,";
					$vals = $vals. "'".$tmpp."',";	
				}


				if(trim($update)){
					$update = "ON DUPLICATE KEY UPDATE " .substr($update, 1);
				}
				
				$query = "Insert into master_file ({$cols}uploaded,uploader) values ({$vals}Now(),'1') {$update}";
				mysqli_query($con,$query);
				echo $query."<br>";
			}
			$mymsg="Master File Successfully Uploaded";
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