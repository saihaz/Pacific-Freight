<div class="col-sm-12">
	<h1>For Approval</h1>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
	  <li class="active"><a href="#home" role="tab" data-toggle="tab">Browse</a></li>
	  <li>
		  <a href="#" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
		    Actions
		    <span class="caret"></span>
		  </a>
		  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="multi_approve('Approved')">Approve</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="multi_approve('Declined')">Decline</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="multi_approve('Approval Not Yet Required')">Approval Not Yet Required</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="multi_approve('No Approval Required')">No Approval Required</a></li>
		    <li role="presentation" class="divider"></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"  onclick="multi_approve('')" id="commentfinal"><span class="glyphicon glyphicon-plus-sign"></span> Comment</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" id="removefinal"><span class="glyphicon glyphicon-trash"></span> Remove</a></li>
		  </ul>
	  </li>
	  <li><a href="#" id="approvalfilter">Filter</a></li>
	  <li><a href="#" id="approvalhelp">Help</a></li>
	</ul>
	<div class="table-responsive" style="height:500px;background-color:#E8DEC8;overflow:scroll;">
		<form action="core/del_final.php" method="post" target="hiddenframe" id="myFinalForm">
		<small>
		<table class="table table-bordered table-striped">
			<thead>
				<tr><!--
					<th>&nbsp;</th>
					<th>
						<label>Doc No</label>
						<input type="text" class="form-control searcha w200" value="<?php if(isset($_GET['dn'])){ echo $_GET['dn']; }?>" placeholder="Doc No" id="doc_no">
					</th>	
					-->
					<!--
					<th>
						<label>Vendor Name</label>
						<input type="text" class="form-control searcha w200" value="<?php if(isset($_GET['vn'])){ echo $_GET['vn']; }?>"  placeholder="Vendor Name" id="vendor_na">
					</th>		
					-->
				</tr>
			</thead>
			<tbody>
			<?php
			$apolo="";
			if(isset($_GET['mover']))
				$apolo = ($_GET['mover'] - 1) * 100;
			$vane = "";
			$valle = "page=approval&";
			if(isset($_GET['dn'])){
				$vane = $vane . " and docno like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['dn']))) . "'";
				$valle = $valle . "dn={$_GET['dn']}&";
			}
			if(isset($_GET['vn'])){
				$vane = $vane . " and vendor_details like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['vn']))) . "'";
				$valle = $valle . "vn={$_GET['vn']}&";
			}

			if(trim($vane)){
				$vane = "where " . substr($vane, 4);
			}
			$num_dsl = 0;
			$tmpquery = "Select * from final_data inner join (Select Sum(amount) as total_amt, doc as d from charges group by d) as t1 on t1.d=final_data.cockpit_data and t1.total_amt=final_data.net_amount {$vane} order by lock_edit, approval, docno limit 100 offset {$apolo}";
			//$tmpquery = "Select fd_id, vendor_details as Vend, docno, approval, lock_edit from final_data inner join (Select Sum(amount) as total_amt, doc as d from charges group by d) as t1 on t1.d=final_data.cockpit_data and t1.total_amt=final_data.net_amount {$vane} order by lock_edit, approval, docno limit 100 offset {$apolo}";
			$subtmpquery = "Select fd_id, vendor_details as Vend, docno, approval, lock_edit from final_data inner join (Select Sum(amount) as total_amt, doc as d from charges group by d) as t1 on t1.d=final_data.cockpit_data and t1.total_amt=final_data.net_amount {$vane}";
			//$subtmpquery = "Select fd_id, vendor_details as Vend, docno, approval, lock_edit from final_data inner join (Select Sum(amount) as total_amt, doc as d from charges group by d) as t1 on t1.d=final_data.cockpit_data and t1.total_amt=final_data.net_amount {$vane}";
			$tmpresult = mysqli_query($con,$tmpquery);
			$subtmpresult = mysqli_query($con,$subtmpquery);
			$max_count = mysqli_num_rows($tmpresult);
			$num_dsl = mysqli_num_rows($subtmpresult);
			if(mysqli_num_rows($tmpresult)>0){
				while($tmpanswer = mysqli_fetch_array($tmpresult)){
			?>
					<tr>
						<td class="w30">
							<input type="checkbox" name="mycheck[]" value="<?php echo $tmpanswer['fd_id'];?>"> 
							<a href="#" class="view_apprv" title="<?php echo $tmpanswer['fd_id'];?>"><span class="glyphicon glyphicon-info-sign" title="View" data-toggle="modal" data-target="#myModal"></span></a> 
							<a href="#" class="to_apprv" title="<?php echo $tmpanswer['fd_id'];?>"><span class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#myModal" title="Approve"></span></a>
							<?php
							if(trim($tmpanswer['lock_edit'])){
							?>
								<span class="glyphicon glyphicon-lock" title="Locked"></span>
							<?php
							}
							else if ($tmpanswer['approval']=="Approved") {
							?>
								<span class="glyphicon glyphicon-ok" title="Approved"></span>
							<?php
							}
							else if ($tmpanswer['approval']=="Declined") {
							?>
								<span class="glyphicon glyphicon-remove" title="Declined"></span>
							<?php
							}
							else if (trim($tmpanswer['approval'])) {
							?>
								<span class="glyphicon glyphicon-question-sign"></span>
							<?php
							}
							?>
						</td>
						<td>
							<div class="col-md-6">
								<table class="table">
									<thead>
									</thead>
									<tbody>
										<tr>
											<td><label>CoCd:</label></td>
											<td><?php echo $tmpanswer['docno'];?></td>
										</tr>
										<tr>
											<td><label>ScanDate:</label></td>
											<td><?php echo $tmpanswer['docno'];?></td>
										</tr>
										<tr>
											<td><label>DocNo:</label></td>
											<td><?php echo $tmpanswer['docno'];?></td>
										</tr>
										<tr>
											<td><label>Doc Date:</label></td>
											<td><?php echo $tmpanswer['docno'];?></td>
										</tr>
										<tr>
											<td><label>Vendor No:</label></td>
											<td><?php echo $tmpanswer['docno'];?></td>
										</tr>
										<tr>
											<td><label>Vendor Details:</label></td>
											<td><?php echo $tmpanswer['vendor_details'];?></td>
										</tr>
										<tr>
											<td><label>Invoice:</label></td>
											<td><?php echo $tmpanswer['invoice'];?></td>
										</tr>
										<tr>
											<td><label>Reference:</label></td>
											<td><?php echo $tmpanswer['Reference'];?></td>
										</tr>
										<tr>
											<td><label>Currency:</label></td>
											<td><?php echo $tmpanswer['Currency'];?></td>
										</tr>
										<tr>
											<td><label>Gross:</label></td>
											<td><?php echo $tmpanswer['Gross'];?></td>
										</tr>
										<tr>
											<td><label>Net Amount:</label></td>
											<td><?php echo $tmpanswer['net_amount'];?></td>
										</tr>
										<tr>
											<td><label>Text:</label></td>
											<td><?php echo $tmpanswer['Text1'];?></td>
										</tr>
										<tr>
											<td><label>Text2:</label></td>
											<td><?php echo $tmpanswer['text2'];?></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-6">
								<table class="table">
									<thead>
									</thead>
									<tbody>
										<tr>
											<td><label>BPO:</label></td>
											<td><?php echo $tmpanswer['BPO'];?></td>
										</tr>
										<tr>
											<td><label>Cost Centre:</label></td>
											<td><?php echo $tmpanswer['cost_centre'];?></td>
										</tr>
										<tr>
											<td><label>Profit Centre:</label></td>
											<td><?php echo $tmpanswer['profit_centre'];?></td>
										</tr>
										<tr>
											<td><label>Profit Per Material:</label></td>
											<td><?php echo $tmpanswer['profit_per_material'];?></td>
										</tr>
										<tr>
											<td><label>Procurer:</label></td>
											<td><?php echo $tmpanswer['procurer'];?></td>
										</tr>
										<tr>
											<td><label>AP Comments:</label></td>
											<td><?php echo $tmpanswer['ap_comments'];?></td>
										</tr>
										<tr>
											<td><label>Approval:</label></td>
											<td><?php echo $tmpanswer['approval'];?></td>
										</tr>
										<tr>
											<td><label>Approver:</label></td>
											<td><?php echo $tmpanswer['approver'];?></td>
										</tr>
										<tr>
											<td><label>Approval Comment:</label></td>
											<td><?php echo $tmpanswer['approval_comment'];?></td>
										</tr>
										<tr>
											<td><label>Type:</label></td>
											<td><?php echo $tmpanswer['dc_type'];?></td>
										</tr>
										<tr>
											<td><label>Costumer No:</label></td>
											<td><?php echo $tmpanswer['costumer_no'];?></td>
										</tr>
										<tr>
											<td><label>Air Sea:</label></td>
											<td><?php echo $tmpanswer['air_sea'];?></td>
										</tr>
										<tr>
											<td><label>HAWB:</label></td>
											<td><?php echo $tmpanswer['hawb'];?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</td>
						<!--<td><?php echo $tmpanswer['docno'];?></td>-->
						<!--<td><?php echo $tmpanswer['Vend'];?></td>-->
					</tr>
			<?php
				}
			}
			else{
			?>
					<tr>
						<td colspan="3"><center><h1>Empty Table</h1></center></td>
					</tr>
			<?php
			}
			mysqli_free_result($tmpresult);
			?>
			</tbody>
		</table>
		</small>
		</form>
	</div>
	<?php include "core/number.php"?>
</div>