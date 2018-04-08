<?php
$con=mysqli_connect("localhost","root","","pacific_freight");

//------------------------------- first send ---------------------------------------------
$approver_list = array();
$query = "SELECT distinct(approver) FROM `final_data` where (approval != 'Approved' or approval is NULL) and approval != 'Declined' and mail_sent is null";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	while ($answer = mysqli_fetch_row($result)) { 
		array_push($approver_list, $answer[0]);
	}
}
mysqli_free_result($result);

$max = count($approver_list);

//print_r($approver_list);

$table_list = array();

for ($i=0; $i < $max; $i++) { 
	$approver_name = "";
	$approver_mail = "";
	if(trim($approver_list[$i])){
		$approver_name = "";
		$approver_mail = "";
		$subquery = "SELECT * FROM final_data
		 LEFT JOIN (SELECT approver_id as ai, email, fname as fn2, lname as ln2 FROM approver) as t2 on t2.ai = final_data.approver
		 LEFT JOIN (SELECT approver_id as ai3, fname as fn3, lname as ln3 FROM approver) as t3 on t3.ai3 = final_data.delegated_by
		 WHERE (approval != 'Approved' or approval is NULL) and approval != 'Declined' AND mail_sent is NULL AND approver='{$approver_list[$i]}'";
		//echo $subquery."<br>";
		$subresult = mysqli_query($con,$subquery);
		if(mysqli_num_rows($subresult)>0){
			$tmptableinner = "";
			while($subanswer = mysqli_fetch_array($subresult)){
				$approver_name = $subanswer['fn2'];
				$approver_mail = $subanswer['email'];
				$tmptableinner = $tmptableinner . "
				<tr>
					<td>{$subanswer['docno']}</td>
					<td>{$subanswer['docdate']}</td>
					<td>{$subanswer['vendor_no']}</td>
					<td>{$subanswer['vendor_details']}</td>
					<td>{$subanswer['Reference']}</td>
					<td>{$subanswer['Currency']}</td>
					<td>{$subanswer['net_amount']}</td>
					<td>{$subanswer['DueDate']}</td>
					<td>{$subanswer['approval']}</td>
					<td>{$subanswer['fn3']} {$subanswer['ln3']}</td>
				</tr>
				";
			}
			$tmptable = "
			<table border='1'>
				<thead>
					<tr>
						<th>Doc No</th>
						<th>Doc Date</th>
						<th>Vendor No</th>
						<th>Vendor Name</th>
						<th>Reference</th>
						<th>Currency</th>
						<th>Net Amount</th>
						<th>Due Date</th>
						<th>Status</th>
						<th>Delegator</th>
					</tr>
				</thead>
				<tbody>
					{$tmptableinner}
				</tbody>
			</table>
			";
		}
		mysqli_free_result($subresult);
	}
	//if(trim($approver_mail)==false){
	//	$approver_mail = "Denver.Encinas@schneider-electric.com";
	//}
	//per approver - send
	if(trim($approver_mail)){

	$from = "freight.automail@donot.reply";
	$to = $approver_mail;
	$subject = "Freight Automail Alert";
	$smsg =  "Hi {$approver_name},<br><br>
	Good Day!<br><br>
	We would like to remind the list of your pending approval in the Freight Tool:{$tmptable}<br>
	All freight invoices for approval are now under strict deadline. Please ensure all invoices<br>
	that need your action should be approved before due date. If not actioned, payment will be delayed<br>
	and may result to shipment hold.<br><br><br>
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
}

$querystamp = "Update final_data set mail_sent='1', mail1 = Now() where (approval != 'Approved' or approval is NULL) and approval != 'Declined' and mail_sent is null";
echo $querystamp;
mysqli_query($con,$querystamp);

//-----------------------------------------------------------------------------------------


//------------------------------- second send ---------------------------------------------
$approver_list = array();
$query = "SELECT distinct(approver) FROM `final_data` where (approval != 'Approved' or approval is NULL) and approval != 'Declined' and mail_sent = '1' and DATEDIFF(Now(),mail1) > 6 ";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	while ($answer = mysqli_fetch_row($result)) {
		array_push($approver_list, $answer[0]);
	}
}
mysqli_free_result($result);

$max = count($approver_list);

//print_r($approver_list);

$table_list = array();

