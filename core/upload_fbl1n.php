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
			//$queryt = "Delete from cockpit where ctry like '{$ctry}'";
			//mysqli_query($con,$queryt);
			for($i=1;$i<$num_rows;$i++){
				if(trim($xlsx[$i][0])==false)
					continue;
				$where = "";
				$update = "";	
				/*
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
				if(trim($ctry)){
					$tmpp = mysqli_real_escape_string($con, $ctry);
					$cols = $cols. "ctry,";
					$vals = $vals. "'".$tmpp."',";	
				}
				*/

				if(trim($xlsx[$i][0])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][0]);
					$where = $where." and cocd = '{$tmpp}' ";
				}
				if(trim($xlsx[$i][1])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][1]);
					$where = $where." and vendor_no = '{$tmpp}' ";
				}
				if(trim($xlsx[$i][2])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][2]);
					$where = $where." and Reference = '{$tmpp}' ";
				}
				if(trim($xlsx[$i][3])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][3]);
					$update = $update.", posting_doc = '{$tmpp}' ";
				}
				if(trim($xlsx[$i][4])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][4]);
					$update = $update.", clearing_doc = '{$tmpp}' ";
				}
				if(trim($xlsx[$i][5])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][5]);
					$update = $update.", sap_user = '{$tmpp}' ";
				}
				if(trim($xlsx[$i][6])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][6]);
					$where = $where." and Currency = '{$tmpp}' ";
				}
				if(trim($xlsx[$i][7])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][7]);
					$where = $where." and Gross = '{$tmpp}' ";
				}
				if(trim($xlsx[$i][8])){
					$datethiss1 = new DateTime("1899-12-30");
					date_add($datethiss1,date_interval_create_from_date_string("{$xlsx[$i][8]} days"));
					$tmpp = date_format($datethiss1, 'Y-m-d');
					$update = $update.", posted_date = '{$tmpp}' ";
				}
				if(trim($xlsx[$i][9])){
					$datethiss1 = new DateTime("1899-12-30");
					date_add($datethiss1,date_interval_create_from_date_string("{$xlsx[$i][9]} days"));
					$tmpp = date_format($datethiss1, 'Y-m-d');
					$update = $update.", clearing_date = '{$tmpp}' ";
				}
				$hastoupdate = false;

				if(trim($update)){
					$update = substr($update, 2);
					$hastoupdate = true;
				}
				if(trim($where)){
					$where = " where ".substr($where, 4);
					$hastoupdate = true;
				}
				if($hastoupdate){
					$query = "Update final_data set {$update} {$where}";
					mysqli_query($con,$query);
					echo $query."<br>--------------------<br>";
				}
			}
			$mymsg="FBL1N Successfully Uploaded";
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