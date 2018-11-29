<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Tools</title>
<link href="toolstyles.css" rel="stylesheet" type="text/css">
</head>
<?php
session_start();
include('nfMv6SUnU9.php');
//Checks to see if the user is logged into the system
if (!isset($_SESSION['basic_is_logged_in']) 
    || $_SESSION['basic_is_logged_in'] !== true) {

	//Redirects the user to the login page
    ob_start();
    include("flogin.php");
    ob_flush();
	exit;
}

$type = $_POST['hf-s'];
$uid = $_POST['huid'];

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$dept = $_POST['s-dept'];
$email = $_POST['email'];
$office = $_POST['office'];
$un = strtolower($_POST['un']);
$pw = $_POST['pass'];

if(isset($pw) && trim($pw) != '')$pw = md5($pw);
// Delete query:
// DELETE FROM staff WHERE staffID = $uid;
if($type=="3") {
	// If delete is used
	echo "<script type='text/javascript'>alert('".$fname." ".$lname." was DELETED!');</script>";
	mysqli_query($conn, "DELETE FROM staff WHERE staffID = $uid") or die(mysqli_error($conn));
} else if($type=="1")	{	// If no user is selected, it means its a new user

//	$qryUser = mysqli_query($conn, "SELECT COUNT(staffID) AS output FROM staff WHERE staff.un = '$un'") or die(mysqli_error($conn));	
//	if($qryUser->num_rows === 0) {
		// Inserts the new users info into the database
		echo "<script type='text/javascript'>confirm('".$fname." ".$lname." was inserted into the database.!!');</script>";
		$sql = "INSERT INTO staff (deptID, fName, lName, titleID, email, office, un, pw, status) VALUES ('$dept', '$fname', '$lname', '2', '$email', '$office', '$un', '$pw', '0');";
		mysqli_query($conn, $sql) or die(mysqli_error($conn));
//	} else { echo "<script type='text/javascript'>alert('Username already exists.1');</script>"; }
		
} else {
	// Updates the existing users info in the database
//	$qryUser = mysqli_query($conn, "SELECT COUNT(staffID) AS output FROM staff WHERE un = '$un' && staffID <> '$uid'") or die(mysqli_error($conn));	
//	if($qryUser && $qryUser->num_rows === 0) {
		echo "<script type='text/javascript'>confirm('".$fname." ".$lname." was updated.');</script>";
		if(!isset($pw)||trim($pw)=='') {
			$sql = "UPDATE staff SET deptID = '$dept', fName='$fname', lName='$lname', email='$email', office='$office', un='$un' WHERE staffID='$uid'";
		} else {
			$sql = "UPDATE staff SET deptID = '$dept', fName='$fname', lName='$lname', email='$email', office='$office', un='$un', pw='$pw' WHERE staffID='$uid'";
		}
		mysqli_query($conn, $sql) or die(mysqli_error($conn));
//	} else { echo "<script type='text/javascript'>alert('Username already exists.2');</script>"; }
}

// Does query based off "if" statement
//Redirects to this page
ob_start();
include("tools.php");
ob_flush();
exit;

?>


</head>
<body>

</body>
</html>