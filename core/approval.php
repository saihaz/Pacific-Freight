
<div class="col-md-12">
	<h1>For Approval</h1>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
	  <li class="active">
	  	<a href="#home" class="dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
	  		<span class="glyphicon glyphicon-eye-open"></span> Browse
	  		<span class="caret">
	  	</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">
			<li role="presentation" class="<?php if(isset($_GET['typ']) and $_GET['typ']=="all"){ echo "active"; }
		  else if(!isset($_GET['typ'])){ echo "active";} ?>"><a role="menuitem" 	="-1" href="?page=approval&typ=all&mover=1">(All Documents)</a></li>
		  <li role="presentation" class="<?php if(isset($_GET['typ']) and $_GET['typ']=="app"){ echo "active"; } ?>"><a role="menuitem" tabindex="-1" href="?page=approval&typ=app&mover=1"><span class="glyphicon glyphicon-ok"></span> Approve</a></li>
		  <li role="presentation" class="<?php if(isset($_GET['typ']) and $_GET['typ']=="dec"){ echo "active"; } ?>"><a role="menuitem" tabindex="-1" href="?page=approval&typ=dec&mover=1"><span class="glyphicon glyphicon-remove"></span> Decline</a></li>
		  <li role="presentation" class="<?php if(isset($_GET['typ']) and $_GET['typ']=="hold"){ echo "active"; } ?>"><a role="menuitem" tabindex="-1" href="?page=approval&typ=hold&mover=1"><span class="glyphicon glyphicon-question-sign"></span> Hold</a></li>
		  <li role="presentation" class="<?php if(isset($_GET['typ']) and $_GET['typ']=="lck"){ echo "active"; } ?>"><a role="menuitem" tabindex="-1" href="?page=approval&typ=lck&mover=1"><span class="glyphicon glyphicon-lock"></span> Locked</a></li>
		  <li role="presentation" class="<?php if(isset($_GET['typ']) and $_GET['typ']=="due"){ echo "active"; } ?>"><a role="menuitem" tabindex="-1" href="?page=approval&typ=due&mover=1"><span class="glyphicon glyphicon-flash red"></span> Due</a></li>
		  <li role="presentation" class="divider"></li>
		  <li role="presentation" class="<?php if(isset($_GET['typ']) and $_GET['typ']=="me"){ echo "active"; } ?>"><a role="menuitem" tabindex="-1" href="?page=approval&typ=me&mover=1">Assigned to me</a></li>
		  <li role="presentation" class="<?php if(isset($_GET['typ']) and $_GET['typ']=="for"){ echo "active"; } ?>"><a role="menuitem" tabindex="-1" href="?page=approval&typ=for&mover=1">Needs Action</a></li>
		  <li role="presentation" class="<?php if(isset($_GET['typ']) and $_GET['typ']=="mdue"){ echo "active"; } ?>"><a role="menuitem" tabindex="-1" href="?page=approval&typ=mdue&mover=1"><span class="glyphicon glyphicon-flash red"></span> My Dues</a></li>
		</ul>
	  </li>
	  <li>
		  <a href="#" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
		    Actions
		    <span class="caret"></span>
		  </a>
		  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="multi_approve('Approved')"><span class="glyphicon glyphicon-ok"></span> Approve</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="multi_approve('Declined')"><span class="glyphicon glyphicon-remove"></span> Decline</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="multi_approve('Hold')"><span class="glyphicon glyphicon-question-sign"></span> Hold</a></li>
		    <li role="presentation" class="divider"></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"  onclick="multi_approve('')" id="commentfinal"><span class="glyphicon glyphicon-plus-sign"></span> Comment</a></li>
		   <!-- <li role="presentation"><a role="menuitem" tabindex="-1" href="#" id="removefinal"><span class="glyphicon glyphicon-trash"></span> Remove</a></li> -->
		    <li role="presentation" class="divider"></li>
		    <?php if(trim($_SESSION['pfreight_admin']) and $_SESSION['pfreight_admin']>1){ ?>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" id="remind" onclick="reminders()"><span class="glyphicon glyphicon-envelope"></span> Remind(Send Mail)</a></li>
		    <?php } ?>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" id="delegate" onclick="delegate()" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-share-alt"></span> Delegation</a></li>
		  </ul>
	  </li>
	  <li><a href="#" id="approvalfilter"><span class="glyphicon glyphicon-search"></span> Search</a></li>
	  <li><a href="#" id="approvalhelp"><span class="glyphicon glyphicon-question-sign"></span> Help</a></li>
	</ul>
