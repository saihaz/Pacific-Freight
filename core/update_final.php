<?php
session_start();
$con=mysqli_connect("localhost","root","","pacific_freight");

$update =  "";
$data =  $_POST['iddata'];
//$pk = "";

$orapproval = "";
$orapprover = "";
$orappname = "";
$orapprovec = "";

$approval = $_POST['approval'];
$approver = $_POST['approver'];
$approvec = $_POST['approvec'];

// additionals

$orcocd = "";
$ordocno = "";
$ordocdate = "";
$orvendor_no = "";
$orvendor_details = "";
$orinvoice = "";
$orReference = "";
$orCurrency = "";
$orGross = "";
$ornet_amount = "";
$orText1 = "";
$ortext2 = "";
$orBPO = "";
$orcost_centre = "";
$orprofit_centre = "";
$orprofit_per_material = "";
$orprocurer = "";
$orap_comments = "";
$ordc_type = "";
$orcostumer_no = "";
$orair_sea = "";
$orhawb = "";
$orshipper = "";
$orgross_weight = "";
$ordeparture = "";
$ordestination = "";
$orpo_ref = "";
$orConsignee = "";
$orap_posted = "";
$orposted_date = "";

$cocd = "";
$docno = "";
$docdate = "";
$vendor_no = "";
$vendor_details = "";
$invoice = "";
$Reference = "";
$Currency = "";
$Gross = "";
$net_amount = "";
$Text1 = "";
$text2 = "";
$BPO = "";
$cost_centre = "";
$profit_centre = "";
$profit_per_material = "";
$procurer = "";
$ap_comments = "";
$dc_type = "";
$costumer_no = "";
$air_sea = "";
$hawb = "";
$shipper = "";
$gross_weight = "";
$departure = "";
$destination = "";
$po_ref = "";
$Consignee = "";
$ap_posted = "";
$posted_date = "";

if(isset($_POST['cocd'])){
	$cocd = $_POST['cocd'];
}
if(isset($_POST['docno'])){
	$docno = $_POST['docno'];
}
if(isset($_POST['docdate'])){
	$docdate = $_POST['docdate'];
}
if(isset($_POST['vendor_no'])){
	$vendor_no = $_POST['vendor_no'];
}
if(isset($_POST['vendor_details'])){
	$vendor_details = $_POST['vendor_details'];
}
if(isset($_POST['invoice'])){
	$invoice = $_POST['invoice'];
}
if(isset($_POST['Reference'])){
	$Reference = $_POST['Reference'];
}
if(isset($_POST['Currency'])){
	$Currency = $_POST['Currency'];
}
if(isset($_POST['Gross'])){
	$Gross = $_POST['Gross'];
}
if(isset($_POST['net_amount'])){
	$net_amount = $_POST['net_amount'];
}
if(isset($_POST['Text1'])){
	$Text1 = $_POST['Text1'];
}
if(isset($_POST['text2'])){
	$text2 = $_POST['text2'];
}
if(isset($_POST['BPO'])){
	$BPO = $_POST['BPO'];
}
if(isset($_POST['cost_centre'])){
	$cost_centre = $_POST['cost_centre'];
}
if(isset($_POST['profit_centre'])){
	$profit_centre = $_POST['profit_centre'];
}
if(isset($_POST['profit_per_material'])){
	$profit_per_material = $_POST['profit_per_material'];
}
if(isset($_POST['procurer'])){
	$procurer = $_POST['procurer'];
}
if(isset($_POST['ap_comments'])){
	$ap_comments = $_POST['ap_comments'];
}
if(isset($_POST['dc_type'])){
	$dc_type = $_POST['dc_type'];
}
if(isset($_POST['costumer_no'])){
	$costumer_no = $_POST['costumer_no'];
}
if(isset($_POST['air_sea'])){
	$air_sea = $_POST['air_sea'];
}
if(isset($_POST['hawb'])){
	$hawb = $_POST['hawb'];
}
if(isset($_POST['shipper'])){
	$shipper = $_POST['shipper'];
}
if(isset($_POST['gross_weight'])){
	$gross_weight = $_POST['gross_weight'];
}
if(isset($_POST['departure'])){
	$departure = $_POST['departure'];
}
if(isset($_POST['destination'])){
	$destination = $_POST['destination'];
}
if(isset($_POST['po_ref'])){
	$po_ref = $_POST['po_ref'];
}
if(isset($_POST['Consignee'])){
	$Consignee = $_POST['Consignee'];
}
if(isset($_POST['ap_posted'])){
	$ap_posted = $_POST['ap_posted'];
}
if(isset($_POST['posted_date'])){
	$posted_date = $_POST['posted_date'];
}


