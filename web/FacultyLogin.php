<html>
	<head>
		<meta charset="utf-8">
		<title>Faculty Tracker - Login</title>
		<link href="styles.css" rel="stylesheet" type="text/css">
		<!--<link href="loginstyles.css" rel="stylesheet" type="text/css">-->
	</head>
	<body> 
		<div class="wrapper" align= "center">
			<?php include("headnav.php") ?>   
				  <h3 style="color:white"> Login </h3>
				<form action="flogin.php" method="POST"> 
					<table border=1>
						<tr><td><input type="text" name="username" class="log_user" placeholder="Username" /></td></tr>
						<tr><td><input type="password" name="password" class="log_pass" placeholder="Password" /></td></tr>
						<tr><td><input type="submit" class="log_submit" /></td></tr>
					</table>
				</form>
			<?php include("footer.php") ?>
		</div>
	</body>
</html>