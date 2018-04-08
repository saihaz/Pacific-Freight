<div class="container" id="mysignin">
<div class="col-md-4 col-md-offset-1" id="misign">
	<form action="core/login.php" method="post" class="form-signin" target="hiddenframe" role="form" id="loginform">
		<h2 class="form-signin-heading">System Login</h2>
		<label for="username" class="sr-only">Username</label>
		<input type="text" id="username" class="form-control" placeholder="Username" required="" autofocus="" name="username">
		<label for="password" class="sr-only">Password</label>
		<input type="password" id="password" class="form-control" placeholder="Password" required="" name="password"></input>

		<div class="alert alert-danger" role="alert" style="display:none;" id="alert_prompt">
		  <button type="button" class="close" id="justClose" aria-label="Close" onclick="$('#alert_prompt').hide(1000);"><span aria-hidden="true">&times;</span></button>
		  <strong>Error!</strong> <span id="alert_span"></span>
		</div>
	    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		<a href="?page=reset" class="pull-right">Forgot Password?</a>
		<hr>
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