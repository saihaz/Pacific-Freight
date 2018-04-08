<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
$date1 = $_POST['mdate1'];
$date2 = $_POST['mdate2'];
?>
		<table class="table">
			<thead></thead>
			<tbody>
				<tr>
					<th>Vendor No</th>
					<th>Vendor Details</th>
					<th>Count</th>
					<th>Net Sum</th>
					<th>Gross Sum</th>
				</tr>
<?php
	$rquery = "Select vendor_no as vno, vendor_details as vd, Count(*) as cnt, Sum(net_amount) as ntamt, Sum(Gross) as grs from final_data where date_format(uploaded,'%Y-%m-%d')>='{$date1}' and date_format(uploaded,'%Y-%m-%d')<='{$date2}' group by vendor_no";
	$rquery2 = "Select Count(*) as cnt, Sum(net_amount) as ntamt, Sum(Gross) as grs from final_data where date_format(uploaded,'%Y-%m-%d')>='{$date1}' and date_format(uploaded,'%Y-%m-%d')<='{$date2}'";
	$rresult = mysqli_query($con,$rquery);
	$rresult2 = mysqli_query($con,$rquery2);
	if(mysqli_num_rows($rresult)>0){
		while($ranswer=mysqli_fetch_array($rresult)){
			//echo "{$ranswer['vd']}";
?>
				<tr>
					<td><?php echo $ranswer['vno']; ?></td>
					<td><?php echo $ranswer['vd']; ?></td>
					<td><?php echo $ranswer['cnt']; ?></td>
					<td><?php echo $ranswer['ntamt']; ?></td>
					<td><?php echo $ranswer['grs']; ?></td>
				</tr>
<?php
		}
	}
	if(mysqli_num_rows($rresult2)>0){
		$ranswer2 = mysqli_fetch_array($rresult2);
?>
				<tr>
					<td><label>Total</label></td>
					<td></td>
					<td><label><label><?php echo $ranswer2['cnt']; ?></label></td>
					<td><label><?php echo $ranswer2['ntamt']; ?></label></td>
					<td><label><?php echo $ranswer2['grs']; ?></label></td>
				</tr>
<?php
	}
	mysqli_free_result($rresult);
	mysqli_free_result($rresult2);
mysqli_close($con);
?>
			</tbody>
		</table>