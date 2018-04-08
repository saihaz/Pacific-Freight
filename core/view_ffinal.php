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
			<td><label><?php echo $answer['CCode'];?></label></td>
		</tr>
		<tr>
			<td>Scan Date</td>
			<td><label><?php echo $answer['Scandate'];?></label></td>
		</tr>
		<tr>
			<td>DocNo</td>
			<td><label><?php echo $answer['DocNo'];?></label></td>
		</tr>
		<tr>
			<td>Doc. Date</td>
			<td><label><?php echo $answer['DocDate'];?></label></td>
		</tr>
		<tr>
			<td>Vendor</td>
			<td><label><?php echo $answer['Vendor'];?></label></td>
		</tr>
		<tr>
			<td>Vendor details</td>
			<td><label><?php echo $answer['Vendordetails'];?></label></td>
		</tr>
		<tr>
			<td>Invoice</td>
			<td><label><?php echo $answer['Invoice'];?></label></td>
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
			<td><label><?php echo $answer['Grossamount'];?></label></td>
		</tr>
			<td>Net Amount</td>
			<td><label><?php echo $answer['Netamount'];?></label></td>
		</tr>
		<tr>
			<td>Text</td>
			<td><label><?php echo $answer['Text1'];?></label></td>
		</tr>
		<tr>
		<tr>
			<td>PO</td>
			<td><label><?php echo $answer['Text2'];?></label></td>
		</tr>
		<tr>
			<td>No</td>
			<td><label><?php echo $answer['DocNo'];?></label></td>
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
			<td><label><?php echo $answer['bpo1'];?></label></td>
		</tr>
		<tr>
			<td>Cost Centre</td>
			<td><label><?php echo $answer['c2'];?></label></td>
		</tr>
		<tr>
			<td>Profit Centre</td>
			<td><label><?php echo $answer['p3'];?></label></td>
		</tr>
		<tr>
			<td>Profit Per Material</td>
			<td><label><?php echo $answer['pc3'];?></label></td>
		</tr>
		<tr>
			<td>Procurer</td>
			<td><label><?php echo $answer['pn3'];?></label></td>
		</tr>
		<tr>
			<td>AP Comments</td>
			<td><label>Manual</label></td>
		</tr>
		<tr>
			<td>Approval</td>
			<td><label>Manual</label></td>
		</tr>
		<tr>
			<td>Approver Name</td>
			<td><label><?php echo $answer['DocNo'];?>/Approver</label></td>
		</tr>
		<tr>
			<td>Approver's Comment</td>
			<td><label>Manual</label></td>
		</tr>
		<tr>
			<td>Type</td>
			<td><label><?php echo $answer['atype'];?></label></td>
		</tr>
		<tr>
			<td>Date of File Creation</td>
			<td><label><?php echo $answer['DocNo'];?></label></td>
		</tr>
		<tr>
			<td>Costumer #</td>
			<td><label>Manual</label></td>
		</tr>
		<tr>
			<td>Mode of Shipment</td>
			<td><label>Manual</label></td>
		</tr>
		<tr>
			<td>HAWB/BL Reference</td>
			<td><label>Manual</label></td>
		</tr>
		<tr>
			<td>Shipper</td>
			<td><label>Manual</label></td>
		</tr>
		<tr>
			<td>Gross Weight</td>
			<td><label>Manual</label></td>
		</tr>
		<tr>
			<td>Departure</td>
			<td><label>Manual</label></td>
		</tr>
		<tr>
			<td>Destination</td>
			<td><label>Manual</label></td>
		</tr>
		<tr>
			<td>PO Ref</td>
			<td><label><?php echo $answer['po_ref'];?></label></td>
		</tr>
		<tr>
			<td>Consignee</td>
			<td><label>Manual</label></td>
		</tr>
		<tr>
			<td>Posted Date</td>
			<td><label>Manual</label></td>
		</tr>
	</tbody>
</table>
<?php
}
mysqli_close($con);
?>