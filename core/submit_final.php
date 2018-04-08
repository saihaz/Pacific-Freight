<?php
session_start();
$con=mysqli_connect("localhost","root","","pacific_freight");
$cols =  "";
$vals =  "";	
$update = "";

$cocd = $_POST['accode'];
$scan_date = $_POST['ascdate'];
$doc_no = $_POST['adocno'];
$doc_date = $_POST['adocdate'];
$vendor = $_POST['avendor'];
$vendor_details = $_POST['avendordetails'];
$invoice = $_POST['ainvoice'];
$reference = $_POST['aref'];
$currency = $_POST['acur'];
$gross = $_POST['agros'];
$net_amount = $_POST['anetamt'];
$text1 = $_POST['atext1'];
$text2 = $_POST['atext2'];
$bpo = $_POST['abpo'];
$cost_center = $_POST['acostc'];
$profit_center = $_POST['aprofitc'];
$profit_per = $_POST['aprofitp'];
$procurer = $_POST['aprocurer'];
$ap_comment = $_POST['aapcomment'];
$approver = $_POST['aappname'];
$io = $_POST['aio'];

$delegated_by = "";

//
$ppquery = "SELECT delegation FROM approver WHERE approver_id='{$approver}' and deleg_bdate >= DATE_FORMAT(Now(),'%Y-%m-%d') and deleg_date <= DATE_FORMAT(Now(),'%Y-%m-%d')";
$ppresult = mysqli_query($con,$ppquery);
if(mysqli_num_rows($ppresult)>0){
	$ppanswer = mysqli_fetch_row($ppresult);
	if(trim($ppanswer[0])){
		$delegated_by = $approver;
		$approver = $ppanswer[0];
	}
}
mysqli_free_result($ppresult);
//
$type = $_POST['atype'];
$customer_no = $_POST['acustomerno'];
$air_sea = $_POST['aairsea'];
$hawb = $_POST['ahawb'];
$shipper = $_POST['ashipper'];
$gross_weight = $_POST['agross'];
$departure = $_POST['adeparture'];
$destination = $_POST['adestination'];
$po_ref = $_POST['aporef'];
$consignee = $_POST['aconsignee'];
$ap_posted = $_POST['aapposted'];
$posted_date = $_POST['aposted'];
$due_date = $_POST['aduedate'];
$cockpit = $_POST['cockpit_data'];
$has_id = $_POST['if_has_id'];

