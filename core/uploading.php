<hr>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <center>
  <div class="carousel-inner">
    <div class="item active">
      <img src="images/image1.png" alt="..." style="height:300px;">
      <div class="carousel-caption">
       <span class="alert alert-success"> Upload Your Data</span>
      </div>
    </div>
    <div class="item">
      <img src="images/image2.jpg" alt="..." style="height:300px;">
      <div class="carousel-caption">
        <span class="alert alert-success">It Must be an Excel 2007 File (xlsx)</span>
      </div>
    </div>
    <div class="item">
      <img src="images/waiting.png" alt="..." style="height:300px;">
      <div class="carousel-caption">
        <span class="alert alert-success">Wait Until It Prompts</span>
      </div>
    </div>
  </div>
</center>
  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>
<hr>
<div class="container-fluid">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
	  <li class="active"><a href="#cockpit" role="tab" data-toggle="tab">Cockpit</a></li>
	  <li><a href="#podata" role="tab" data-toggle="tab">PO Data</a></li>
	  <li><a href="#masterfile" role="tab" data-toggle="tab">Master File</a></li>
	  <li><a href="#peoplesoft" role="tab" data-toggle="tab">PeopleSoft</a></li>
	  <li><a href="#matrix" role="tab" data-toggle="tab">Matrix</a></li>
	  <li><a href="#mvp" role="tab" data-toggle="tab">Material Vs PC</a></li>
	  <li><a href="#charge1" role="tab" data-toggle="tab">Charges 1</a></li>
	  <li><a href="#charge2" role="tab" data-toggle="tab">Charges 2</a></li>
	  <li><a href="#charge3" role="tab" data-toggle="tab">Charges 3</a></li>
	  <li><a href="#charge4" role="tab" data-toggle="tab">Charges 4</a></li>
	  <li><a href="#fbl1n" role="tab" data-toggle="tab">FBL1N</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
	  <div class="tab-pane active" id="cockpit">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Upload Cockpit Excel (.xlsx 2007) File</h3>
			</div>
			<div class="panel-body">
				<form action="core/upload_cockpit.php" method="post" enctype="multipart/form-data" target="hiddenframe">
					<input type="file" name="myfile" id="file" class="form-control">
					<input type="hidden" value="AU" name="myctry">
					<button type="submit" name="submit" class="btn btn-primary submitfile" data-toggle="modal" data-target="#myModal">Upload <span class="glyphicon glyphicon-upload"></span></button><a href="format/cockpit.xlsx" class="pull-right">Download Format</a>
				</form>
			</div>
		</div>
	  </div>
	  <div class="tab-pane" id="podata">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Upload PO Data Excel (.xlsx 2007) File</h3>
			</div>
			<div class="panel-body">
				<form action="core/upload_podata.php" method="post" enctype="multipart/form-data" target="hiddenframe">
					<input type="file" name="myfile" id="file" class="form-control">
					<input type="hidden" value="AU" name="myctry">
					<button type="submit" name="submit" class="btn btn-primary submitfile" data-toggle="modal" data-target="#myModal">Upload <span class="glyphicon glyphicon-upload"></span></button><a href="format/podata.xlsx" class="pull-right">Download Format</a>
				</form>
			</div>
		</div>	  
	  </div>
	  <div class="tab-pane" id="masterfile">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Upload Master File Excel (.xlsx 2007) File</h3>
			</div>
			<div class="panel-body">
				<form action="core/upload_masterfile.php" method="post" enctype="multipart/form-data" target="hiddenframe">
					<input type="file" name="myfile" id="file" class="form-control">
					<input type="hidden" value="AU" name="myctry">
					<button type="submit" name="submit" class="btn btn-primary submitfile" data-toggle="modal" data-target="#myModal">Upload <span class="glyphicon glyphicon-upload"></span></button><a href="format/masterfile.xlsx" class="pull-right">Download Format</a>
				</form>
			</div>
		</div>	  
	  </div>
	  <div class="tab-pane" id="peoplesoft">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Upload PeopleSoft Excel (.xlsx 2007) File</h3>
			</div>
			<div class="panel-body">
				<form action="core/upload_peoplesoft.php" method="post" enctype="multipart/form-data" target="hiddenframe">
					<input type="file" name="myfile" id="file" class="form-control">
					<input type="hidden" value="AU" name="myctry">
					<button type="submit" name="submit" class="btn btn-primary submitfile" data-toggle="modal" data-target="#myModal">Upload <span class="glyphicon glyphicon-upload"></span></button><a href="format/peoplesoft.xlsx" class="pull-right">Download Format</a>
				</form>
			</div>
		</div>	
	  </div>
	  <div class="tab-pane" id="matrix">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Upload Matrix Excel (.xlsx 2007) File</h3>
			</div>
			<div class="panel-body">
				<form action="core/upload_matrix.php" method="post" enctype="multipart/form-data" target="hiddenframe">
					<input type="file" name="myfile" id="file" class="form-control">
					<input type="hidden" value="AU" name="myctry">
					<button type="submit" name="submit" class="btn btn-primary submitfile" data-toggle="modal" data-target="#myModal">Upload <span class="glyphicon glyphicon-upload"></span></button><a href="format/matrix.xlsx" class="pull-right">Download Format</a>
				</form>
			</div>
		</div>		  
	  </div>
	  <div class="tab-pane" id="mvp">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Upload Material Vs PC Excel (.xlsx 2007) File</h3>
			</div>
			<div class="panel-body">
				<form action="core/upload_mvp.php" method="post" enctype="multipart/form-data" target="hiddenframe">
					<input type="file" name="myfile" id="file" class="form-control">
					<input type="hidden" value="AU" name="myctry">
					<button type="submit" name="submit" class="btn btn-primary submitfile" data-toggle="modal" data-target="#myModal">Upload <span class="glyphicon glyphicon-upload"></span></button><a href="format/materialvspc.xlsx" class="pull-right">Download Format</a>
				</form>
			</div>
		</div>	
	  </div>
	  <div class="tab-pane" id="charge1">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Upload Charges 1 Excel (.xlsx 2007) File</h3>
			</div>
			<div class="panel-body">
				<form action="core/upload_charge1.php" method="post" enctype="multipart/form-data" target="hiddenframe">
					<input type="file" name="myfile" id="file" class="form-control">
					<input type="hidden" value="AU" name="myctry">
					<button type="submit" name="submit" class="btn btn-primary submitfile" data-toggle="modal" data-target="#myModal">Upload <span class="glyphicon glyphicon-upload"></span></button><a href="format/charge1.xlsx" class="pull-right">Download Format</a>
				</form>
			</div>
		</div>	
	  </div>
	  <div class="tab-pane" id="charge2">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Upload Charges 2 Excel (.xlsx 2007) File</h3>
			</div>
			<div class="panel-body">
				<form action="core/upload_charge2.php" method="post" enctype="multipart/form-data" target="hiddenframe">
					<input type="file" name="myfile" id="file" class="form-control">
					<input type="hidden" value="AU" name="myctry">
					<button type="submit" name="submit" class="btn btn-primary submitfile" data-toggle="modal" data-target="#myModal">Upload <span class="glyphicon glyphicon-upload"></span></button><a href="format/charge2.xlsx" class="pull-right">Download Format</a>
				</form>
			</div>
		</div>	
	  </div>
	  <div class="tab-pane" id="charge3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Upload Charges 3 Excel (.xlsx 2007) File</h3>
			</div>
			<div class="panel-body">
				<form action="core/upload_charge3.php" method="post" enctype="multipart/form-data" target="hiddenframe">
					<input type="file" name="myfile" id="file" class="form-control">
					<input type="hidden" value="AU" name="myctry">
					<button type="submit" name="submit" class="btn btn-primary submitfile" data-toggle="modal" data-target="#myModal">Upload <span class="glyphicon glyphicon-upload"></span></button><a href="format/charge3.xlsx" class="pull-right">Download Format</a>
				</form>
			</div>
		</div>	
	  </div>
	  <div class="tab-pane" id="charge4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Upload Charges 4 Excel (.xlsx 2007) File</h3>
			</div>
			<div class="panel-body">
				<form action="core/upload_charge4.php" method="post" enctype="multipart/form-data" target="hiddenframe">
					<input type="file" name="myfile" id="file" class="form-control">
					<input type="hidden" value="AU" name="myctry">
					<button type="submit" name="submit" class="btn btn-primary submitfile" data-toggle="modal" data-target="#myModal">Upload <span class="glyphicon glyphicon-upload"></span></button><a href="format/charge4.xlsx" class="pull-right">Download Format</a>
				</form>
			</div>
		</div>	
	  </div>
	  <div class="tab-pane" id="fbl1n">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Upload FBL1N Excel (.xlsx 2007) File</h3>
			</div>
			<div class="panel-body">
				<form action="core/upload_fbl1n.php" method="post" enctype="multipart/form-data" target="hiddenframe">
					<input type="file" name="myfile" id="file" class="form-control">
					<input type="hidden" value="AU" name="myctry">
					<button type="submit" name="submit" class="btn btn-primary submitfile" data-toggle="modal" data-target="#myModal">Upload <span class="glyphicon glyphicon-upload"></span></button><a href="format/fbl1n.xlsx" class="pull-right">Download Format</a>
				</form>
			</div>
		</div>	
	  </div>
	</div>
</div>