<div class="col-md-12">
	<div class="col-md-12" >
		<h1>Extract Report</h1>
		<small>*Note: Once extracted, it will automatically lock the approved data. Editing/Deleting will not be allowed.</small>
	</div>
	<div class="col-md-6">
		<form action="core/extract_final.php" method="post" target="hiddenframe" id="extraction">
		<table class="table">
			<thead>
				<tr>
					<th></th>
					<th>From</th>
					<th>To</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Date Finalized</td>
					<td><input type="date" class="form-control" name="date1" placeholder="yyyy-mm-dd"></td>
					<td><input type="date" class="form-control" name="date2" placeholder="yyyy-mm-dd"></td>
				</tr>
				<tr>
					<td colspan="3"><input type="button" value="Lock and Extract" class="btn btn-primary" id="lne"></td>
				</tr>
			</tbody>
		</table>
		</form>
	</div>

	<div class="col-md-12" >
		<h1>Filter</h1>
		<form action="core/summary.php" method="post" target="hiddenframe">
		<div class="col-md-12">
			<table class="table">
				<thead>
				</thead>
				<tbody>
					<tr>
						<td><label>Date Finalized</label></td>
						<td><input type="date" class="form-control" name="date1" id="rfdate1" value="<?php if(isset($_GET['rd1'])){ echo $_GET['rd1']; } ?>" placeholder="yyyy-mm-dd"></td>
						<td><input type="date" class="form-control" name="date2" id="rfdate2" value="<?php if(isset($_GET['rd2'])){ echo $_GET['rd2']; } ?>" placeholder="yyyy-mm-dd"></td>
					</tr>
					<tr>
						<td><label>Approver</label></td>
						<td>
							<select class="form-control" name="approver" id="rfapp">
								<option value="">----- ALL ----</option>
			<?php
					$apquery = "Select *, concat(fname, ' ', lname) as fullname from approver";
					$apresult = mysqli_query($con,$apquery);
					if(mysqli_num_rows($apresult)>0){
						while($apanswer = mysqli_fetch_array($apresult)){
			?>
								<option value="<?php echo $apanswer['approver_id']; ?>" <?php if(isset($_GET['rfapp']) and $_GET['rfapp']==$apanswer['approver_id']){ echo "selected";} ?> ><?php echo $apanswer['fullname']?></option>
			<?php
						}

					}
					mysqli_free_result($apresult);
			?>
							</select>
						</td>
						<td>
							&nbsp;
						</td>
					</tr>
					<tr>
						<td><label>Status</label></td>
						<td>
							<select class="form-control" id="rfstt" name="rfstt">
								<option value="">-----   ALL   -----</option>
								<option <?php if(isset($_GET['rfstt']) and $_GET['rfstt']=="Approved"){ echo "selected";} ?> >Approved</option>
								<option <?php if(isset($_GET['rfstt']) and $_GET['rfstt']=="Declined"){ echo "selected";} ?> >Declined</option>
								<option <?php if(isset($_GET['rfstt']) and $_GET['rfstt']=="Hold"){ echo "selected";} ?> >Hold</option>
							</select>
						</td>
						<td>
							<div class="pull-right">
								<button type="button" class="btn btn-primary" id="refilter">Filter</button>
								<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span></button>
							</div></td>
					</tr>
				</tbody>
			</table>
		</div>
		</form>
		<hr>
	</div>
	<?php
	$f = "";
	$wh = "";

	if(isset($_GET['rd1']) and trim($_GET['rd1'])){
		$f = "and date_format(uploaded,'%Y-%m-%d')='{$_GET['rd1']}' ";
	}
	if(isset($_GET['rd2']) and trim($_GET['rd2'])){
		if(trim($_GET['rd1'])){
			$f = "and date_format(uploaded,'%Y-%m-%d')>='{$_GET['rd1']}' and date_format(uploaded,'%Y-%m-%d')<='{$_GET['rd2']}' ";
		}
		else{
			$f = "and date_format(uploaded,'%Y-%m-%d')='{$_GET['rd2']}' ";
		}
	}

	if(isset($_GET['rfapp']) and trim($_GET['rfapp'])){
		$f = $f."and approver = '{$_GET['rfapp']}' ";
	}
	if(isset($_GET['rfstt']) and trim($_GET['rfstt'])){
		$f = $f."and approval like '{$_GET['rfstt']}' ";
	}
	if(trim($f)){
		$wh = "where ".substr($f, 3);
	}
	?>
	<div class="col-md-12">
		<hr>
		<!--data query-->
		<textarea class="unseen" id="allsum">
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
		$tmpvd = array();
		$tmpcnt = array();
		$tmpnet = array();
		$tmpgrs = array();
		$rquery = "SELECT vendor_no as vno, vendor_details as vd, Count(*) as cnt, Sum(net_amount) as ntamt, Sum(Gross) as grs from final_data {$wh} group by vendor_no";
		$rquery2 = "SELECT Count(*) as cnt, Sum(net_amount) as ntamt, Sum(Gross) as grs from final_data {$wh} ";
		$rresult = mysqli_query($con,$rquery);
		$rresult2 = mysqli_query($con,$rquery2);
		if(mysqli_num_rows($rresult)>0){
			while($ranswer=mysqli_fetch_array($rresult)){
				//echo "{$ranswer['vd']}";
				array_push($tmpvd, $ranswer['vd']);
				array_push($tmpcnt, $ranswer['cnt']);
				array_push($tmpnet, $ranswer['ntamt']);
				array_push($tmpgrs, $ranswer['grs']);
	?>
					<tr>
						<td><?php echo $ranswer['vno']; ?></td>
						<td><?php echo $ranswer['vd']; ?></td>
						<td><?php echo $ranswer['cnt']; ?></td>
						<td><?php echo round($ranswer['ntamt'],2); ?></td>
						<td><?php echo round($ranswer['grs'],2); ?></td>
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
						<td><label><?php echo round($ranswer2['ntamt'],2); ?></label></td>
						<td><label><?php echo round($ranswer2['grs'],2); ?></label></td>
					</tr>
	<?php
		}
		mysqli_free_result($rresult);
		mysqli_free_result($rresult2);
	?>
				</tbody>
			</table>
		</textarea>

		<!--graph-->
		<script type="text/javascript">
		$(function () {
		    $('#container-graph').highcharts({
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Net and Gross Summary'
		        },
		        xAxis: {
		            categories: [
		            <?php
		            $tmpstr = ""; 
		            foreach ($tmpvd as $value) {
					    $tmpstr = $tmpstr.",'{$value}'";
					}
					echo substr($tmpstr, 1);
		            ?>
		            ]
		        },
		        yAxis: [{
		            min: 0,
		            title: {
		                text: 'Count'
		            }
		        }, {
		            title: {
		                text: 'Amount'
		            },
		            opposite: true
		        }],
		        legend: {
		            shadow: false
		        },
		        tooltip: {
		            shared: true
		        },
		        plotOptions: {
		            column: {
		                grouping: false,
		                shadow: false,
		                borderWidth: 0
		            }
		        },
	            credits: {
	                enabled: false
	            },
		        series: [{
		            name: 'Count',
		            color: 'rgba(126,86,134,.9)',
		            data: [
		            <?php
		            $tmpstr = ""; 
		            foreach ($tmpcnt as $value) {
					    $tmpstr = $tmpstr.",{$value}";
					}
					echo substr($tmpstr, 1);
		            ?>
		            ],
		            pointPadding: 0.4,
		            pointPlacement: -0.2
		        }, {
		            name: 'Net',
		            color: 'rgba(248,161,63,1)',
		            data: [
		            <?php
		            $tmpstr = ""; 
		            foreach ($tmpnet as $value) {
					    $tmpstr = $tmpstr.",".round($value,2);
					}
					echo substr($tmpstr, 1);
		            ?>
		            ],
		            tooltip: {
		                valuePrefix: '',
		                valueSuffix: ' '
		            },
		            pointPadding: 0.3,
		            pointPlacement: 0.2,
		            yAxis: 1
		        }, {
		            name: 'Gross',
		            color: 'rgba(186,60,61,.9)',
		            data: [
		            <?php
		            $tmpstr = ""; 
		            foreach ($tmpgrs as $value) {
					    $tmpstr = $tmpstr.",".round($value,2);
					}
					echo substr($tmpstr, 1);
		            ?>
		            ],
		            tooltip: {
		                valuePrefix: '',
		                valueSuffix: ' '
		            },
		            pointPadding: 0.4,
		            pointPlacement: 0.2,
		            yAxis: 1
		        }]
		    });
		});
		</script>
    	<div id="container-graph" style="min-width: 400px; max-width: 100%; height: 400px; margin: 0 auto"></div>
    	<a href="#" data-toggle="modal" data-target="#myModal" onclick="transferHTML('allsum')">View Summary</a>
	</div>

	<div class="col-md-12" >
		<hr>
		<textarea class="unseen" id="unpaidsum">
			<table class="table table-bordered">
				<thead></thead>
				<tbody>
					<tr>
						<th>Vendor No</th>
						<th>Vendor Details</th>
						<th><span class="red">Due</span></th>
						<th><span class="red">Due Amount</span></th>
						<th>Not Due</th>
						<th>Not Due Amount</th>
					</tr>
	<?php
		$tmpvd = array();
		$tmpdue = array();
		$tmpdues = array();
		$tmpndue = array();
		$tmpndues = array();
		$rquery = "SELECT vendor_no as vno, vendor_details as vd,
				 Sum(case when DATEDIFF(duedate,now())<0 then 1 else 0 end) as due,
				 Sum(case when DATEDIFF(duedate,now())<0 then Gross else 0 end) as grsd, 
				 Sum(case when DATEDIFF(duedate,now())>-1 then 1 else 0 end) as notdue,
				 Sum(case when DATEDIFF(duedate,now())>-1 then Gross else 0 end) as grsn 
				 from final_data where clearing_date IS NULL {$f} group by vendor_no";
		//$rquery = "Select vendor_no as vno, vendor_details as vd, Count(*) as cnt, Sum(net_amount) as ntamt, Sum(Gross) as grs from final_data group by vendor_no";
		$rquery2 = "SELECT Sum(case when DATEDIFF(duedate,now())<0 then 1 else 0 end) as due,
				 Sum(case when DATEDIFF(duedate,now())<0 then Gross else 0 end) as grsd, 
				 Sum(case when DATEDIFF(duedate,now())>-1 then 1 else 0 end) as notdue,
				 Sum(case when DATEDIFF(duedate,now())>-1 then Gross else 0 end) as grsn from final_data where clearing_date IS NULL {$f}";
		$rresult = mysqli_query($con,$rquery);
		$rresult2 = mysqli_query($con,$rquery2);
		if(mysqli_num_rows($rresult)>0){
			while($ranswer=mysqli_fetch_array($rresult)){
				//echo "{$ranswer['vd']}";
				array_push($tmpvd, $ranswer['vd']);
				array_push($tmpdue, $ranswer['due']);
				array_push($tmpdues, $ranswer['grsd']);
				array_push($tmpndue, $ranswer['notdue']);
				array_push($tmpndues, $ranswer['grsn']);
	?>
					<tr>
						<td><?php echo $ranswer['vno']; ?></td>
						<td><?php echo $ranswer['vd']; ?></td>
						<td><span class="red"><?php echo $ranswer['due']; ?></span></td>
						<td><span class="red"><?php echo round($ranswer['grsd'],2); ?></span></td>
						<td><?php echo $ranswer['notdue']; ?></td>
						<td><?php echo round($ranswer['grsn'],2); ?></td>
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
						<td><label class="red"><?php echo $ranswer2['due']; ?></label></td>
						<td><label class="red"><?php echo round($ranswer2['grsd'],2); ?></label></td>
						<td><label><?php echo $ranswer2['notdue']; ?></label></td>
						<td><label><?php echo round($ranswer2['grsn'],2); ?></label></td>
					</tr>
	<?php
		}
		mysqli_free_result($rresult);
		mysqli_free_result($rresult2);
	?>
				</tbody>
			</table>
		</textarea>

		<!-- Graph -->
		<script type="text/javascript">
			$(function () {
			    $('#container-graph2').highcharts({
			        chart: {
			            type: 'column'
			        },
			        title: {
			            text: 'Unpaid Due Summary'
			        },
			        xAxis: {
			            categories: [
			            <?php
			            $tmpstr = ""; 
			            foreach ($tmpvd as $value) {
						    $tmpstr = $tmpstr.",'{$value}'";
						}
						echo substr($tmpstr, 1);
			            ?>
			            ]
			        },
			        yAxis: {
			            min: 0,
			            title: {
			                text: 'Gross Amount'
			            },
			            stackLabels: {
			                enabled: true,
			                style: {
			                    fontWeight: 'bold',
			                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
			                }
			            }
			        },
			        legend: {
			            align: 'right',
			            x: -70,
			            verticalAlign: 'top',
			            y: 20,
			            floating: true,
			            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
			            borderColor: '#CCC',
			            borderWidth: 1,
			            shadow: false
			        },
			        tooltip: {
			            formatter: function () {
			                return '<b>' + this.x + '</b><br/>' +
			                    this.series.name + ': ' + this.y + '<br/>' +
			                    'Total: ' + this.point.stackTotal;
			            }
			        },
			        plotOptions: {
			            column: {
			                stacking: 'normal',
			                dataLabels: {
			                    enabled: true,
			                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
			                    style: {
			                        textShadow: '0 0 3px black, 0 0 3px black'
			                    }
			                }
			            }
			        },
		            credits: {
		                enabled: false
		            },
			        series: [{
			            name: 'Due',
		      	      	color: 'rgba(245,81,81,1)',
			            data: [<?php
			            $tmpstr = ""; 
			            foreach ($tmpdues as $value) {
						    $tmpstr = $tmpstr.",".round($value,2);
						}
						echo substr($tmpstr, 1);
			            ?>]
			        }, {
			            name: 'Not Due',
			            data: [<?php
			            $tmpstr = ""; 
			            foreach ($tmpndues as $value) {
						    $tmpstr = $tmpstr.",".round($value,2);
						}
						echo substr($tmpstr, 1);
			            ?>]
			        }]
			    });
			});
		</script>


    	<div id="container-graph2" style="min-width: 400px; max-width: 100%; height: 400px; margin: 0 auto"></div>
    	<a href="#" data-toggle="modal" data-target="#myModal" onclick="transferHTML('unpaidsum')">View Summary</a>
	</div>
	<div class="col-md-10" id="final_summary1" style="display:none;">

		
	</div>

	<div class="col-md-12" >
		<hr>

		<textarea class="unseen" id="paidsum">
			<table class="table table-bordered">
				<thead></thead>
				<tbody>
					<tr>
						<th>Vendor No</th>
						<th>Vendor Details</th>
						<th><span class="red">Due</span></th>
						<th><span class="red">Due Amount</span></th>
						<th>Not Due</th>
						<th>Not Due Amount</th>
					</tr>
	<?php
		$tmpvd = array();
		$tmpdue = array();
		$tmpdues = array();
		$tmpndue = array();
		$tmpndues = array();
		$rquery = "SELECT vendor_no as vno, vendor_details as vd,
				 Sum(case when DATEDIFF(duedate,clearing_date)<0 then 1 else 0 end) as due,
				 Sum(case when DATEDIFF(duedate,clearing_date)<0 then Gross else 0 end) as grsd, 
				 Sum(case when DATEDIFF(duedate,clearing_date)>-1 then 1 else 0 end) as notdue,
				 Sum(case when DATEDIFF(duedate,clearing_date)>-1 then Gross else 0 end) as grsn 
				 from final_data where clearing_date IS NOT NULL {$f} group by vendor_no";
		//$rquery = "Select vendor_no as vno, vendor_details as vd, Count(*) as cnt, Sum(net_amount) as ntamt, Sum(Gross) as grs from final_data group by vendor_no";
		$rquery2 = "SELECT Sum(case when DATEDIFF(duedate,clearing_date)<0 then 1 else 0 end) as due,
				 Sum(case when DATEDIFF(duedate,clearing_date)<0 then Gross else 0 end) as grsd, 
				 Sum(case when DATEDIFF(duedate,clearing_date)>-1 then 1 else 0 end) as notdue,
				 Sum(case when DATEDIFF(duedate,clearing_date)>-1 then Gross else 0 end) as grsn from final_data where clearing_date IS NOT NULL {$f}";
		$rresult = mysqli_query($con,$rquery);
		$rresult2 = mysqli_query($con,$rquery2);
		if(mysqli_num_rows($rresult)>0){
			while($ranswer=mysqli_fetch_array($rresult)){
				array_push($tmpvd, $ranswer['vd']);
				array_push($tmpdue, $ranswer['due']);
				array_push($tmpdues, $ranswer['grsd']);
				array_push($tmpndue, $ranswer['notdue']);
				array_push($tmpndues, $ranswer['grsn']);
				//echo "{$ranswer['vd']}";
	?>
					<tr>
						<td><?php echo $ranswer['vno']; ?></td>
						<td><?php echo $ranswer['vd']; ?></td>
						<td><span class="red"><?php echo $ranswer['due']; ?></span></td>
						<td><span class="red"><?php echo round($ranswer['grsd'],2); ?></span></td>
						<td><?php echo $ranswer['notdue']; ?></td>
						<td><?php echo round($ranswer['grsn'],2); ?></td>
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
						<td><label class="red"><?php echo $ranswer2['due']; ?></label></td>
						<td><label class="red"><?php echo round($ranswer2['grsd'],2); ?></label></td>
						<td><label><?php echo $ranswer2['notdue']; ?></label></td>
						<td><label><?php echo round($ranswer2['grsn'],2); ?></label></td>
					</tr>
	<?php
		}
		mysqli_free_result($rresult);
		mysqli_free_result($rresult2);
	?>
				</tbody>
			</table>
		</textarea>

		<!-- Graph -->
		<script type="text/javascript">
			$(function () {
			    $('#container-graph3').highcharts({
			        chart: {
			            type: 'column'
			        },
			        title: {
			            text: 'Paid Due Summary'
			        },
			        xAxis: {
			            categories: [
			            <?php
			            $tmpstr = ""; 
			            foreach ($tmpvd as $value) {
						    $tmpstr = $tmpstr.",'{$value}'";
						}
						echo substr($tmpstr, 1);
			            ?>
			            ]
			        },
			        yAxis: {
			            min: 0,
			            title: {
			                text: 'Gross Amount'
			            },
			            stackLabels: {
			                enabled: true,
			                style: {
			                    fontWeight: 'bold',
			                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
			                }
			            }
			        },
			        legend: {
			            align: 'right',
			            x: -70,
			            verticalAlign: 'top',
			            y: 20,
			            floating: true,
			            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
			            borderColor: '#CCC',
			            borderWidth: 1,
			            shadow: false
			        },
			        tooltip: {
			            formatter: function () {
			                return '<b>' + this.x + '</b><br/>' +
			                    this.series.name + ': ' + this.y + '<br/>' +
			                    'Total: ' + this.point.stackTotal;
			            }
			        },
			        plotOptions: {
			            column: {
			                stacking: 'normal',
			                dataLabels: {
			                    enabled: true,
			                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
			                    style: {
			                        textShadow: '0 0 3px black, 0 0 3px black'
			                    }
			                }
			            }
			        },
			        credits: {
		                enabled: false
		            },
			        series: [{
			            name: 'Due',
		      	      	color: 'rgba(245,245,81,1)',
			            data: [<?php
			            $tmpstr = ""; 
			            foreach ($tmpdues as $value) {
						    $tmpstr = $tmpstr.",".round($value,2);
						}
						echo substr($tmpstr, 1);
			            ?>]
			        }, {
			            name: 'Not Due',
			            color: 'rgba(19,120,16,1)',
			            data: [<?php
			            $tmpstr = ""; 
			            foreach ($tmpndues as $value) {
						    $tmpstr = $tmpstr.",".round($value,2);
						}
						echo substr($tmpstr, 1);
			            ?>]
			        }]
			    });
			});
		</script>


    	<div id="container-graph3" style="min-width: 400px; max-width: 100%; height: 400px; margin: 0 auto"></div>
    	<a href="#" data-toggle="modal" data-target="#myModal" onclick="transferHTML('paidsum')">View Summary</a>

	</div>
	<div class="col-md-10" id="final_summary3" style="display:none;">
	</div>

	<div class="col-md-12" >
		<hr>
		<textarea class="unseen" id="shipsum">
			<table class="table table-bordered">
				<thead></thead>
				<tbody>
					<tr>
						<th>Vendor No</th>
						<th>Vendor Details</th>
						<th>Air</th>
						<th>Air Amount</th>
						<th>Sea</th>
						<th>Sea Amount</th>
						<th>Road</th>
						<th>Road Amount</th>
					</tr>
	<?php
		$tmpvd = array();
		$tmpair = array();
		$tmproad = array();
		$tmpsea = array();
		$rquery = "SELECT vendor_no as vno, vendor_details as vd,
				 Sum(case when air_sea like '%air%' then 1 else 0 end) as air,
				 Sum(case when air_sea like '%air%' then Gross else 0 end) as aird, 
				 Sum(case when air_sea like '%sea%' then 1 else 0 end) as sea,
				 Sum(case when air_sea like '%sea%' then Gross else 0 end) as sean, 
				 Sum(case when air_sea like '%road%' then 1 else 0 end) as road,
				 Sum(case when air_sea like '%road%' then Gross else 0 end) as roadn 
				 from final_data {$wh} group by vendor_no";
		//$rquery = "Select vendor_no as vno, vendor_details as vd, Count(*) as cnt, Sum(net_amount) as ntamt, Sum(Gross) as grs from final_data group by vendor_no";
		$rquery2 = "SELECT Sum(case when air_sea like '%air%' then 1 else 0 end) as air,
				 Sum(case when air_sea like '%air%' then Gross else 0 end) as aird, 
				 Sum(case when air_sea like '%sea%' then 1 else 0 end) as sea,
				 Sum(case when air_sea like '%sea%' then Gross else 0 end) as sean, 
				 Sum(case when air_sea like '%road%' then 1 else 0 end) as road,
				 Sum(case when air_sea like '%road%' then Gross else 0 end) as roadn 
				 from final_data {$wh}";
		$rresult = mysqli_query($con,$rquery);
		$rresult2 = mysqli_query($con,$rquery2);
		if(mysqli_num_rows($rresult)>0){
			while($ranswer=mysqli_fetch_array($rresult)){
				array_push($tmpvd, $ranswer['vd']);
				array_push($tmpair, $ranswer['aird']);
				array_push($tmproad, $ranswer['roadn']);
				array_push($tmpsea, $ranswer['sean']);
				//echo "{$ranswer['vd']}";
	?>
					<tr>
						<td><?php echo $ranswer['vno']; ?></td>
						<td><?php echo $ranswer['vd']; ?></td>
						<td><?php echo $ranswer['air']; ?></td>
						<td><?php echo round($ranswer['aird'],2); ?></td>
						<td><?php echo $ranswer['sea']; ?></td>
						<td><?php echo round($ranswer['sean'],2); ?></td>
						<td><?php echo $ranswer['road']; ?></td>
						<td><?php echo round($ranswer['roadn'],2); ?></td>
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
						<td><label><label><?php echo $ranswer2['air']; ?></label></td>
						<td><label><?php echo round($ranswer2['aird'],2); ?></label></td>
						<td><label><label><?php echo $ranswer2['sea']; ?></label></td>
						<td><label><?php echo round($ranswer2['sean'],2); ?></label></td>
						<td><label><label><?php echo $ranswer2['road']; ?></label></td>
						<td><label><?php echo round($ranswer2['roadn'],2); ?></label></td>
					</tr>
	<?php
		}
		mysqli_free_result($rresult);
		mysqli_free_result($rresult2);
	?>
				</tbody>
			</table>
		</textarea>
		<script type="text/javascript">
			$(function () {
			    $('#container-graph4').highcharts({
			        chart: {
			            type: 'column'
			        },
			        title: {
			            text: 'Mode of Shipment Summary'
			        },
			        xAxis: {
			            categories: [
			            <?php
			            $tmpstr = ""; 
			            foreach ($tmpvd as $value) {
						    $tmpstr = $tmpstr.",'{$value}'";
						}
						echo substr($tmpstr, 1);
			            ?>
			            ]
			        },
			        yAxis: {
			            min: 0,
			            title: {
			                text: 'Gross Amount'
			            },
			            stackLabels: {
			                enabled: true,
			                style: {
			                    fontWeight: 'bold',
			                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
			                }
			            }
			        },
			        legend: {
			            align: 'right',
			            x: -70,
			            verticalAlign: 'top',
			            y: 20,
			            floating: true,
			            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
			            borderColor: '#CCC',
			            borderWidth: 1,
			            shadow: false
			        },
			        tooltip: {
			            formatter: function () {
			                return '<b>' + this.x + '</b><br/>' +
			                    this.series.name + ': ' + this.y + '<br/>' +
			                    'Total: ' + this.point.stackTotal;
			            }
			        },
			        plotOptions: {
			            column: {
			                stacking: 'normal',
			                dataLabels: {
			                    enabled: true,
			                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
			                    style: {
			                        textShadow: '0 0 3px black, 0 0 3px black'
			                    }
			                }
			            }
			        },
			        credits: {
		                enabled: false
		            },
			        series: [{
			            name: 'Sea',
			            data: [<?php
			            $tmpstr = ""; 
			            foreach ($tmpsea as $value) {
						    $tmpstr = $tmpstr.",".round($value,2);
						}
						echo substr($tmpstr, 1);
			            ?>]
			        }, {
			            name: 'Road',
			            data: [<?php
			            $tmpstr = ""; 
			            foreach ($tmproad as $value) {
						    $tmpstr = $tmpstr.",".round($value,2);
						}
						echo substr($tmpstr, 1);
			            ?>]
			        }, {
			            name: 'Air',
			            data: [<?php
			            $tmpstr = ""; 
			            foreach ($tmpair as $value) {
						    $tmpstr = $tmpstr.",".round($value,2);
						}
						echo substr($tmpstr, 1);
			            ?>]
			        }]
			    });
			});
		</script>
    	<div id="container-graph4" style="min-width: 400px; max-width: 100%; height: 400px; margin: 0 auto"></div>
    	<a href="#" data-toggle="modal" data-target="#myModal" onclick="transferHTML('shipsum')">View Summary</a>
	</div>
	<div class="col-md-10" id="final_summary2" style="display:none;">
	</div>
</div>
	    <script src="js/graph/js/highcharts.js"></script>
	    <script src="js/graph/js/modules/exporting.js"></script>