</div>
<div class="col-md-12">
	<div class="height400">
	    <table class="fancyTable" id="myTable05" cellpadding="0" cellspacing="0">
	        <thead>
	        	<tr>
	        		<th>
	        			<a href="#" onclick="check_all(false);" id="checkall"><span class="glyphicon glyphicon-check"></span></a>
	        			<a href="#" onclick="check_all(true);" class="unseen" id="uncheckall"><span class="glyphicon glyphicon-share"></span></a>
	        		</th>
	        		<th><div class="w50">Stat</div></th>
	        		<th><div class="w50">&nbsp;</div></th>
	        		<th><div class="w50">CoCd</div></th>
	        		<th><div class="w70">Doc No</div></th>
	        		<th><div class="w70">Doc Date</div></th>
	        		<th><div class="w100">Vendor No</div></th>
	        		<th><div class="w200">Vendor Details</div></th>
	        		<th><div class="w50">Invoice</div></th>
	        		<th><div class="w100">Reference</div></th>
	        		<th><div class="w50">Currency</div></th>
	        		<th><div class="w70">Gross</div></th>
	        		<th><div class="w70">Net Amount</div></th>
	        		<th><div class="w200">Text</div></th>
	        		<th><div class="w200">PO</div></th>
	        		<th><div class="w70">Due Date</div></th>
	        		<th><div class="w100">BPO</div></th>
	        		<th><div class="w100">Cost Centre</div></th>
	        		<th><div class="w200">Profit Centre</div></th>
	        		<th><div class="w200">Profit Per Material</div></th>
	        		<th><div class="w100">Procurer</div></th>
	        		<th><div class="w200">AP Comments</div></th>
	        		<th><div class="w100">Approval</div></th>
	        		<th><div class="w200">Approver</div></th>
	        		<th><div class="w200">Approver's Comment</div></th>
	        		<th><div class="w70">Type</div></th>
	        		<th><div class="w70">Costumer No</div></th>
	        		<th><div class="w70">Mode of Shipment</div></th>
	        		<th><div class="w100">HAWB/BL Reference</div></th>
	        		<th><div class="w70">Shipper</div></th>
	        		<th><div class="w70">Gross Weight</div></th>
	        		<th><div class="w100">Departure</div></th>
	        		<th><div class="w100">Destination</div></th>
	        		<th><div class="w100">PO Ref</div></th>
	        		<th><div class="w100">Consignee</div></th>
	        		<th><div class="w100">Posted Date</div></th>
	        		<th><div class="w100">Posting Doc</div></th>
	        		<th><div class="w100">Clearing Date</div></th>
	        		<th><div class="w100">Clearing Doc</div></th>
	        		<th><div class="w100">Creator</div></th>
	        		<th><div class="w100">Finalized</div></th>
	        		<th><div class="w100">Last Update</div></th>
	        		<th><div class="w100">Last Update by</div></th>
	        	</tr>
	        </thead>
			<tbody>
			<?php
			$apolo="";
			if(isset($_GET['mover']))
				$apolo = ($_GET['mover'] - 1) * 100;
			$vane = "";
			$valle = "page=approval&";

			if(isset($_GET['ccd'])){
				$vane = $vane . " and cocd like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['ccd']))) . "'";
				$valle = $valle . "ccd={$_GET['ccd']}&";
			}

			if(isset($_GET['dn1'])){
				if(isset($_GET['dn2'])){
					$vane = $vane . " and docno >= '" . str_replace("''","'",str_replace("%20"," ",$_GET['dn1'])) . "' and docno <= '" . str_replace("''","'",str_replace("%20"," ",$_GET['dn2'])) . "'";	
					$valle = $valle . "dn2={$_GET['dn2']}&";
				}
				else{
					$vane = $vane . " and docno like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['dn1']))) . "'";
				}
				$valle = $valle . "dn1={$_GET['dn1']}&";
			}

			if(isset($_GET['dd1'])){
				if(isset($_GET['dd2'])){
					$vane = $vane . " and docdate >= '" . $_GET['dd1']. "' and docdate <= '" . $_GET['dd2']. "' ";
					$valle = $valle . "dd2={$_GET['dd2']}&";
				}
				else{
					$vane = $vane . " and docdate = '" . $_GET['dd1']. "'";
				}
				$valle = $valle . "dd1={$_GET['dd1']}&";
			}
			if(isset($_GET['vno'])){
				$vane = $vane . " and vendor_no like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['vno']))) . "'";
				$valle = $valle . "vno={$_GET['vno']}&";
			}
			if(isset($_GET['vn'])){
				$vane = $vane . " and vendor_details like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['vn']))) . "'";
				$valle = $valle . "vn={$_GET['vn']}&";
			}
			if(isset($_GET['ref'])){
				$vane = $vane . " and Reference like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['ref']))) . "'";
				$valle = $valle . "ref={$_GET['ref']}&";
			}
			if(isset($_GET['cur'])){
				$vane = $vane . " and Currency like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['cur']))) . "'";
				$valle = $valle . "cur={$_GET['cur']}&";
			}
			if(isset($_GET['grs1'])){
				if(isset($_GET['grs2'])){
					$vane = $vane . " and Gross >= '" . str_replace("",",",$_GET['grs1']) . "' and Gross <= '" . str_replace("",",",$_GET['grs2']) . "'";
					$valle = $valle . "grs2={$_GET['grs2']}&";
				}
				else{
					$vane = $vane . " and Gross = '" . str_replace("",",",$_GET['grs1']) . "'";
				}
				$valle = $valle . "grs1={$_GET['grs1']}&";
			}
			if(isset($_GET['net1'])){
				if(isset($_GET['net2'])){
					$vane = $vane . " and Gross >= '" . str_replace("",",",$_GET['net1']) . "' and Gross <= '" . str_replace("",",",$_GET['net2']) . "'";
					$valle = $valle . "net2={$_GET['net2']}&";
				}
				else{
					$vane = $vane . " and Gross = '" . str_replace("",",",$_GET['net1']) . "'";
				}
				$valle = $valle . "net1={$_GET['net1']}&";
			}
			if(isset($_GET['cst'])){
				$vane = $vane . " and cost_centre like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['cst']))) . "'";
				$valle = $valle . "cst={$_GET['cst']}&";
			}
			if(isset($_GET['prc'])){
				$vane = $vane . " and procurer like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['prc']))) . "'";
				$valle = $valle . "prc={$_GET['prc']}&";
			}
			if(isset($_GET['app'])){
				$vane = $vane . " and approval like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['app']))) . "'";
				$valle = $valle . "app={$_GET['app']}&";
			}
			if(isset($_GET['appr'])){
				$vane = $vane . " and approver like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['appr']))) . "'";
				$valle = $valle . "appr={$_GET['appr']}&";
			}
			if(isset($_GET['typ'])){
				//$vane = $vane . " and approver like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['appr']))) . "'";
				//$valle = $valle . "appr={$_GET['appr']}&";
				if($_GET['typ']=="app"){
					$vane = $vane . " and approval like 'Approved' and lock_edit is null";
				}
				else if($_GET['typ']=="dec"){
					$vane = $vane . " and approval like 'Declined'";
				}
				else if($_GET['typ']=="hold"){
					$vane = $vane . " and approval like 'Hold'";
				}
				else if($_GET['typ']=="lck"){
					$vane = $vane . " and approval like 'Approved' and lock_edit is not null";
				}
				else if($_GET['typ']=="me"){
					$vane = $vane . " and approver = '{$_SESSION['pfreight_userid']}'";
				}
				else if($_GET['typ']=="for"){
					$vane = $vane . " and approver = '{$_SESSION['pfreight_userid']}' and (approval like 'Hold' or approval is null)";
				}
				else if($_GET['typ']=="due"){
					$vane = $vane . " and DueDate < Now() and clearing_date is null ";
				}
				else if($_GET['typ']=="mdue"){
					$vane = $vane . " and approver = '{$_SESSION['pfreight_userid']}' and DueDate < Now() and clearing_date is null ";
				}
				$valle = $valle . "typ={$_GET['typ']}&";
			}

			if(trim($vane)){
				$vane = "where " . substr($vane, 4);
			}
			$num_dsl = 0;
			$nettotal = 0;
			$grosstotal = 0;
			//$tmpquery = "Select fd_id, vendor_details as Vend, docno, approval, lock_edit from final_data inner join (Select Sum(amount) as total_amt, doc as d from charges group by d) as t1 on t1.d=final_data.cockpit_data and t1.total_amt=final_data.net_amount {$vane} order by lock_edit, approval, docno limit 100 offset {$apolo}";
			//$subtmpquery = "Select fd_id, vendor_details as Vend, docno, approval, lock_edit from final_data inner join (Select Sum(amount) as total_amt, doc as d from charges group by d) as t1 on t1.d=final_data.cockpit_data and t1.total_amt=final_data.net_amount {$vane}";
			$tmpquery = "SELECT * from final_data
			 left join (Select Round(Sum(amount),2) as total_amt, doc as d from charges group by d) as t1 on t1.d=final_data.cockpit_data and t1.total_amt=final_data.net_amount 
			 left join (select approver_id, concat(fname,' ',lname) as appname from approver) as t2 on t2.approver_id = final_data.approver
			 left join (select user_id as uid3, concat(fname,' ',lname) as name3 from users) as t3 on t3.uid3 = final_data.uploader
			 left join (select user_id as uid4, concat(fname,' ',lname) as name4 from users) as t4 on t4.uid4 = final_data.updated_by
			 left join (select vend as v5, ave_amt as aa5, max_amt as ma5 from amount_matrix ) as t5 on t5.v5 = final_data.vendor_no
			 left join (SELECT doc as d6, Count(*) as c6 FROM `file_data` group by doc ) as t6 on t6.d6 = final_data.fd_id
			 {$vane} order by lock_edit, approval, docno limit 100 offset {$apolo}";
			$subtmpquery = "Select * from final_data left join (Select Round(Sum(amount),2) as total_amt, doc as d from charges group by d) as t1 on t1.d=final_data.cockpit_data and t1.total_amt=final_data.net_amount  left join (select approver_id, concat(fname,' ',lname) as appname from approver) as t2 on t2.approver_id = final_data.approver
			{$vane}";
			$tmpresult = mysqli_query($con,$tmpquery);
			$subtmpresult = mysqli_query($con,$subtmpquery);
			$max_count = mysqli_num_rows($tmpresult);
			$num_dsl = mysqli_num_rows($subtmpresult);
			if(mysqli_num_rows($tmpresult)>0){
				while($tmpanswer = mysqli_fetch_array($tmpresult)){

				$nettotal += $tmpanswer['net_amount'];
				$grosstotal += $tmpanswer['Gross'];
			?>
					<tr>
						<td>
							<input type="checkbox" name="mycheck[]" value="<?php echo $tmpanswer['fd_id'];?>"> 
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
						<?php
							$mailcolor = "";
							$seencolor = "";
							$seentime = "";
							$statcolor = "";
							$duecolor = "";
							$moneycolor = "";
							$foldercolor = "";

							if(trim($tmpanswer['mail4'])){
								$mailcolor = " red";
							}
							else if(trim($tmpanswer['mail3'])){
								$mailcolor = " orange";
							}
							else if(trim($tmpanswer['mail2'])){
								$mailcolor = " yellow";
							}
							else if(trim($tmpanswer['mail1'])){
								$mailcolor = " green";
							}

							if(trim($tmpanswer['clearing_doc'])){
								$statcolor = " green";
							}
							else if(trim($tmpanswer['posting_doc'])){
								$statcolor = " yellow";
							}

							if(trim($tmpanswer['DueDate']) and trim($tmpanswer['clearing_date'])==false and ($tmpanswer['DueDate'] < date("Y-m-d"))){
								$duecolor = " red";
							}

							if(trim($tmpanswer['seen'])){
								$seencolor = " green";
								$seentime = $tmpanswer['seen'];
							}

							if(trim($tmpanswer['ma5']) and $tmpanswer['ma5'] < $tmpanswer['Gross']){
								$moneycolor = " red";
							}
							else if(trim($tmpanswer['aa5']) and $tmpanswer['aa5'] < $tmpanswer['Gross']){
								$moneycolor = " yellow";
							}

							if(trim($tmpanswer['c6']) and $tmpanswer['c6']>0){
								$foldercolor = " green";
							}
						?>
							<span class="glyphicon glyphicon-cloud-upload<?php echo $mailcolor;?>" title="Mail Sent"></span>
							<span class="glyphicon glyphicon-eye-open<?php echo $seencolor;?>" title="Seen By Approver <?php echo $seentime;?>"></span>
							<span class="glyphicon glyphicon-flash<?php echo $duecolor;?>" title="Overdue"></span>
							<span class="glyphicon glyphicon-pushpin<?php echo $statcolor;?>" title="Posting Status"></span>
							<span class="glyphicon glyphicon-usd<?php echo $moneycolor;?>" title="Amount Limit"></span>
						</td>
						<td>
							<a href="#" class="view_apprv" title="<?php echo $tmpanswer['fd_id'];?>"><span class="glyphicon glyphicon-info-sign" title="View" data-toggle="modal" data-target="#myModal"></span></a> 
							<?php if($_SESSION['pfreight_userid']==$tmpanswer['approver']){ ?>
							<a href="#" class="to_apprv" title="<?php echo $tmpanswer['fd_id'];?>"><span class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#myModal" title="Approve"></span></a>
							<?php } ?>
							<a href="#" class="hist" title="<?php echo $tmpanswer['fd_id'];?>"><span class="glyphicon glyphicon-list-alt" data-toggle="modal" data-target="#myModal" title="History"></span></a>
							<?php if(trim($_SESSION['pfreight_admin']) and $_SESSION['pfreight_admin']>1){ ?>
							<a href="#" class="edit_apprv" title="<?php echo $tmpanswer['fd_id'];?>"><span class="glyphicon glyphicon-pencil" data-toggle="modal" data-target="#myModal" title="Advance Edit"></span></a>
							<a href="#" class="del_apprv" title="<?php echo $tmpanswer['fd_id'];?>"><span class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#myModal" title="Delete"></span></a>
							<?php } ?>
							<a href="#" class="attach_apprv" title="<?php echo $tmpanswer['fd_id'];?>"><span class="glyphicon glyphicon-folder-open<?php echo $foldercolor;?>" title="Attachments" data-toggle="modal" data-target="#myModal4"></span></a> 
						</td>
						<td><?php echo $tmpanswer['cocd'];?></td>
						<td><?php echo $tmpanswer['docno'];?></td>
						<td><?php echo $tmpanswer['docdate'];?></td>
						<td><?php echo $tmpanswer['vendor_no'];?></td>
						<td><?php echo $tmpanswer['vendor_details'];?></td>
						<td><?php echo $tmpanswer['invoice'];?></td>
						<td><?php echo $tmpanswer['Reference'];?></td>
						<td><?php echo $tmpanswer['Currency'];?></td>
						<td><?php echo $tmpanswer['Gross'];?></td>
						<td><?php echo $tmpanswer['net_amount'];?></td>
						<td><?php echo $tmpanswer['Text1'];?></td>
						<td><?php echo $tmpanswer['text2'];?></td>
						<td><?php echo $tmpanswer['DueDate'];?></td>
						<td><?php echo $tmpanswer['BPO'];?></td>
						<td><?php echo $tmpanswer['cost_centre'];?></td>
						<td><?php echo $tmpanswer['profit_centre'];?></td>
						<td><?php echo $tmpanswer['profit_per_material'];?></td>
						<td><?php echo $tmpanswer['procurer'];?></td>
						<td><?php echo $tmpanswer['ap_comments'];?></td>
						<td><?php echo $tmpanswer['approval'];?></td>
						<td><?php echo $tmpanswer['appname'];?></td>
						<td><?php echo $tmpanswer['approval_comment'];?></td>
						<td><?php echo $tmpanswer['dc_type'];?></td>
						<td><?php echo $tmpanswer['costumer_no'];?></td>
						<td><?php echo $tmpanswer['air_sea'];?></td>
						<td><?php echo $tmpanswer['hawb'];?></td>
						<td><?php echo $tmpanswer['shipper'];?></td>
						<td><?php echo $tmpanswer['gross_weight'];?></td>
						<td><?php echo $tmpanswer['departure'];?></td>
						<td><?php echo $tmpanswer['destination'];?></td>
						<td><?php echo $tmpanswer['po_ref'];?></td>
						<td><?php echo $tmpanswer['Consignee'];?></td>
						<td><?php echo $tmpanswer['posted_date'];?></td>
						<td><?php echo $tmpanswer['posting_doc'];?></td>
						<td><?php echo $tmpanswer['clearing_date'];?></td>
						<td><?php echo $tmpanswer['clearing_doc'];?></td>
						<td><?php echo $tmpanswer['name3'];?></td>
						<td><?php echo $tmpanswer['uploaded'];?></td>
						<td><?php echo $tmpanswer['updated'];?></td>
						<td><?php echo $tmpanswer['name4'];?></td>
					</tr>
			<?php
				}
			}
			else{
			?>
					<tr>
						<td>&nbsp;</td>
						<td colspan="4"><center><h1>Empty Table</h1></center></td>
					</tr>
			<?php
			}
			mysqli_free_result($tmpresult);
			?>
			</tbody>
		</table>
	</div>
</div>
<div class="col-md-12">
	<p style="float:right;">Net Amount: <label><?php echo number_format($nettotal,2);?></label> || Gross Amount: <label><?php echo number_format($grosstotal,2);?></label></p>
</div>
<div class="col-md-12">
	<?php include "core/number.php"; ?>
</div>
<form action="core/mail_approval.php" method="post" target="hiddenframe" id="forMail"></form>
<form action="core/delete_file.php" method="post" target="hiddenframe" id="forFile">
	<input type="hidden" id="fileDeletion" name="fileDeletion">
</form>

<?php
// seen query
$squery = "Update final_data set seen=Now() where seen is null and approver = '{$_SESSION['pfreight_userid']}'";
mysqli_query($con,$squery);
?>