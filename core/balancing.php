<hr>
<?php 
	if(isset($_GET['d'])){
	
$queryu = "Select * from cockpit where c_id='{$_GET['d']}'";
$resultu = mysqli_query($con,$queryu);
		if(mysqli_num_rows($resultu)>0){
			$answeru = mysqli_fetch_array($resultu);
			//echo $answer['c_id']."!!".$answer['DocNo']."!!".$answer['Vendor']."!!".$answer['Vendordetails']."!!".$answer['Reference']."!!".$answer['Netamount']."!!".$answer['Text2'];

?>
	<div class="col-sm-12">
		<div class="col-sm-6">
			<table class="table">
				<thead>
					<tr>
						<th colspan="2"><h3>Information</h3></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>ID:</td>
						<td><label><?php echo $answeru['c_id'];?></label></td>
					</tr>
					<tr>
						<td>Doc No:</td>
						<td><label><?php echo $answeru['DocNo'];?></label></td>
					</tr>
					<tr>
						<td>Vendor #:</td>
						<td><label><?php echo $answeru['Vendor'];?></label></td>
					</tr>
					<tr>
						<td>Vendor:</td>
						<td><label><?php echo $answeru['Vendordetails'];?></label></td>
					</tr>
					<tr>
						<td>Reference:</td>
						<td><label><?php echo $answeru['Reference'];?></label></td>
					</tr>
					<tr>
						<td>Netamount:</td>
						<td><label><?php echo $answeru['Netamount'];?></label></td>
					</tr>
					<tr>
						<td>PO:</td>
						<td><label><?php echo $answeru['Text2'];?></label></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-6">
			<a href="?page=balancing" class="btn btn-danger pull-right">Hide</a>
			<form action="core/add_charge.php" method="post" target="hiddenframe" id="ncharge">
			<table class="table">
				<thead>
				</thead>
				<tbody>
					<tr>
						<td>Charge</td>
						<td><!--<input type="text" class="form-control" name="mcharge">-->
							<select class="form-control" name="mcharge">
								<option value="">--------------</option>
						<?php
							$chargequery = "Select ac_id, charges from all_charges2 where Vendor='{$answeru['Vendor']}' order by charges";
							echo $chargequery;
							$chargeresult = mysqli_query($con,$chargequery);
							if(mysqli_num_rows($chargeresult)>0){
								while ($chargeanswer=mysqli_fetch_array($chargeresult)) {
						?>
								<option value="<?php echo $chargeanswer['ac_id']?>"><?php echo $chargeanswer['charges']?></option>
						<?php
								}
							}
							mysqli_free_result($chargeresult);
						?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Amount</td>
						<td><input type="text" class="form-control" name="mamount"></td>
					</tr>
					<tr>
						<td colspan="2"><button type="button" class="btn btn-warning" id="acharge"  data-toggle="modal" data-target="#myModal">Add Charge</button></td>
					</tr>
				</tbody>
			</table>
			<input type="hidden" value="<?php echo $_GET['d'];?>" name="mdata">
			</form>
			<form action="core/del_charge.php" method="post" target="hiddenframe" id="dcharge">
				<input type="hidden" value="" name="fd_charge" id="fd_charge">
			</form>
			<hr>
			<div class="col-sm-12 panel" id="chargelist">
				<h4>Charges</h4>
				<table class="table">
					<thead>
					</thead>
					<tbody>
<?php
	//for echoing list
	$listquery = "Select charge_id, charge, amount from charges where doc='{$_GET['d']}'";
	$listresult = mysqli_query($con,$listquery);
	if(mysqli_num_rows($listresult)>0){
		while($listanswer = mysqli_fetch_array($listresult)){
?>
						<tr>
							<td><a href="#" title="<?php echo $listanswer['charge_id'];?>" class="del_charge"><span class="glyphicon glyphicon-trash"></span></a></td>
							<td><?php echo $listanswer['charge'];?></td>	
							<td><?php echo number_format($listanswer['amount'], 2, '.', '');?></td>	
						</tr>
<?php
		}
	}
	mysqli_free_result($listresult);
?>
						<tr>
							<td>&nbsp;</td>
							<td>Total</td>
							<td><label><?php
	$sumquery = "Select Sum(amount) as stotal from charges where doc='{$_GET['d']}'";
	$sumresult=mysqli_query($con,$sumquery);
	if(mysqli_num_rows($sumresult)>0){
		$sumnswer=mysqli_fetch_array($sumresult);
		if(trim($sumnswer[0])){
			echo number_format($sumnswer[0], 2, '.', '');
		}
		else{
			echo "0.00";
		}
	}
	else{
		echo "0.00";
	}
	mysqli_free_result($sumresult);
							?></label></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php
		}
		mysqli_free_result($resultu);
	}
