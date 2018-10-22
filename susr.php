<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php
include("connect.php");
//Code to connect to the database
$con = mysql_connect($hostname, $dbusername, $dbpassword);
	
//If it couldnt connect to the database, the error message will tell us why	
if (!$con)
{
	die('Unable to connect to MySQL' . mysql_error());
}

$selected_db = mysql_select_db($databaseName, $con);

//Checks to see if the user is logged into the system
if (!isset($_SESSION['basic_is_logged_in']) 
    || $_SESSION['basic_is_logged_in'] !== true) {

	//Redirects the user to the login page
    ob_start();
    include("floogin.php");
    ob_flush();
	exit;
	
}

$name = $_POST['Name'];
$username = strtolower($_POST['Username']);
$pass = $_POST['pwd1'];
$lvl = $_POST['lvl'];
$uid = $_POST['hiddenField'];

// Delete query:
// DELETE FROM staff WHERE staffID = $uid;
if(!$_POST['save'])
{
	// If delete is used
	echo "<script type='text/javascript'>alert('" . $name . " was DELETED!');</script>";
	mysql_query("DELETE FROM staff WHERE staffID = $uid") or die(mysql_error());
	include("AdminHome.html");
}
else if($uid == NULL)		// If no user is selected, it means its a new user
{
	$qryUser = mysql_query("SELECT * FROM staff WHERE staff.username = $username");
	
	if($qryUser == false)
	{
		// Inserts the new users info into the database
		$epass = md5($pass);
		echo "<script type='text/javascript'>confirm('" . $name . " was inserted into the database.');</script>";
		$sql = "INSERT INTO staff(name, username, password, level) VALUES ('$name', '$username', '$epass', '$lvl')";
	}
	else
	{
		echo "<script type='text/javascript'>alert('Username already exists');</script>";
	}
		
}
else
{
	// Updates the existing users info in the database
	if(strlen($pass)!= 32){$epass = md5($pass);}// To ensure you dont re-encrypt an encrypted password
	else{$epass = $pass;}
	echo "<script type='text/javascript'>confirm('" . $name . " was updated.');</script>";
	$sql = "UPDATE staff SET name = '$name', username = '$username', password = '$epass', level = '$lvl' WHERE staff.staffID = '$uid'";
}

// Does query based off "if" statement
mysql_query($sql) or die(mysql_error());

//Redirects to this page
ob_start();
include("Administrator.html");
ob_flush();
exit;

?>


</head>
<body>

</body>
</html>