$query = "SELECT * FROM final_data
 left join(SELECT approver_id as aid2, fname as fname2, lname as lname2 FROM approver) as t2 on t2.aid2=final_data.approver
 WHERE fd_id='{$data}'";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	$answer = mysqli_fetch_array($result);
	$orapproval = $answer['approval'];
	$orapprover = $answer['approver'];
	$orappname = $answer['fname2']." ".$answer['lname2'];
	$orapprovec = $answer['approval_comment'];

	$orcocd = $answer['cocd'];
	$ordocno = $answer['docno'];
	$ordocdate = $answer['docdate'];
	$orvendor_no = $answer['vendor_no'];
	$orvendor_details = $answer['vendor_details'];
	$orinvoice = $answer['invoice'];
	$orReference = $answer['Reference'];
	$orCurrency = $answer['Currency'];
	$orGross =$answer['Gross'];
	$ornet_amount = $answer['net_amount'];
	$orText1 = $answer['Text1'];
	$ortext2 = $answer['text2'];
	$orBPO = $answer['BPO'];
	$orcost_centre = $answer['cost_centre'];
	$orprofit_centre = $answer['profit_centre'];
	$orprofit_per_material = $answer['profit_per_material'];
	$orprocurer = $answer['procurer'];
	$orap_comments = $answer['ap_comments'];
	$ordc_type = $answer['dc_type'];
	$orcostumer_no = $answer['costumer_no'];
	$orair_sea =$answer['air_sea'];
	$orhawb = $answer['hawb'];
	$orshipper =  $answer['shipper'];
	$orgross_weight = $answer['gross_weight'];
	$ordeparture = $answer['departure'];
	$ordestination = $answer['destination'];
	$orpo_ref = $answer['po_ref'];
	$orConsignee = $answer['Consignee'];
	$orap_posted = $answer['ap_posted'];
	$orposted_date = $answer['posted_date'];
}
mysqli_free_result($result);

