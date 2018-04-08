<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
$mydoc = $_POST['mydoc'];
$query = "Select *,
(CASE when text2 = '' or text2 is null  then 'No PO Found on Invoice'
	else text2
END) as po_ref,
(CASE when Invoice = 'true' then 'Debit'
	when Invoice = 'false' then 'Credit'
	else ''
END) as atype,c2
 from cockpit
left join(Select Vendor as v1, BPO as bpo1 from all_charges1) as t1 on t1.v1 = cockpit.vendor
left join(Select costcentre as c2, doc as d2 from charges) as t2 on t2.d2 = cockpit.c_id 
left join(Select purchdoc as pd3, profit as p3, pc_name as pc3, prg_name as pn3 from po_data) as t3 on t3.pd3 = 
	(CASE when text2 = '' or text2 is null 
	then 'No PO Found on Invoice'
	else text2
	END)
where c_id = '{$mydoc}'";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	$answer = mysqli_fetch_array($result);
?>
<table class="table">
	<thead></thead>
	<tbody>
		<tr>
			<td>CoCd</td>
			<td><input type="text" name="accode" class="form-control" value="<?php echo $answer['CCode'];?>"></td>
		</tr>
		<tr>
			<td>Scan Date</td>
			<td><input type="date" name="ascdate" class="form-control" value="<?php echo $answer['Scandate'];?>"></td>
		</tr>
		<tr>
			<td>DocNo</td>
			<td><input type="text" name="adocno" class="form-control" value="<?php echo $answer['DocNo'];?>"></td>
		</tr>
		<tr>
			<td>Doc. Date</td>
			<td><input type="date" name="adocdate" class="form-control" value="<?php echo $answer['DocDate'];?>"></td>
		</tr>
		<tr>
			<td>Vendor</td>
			<td><input type="text" name="avendor" class="form-control" value="<?php echo $answer['Vendor'];?>"></td>
		</tr>
		<tr>
			<td>Vendor details</td>
			<td><input type="text" name="avendordetails" class="form-control" value="<?php echo $answer['Vendordetails'];?>"></td>
		</tr>
		<tr>
			<td>Invoice</td>
			<td><select name="ainvoice" class="form-control">
					<option value="">--------</option>
					<option value="true" <?php if($answer['Invoice']=="true") echo "Selected";?>>true</option>
					<option value="false" <?php if($answer['Invoice']=="false") echo "Selected";?>>false</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Reference</td>
			<td><input type="text" name="aref" class="form-control" value="<?php echo $answer['Reference'];?>"></td>
		</tr>
		<tr>
			<td>Currency</td>
			<td><input type="text" name="acur" class="form-control" value="<?php echo $answer['Currency'];?>"></td>
		</tr>
		<tr>
			<td>Gross</td>
			<td><input type="text" name="agros" class="form-control" value="<?php echo $answer['Grossamount'];?>"></td>
		</tr>
			<td>Net Amount</td>
			<td><input type="text" name="anetamt" class="form-control" value="<?php echo $answer['Netamount'];?>"></td>
		</tr>
		<tr>
			<td>Text</td>
			<td><input type="text" name="atext1" class="form-control" value="<?php echo $answer['Text1'];?>"></td>
		</tr>
		<tr>
		<tr>
			<td>PO</td>
			<td><input type="text" name="atext2" class="form-control" value="<?php echo $answer['Text2'];?>"></td>
		</tr>
		<tr>
			<th>Usual Charge / GL</th>
			<th>Charges : Amount</th>
		</tr>
<?php
	//charges
	$cquery = "Select gl, costcentre, value2, charge, amount from charges where doc = '{$mydoc}'";
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
			<td><input type="text" name="abpo" class="form-control" value="<?php echo $answer['bpo1'];?>"></td>
		</tr>
		<tr>
			<td>Cost Centre</td>
			<td><input type="text" name="acostc" class="form-control" value="<?php echo $answer['c2'];?>"></td>
		</tr>
		<tr>
			<td>Profit Centre</td>
			<td><input type="text" name="aprofitc" class="form-control" value="<?php echo $answer['p3'];?>"></td>
		</tr>
		<tr>
			<td>Profit Per Material</td>
			<td><input type="text" name="aprofitp" class="form-control" value="<?php echo $answer['pc3'];?>"></td>
		</tr>
		<tr>
			<td>Procurer</td>
			<td><input type="text" name="aprocurer" class="form-control" value="<?php echo $answer['pn3'];?>"></td>
		</tr>
		<tr>
			<td>AP Comments</td>
			<td><input type="text" name="aapcomment" class="form-control"></td>
		</tr>
		<tr>
			<td>Approval</td>
			<td><label>----</label></td>
		</tr>
		<tr>
			<td>Approver Name</td>
			<td><select name="aappname" class="form-control">
					<option value="">------------</option>
<?php
		$apquery = "Select *, concat(fname, ' ', lname) as fullname from approver";
		$apresult = mysqli_query($con,$apquery);
		if(mysqli_num_rows($apresult)>0){
			while($apanswer = mysqli_fetch_array($apresult)){
?>
					<option value="<?php echo $apanswer['approver_id']?>"><?php echo $apanswer['fullname']?></option>
<?php
			}

		}
		mysqli_free_result($apresult);
?>
			</td>
		</tr>
		<tr>
			<td>Approver Comment</td>
			<td><label>----</label></td>
		</tr>
		<tr>
			<td>Type</td>
			<td><select name="atype" class="form-control">
					<option value="" <?php if($answer['atype']=="") echo "Selected";?>>--------</option>
					<option value="Debit" <?php if($answer['atype']=="Debit") echo "Selected";?>>Debit</option>
					<option value="Credit" <?php if($answer['atype']=="Credit") echo "Selected";?>>Credit</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Costumer #</td>
			<td><input type="text" name="acustomerno" class="form-control"></td>
		</tr>
		<tr>
			<td>AIR/SEA</td>
			<td><input type="text" name="aairsea" class="form-control"></td>
		</tr>
		<tr>
			<td>HAWB</td>
			<td><input type="text" name="ahawb" class="form-control"></td>
		</tr>
		<tr>
			<td>OBL</td>
			<td><label>Not Useful</label></td>
		</tr>
		<tr>
			<td>Shipper</td>
			<td><input type="text" name="ashipper" class="form-control"></td>
		</tr>
		<tr>
			<td>Gross Weight</td>
			<td><input type="text" name="agross" class="form-control"></td>
		</tr>
		<tr>
			<td>Departure</td>
			<td><input type="text" name="adeparture" class="form-control"></td>
		</tr>
		<tr>
			<td>Destination</td>
			<td><input type="text" name="adestination" class="form-control"></td>
		</tr>
		<tr>
			<td>Departure Port / Airport</td>
			<td><label>unknown</label></td>
		</tr>
		<tr>
			<td>PO Ref</td>
			<td><input type="text" name="aporef" class="form-control" value="<?php echo $answer['po_ref'];?>"></td>
		</tr>
		<tr>
			<td>Consignee</td>
			<td><input type="text" name="aconsignee" class="form-control"></td>
		</tr>
		<tr>
			<td>AP Posted</td>
			<td><input type="text" name="aapposted" class="form-control"></td>
		</tr>
		<tr>
			<td>Posted Date</td>
			<td><input type="date" name="aposted" class="form-control"></td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="cockpit_data" value="<?php echo $mydoc;?>">
<input type="hidden" name="if_has_id" value="<?php echo $answer['finalize'];?>">
<?php
}
mysqli_close($con);
?>