<div class="col-sm-12">
	<h1>To Finalize</h1>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
	  <li class="active"><a href="#home" role="tab" data-toggle="tab">Browse</a></li>
	</ul>
	<div class="table-responsive" style="height:500px;background-color:#E6D1FF;overflow:scroll;">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th>
						<label>Doc No</label>
						<input type="text" class="form-control searchb" value="<?php if(isset($_GET['dn'])){ echo $_GET['dn']; }?>" placeholder="Doc No" id="doc_nob">
					</th>
					<th>
						<label>Vendor Name</label>
						<input type="text" class="form-control searchb" value="<?php if(isset($_GET['vn'])){ echo $_GET['vn']; }?>" placeholder="Vendor Name" id="vendor_nab">
					</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$apolo="";
			if(isset($_GET['mover']))
				$apolo = ($_GET['mover'] - 1) * 100;
			$vane = "";
			$valle = "page=tofinal&";

			if(isset($_GET['dn'])){
				$vane = $vane . " and DocNo like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['dn']))) . "'";
				$valle = $valle . "dn={$_GET['dn']}&";
			}
			if(isset($_GET['vn'])){
				$vane = $vane . " and Vendordetails like '" . str_replace("''","'",str_replace('*','%',str_replace("%20"," ",$_GET['vn']))) . "'";
				$valle = $valle . "vn={$_GET['vn']}&";
			}

			$num_dsl = 0;
			$tmpquery = "Select c_id, Vendordetails as Vend, DocNo from cockpit inner join (Select Round(Sum(amount),2) as total_amt, doc as d from charges group by d) as t1 on t1.d=cockpit.c_id where finalize is null and balanced='1' {$vane} limit 100 offset {$apolo}";
			$subtmpquery = "Select c_id, Vendordetails as Vend, DocNo from cockpit inner join (Select Round(Sum(amount),2) as total_amt, doc as d from charges group by d) as t1 on t1.d=cockpit.c_id where finalize is null and balanced='1' {$vane} ";
			$tmpresult = mysqli_query($con,$tmpquery);
			$subtmpresult = mysqli_query($con,$subtmpquery);
			$max_count = mysqli_num_rows($tmpresult);
			$num_dsl = mysqli_num_rows($subtmpresult);
			if(mysqli_num_rows($tmpresult)>0){
				while($tmpanswer = mysqli_fetch_array($tmpresult)){
			?>
					<tr>
						<td><input type="checkbox" value="<?php echo $tmpanswer['c_id'];?>"> 
							<a href="#" class="view_ffinal" title="<?php echo $tmpanswer['c_id'];?>"><span class="glyphicon glyphicon-info-sign" title="View" data-toggle="modal" data-target="#myModal"></span></a> 
							<!--<a href="#" class="edit_apprv" title="<?php echo $tmpanswer['c_id'];?>"><span class="glyphicon glyphicon-pencil" data-toggle="modal" data-target="#myModal" title="Edit"></span></a> -->
							<a href="#" class="to_ffinal" title="<?php echo $tmpanswer['c_id'];?>"><span class="glyphicon glyphicon-send" data-toggle="modal" data-target="#myModal" title="Send"></span></a></td>
						<td><?php echo $tmpanswer['DocNo'];?></td>
						<td><?php echo $tmpanswer['Vend'];?></td>
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
	</div>
	<?php include "core/number.php"?>
</div>