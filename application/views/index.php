
<!DOCTYPE html>
	<html ng-app="myApp">
	<head>
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="assets/css/bootstrap.min.css">
			<link rel="stylesheet" href="assets/css/halflings.css">
			<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<style>
body {
background: #e6cca6 url(/assets/images/wood.png) repeat fixed;

}
.panel{border:2px solid #AEAB91;}
</style>
	<body color="woodbg">
		<div class="container">
			<div class="col-lg-offset-4 col-lg-4">
				<div class="panel">
					<div class="panel-heading">Sign in</div>
					<form method="post" name="form" ng-submit="submitForm()" ng-controller="FormCtrl" novalidate>
						<div class="form-group">
							<span style="color:red" >{{error}}</span><br/>
							<label for="username" class="control-label">Username</label>
							<input type="text" name="username" id="username" placeholder="Username" unique-username required ng-model="username" autofocus class="form-control" ng-minlength="3" ng-maxlength="20">
							<i ng-show="busy" class="halflings-icon refresh rotating"></i>
							<span ng-show="form.username.$dirty &amp;&amp; form.username.$error.required" class="help-block">
								Please choose a username
							</span>					
							<span ng-show="form.username.$dirty &amp;&amp; form.username.$error.invalidChars" test="{{form.username.$error.invalidChars}}" class="help-block">Username may not contain any non-url-safe characters</span>
							<span ng-show="form.username.$dirty &amp;&amp; form.username.$error.maxlength" class="help-block">Username sholuld not exceed 20 characters</span>
							<span ng-show="form.username.$dirty &amp;&amp; form.username.$error.minlength" class="help-block"> Username Should Contain Atleast 3 Characters</span>
						</div>						
						<div class="form-group">
							<label for="password" class="control-label">Password</label>
							<input type="password" name="password" id="password" ng-model="password" placeholder="Password" ng-maxlength="20" required class="form-control">
							<span ng-show="form.password.$dirty &amp;&amp; form.password.$error.required" class="help-block">Please enter a password</span>
							<span ng-show="form.password.$dirty &amp;&amp; form.password.$error.maxlength" class="help-block">Sorry You are Exceeding the Limit</span>						
						</div>						
						<input type="submit" value="Sign in" ng-disabled="form.$invalid" class="btn btn-primary">
					</form>
				</div>
			</div>
		</div>
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/angular.js"></script>
		<script src="assets/js/script_login.js"></script>
	</body>
	</html>

