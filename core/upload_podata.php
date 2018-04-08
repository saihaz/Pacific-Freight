<?php
session_start();
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
			$queryt = "Delete from po_data where ctry like '{$ctry}'";
			mysqli_query($con,$queryt);
			for($i=1;$i<$num_rows;$i++){
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
				}/*
				if(trim($xlsx[$i][4])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][4]);
					$cols = $cols. "prg_name,";
					$vals = $vals. "'".$tmpp."',";	
				}
				if(trim($xlsx[$i][5])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][5]);
					$cols = $cols. "profit,";
					$vals = $vals. "'".$tmpp."',";	
				}
				if(trim($xlsx[$i][6])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][6]);
					$cols = $cols. "pc_name,";
					$vals = $vals. "'".$tmpp."',";	
				}*/
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
				if(trim($ctry)){
					$tmpp = mysqli_real_escape_string($con, $ctry);
					$cols = $cols. "ctry,";
					$vals = $vals. "'".$tmpp."',";	
				}
				$query = "Insert into po_data ({$cols}uploaded,uploader) values ({$vals}Now(),'{$_SESSION['pfreight_userid']}') ";
				mysqli_query($con,$query);
				//echo $query."<br>";
			}
			$mymsg="PO Data Successfully Uploaded";
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