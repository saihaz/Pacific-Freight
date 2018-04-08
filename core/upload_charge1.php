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
			$queryt = "Delete from all_charges1 where ctry like '{$ctry}'";
			mysqli_query($con,$queryt);
			for($i=1;$i<$num_rows;$i++){
				if(trim($xlsx[$i][0])==false and trim($xlsx[$i][1])==false)
					continue;
				$cols =  "";
				$vals =  "";	
				if(trim($xlsx[$i][0])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][0]);
					$cols = $cols. "ctry,";
					$vals = $vals. "'".$tmpp."',";	
				}	
				if(trim($xlsx[$i][1])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][1]);
					$cols = $cols. "Vendor,";
					$vals = $vals. "'".$tmpp."',";	
				}
				if(trim($xlsx[$i][2])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][2]);
					$cols = $cols. "BPO,";
					$vals = $vals. "'".$tmpp."',";	
				}
				if(trim($xlsx[$i][3])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][3]);
					$cols = $cols. "Vendordetails,";
					$vals = $vals. "'".$tmpp."',";	
				}
				if(trim($xlsx[$i][4])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][4]);
					$cols = $cols. "MyValue,";
					$vals = $vals. "'".$tmpp."',";	
				}
				$query = "Insert into all_charges1 ({$cols}uploaded,uploader) values ({$vals}Now(),'1') ";
				mysqli_query($con,$query);
			}
			$mymsg="Charge 1 Successfully Uploaded";
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