if(trim($cocd)){
	$tmpp = mysqli_real_escape_string($con, $cocd);
	$cols = $cols. "cocd,";
	$vals = $vals. "'".$tmpp."',";
	//update cockpit	
	$update = "CCode='".$tmpp."'";
}
else{
	$update = "CCode=Null";
}
if(trim($scan_date)){
	$tmpp = mysqli_real_escape_string($con, $scan_date);
	$cols = $cols. "scandate,";
	$vals = $vals. "'".$tmpp."',";	
	//update cockpit	
	$update = "Scandate='".$tmpp."'";
}
else{
	$update = "Scandate=Null";
}
if(trim($doc_no)){
	$tmpp = mysqli_real_escape_string($con, $doc_no);
	$cols = $cols. "docno,";
	$vals = $vals. "'".$tmpp."',";	
	//update cockpit	
	$update = "DocNo='".$tmpp."'";
}
else{
	$update = "DocNo=Null";
}
if(trim($doc_date)){
	$tmpp = mysqli_real_escape_string($con, $doc_date);
	$cols = $cols. "docdate,";
	$vals = $vals. "'".$tmpp."',";	
	//update cockpit	
	$update = "DocDate='".$tmpp."'";
}
else{
	$update = "DocDate=Null";
}
if(trim($vendor)){
	$tmpp = mysqli_real_escape_string($con, $vendor);
	$cols = $cols. "vendor_no,";
	$vals = $vals. "'".$tmpp."',";	
	//update cockpit	
	$update = "Vendor='".$tmpp."'";
}
else{
	$update = "Vendor=Null";
}
if(trim($vendor_details)){
	$tmpp = mysqli_real_escape_string($con, $vendor_details);
	$cols = $cols. "vendor_details,";
	$vals = $vals. "'".$tmpp."',";	
	//update cockpit	
	$update = "Vendordetails='".$tmpp."'";
}
else{
	$update = "Vendordetails=Null";
}
if(trim($invoice)){
	$tmpp = mysqli_real_escape_string($con, $invoice);
	$cols = $cols. "invoice,";
	$vals = $vals. "'".$tmpp."',";	
	//update cockpit	
	$update = "Invoice='".$tmpp."'";
}
else{
	$update = "Invoice=Null";
}
if(trim($reference)){
	$tmpp = mysqli_real_escape_string($con, $reference);
	$cols = $cols. "Reference,";
	$vals = $vals. "'".$tmpp."',";	
	//update cockpit	
	$update = "Reference='".$tmpp."'";
}
else{
	$update = "Reference=Null";
}
if(trim($currency)){
	$tmpp = mysqli_real_escape_string($con, $currency);
	$cols = $cols. "Currency,";
	$vals = $vals. "'".$tmpp."',";	
	//update cockpit	
	$update = "Currency='".$tmpp."'";
}
else{
	$update = "Currency=Null";
}
if(trim($gross)){
	$tmpp = mysqli_real_escape_string($con, $gross);
	$cols = $cols. "Gross,";
	$vals = $vals. "'".$tmpp."',";	
	//update cockpit	
	$update = "Grossamount='".$tmpp."'";
}
else{
	$update = "Grossamount=Null";
}
if(trim($net_amount)){
	$tmpp = mysqli_real_escape_string($con, $net_amount);
	$cols = $cols. "net_amount,";
	$vals = $vals. "'".$tmpp."',";	
	//update cockpit	
	$update = "Netamount='".$tmpp."'";
}
else{
	$update = "Netamount=Null";
}
if(trim($text1)){
	$tmpp = mysqli_real_escape_string($con, $text1);
	$cols = $cols. "Text1,";
	$vals = $vals. "'".$tmpp."',";	
	//update cockpit	
	$update = "Text1='".$tmpp."'";
}
else{
	$update = "Text1=Null";
}
if(trim($text2)){
	$tmpp = mysqli_real_escape_string($con, $text2);
	$cols = $cols. "Text2,";
	$vals = $vals. "'".$tmpp."',";	
	//update cockpit	
	$update = "Text2='".$tmpp."'";
}
else{
	$update = "Text2=Null";
}
if(trim($bpo)){
	$tmpp = mysqli_real_escape_string($con, $bpo);
	$cols = $cols. "BPO,";
	$vals = $vals. "'".$tmpp."',";	
}
if(trim($cost_center)){
	$tmpp = mysqli_real_escape_string($con, $cost_center);
	$cols = $cols. "cost_centre,";
	$vals = $vals. "'".$tmpp."',";	
}
if(trim($profit_center)){
	$tmpp = mysqli_real_escape_string($con, $profit_center);
	$cols = $cols. "profit_centre,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($profit_per)){
	$tmpp = mysqli_real_escape_string($con, $profit_per);
	$cols = $cols. "profit_per_material,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($procurer)){
	$tmpp = mysqli_real_escape_string($con, $procurer);
	$cols = $cols. "procurer,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($ap_comment)){
	$tmpp = mysqli_real_escape_string($con, $ap_comment);
	$cols = $cols. "ap_comments,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($approver)){
	$tmpp = mysqli_real_escape_string($con, $approver);
	$cols = $cols. "approver,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($type)){
	$tmpp = mysqli_real_escape_string($con, $type);
	$cols = $cols. "dc_type,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($customer_no)){
	$tmpp = mysqli_real_escape_string($con, $customer_no);
	$cols = $cols. "costumer_no,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($air_sea)){
	$tmpp = mysqli_real_escape_string($con, $air_sea);
	$cols = $cols. "air_sea,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($hawb)){
	$tmpp = mysqli_real_escape_string($con, $hawb);
	$cols = $cols. "hawb,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($io)){
	$tmpp = mysqli_real_escape_string($con, $io);
	$cols = $cols. "io_type,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($shipper)){
	$tmpp = mysqli_real_escape_string($con, $shipper);
	$cols = $cols. "shipper,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($gross_weight)){
	$tmpp = mysqli_real_escape_string($con, $gross_weight);
	$cols = $cols. "gross_weight,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($departure)){
	$tmpp = mysqli_real_escape_string($con, $departure);
	$cols = $cols. "departure,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($destination)){
	$tmpp = mysqli_real_escape_string($con, $destination);
	$cols = $cols. "destination,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($po_ref)){
	$tmpp = mysqli_real_escape_string($con, $po_ref);
	$cols = $cols. "po_ref,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($consignee)){
	$tmpp = mysqli_real_escape_string($con, $consignee);
	$cols = $cols. "Consignee,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($ap_posted)){
	$tmpp = mysqli_real_escape_string($con, $ap_posted);
	$cols = $cols. "ap_posted,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($posted_date)){
	$tmpp = mysqli_real_escape_string($con, $posted_date);
	$cols = $cols. "posted_date,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($due_date)){
	$tmpp = mysqli_real_escape_string($con, $due_date);
	$cols = $cols. "DueDate,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($cockpit)){
	$tmpp = mysqli_real_escape_string($con, $cockpit);
	$cols = $cols. "cockpit_data,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($delegated_by)){
	$tmpp = mysqli_real_escape_string($con, $delegated_by);
	$cols = $cols. "delegated_by,";
	$vals = $vals. "'".$tmpp."',";	
}

if(trim($has_id)){
	$tmpp = mysqli_real_escape_string($con, $has_id);
	$cols = $cols. "fd_id,";
	$vals = $vals. "'".$tmpp."',";	
}


$query = "Insert into final_data ({$cols}uploaded,uploader) values ({$vals}Now(),'{$_SESSION['pfreight_userid']}') ";
mysqli_query($con,$query);
$tmpid = mysqli_insert_id($con);
$query1 = "Update cockpit set finalize='{$tmpid}' where c_id='{$cockpit}' limit 1 ";
mysqli_query($con,$query1);
//echo $query."<br>";

mysqli_close($con);
?>
<script language="javascript" type="text/javascript">
top.alert("Data Successfully Finalized!");
top.location.reload();</script>