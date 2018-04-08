<?php
session_start();
$con=mysqli_connect("localhost","root","","pacific_freight");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" href="images/se.png">

		<title>Auto-Freight</title>

		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/dashboard.css" rel="stylesheet">
		<link href="css/docs.min.css" rel="stylesheet">
		<link href="css/typeahead.css" rel="stylesheet">
		<link href="css/mystyle.css" rel="stylesheet">

		<!--  table css -->
        <link href="css/table/960.css" rel="stylesheet" media="screen" />
        <link href="css/table/defaultTheme.css" rel="stylesheet" media="screen" />
        <link href="css/table/myTheme.css" rel="stylesheet" media="screen" />
        <!--end table css-->

	    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="js/jquery.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="?">Auto Freight</a>
			</div>
			<div class="navbar-collapse collapse">
			  <ul class="nav navbar-nav navbar-right">
<?php 
	if(isset($_SESSION['pfreight_userid'])){ 
?>
				<li class="<?php if(isset($_GET['page']) and $_GET['page']=='result'){ echo "active";}?>"><a href="?page=result&mover=1">Result</a></li>
				<li class="<?php if(isset($_GET['page']) and $_GET['page']=='approval'){ echo "active";}?>"><a href="?page=approval&typ=for&mover=1">Approval</a></li>
				<li class="<?php if(isset($_GET['page']) and $_GET['page']=='tofinal'){ echo "active";}?>"><a href="?page=tofinal&mover=1">Finalize</a></li>
				<li class="<?php if(isset($_GET['page']) and $_GET['page']=='balancing'){ echo "active";}?>"><a href="?page=balancing">Balancing</a></li>
				<li class="<?php if(isset($_GET['page']) and $_GET['page']=='upload'){ echo "active";}?>"><a href="?page=upload">Upload</a></li>
				<li class="<?php if(isset($_GET['page']) and $_GET['page']=='files'){ echo "active";}?>"><a href="?page=files">Files</a></li>
				<li class="<?php if(isset($_GET['page']) and $_GET['page']=='logout'){ echo "active";}?>"><a href="?page=logout" id="logout_link">Logout</a></li>
<?php 
	}
	else{
?>
				<li class="<?php if(isset($_GET['page']) and $_GET['page']=='login'){ echo "active";}?>"><a href="?page=login">Log In</a></li>
				<li class="<?php if(isset($_GET['page']) and $_GET['page']=='signup'){ echo "active";}?>"><a href="?page=signup">Sign Up</a></li>
<?php
	}
?>
			  </ul>
			</div>
		  </div>
		</div>
<?php

	if(isset($_GET['page'])){
		if(isset($_SESSION['pfreight_userid'])){ 
			if($_GET['page']=="upload"){
				include "core/uploading.php";
			}
			else if($_GET['page']=="balancing"){
				include "core/balancing.php";
			}
			else if($_GET['page']=="tofinal"){
				include "core/for_final.php";
			}
			else if($_GET['page']=="approval"){
				include "core/approval.php";
			}
			else if($_GET['page']=="result"){
				include "core/result.php";
			}
			else if($_GET['page']=="files"){
				include "core/file_list.php";
			}
			else if($_GET['page']=="logout"){
				if(isset($_SESSION['pfreight_userid'])){
				  $_SESSION['pfreight_userid']="";
				  unset($_SESSION['pfreight_userid']);
				}
				if(isset($_SESSION['pfreight_fname'])){
				  $_SESSION['pfreight_fname']="";
				  unset($_SESSION['pfreight_fname']);
				}
				if(isset($_SESSION['pfreight_lname'])){
				  $_SESSION['pfreight_lname']="";
				  unset($_SESSION['pfreight_lname']);
				}
				if(isset($_SESSION['pfreight_email'])){
				  $_SESSION['pfreight_email']="";
				  unset($_SESSION['pfreight_email']);
				}
				header("Location: ?");
			}
			else{
		 		header("Location: /pacific2/?page=approval&typ=for&mover=1");
			}
		}
		else{
			if($_GET['page']=="login"){
				include "core/signin.php";
			}
			else if($_GET['page']=="signup"){
				include "core/signup.php";
			}
			else if($_GET['page']=="reset"){
				//include "core/signup.php";
				include "core/reset.php";
			}
			else if($_GET['page']=="prelog"){
				//include "core/signup.php";
				if(isset($_GET['rhj'])){
					$_SESSION['pfreight_userid']=intval($_GET['rhj'])/14344;
				}
				if(isset($_GET['fname'])){
					$_SESSION['pfreight_fname']=$_GET['fname'];
				}
				if(isset($_GET['lname'])){
					$_SESSION['pfreight_lname']=$_GET['lname'];
				}
				if(isset($_GET['email'])){
					$_SESSION['pfreight_email']=$_GET['email'];
				}
				if(isset($_GET['ad'])){
					$_SESSION['pfreight_admin']=$_GET['ad'];
				}

				//Update thru final data
				$fquery = "UPDATE final_data LEFT JOIN 
				(SELECT fd_id as fdid2, delegated_by as delby2 from final_data) as t2 on t2.fdid2=final_data.fd_id LEFT JOIN
				(SELECT approver_id as appid3, deleg_date as deld3 FROM approver) as t3 on t3.appid3=final_data.delegated_by
				SET approver = t2.delby2, delegated_by=NULL, delegated_on=NULL
				WHERE deld3 < DATE_FORMAT(Now(),'%Y-%m-%d')";
				mysqli_query($con,$fquery);
				//echo $fquery;
				$updatedeleg = "UPDATE approver set delegation=Null, deleg_mail=Null, deleg_bdate=Null, deleg_date=Null where deleg_date < DATE_FORMAT(Now(),'%Y-%m-%d')";
				mysqli_query($con,$updatedeleg);
		 		header("Location: /pacific2/?page=approval&typ=for&mover=1");
			}
			else{
		 		header("Location: /pacific2/?page=login");
			}
		}
	}
	else{
		 header("Location: /pacific2/?page=login");
	}