//compare
$action = "";
$old_value = "";
/////////////////////////
if($approval != $orapproval){
	$action = $action . "|Approval";
	if(trim($orapprover)){
		$old_value = $old_value . "|{$orapproval}";
	}
	else{
		$old_value = $old_value . "|<blank approval>";
	}
}
//////////////////////////
if($approver != $orapprover){
	$action = $action . "|Approver";
	if(trim($orapprover)){
		$old_value = $old_value . "|{$orappname}";
		//delegation		
		$dequery = "SELECT fname, lname from users where user_id='{$_SESSION['pfreight_userid']}'";
		$deresult = mysqli_query($con,$dequery);
		$delegator = "";
		if(mysqli_num_rows($deresult)>0){
			$deanswer = mysqli_fetch_array($deresult);
			$delegator = $deanswer['fname']." ".$deanswer['lname'];
		}
		mysqli_free_result($deresult);
		$approver_mail = "";
		$approver_name = "";
		$amquery = "Select * from approver where approver_id='{$approver}' ";
		$amresult = mysqli_query($con,$amquery);
		if(mysqli_num_rows($amresult)>0){
			$amanswer = mysqli_fetch_array($amresult);

			$approver_mail = $amanswer['email'];
			$approver_name = $amanswer['fname'];
		}
		mysqli_free_result($amresult);
		if(trim($approver_mail)==false){
			$approver_mail = "Denver.Encinas@schneider-electric.com";
		}

		$from = "freight.automail@donot.reply";
		$to = $approver_mail;
		$subject = "Freight Automail Delegation Alert";
		$smsg =  "Hi {$approver_name},<br><br>
		Good Day!<br><br>
		You have been delegated to process Doc No: <strong>{$ordocno}</strong> by {$delegator}<br><br><br>
		<h5>***Note:This is a system generated mail. Please don't hesitate to send a reply email to Denver Encinas<br> 
		should you have questions and/or clarifications regarding with your approvals.</h5> 
		";
		//echo $smsg."-----------------------------------<br>";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// More headers
		$headers .= 'From: '.$from. "\r\n";

		mail($to,$subject,$smsg,$headers);

	}
	else{
		$old_value = $old_value . "|<blank approver>";
	}
}
if($approvec != $orapprovec){
	$action = $action . "|Approver Comments";
	if(trim($orapprover)){
		$old_value = $old_value . "|{$orapprovec}";
	}
	else{
		$old_value = $old_value . "|<blank approver comment>";
	}
}
//------------
if($cocd != $orcocd){
	$action = $action . "|Cocd";
	if(trim($orcocd)){
		$old_value = $old_value . "|{$orcocd}";
	}
	else{
		$old_value = $old_value . "|<blank CoCd>";
	}
}
if($docno != $ordocno){
	$action = $action . "|DocNo";
	if(trim($ordocno)){
		$old_value = $old_value . "|{$ordocno}";
	}
	else{
		$old_value = $old_value . "|<blank DocNo>";
	}
}
if($docdate != $ordocdate){
	$action = $action . "|DocDate";
	if(trim($ordocdate)){
		$old_value = $old_value . "|{$ordocdate}";
	}
	else{
		$old_value = $old_value . "|<blank DocDate>";
	}
}
if($vendor_no != $orvendor_no){
	$action = $action . "|VendorNo";
	if(trim($orvendor_no)){
		$old_value = $old_value . "|{$orvendor_no}";
	}
	else{
		$old_value = $old_value . "|<blank VendorNo>";
	}
}
if($vendor_details != $orvendor_details){
	$action = $action . "|Vendor Details";
	if(trim($orvendor_details)){
		$old_value = $old_value . "|{$orvendor_details}";
	}
	else{
		$old_value = $old_value . "|<blank Vendor Details>";
	}
}
if($invoice != $orinvoice){
	$action = $action . "|Invoice";
	if(trim($orinvoice)){
		$old_value = $old_value . "|{$orinvoice}";
	}
	else{
		$old_value = $old_value . "|<blank Invoice>";
	}
}
if($Reference != $orReference){
	$action = $action . "|Reference";
	if(trim($orReference)){
		$old_value = $old_value . "|{$orReference}";
	}
	else{
		$old_value = $old_value . "|<blank Reference>";
	}
}
if($Currency != $orCurrency){
	$action = $action . "|Currency";
	if(trim($orCurrency)){
		$old_value = $old_value . "|{$orCurrency}";
	}
	else{
		$old_value = $old_value . "|<blank Currency>";
	}
}
if($Gross != $orGross){
	$action = $action . "|Gross";
	if(trim($orGross)){
		$old_value = $old_value . "|{$orGross}";
	}
	else{
		$old_value = $old_value . "|<blank Gross>";
	}
}
if($net_amount != $ornet_amount){
	$action = $action . "|Net Amount";
	if(trim($ornet_amount)){
		$old_value = $old_value . "|{$ornet_amount}";
	}
	else{
		$old_value = $old_value . "|<blank Net Amount>";
	}
}
if($Text1 != $orText1){
	$action = $action . "|Text1";
	if(trim($orText1)){
		$old_value = $old_value . "|{$orText1}";
	}
	else{
		$old_value = $old_value . "|<blank Text1>";
	}
}
if($text2 != $ortext2){
	$action = $action . "|Text2";
	if(trim($ortext2)){
		$old_value = $old_value . "|{$ortext2}";
	}
	else{
		$old_value = $old_value . "|<blank Text2>";
	}
}
if($BPO != $orBPO){
	$action = $action . "|BPO";
	if(trim($orBPO)){
		$old_value = $old_value . "|{$orBPO}";
	}
	else{
		$old_value = $old_value . "|<blank BPO>";
	}
}
if($cost_centre != $orcost_centre){
	$action = $action . "|Cost Centre";
	if(trim($orcost_centre)){
		$old_value = $old_value . "|{$orcost_centre}";
	}
	else{
		$old_value = $old_value . "|<blank Cost Centre>";
	}
}
if($profit_centre != $orprofit_centre){
	$action = $action . "|Profit Centre";
	if(trim($orprofit_centre)){
		$old_value = $old_value . "|{$orprofit_centre}";
	}
	else{
		$old_value = $old_value . "|<blank Profit Centre>";
	}
}
if($profit_per_material != $orprofit_per_material){
	$action = $action . "|Profit Per Material";
	if(trim($orprofit_per_material)){
		$old_value = $old_value . "|{$orprofit_per_material}";
	}
	else{
		$old_value = $old_value . "|<blank Profit Per Material>";
	}
}
if($procurer != $orprocurer){
	$action = $action . "|Procurer";
	if(trim($orprocurer)){
		$old_value = $old_value . "|{$orprocurer}";
	}
	else{
		$old_value = $old_value . "|<blank Procurer>";
	}
}
if($ap_comments != $orap_comments){
	$action = $action . "|AP Comments";
	if(trim($orap_comments)){
		$old_value = $old_value . "|{$orap_comments}";
	}
	else{
		$old_value = $old_value . "|<blank AP Comments>";
	}
}
if($costumer_no != $orcostumer_no){
	$action = $action . "|Costumer No";
	if(trim($orcostumer_no)){
		$old_value = $old_value . "|{$orcostumer_no}";
	}
	else{
		$old_value = $old_value . "|<blank Costumer No>";
	}
}
if($air_sea != $orair_sea){
	$action = $action . "|Air Sea";
	if(trim($orair_sea)){
		$old_value = $old_value . "|{$orair_sea}";
	}
	else{
		$old_value = $old_value . "|<blank Air Sea>";
	}
}
if($hawb != $orhawb){
	$action = $action . "|Hawb";
	if(trim($orhawb)){
		$old_value = $old_value . "|{$orhawb}";
	}
	else{
		$old_value = $old_value . "|<blank Hawb>";
	}
}
if($shipper != $orshipper){
	$action = $action . "|Shipper";
	if(trim($orshipper)){
		$old_value = $old_value . "|{$orshipper}";
	}
	else{
		$old_value = $old_value . "|<blank Shipper>";
	}
}
if($gross_weight != $orgross_weight){
	$action = $action . "|Gross Weight";
	if(trim($orgross_weight)){
		$old_value = $old_value . "|{$orgross_weight}";
	}
	else{
		$old_value = $old_value . "|<blank Gross Weight>";
	}
}
if($departure != $ordeparture){
	$action = $action . "|Departure";
	if(trim($ordeparture)){
		$old_value = $old_value . "|{$ordeparture}";
	}
	else{
		$old_value = $old_value . "|<blank Departure>";
	}
}
if($destination != $ordestination){
	$action = $action . "|Destination";
	if(trim($ordestination)){
		$old_value = $old_value . "|{$ordestination}";
	}
	else{
		$old_value = $old_value . "|<blank Destination>";
	}
}
if($po_ref != $orpo_ref){
	$action = $action . "|PO Ref";
	if(trim($orpo_ref)){
		$old_value = $old_value . "|{$orpo_ref}";
	}
	else{
		$old_value = $old_value . "|<blank PO Ref>";
	}
}
if($Consignee != $orConsignee){
	$action = $action . "|Consignee";
	if(trim($orConsignee)){
		$old_value = $old_value . "|{$orConsignee}";
	}
	else{
		$old_value = $old_value . "|<blank Consignee>";
	}
}
if($ap_posted != $orap_posted){
	$action = $action . "|AP Posted";
	if(trim($orap_posted)){
		$old_value = $old_value . "|{$orap_posted}";
	}
	else{
		$old_value = $old_value . "|<blank AP Posted>";
	}
}
if($posted_date != $orposted_date){
	$action = $action . "|Posted Date";
	if(trim($orposted_date)){
		$old_value = $old_value . "|{$orposted_date}";
	}
	else{
		$old_value = $old_value . "|<blank Posted Date>";
	}
}