for ($i=0; $i < $max; $i++) { 
	$approver_name = "";
	$approver_mail = "";
	if(trim($approver_list[$i])){
		$approver_name = "";
		$approver_mail = "";
		$manager_mail = "";
		$subquery = "SELECT * FROM final_data
		 LEFT JOIN (SELECT approver_id as ai, email, manager_mail, fname as fn2, lname as ln2 FROM approver) as t2 on t2.ai = final_data.approver
		 LEFT JOIN (SELECT approver_id as ai3, fname as fn3, lname as ln3 FROM approver) as t3 on t3.ai3 = final_data.delegated_by
		 WHERE (approval != 'Approved' or approval is NULL) and approval != 'Declined' and mail_sent = '1' and DATEDIFF(Now(),mail1) > 6 and approver='{$approver_list[$i]}'";
		//echo $subquery."<br>";
		$subresult = mysqli_query($con,$subquery);
		if(mysqli_num_rows($subresult)>0){
			$tmptableinner = "";
			while($subanswer = mysqli_fetch_array($subresult)){
				$approver_name = $subanswer['fn2'];
				$approver_mail = $subanswer['email'];
				$manager_mail = $subanswer['manager_mail'];
				$tmptableinner = $tmptableinner . "
				<tr>
					<td>{$subanswer['docno']}</td>
					<td>{$subanswer['docdate']}</td>
					<td>{$subanswer['vendor_no']}</td>
					<td>{$subanswer['vendor_details']}</td>
					<td>{$subanswer['Reference']}</td>
					<td>{$subanswer['Currency']}</td>
					<td>{$subanswer['net_amount']}</td>
					<td>{$subanswer['DueDate']}</td>
					<td>{$subanswer['approval']}</td>
					<td>{$subanswer['fn3']} {$subanswer['ln3']}</td>
				</tr>
				";
			}
			$tmptable = "
			<table border='1'>
				<thead>
					<tr>
						<th>Doc No</th>
						<th>Doc Date</th>
						<th>Vendor No</th>
						<th>Vendor Name</th>
						<th>Reference</th>
						<th>Currency</th>
						<th>Net Amount</th>
						<th>Due Date</th>
						<th>Status</th>
						<th>Delegator</th>
					</tr>
				</thead>
				<tbody>
					{$tmptableinner}
				</tbody>
			</table>
			";
		}
		mysqli_free_result($subresult);
	}
	//if(trim($approver_mail)==false){
	//	$approver_mail = "Denver.Encinas@schneider-electric.com";
	//}
	//per approver - send

	if(trim($approver_mail)){

	$from = "freight.automail@donot.reply";
	$to = $approver_mail;
	$subject = "Freight Automail Alert [2nd Follow Up]";
	$smsg =  "Hi {$approver_name},<br><br>
	Good Day!<br><br>
	We would like to remind the list of your pending approval in the Freight Tool:{$tmptable}<br>
	All freight invoices for approval are now under strict deadline. Please ensure all invoices<br>
	that need your action should be approved before due date. If not actioned, payment will be delayed<br>
	and may result to shipment hold.<br><br><br>
	<h5>***Note:This is a system generated mail. Please don't hesitate to send a reply email to Denver Encinas<br> 
	should you have questions and/or clarifications regarding with your approvals.</h5> 
	";
	//echo $smsg."-----------------------------------<br>";
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	// More headers
	$headers .= 'From: '.$from. "\r\n";
	if(trim($manager_mail)){
		$headers .= 'Cc: ' . $manager_mail . "\r\n";
	}

	mail($to,$subject,$smsg,$headers);

	}

}

$querystamp = "Update final_data set mail_sent='2', mail2 = Now() where (approval != 'Approved' or approval is NULL) and approval != 'Declined' and mail_sent = '1' and DATEDIFF(Now(),mail1) > 6 ";
echo $querystamp;
mysqli_query($con,$querystamp);

//-----------------------------------------------------------------------------------


//------------------------------- third send ---------------------------------------------
$approver_list = array();
$query = "SELECT distinct(approver) FROM `final_data` where (approval != 'Approved' or approval is NULL) and approval != 'Declined' and mail_sent = '2' and DATEDIFF(Now(),mail2) > 6 ";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	while ($answer = mysqli_fetch_row($result)) {
		array_push($approver_list, $answer[0]);
	}
}
mysqli_free_result($result);

$max = count($approver_list);

//print_r($approver_list);

$table_list = array();