?>
<div class="col-sm-6">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Balanced Data</h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Doc No</th>
						<th>Vendor</th>
					</tr>
				</thead>
				<tbody>
			<?php
			$tmpquery = "Select c_id, Vendordetails as Vend, DocNo from cockpit inner join (Select Round(Sum(amount),2) as total_amt, doc as d from charges group by d) as t1 on t1.d=cockpit.c_id  where finalize is null and balanced='1' order by DocNo";
			$tmpresult = mysqli_query($con,$tmpquery);
			$max_count = mysqli_num_rows($tmpresult);
			if(mysqli_num_rows($tmpresult)>0){
				while($tmpanswer = mysqli_fetch_array($tmpresult)){
					$tmpvend = explode(" ", $tmpanswer['Vend'])
			?>
					<tr>
						<td><a href="?page=balancing&d=<?php echo $tmpanswer['c_id'];?>" class="unbalance" title="<?php echo $tmpanswer['c_id'];?>"><?php echo $tmpanswer['DocNo'];?></a></td>
						<td><?php echo $tmpanswer['Vend'];?></td>
					</tr>
			<?php
				}
			}
			mysqli_free_result($tmpresult);
			?>
				</tbody>
			</table>
			</div>
			<!--
			<ul class="pagination">
			  <li><a href="#">&laquo;</a></li>
			  <li><a><input type="text" style="width:40px;"><input type="button" class="btn btn-success" value="Go"></a></li>
			  <li><a href="#">&raquo;</a></li>
			</ul>
			-->
			Count: <?php echo $max_count;
			$max_count = 0;
			?>
		</div>
	</div>	
</div>
<div class="col-sm-6">
	<div class="panel panel-danger">
		<div class="panel-heading">
			<h3 class="panel-title">Unbalanced Data</h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Doc No</th>
						<th>Vendor</th>
					</tr>
				</thead>
				<tbody>
			<?php
			$tmpquery = "Select c_id, Vendordetails as Vend, DocNo from cockpit left join (Select Round(Sum(amount),2) as total_amt, doc as d from charges group by d) as t1 on t1.d=cockpit.c_id where balanced!='1' or balanced is null order by DocNo";
			$tmpresult = mysqli_query($con,$tmpquery);
			$max_count = mysqli_num_rows($tmpresult);
			if(mysqli_num_rows($tmpresult)>0){
				while($tmpanswer = mysqli_fetch_array($tmpresult)){
			?>
					<tr>
						<td><a href="?page=balancing&d=<?php echo $tmpanswer['c_id'];?>" class="unbalance" title="<?php echo $tmpanswer['c_id'];?>"><?php echo $tmpanswer['DocNo'];?></a></td>
						<td><?php echo $tmpanswer['Vend'];?></td>
					</tr>
			<?php
				}
			}
			mysqli_free_result($tmpresult);
			?>
				</tbody>
			</table>
			</div>
			<!--
			<ul class="pagination">
			  <li><a href="#">&laquo;</a></li>
			  <li><a><input type="text" style="width:40px;"><input type="button" class="btn btn-danger" value="Go"></a></li>
			  <li><a href="#">&raquo;</a></li>
			</ul>-->
			Count: <?php echo $max_count;
			$max_count = 0;?>
		</div>
	</div>	
</div>