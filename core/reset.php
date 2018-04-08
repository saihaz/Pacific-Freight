<div class="container" id="resetPage">
	<hr>
	<div class="col-md-4 col-md-offset-1">
		<div class="panel panel-primary">
		  <div class="panel-heading">
		    <h3 class="panel-title">Forgot Your Password?</h3>
		  </div>
		  <div class="panel-body">
		  	<div class="form-group">
		  		<form action="core/reset_password.php" method="post" target="hiddenframe" id="mailPin">
					<label for="seEmail">Enter your SE E-mail Address</label>
					<input type="email" class="form-control" id="seEmail" name="semail" placeholder="ie. Name.Surname@schneider-electric.com" required>
				  	<p class="help-block">Please check your mail for reset pin</p>
			   		<input type="submit" class="btn btn-primary pull-right" value="Reset">
		   		</form>
			</div>
		    
		  </div>
		</div>
	</div>
	<div class="col-md-4 col-md-offset-1">
		<div class="panel panel-primary">
		  <div class="panel-heading">
		    <h3 class="panel-title">Enter New Password</h3>
		  </div>
		  <div class="panel-body">
		  	<div class="form-group">
		  		<form action="core/new_password.php" method="post" target="hiddenframe" id="newPass">
					<label for="senpword">New Password</label>
					<input type="password" class="form-control" id="senpword" name="senpword" placeholder="Create your new password" required>
					<label for="serpword">Re-Enter New Password</label>
					<input type="password" class="form-control" id="serpword" name="serpword" placeholder="Re-enter your new password" required>
					<hr>
					<label for="senpin">Reset PIN</label>
					<input type="text" class="form-control" id="senpin" name="senpin" required>
				  	<p class="help-block">Please check your mail for reset pin</p>
			   		<input type="submit" class="btn btn-primary pull-right" value="Save">
		  	 	</form>
			</div>
		    
		  </div>
		</div>
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