for ($i=0; $i < $max; $i++) { 
	$approver_name = "";
	$approver_mail = "";
	if(trim($approver_list[$i])){
		$approver_name = "";
		$approver_mail = "";
		$manager_mail = "";
		$manager2_mail = "";
		$subquery = "SELECT * FROM final_data
		 LEFT JOIN (SELECT approver_id as ai, email, manager_mail, manager2_email, fname as fn2, lname as ln2 FROM approver) as t2 on t2.ai = final_data.approver
		 LEFT JOIN (SELECT approver_id as ai3, fname as fn3, lname as ln3 FROM approver) as t3 on t3.ai3 = final_data.delegated_by
		 WHERE (approval != 'Approved' or approval is NULL) and approval != 'Declined' and mail_sent = '2' and DATEDIFF(Now(),mail2) > 6 and approver='{$approver_list[$i]}'";
		//echo $subquery."<br>";
		$subresult = mysqli_query($con,$subquery);
		if(mysqli_num_rows($subresult)>0){
			$tmptableinner = "";
			while($subanswer = mysqli_fetch_array($subresult)){
				$approver_name = $subanswer['fn2'];
				$approver_mail = $subanswer['email'];
				$manager_mail = $subanswer['manager_mail'];
				$manager2_mail = $subanswer['manager2_email'];
				$tmptableinner = $tmptableinner . "
				<tr>
					<td>{$subanswer['docno']}</td>
					<td>{$subanswer['docdate']}</td>
					<td>{$subanswer['vendor_no']}</td>
					<td>{$subanswer['vendor_details']}</td>
					<td>{$subanswer['Reference']}</td>
					<td>{$subanswer['Currency']}</td>
					<td>{$subanswer['net_amount']}</td>
					<td>{$subanswer['DueDate']}</td>
					<td>{$subanswer['approval']}</td>
					<td>{$subanswer['fn3']} {$subanswer['ln3']}</td>
				</tr>
				";
			}
			$tmptable = "
			<table border='1'>
				<thead>
					<tr>
						<th>Doc No</th>
						<th>Doc Date</th>
						<th>Vendor No</th>
						<th>Vendor Name</th>
						<th>Reference</th>
						<th>Currency</th>
						<th>Net Amount</th>
						<th>Due Date</th>
						<th>Status</th>
						<th>Delegator</th>
					</tr>
				</thead>
				<tbody>
					{$tmptableinner}
				</tbody>
			</table>
			";
		}
		mysqli_free_result($subresult);
	}
	//if(trim($approver_mail)==false){
	//	$approver_mail = "Denver.Encinas@schneider-electric.com";
	//}
	//per approver - send

	if(trim($approver_mail)){

	$from = "freight.automail@donot.reply";
	$to = $approver_mail;
	$subject = "Freight Automail Alert [3nd Follow Up]";
	$smsg =  "Hi {$approver_name},<br><br>
	Good Day!<br><br>
	We would like to remind the list of your pending approval in the Freight Tool:{$tmptable}<br>
	All freight invoices for approval are now under strict deadline. Please ensure all invoices<br>
	that need your action should be approved before due date. If not actioned, payment will be delayed<br>
	and may result to shipment hold.<br><br><br>
	<h5>***Note:This is a system generated mail. Please don't hesitate to send a reply email to Denver Encinas<br> 
	should you have questions and/or clarifications regarding with your approvals.</h5> 
	";
	//echo $smsg."-----------------------------------<br>";
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	// More headers
	$headers .= 'From: '.$from. "\r\n";
	$cc = "";
	if(trim($manager_mail)){
		$cc = $cc . "," . $manager_mail;
	}
	if(trim($manager2_mail)){
		$cc = $cc . "," . $manager2_mail;
	}
	if(trim($cc)){
		$cc = substr($cc, 1);
		$headers .= 'Cc: ' . $cc . "\r\n";
		echo $headers;
	}

	mail($to,$subject,$smsg,$headers);

	}

}

$querystamp = "Update final_data set mail_sent='3', mail3 = Now() where (approval != 'Approved' or approval is NULL) and approval != 'Declined' and mail_sent = '2' and DATEDIFF(Now(),mail2) > 6 ";
echo $querystamp;
mysqli_query($con,$querystamp);

//-----------------------------------------------------------------------------------



mysqli_close($con);
?>
<script>
	alert("Mail Successfully Sent!");
</script>