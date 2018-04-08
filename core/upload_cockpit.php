<?php
/*
Things to do:
Update....
The query must update those duplicates with the following details...
*/
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
				$cols =  "";
				$vals =  "";
				$update = "";
				$tccode="";	
				$tdocno="";	
				$tdocdate="";	
				if(trim($xlsx[$i][0])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][0]);
					$cols = $cols. "CCode,";
					$vals = $vals. "'".$tmpp."',";	
					$tccode=$tmpp;	
				}
				if(trim($xlsx[$i][1])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][1]);
					$cols = $cols. "DocNo,";
					$vals = $vals. "'".$tmpp."',";	
					$tdocno=$tmpp;	
				}
				if(trim($xlsx[$i][2])){
					$datethiss1 = new DateTime("1899-12-30");
					date_add($datethiss1,date_interval_create_from_date_string("{$xlsx[$i][2]} days"));
					$tmpp = date_format($datethiss1, 'Y-m-d');
					$cols = $cols. "DocDate,";
					$vals = $vals. "'".$tmpp."',";
					$tdocdate = $tmpp;	
				}
				if(trim($xlsx[$i][3])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][3]);
					$cols = $cols. "Vendor,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", Vendor='{$tmpp}'";
				}
				if(trim($xlsx[$i][4])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][4]);
					$cols = $cols. "Vendordetails,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", Vendordetails='{$tmpp}'";
				}
				if(trim($xlsx[$i][5])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][5]);
					$cols = $cols. "Invoice,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", Invoice='{$tmpp}'";
				}
				if(trim($xlsx[$i][6])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][6]);
					$cols = $cols. "Reference,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", Reference='{$tmpp}'";
				}
				if(trim($xlsx[$i][7])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][7]);
					$cols = $cols. "Currency,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", Currency='{$tmpp}'";
				}
				if(trim($xlsx[$i][8])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][8]);
					$cols = $cols. "Grossamount,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", Grossamount='{$tmpp}'";
				}
				if(trim($xlsx[$i][9])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][9]);
					$cols = $cols. "Netamount,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", Netamount='{$tmpp}'";
				}
				if(trim($xlsx[$i][10])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][10]);
					$cols = $cols. "Text1,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", Text1='{$tmpp}'";
				}
				if(trim($xlsx[$i][11])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][11]);
					$cols = $cols. "Text2,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", Text2='{$tmpp}'";
				}
				if(trim($xlsx[$i][12])){
					$datethiss1 = new DateTime("1899-12-30");
					date_add($datethiss1,date_interval_create_from_date_string("{$xlsx[$i][12]} days"));
					$tmpp = date_format($datethiss1, 'Y-m-d');
					$cols = $cols. "DueDate,";
					$vals = $vals. "'".$tmpp."',";	
					$update = $update.", DueDate='{$tmpp}'";
				}
				if(trim($xlsx[$i][13])){
					$tmpp = mysqli_real_escape_string($con, $xlsx[$i][13]);
					$cols = $cols. "doc_header,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", doc_header='{$tmpp}'";
				}
				if(trim($xlsx[$i][14])){
					$datethiss1 = new DateTime("1899-12-30");
					date_add($datethiss1,date_interval_create_from_date_string("{$xlsx[$i][14]} days"));
					$tmpp = date_format($datethiss1, 'Y-m-d');
					$cols = $cols. "Scandate,";
					$vals = $vals. "'".$tmpp."',";	
					$update = $update.", Scandate='{$tmpp}'";
				}
				if(trim($xlsx[$i][15])){
					$atmpp = explode(" ", $xlsx[$i][15]);
					$btmpp = explode("/", $atmpp[0]);
					$tmpp = "{$btmpp[2]}-{$btmpp[1]}-{$btmpp[0]}";
					//$tmpp = mysqli_real_escape_string($con, $xlsx[$i][15]);
					$cols = $cols. "colle_date,";
					$vals = $vals. "'".$tmpp."',";	
					$update =  $update.", colle_date='{$tmpp}'";
				}
				if(trim($ctry)){
					$tmpp = mysqli_real_escape_string($con, $ctry);
					$cols = $cols. "ctry,";
					$vals = $vals. "'".$tmpp."',";	
				}
				if(trim($update)){
					$update = "ON DUPLICATE KEY UPDATE " .substr($update, 1);
				}


				$idata = "";
				$query = "INSERT into cockpit ({$cols}uploaded,uploader) values ({$vals}Now(),'{$_SESSION['pfreight_userid']}') 
						{$update}";

				$iquery = "SELECT * FROM cockpit WHERE CCode='{$tccode}' AND DocNo='{$tdocno}' AND DocDate='{$tdocdate}'";
				$iresult = mysqli_query($con,$iquery);
				if(mysqli_num_rows($iresult)>0){
					$ianswer = mysqli_fetch_array($iresult);
					if($ianswer['balanced']=="1"){
						$query = "INSERT into cockpit ({$cols}uploaded,uploader) values ({$vals}Now(),'{$_SESSION['pfreight_userid']}') ";
					}
					$idata = $ianswer['c_id'];
				}

				mysqli_query($con,$query);
				echo $query."<br>";
				mysqli_free_result($iresult);


				////////////////////////////////////////
				if(trim($idata)){
					$bquery = "SELECT Sum(amount) as sumnet, Netamount FROM charges LEFT JOIN
								(SELECT c_id, Netamount FROM cockpit) as t2 on t2.c_id=charges.doc 
					 			WHERE doc='{$idata}'";
					$bresult = mysqli_query($con,$bquery);
					if(mysqli_num_rows($bresult)>0){
						$bsubquery = "";
						$banswer = mysqli_fetch_array($bresult);
						if($banswer['Netamount']==$banswer['sumnet']){
							$bsubquery = "Update cockpit set balanced='1' where c_id='{$idata}' limit 1 ";
							mysqli_query($con,$bsubquery);
						}
						else{
							$bsubquery = "Update cockpit set balanced=Null where c_id='{$idata}' limit 1 ";
							mysqli_query($con,$bsubquery);
						}
					}
					mysqli_free_result($bresult);
				}
				//////////////////////////////////////

			}
			$mymsg="Cockpit Successfully Uploaded";
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