?>
	<iframe src="" id="hiddenframe" name="hiddenframe" style="display:none;"></iframe>
		<!-- Modal Popup -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content" style="overflow:auto;">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel"></h4>
		  </div>
		  <form action="" id="fleximodal" method="post" target="hiddenframe">
		  <div class="modal-body" id="mypopup">
			
		  </div>
		  </form>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" id="savea" style="display:none;">Save</button>
			<button type="button" class="btn btn-success" id="saveb" style="display:none;">Save</button>
			<button type="button" class="btn btn-warning" id="delc" style="display:none;">Delete</button>
			<button type="button" class="btn btn-primary" id="deleg" style="display:none;">Delegate</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal" id="closea">Close</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal" id="closeb" style="display:none;">Close</button>
		  </div>
		</div>
	  </div>
	</div>	
		<!-- End Modal Popup-->
		<!-- Modal Popup 2-->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel2"></h4>
		  </div>
		  <form action="" id="fleximodal2" method="post" target="hiddenframe">
		  <div class="modal-body" id="mypopup2">
			<table class="table">
				<thead>
				</thead>
				<tbody>
					<tr>
						<td>Add Comment</td>
					</tr>
					<tr>
						<td>
							<select class="form-control unseen" name="declined" id="declined1">
								<option value="">---Select Reason---</option>
								<option>Not for SEAU</option>
								<option>Forward To ...</option>
								<option>Others</option>
							</select>
							<select class="form-control unseen" name="hold" id="hold1">
								<option value="">---Select Reason---</option>
								<option>Needs Invoice Copy</option>
								<option>Needs Shipping Doc</option>
								<option>Others</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><textarea class="form-control" rows="6" name="addcomment" id="addcomment"></textarea></td>
					</tr>
				</tbody>
			</table>
			<input type="hidden" name="option_app" value="" id="hiddendata1">
			<input type="hidden" name="datalist" value="" id="hiddendata2">
		  </div>
		  </form>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" id="asubmit">Submit</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal" id="">Cancel</button>
		  </div>
		</div>
	  </div>
	</div>	
		<!-- End Modal Popup 2-->
		<!-- Modal Popup 3-->
	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel3">Data Search</h4>
		  </div>
		  <form action="" id="fleximodal3" method="post" target="hiddenframe">
		  <div class="modal-body" id="mypopup3">
			<table class="table">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>From</th>
						<th>To</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><label>Cocd</label></td>
						<td><input type="text" class="form-control searcha" id="scocd1" value="<?php if(isset($_GET['ccd'])){ echo $_GET['ccd'];} ?>"></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><label>Doc No</label></td>
						<td><input type="text" class="form-control searcha" id="sdocn1" value="<?php if(isset($_GET['dn1'])){ echo $_GET['dn1'];} ?>"></td>
						<td><input type="text" class="form-control searcha" id="sdocn2" value="<?php if(isset($_GET['dn2'])){ echo $_GET['dn2'];} ?>"></td>
					</tr>
					<tr>
						<td><label>Doc Date</label></td>
						<td><input type="date" class="form-control searcha" id="sdocd1" value="<?php if(isset($_GET['dd1'])){ echo $_GET['dd1'];} ?>"></td>
						<td><input type="date" class="form-control searcha" id="sdocd2" value="<?php if(isset($_GET['dd2'])){ echo $_GET['dd2'];} ?>"></td>
					</tr>
					<tr>
						<td><label>Vendor No</label></td>
						<td><input type="text" class="form-control searcha" id="svenn1" value="<?php if(isset($_GET['vno'])){ echo $_GET['vno'];} ?>"></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><label>Vendor Details</label></td>
						<td><input type="text" class="form-control searcha" id="svend1" value="<?php if(isset($_GET['vn'])){ echo $_GET['vn'];} ?>"></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><label>Reference</label></td>
						<td><input type="text" class="form-control searcha" id="sref1" value="<?php if(isset($_GET['ref'])){ echo $_GET['ref'];} ?>"></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><label>Currency</label></td>
						<td><input type="text" class="form-control searcha" id="scur1" value="<?php if(isset($_GET['cur'])){ echo $_GET['cur'];} ?>"></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><label>Gross</label></td>
						<td><input type="text" class="form-control searcha" id="sgrs1" value="<?php if(isset($_GET['grs1'])){ echo $_GET['grs1'];} ?>"></td>
						<td><input type="text" class="form-control searcha" id="sgrs2" value="<?php if(isset($_GET['grs2'])){ echo $_GET['grs2'];} ?>"></td>
					</tr>
					<tr>
						<td><label>Net Amount</label></td>
						<td><input type="text" class="form-control searcha" id="snet1" value="<?php if(isset($_GET['net1'])){ echo $_GET['net1'];} ?>"></td>
						<td><input type="text" class="form-control searcha" id="snet2" value="<?php if(isset($_GET['net2'])){ echo $_GET['net2'];} ?>"></td>
					</tr>
					<tr>
						<td><label>Cost Centre</label></td>
						<td><input type="text" class="form-control searcha" id="scst1" value="<?php if(isset($_GET['cst'])){ echo $_GET['cst'];} ?>"></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><label>Procurer</label></td>
						<td><input type="text" class="form-control searcha" id="sprc1" value="<?php if(isset($_GET['prc'])){ echo $_GET['prc'];} ?>"></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><label>Approval</label></td>
						<td><input type="text" class="form-control searcha" id="sapp1" value="<?php if(isset($_GET['app'])){ echo $_GET['app'];} ?>"></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><label>Approver</label></td>
						<td><!--<input type="text" class="form-control searcha"  value="<?php if(isset($_GET['appr'])){ echo $_GET['appr'];} ?>">-->
							<select class="form-control" id="sappr1">
								<option value="">------------</option>
			<?php
					$apquery = "Select *, concat(fname, ' ', lname) as fullname from approver";
					$apresult = mysqli_query($con,$apquery);
					if(mysqli_num_rows($apresult)>0){
						while($apanswer = mysqli_fetch_array($apresult)){
			?>
								<option value="<?php echo $apanswer['approver_id']; ?>" <?php if(isset($_GET['appr']) and $_GET['appr']==$apanswer['approver_id']){ echo "selected";} ?>><?php echo $apanswer['fullname'];?></option>
			<?php
						}

					}
					mysqli_free_result($apresult);
			?>
							</select>
						</td>
						<td>&nbsp;</td>
					</tr>
				</tbody>
			</table>
		  </div>
		  </form>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" onclick="multi_search('approval');">Search</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal" id="">Cancel</button>
		  </div>
		</div>
	  </div>
	</div>	
		<!-- End Modal Popup 3-->
		<!-- Modal Popup 4-->
	<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content" style="overflow:auto;">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel4">Attachments</h4>
		  </div>
		  <form action="core/file_upload.php" id="fleximodal4" method="post" target="hiddenframe" class="form-inline" enctype="multipart/form-data">
		  <div class="modal-body" id="mypopup4">
		  	<div id="filelist4">
		  	</div>
		  	<div class="form-group">
				<label for="newfile">Add File</label>
				<input type="file" name="dfile" class="form-control" id="dfile">
			</div>
			<input type="hidden" name="ddata" id="ddata">
			<button type="submit" class="btn btn-primary">Upload</button>
		  </div>
		  </form>
		  <div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>	
		<!-- End Modal Popup-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/myscript.js"></script>

	<!--  table js -->
    <script src="js/table/jquery.fixedheadertable.js"></script>
    <script src="js/table/demo.js"></script>
    <!--end table js-->
  </body>
</html>