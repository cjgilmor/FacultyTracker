<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Faculty Tracker - Login</title>
<link href="loginstyles.css" rel="stylesheet" type="text/css">
</head>

<body>  
<?php include("headnav.php") ?>   
<!--    <div id="content">
    <div id="box"> -->
      <h3> Login </h3>
    <form action="flogin.php" method="POST"> 
        <input type="text" name="username" class="user" placeholder="Username" >
		<input type="password" name="password" class="pass" placeholder="Password" >
		<input type="submit" class="submit" >
	</form>

    <!--	</div> End inner box 
    	</div> <!--End box-->
    <!--End main content-->
<?php include("footer.php") ?>
</body>
</html>
