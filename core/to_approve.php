<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
$mydoc = $_POST['mydoc'];
$datac = 0;
$query = "Select * from final_data left join
(Select approver_id as appid, concat(fname,' ',lname) as fullname from approver) as t1 on t1.appid=final_data.approver
where fd_id = '{$mydoc}' and lock_edit is null";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	$answer = mysqli_fetch_array($result);
	$datac = $answer['cockpit_data'];
?>
<table class="table">
	<thead></thead>
	<tbody>
		<tr>
			<td>CoCd</td>
			<td><label><?php echo $answer['cocd'];?></label></td>
		</tr>
		<tr>
			<td>Scan Date</td>
			<td><label><?php echo $answer['scandate'];?></label></td>
		</tr>
		<tr>
			<td>DocNo</td>
			<td><label><?php echo $answer['docno'];?></label></td>
		</tr>
		<tr>
			<td>Doc. Date</td>
			<td><label><?php echo $answer['docdate'];?></label></td>
		</tr>
		<tr>
			<td>Vendor</td>
			<td><label><?php echo $answer['vendor_no'];?></label></td>
		</tr>
		<tr>
			<td>Vendor details</td>
			<td><label><?php echo $answer['vendor_details'];?></label></td>
		</tr>
		<tr>
			<td>Invoice</td>
			<td><label><?php echo $answer['invoice'];?></label></td>
		</tr>
		<tr>
			<td>Reference</td>
			<td><label><?php echo $answer['Reference'];?></label></td>
		</tr>
		<tr>
			<td>Crcy</td>
			<td><label><?php echo $answer['Currency'];?></label></td>
		</tr>
		<tr>
			<td>Gross</td>
			<td><label><?php echo $answer['Gross'];?></label></td>
		</tr>
			<td>Net Amount</td>
			<td><label><?php echo $answer['net_amount'];?></label></td>
		</tr>
		<tr>
			<td>Text</td>
			<td><label><?php echo $answer['Text1'];?></label></td>
		</tr>
		<tr>
		<tr>
			<td>PO</td>
			<td><label><?php echo $answer['text2'];?></label></td>
		</tr>
		<tr>
			<th>Usual Charge / GL</th>
			<th>Charges : Amount</th>
		</tr>
<?php
	//charges
	$cquery = "Select gl, costcentre, value2, charge, amount from charges where doc = '{$datac}'";
	$cresult = mysqli_query($con,$cquery);
	if(mysqli_num_rows($cresult)>0){
		$coun = 1;
		while ($canswer = mysqli_fetch_array($cresult)) {
?>
		<tr>
			<td><?php echo $canswer['value2']." / ".$canswer['gl'] ?></td>
			<td><?php echo $canswer['charge']." : ".$canswer['amount'];?></td>
		</tr>
<?php
			$coun ++;
		}
	}
	mysqli_free_result($cresult);
?>
		<tr>
			<td colspan="2"><hr></td>
		</tr>
		<tr>
			<td>BPO</td>
			<td><label><?php echo $answer['BPO'];?></label></td>
		</tr>
		<tr>
			<td>Cost Centre</td>
			<td><label><?php echo $answer['cost_centre'];?></label></td>
		</tr>
		<tr>
			<td>Profit Centre</td>
			<td><label><?php echo $answer['profit_centre'];?></label></td>
		</tr>
		<tr>
			<td>Profit Per Material</td>
			<td><label><?php echo $answer['profit_per_material'];?></label></td>
		</tr>
		<tr>
			<td>Procurer</td>
			<td><label><?php echo $answer['procurer'];?></label></td>
		</tr>
		<tr>
			<td>AP Comments</td>
			<td><label><?php echo $answer['ap_comments'];?></label></td>
		</tr>
		<tr>
			<td>Approval</td>
			<td>
				<select class="form-control" name="approval">
					<option value="">-----------</option>
					<option <?php if($answer['approval']=="Approved"){ echo "Selected";}?>>Approved</option>
					<option <?php if($answer['approval']=="Declined"){ echo "Selected";}?>>Declined</option>
					<option <?php if($answer['approval']=="Hold"){ echo "Selected";}?>>Hold</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Approver Name</td>
			<td><select class="form-control" name="approver">
					<option>----------</option>
<?php
		$apquery = "Select *, concat(fname, ' ', lname) as fullname from approver";
		$apresult = mysqli_query($con,$apquery);
		if(mysqli_num_rows($apresult)>0){
			while($apanswer = mysqli_fetch_array($apresult)){
?>
					<option value="<?php echo $apanswer['approver_id'];?>" 
						<?php if($apanswer['approver_id']==$answer['approver']){ echo "Selected";}?>><?php echo $apanswer['fullname']?></option>
<?php
			}

		}
		mysqli_free_result($apresult);
?>
				</select></td>
		</tr>
		<tr>
			<td>Approver's Comment</td>
			<td><textarea class="form-control" name="approvec"><?php echo $answer['approval_comment'];?></textarea></td>
		</tr>
		<tr>
			<td>Type</td>
			<td><label><?php echo $answer['dc_type'];?></label></td>
		</tr>
		<tr>
			<td>Costumer #</td>
			<td><label><?php echo $answer['costumer_no'];?></label></td>
		</tr>
		<tr>
			<td>Mode of Shipment</td>
			<td><label><?php echo $answer['air_sea'];?></label></td>
		</tr>
		<tr>
			<td>HAWB/BL Reference</td>
			<td><label><?php echo $answer['hawb'];?></label></td>
		</tr>
		<tr>
			<td>Shipper</td>
			<td><label><?php echo $answer['shipper'];?></label></td>
		</tr>
		<tr>
			<td>Gross Weight</td>
			<td><label><?php echo $answer['gross_weight'];?></label></td>
		</tr>
		<tr>
			<td>Departure</td>
			<td><label><?php echo $answer['departure'];?></label></td>
		</tr>
		<tr>
			<td>Destination</td>
			<td><label><?php echo $answer['destination'];?></label></td>
		</tr>
		<tr>
			<td>PO Ref</td>
			<td><label><?php echo $answer['po_ref'];?></label></td>
		</tr>
		<tr>
			<td>Consignee</td>
			<td><label><?php echo $answer['Consignee'];?></label></td>
		</tr>
		<tr>
			<td>Posted Date</td>
			<td><label><?php echo $answer['posted_date'];?></label></td>
		</tr>
	</tbody>
</table>
<?php
}
else{
?>
	<h1>Locked Data</h1>
<?php
}
mysqli_free_result($result);
mysqli_close($con);
?>
<input type="hidden" name="iddata" value="<?php echo $mydoc;?>">