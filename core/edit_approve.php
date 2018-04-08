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
			<td>
				<input type="text" class="form-control" name="cocd" value="<?php echo $answer['cocd'];?>">
			</td>
		</tr>
		<tr>
			<td>DocNo</td>
			<td>
				<input type="text" class="form-control" name="docno" value="<?php echo $answer['docno'];?>" disabled>
			</td>
		</tr>
		<tr>
			<td>Doc. Date</td>
			<td>
				<input type="date" class="form-control" name="docdate" value="<?php echo $answer['docdate'];?>" placeholder="yyyy-mm-dd">
			</td>
		</tr>
		<tr>
			<td>Vendor</td>
			<td>
				<input type="text" class="form-control" name="vendor_no" value="<?php echo $answer['vendor_no'];?>">
			</td>
		</tr>
		<tr>
			<td>Vendor details</td>
			<td>
				<input type="text" class="form-control" name="vendor_details" value="<?php echo $answer['vendor_details'];?>">
			</td>
		</tr>
		<tr>
			<td>Invoice</td>
			<td>
				<input type="text" class="form-control" name="invoice" value="<?php echo $answer['invoice'];?>">
			</td>
		</tr>
		<tr>
			<td>Reference</td>
			<td>
				<input type="text" class="form-control" name="Reference" value="<?php echo $answer['Reference'];?>">
			</td>
		</tr>
		<tr>
			<td>Crcy</td>
			<td>
				<input type="text" class="form-control" name="Currency" value="<?php echo $answer['Currency'];?>">
			</td>
		</tr>
		<tr>
			<td>Gross</td>
			<td>
				<input type="text" class="form-control" name="Gross" value="<?php echo $answer['Gross'];?>">
			</td>
		</tr>
			<td>Net Amount</td>
			<td>
				<input type="text" class="form-control" name="net_amount" value="<?php echo $answer['net_amount'];?>">
			</td>
		</tr>
		<tr>
			<td>Text</td>
			<td>
				<input type="text" class="form-control" name="Text1" value="<?php echo $answer['Text1'];?>">
			</td>
		</tr>
		<tr>
		<tr>
			<td>PO</td>
			<td>
				<input type="text" class="form-control" name="text2" value="<?php echo $answer['text2'];?>">
			</td>
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
			<td>
				<input type="text" class="form-control" name="BPO" value="<?php echo $answer['BPO'];?>">
			</td>
		</tr>
		<tr>
			<td>Cost Centre</td>
			<td>
				<input type="text" class="form-control" name="cost_centre" value="<?php echo $answer['cost_centre'];?>">
			</td>
		</tr>
		<tr>
			<td>Profit Centre</td>
			<td>
				<input type="text" class="form-control" name="profit_centre" value="<?php echo $answer['profit_centre'];?>">
			</td>
		</tr>
		<tr>
			<td>Profit Per Material</td>
			<td>
				<input type="text" class="form-control" name="profit_per_material" value="<?php echo $answer['profit_per_material'];?>">
			</td>
		</tr>
		<tr>
			<td>Procurer</td>
			<td>
				<input type="text" class="form-control" name="procurer" value="<?php echo $answer['procurer'];?>">
			</td>
		</tr>
		<tr>
			<td>AP Comments</td>
			<td>
				<textarea class="form-control" name="ap_comments"><?php echo $answer['ap_comments'];?></textarea>
			</td>
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
			<td>
				<input type="text" class="form-control" name="dc_type" value="<?php echo $answer['dc_type'];?>">
			</td>
		</tr>
		<tr>
			<td>Costumer #</td>
			<td>
				<input type="text" class="form-control" name="costumer_no" value="<?php echo $answer['costumer_no'];?>">
			</td>
		</tr>
		<tr>
			<td>Mode of Shipment</td>
			<td>
				<select class="form-control" name="air_sea">
					<option value="" <?php if(strtoupper($answer['air_sea'])==""){ echo "selected"; } ?>>----------</option>
					<option value="AIR" <?php if(strtoupper($answer['air_sea'])=="AIR"){ echo "selected"; } ?>>AIR</option>
					<option value="ROAD" <?php if(strtoupper($answer['air_sea'])=="ROAD"){ echo "selected"; } ?>>ROAD</option>
					<option value="SEA" <?php if(strtoupper($answer['air_sea'])=="SEA"){ echo "selected"; } ?>>SEA</option>
				</select>
				<!--<input type="text" class="form-control" name="air_sea" value="<?php echo $answer['air_sea'];?>">-->
			</td>
		</tr>
		<tr>
			<td>HAWB/BL Reference</td>
			<td>
				<input type="text" class="form-control" name="hawb" value="<?php echo $answer['hawb'];?>">
			</td>
		</tr>
		<tr>
			<td>Shipper</td>
			<td>
				<input type="text" class="form-control" name="shipper" value="<?php echo $answer['shipper'];?>">
			</td>
		</tr>
		<tr>
			<td>Gross Weight</td>
			<td>
				<input type="text" class="form-control" name="gross_weight" value="<?php echo $answer['gross_weight'];?>">
			</td>
		</tr>
		<tr>
			<td>Departure</td>
			<td>
				<input type="text" class="form-control" name="departure" value="<?php echo $answer['departure'];?>">
			</td>
		</tr>
		<tr>
			<td>Destination</td>
			<td>
				<input type="text" class="form-control" name="destination" value="<?php echo $answer['destination'];?>">
			</td>
		</tr>
		<tr>
			<td>PO Ref</td>
			<td>
				<input type="text" class="form-control" name="po_ref" value="<?php echo $answer['po_ref'];?>">
			</td>
		</tr>
		<tr>
			<td>Consignee</td>
			<td>
				<input type="text" class="form-control" name="Consignee" value="<?php echo $answer['Consignee'];?>">
			</td>
		</tr>
		<tr class="unseen">
			<td>AP Posted</td>
			<td>
				<input type="text" class="form-control" name="ap_posted" value="<?php echo $answer['ap_posted'];?>">
			</td>
		</tr>
		<tr>
			<td>Posted Date</td>
			<td>
				<input type="date" class="form-control" name="posted_date" value="<?php echo $answer['posted_date'];?>">
			</td>
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