if(trim($action) or trim($old_value)){
	if(trim($action)){
		$action = substr($action, 1);
	}
	if(trim($old_value)){
		$old_value = substr($old_value, 1);
	}
	$histquery = "INSERT INTO data_history (user,action,avalue,created,doc) VALUES ('{$_SESSION['pfreight_userid']}','{$action}','{$old_value}',Now(),'{$data}') ";
	echo $histquery;
	mysqli_query($con,$histquery);
}
//////////////
if(trim($approval)){
	$tmpp = mysqli_real_escape_string($con, $approval);
	$update = $update. "approval='{$tmpp}',";
}
else{
	$update = $update. "approval=Null,";
}
//////////
if(trim($approver)){
	$tmpp = mysqli_real_escape_string($con, $approver);
	$update = $update. "approver='{$tmpp}',";
}
else{
	$update = $update. "approver=Null,";
}
if(trim($approvec)){
	$tmpp = mysqli_real_escape_string($con, $approvec);
	$update = $update. "approval_comment='{$tmpp}',";
}
else{
	$update = $update. "approval_comment=Null,";
}
//---------------
if(trim($cocd)){
	$tmpp = mysqli_real_escape_string($con, $cocd);
	$update = $update. "cocd='{$tmpp}',";
}
else{
	//$update = $update. "cocd=Null,";
}
if(trim($docno)){
	$tmpp = mysqli_real_escape_string($con, $docno);
	$update = $update. "docno='{$tmpp}',";
}
else{
	//$update = $update. "docno=Null,";
}
if(trim($docdate)){
	$tmpp = mysqli_real_escape_string($con, $docdate);
	$update = $update. "docdate='{$tmpp}',";
}
else{
	//$update = $update. "docdate=Null,";
}
if(trim($vendor_no)){
	$tmpp = mysqli_real_escape_string($con, $vendor_no);
	$update = $update. "vendor_no='{$tmpp}',";
}
else{
	//$update = $update. "vendor_no=Null,";
}
if(trim($vendor_details)){
	$tmpp = mysqli_real_escape_string($con, $vendor_details);
	$update = $update. "vendor_details='{$tmpp}',";
}
else{
	//$update = $update. "vendor_details=Null,";
}
if(trim($invoice)){
	$tmpp = mysqli_real_escape_string($con, $invoice);
	$update = $update. "invoice='{$tmpp}',";
}
else{
	//$update = $update. "invoice=Null,";
}
if(trim($Reference)){
	$tmpp = mysqli_real_escape_string($con, $Reference);
	$update = $update. "Reference='{$tmpp}',";
}
else{
	//$update = $update. "Reference=Null,";
}
if(trim($Currency)){
	$tmpp = mysqli_real_escape_string($con, $Currency);
	$update = $update. "Currency='{$tmpp}',";
}
else{
	//$update = $update. "Currency=Null,";
}
if(trim($Gross)){
	$tmpp = mysqli_real_escape_string($con, $Gross);
	$update = $update. "Gross='{$tmpp}',";
}
else{
	//$update = $update. "Gross=Null,";
}
if(trim($net_amount)){
	$tmpp = mysqli_real_escape_string($con, $net_amount);
	$update = $update. "net_amount='{$tmpp}',";
}
else{
	//$update = $update. "net_amount=Null,";
}
if(trim($Text1)){
	$tmpp = mysqli_real_escape_string($con, $Text1);
	$update = $update. "Text1='{$tmpp}',";
}
else{
	//$update = $update. "Text1=Null,";
}
if(trim($text2)){
	$tmpp = mysqli_real_escape_string($con, $text2);
	$update = $update. "text2='{$tmpp}',";
}
else{
	//$update = $update. "text2=Null,";
}
if(trim($BPO)){
	$tmpp = mysqli_real_escape_string($con, $BPO);
	$update = $update. "BPO='{$tmpp}',";
}
else{
	//$update = $update. "BPO=Null,";
}
if(trim($cost_centre)){
	$tmpp = mysqli_real_escape_string($con, $cost_centre);
	$update = $update. "cost_centre='{$tmpp}',";
}
else{
	//$update = $update. "cost_centre=Null,";
}
if(trim($profit_centre)){
	$tmpp = mysqli_real_escape_string($con, $profit_centre);
	$update = $update. "profit_centre='{$tmpp}',";
}
else{
	//$update = $update. "profit_centre=Null,";
}
if(trim($profit_per_material)){
	$tmpp = mysqli_real_escape_string($con, $profit_per_material);
	$update = $update. "profit_per_material='{$tmpp}',";
}
else{
	//$update = $update. "profit_per_material=Null,";
}
if(trim($procurer)){
	$tmpp = mysqli_real_escape_string($con, $procurer);
	$update = $update. "procurer='{$tmpp}',";
}
else{
	//$update = $update. "procurer=Null,";
}
if(trim($ap_comments)){
	$tmpp = mysqli_real_escape_string($con, $ap_comments);
	$update = $update. "ap_comments='{$tmpp}',";
}
else{
	//$update = $update. "ap_comments=Null,";
}
if(trim($dc_type)){
	$tmpp = mysqli_real_escape_string($con, $dc_type);
	$update = $update. "dc_type='{$tmpp}',";
}
else{
	//$update = $update. "dc_type=Null,";
}
if(trim($costumer_no)){
	$tmpp = mysqli_real_escape_string($con, $costumer_no);
	$update = $update. "costumer_no='{$tmpp}',";
}
else{
	//$update = $update. "costumer_no=Null,";
}
if(trim($air_sea)){
	$tmpp = mysqli_real_escape_string($con, $air_sea);
	$update = $update. "air_sea='{$tmpp}',";
}
else{
	//$update = $update. "air_sea=Null,";
}
if(trim($hawb)){
	$tmpp = mysqli_real_escape_string($con, $hawb);
	$update = $update. "hawb='{$tmpp}',";
}
else{
	//$update = $update. "hawb=Null,";
}
if(trim($shipper)){
	$tmpp = mysqli_real_escape_string($con, $shipper);
	$update = $update. "shipper='{$tmpp}',";
}
else{
	//$update = $update. "shipper=Null,";
}
if(trim($gross_weight)){
	$tmpp = mysqli_real_escape_string($con, $gross_weight);
	$update = $update. "gross_weight='{$tmpp}',";
}
else{
	//$update = $update. "gross_weight=Null,";
}
if(trim($departure)){
	$tmpp = mysqli_real_escape_string($con, $departure);
	$update = $update. "departure='{$tmpp}',";
}
else{
	//$update = $update. "departure=Null,";
}
if(trim($destination)){
	$tmpp = mysqli_real_escape_string($con, $destination);
	$update = $update. "destination='{$tmpp}',";
}
else{
	//$update = $update. "destination=Null,";
}
if(trim($po_ref)){
	$tmpp = mysqli_real_escape_string($con, $po_ref);
	$update = $update. "po_ref='{$tmpp}',";
}
else{
	//$update = $update. "po_ref=Null,";
}
if(trim($Consignee)){
	$tmpp = mysqli_real_escape_string($con, $Consignee);
	$update = $update. "Consignee='{$tmpp}',";
}
else{
	//$update = $update. "Consignee=Null,";
}
if(trim($ap_posted)){
	$tmpp = mysqli_real_escape_string($con, $ap_posted);
	$update = $update. "ap_posted='{$tmpp}',";
}
else{
	//$update = $update. "ap_posted=Null,";
}
if(trim($posted_date)){
	$tmpp = mysqli_real_escape_string($con, $posted_date);
	$update = $update. "posted_date='{$tmpp}',";
}
else{
	//$update = $update. "posted_date=Null,";
}


if(trim($update)){
	//$update = substr($update, 0, -1);
	$uquery = "Update final_data set {$update}updated=Now(), updated_by='{$_SESSION['pfreight_userid']}' where fd_id='{$data}' and lock_edit is null ";
	$pk = $uquery;
	echo $uquery;
	mysqli_query($con,$uquery);
}

mysqli_close($con);
?>
<script language="javascript" type="text/javascript">
top.alert("Data Changed");
top.location.reload();
</script>