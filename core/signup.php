<div class="container" id="mysignup">
	<div class="col-md-4 col-md-offset-1" id="announce">
		<h1>Guide</h1>
		<hr>
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
		    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
		    <div class="item active">
		    	<center>
		    		<h3>Fill up all the fields<br> in the form</h3>
		    	</center>
		    	<hr>
		      <!--<img src="..." alt="...">-->
		      <div class="carousel-caption">
		        ...
		      </div>
		    </div>
		    <div class="item">
		    	<center>
		    		<h3>Wait for the e-mail<br>Confirmation &amp; Activation</h3>
		    	</center>
		    	<hr>
		      <!--<img src="..." alt="...">-->
		      <div class="carousel-caption">
		        ...
		      </div>
		    </div>
		    <div class="item">
		    	<center>
		    		<h3>Your account will be activated<br> according to your process</h3>
		    	</center>
		    	<hr>
		      <!--<img src="..." alt="...">-->
		      <div class="carousel-caption">
		        ...
		      </div>
		    </div>
		    ...
		  </div>

		  <!-- Controls 
		  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>-->
		</div>
	</div>
	<div class="col-md-5 col-md-offset-1" id="minew">
		<form action="core/newuser.php" method="post" target="hiddenframe" id="signupform">
		<table class="table">
			<thead>
					<tr>
						<th colspan="2"><h1>New User</h1></th>
					</tr>
			</thead>
			<tbody>
				<tr>
					<td><label>Firstname</label></td>
					<td><input type="text" class="form-control" name="fname" id="fname" required></td>
				</tr>
				<tr>
					<td><label>Lastname</label></td>
					<td><input type="text" class="form-control" name="lname" id="lname" required></td>
				</tr>
				<tr>
					<td><label>SESA ID</label></td>
					<td><input type="text" class="form-control" name="sesa" id="sesa" required></td>
				</tr>
				<tr>
					<td><label>SE Mail Add</label></td>
					<td><input type="email" class="form-control" name="semail" id="semail" required></td>
				</tr>
				<tr>
					<td><label>Username</label></td>
					<td><input type="text" class="form-control" name="uname" id="uname" required></td>
				</tr>
				<tr>
					<td><label>Password</label></td>
					<td><input type="password" class="form-control" name="pword" id="pword" required></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" class="btn btn-primary pull-right" value="Sign Up"></td>
				</tr>
			</tbody>
		</table>
	</form>
	</div>
</div>

<div id="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-lg-offset-3">
					<p class="copyright">Copyright &copy; 2015 - Pacific Freight : Schneider Electric</p>
			</div>
		</div>		
	</div>	
</div>