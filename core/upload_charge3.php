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
			$queryt = "Delete from all_charges3 where ctry like '{$ctry}'";
			mysqli_query($con,$queryt);
			for($i=2;$i<$num_rows;$i++){
				//echo $xlsx[$i][0]."<br>";
				$cols =  "";
				$vals =  "";	
				if(trim($xlsx[$i][0])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][0]);
					$cols = $cols. "TypeofCharge,";
					$vals = $vals. "'".$tmpp."',";	
				}	
				if(trim($xlsx[$i][1])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][1]);
					$cols = $cols. "gl,";
					$vals = $vals. "'".$tmpp."',";	
				}	
				if(trim($xlsx[$i][2])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][2]);
					$cols = $cols. "LifeSpace,";
					$vals = $vals. "'".$tmpp."',";	
				}
				if(trim($xlsx[$i][3])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][3]);
					$cols = $cols. "Power,";
					$vals = $vals. "'".$tmpp."',";	
				}
				if(trim($xlsx[$i][4])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][4]);
					$cols = $cols. "Benalla,";
					$vals = $vals. "'".$tmpp."',";	
				}
				if(trim($xlsx[$i][5])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][5]);
					$cols = $cols. "Recloser,";
					$vals = $vals. "'".$tmpp."',";	
				}
				if(trim($ctry)){
					$tmpp = mysqli_real_escape_string($con, $ctry);
					$cols = $cols. "ctry,";
					$vals = $vals. "'".$tmpp."',";	
				}
				$query = "Insert into all_charges3 ({$cols}uploaded,uploader) values ({$vals}Now(),'1') ";
				mysqli_query($con,$query);
				//echo $query."<br>";
			}
			$mymsg="Charge 3 Successfully Uploaded";
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