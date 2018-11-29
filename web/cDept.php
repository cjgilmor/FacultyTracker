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

$type = $_POST['hf-d'];
$did = $_POST['hdid'];

$dname = $_POST['dt-dname'];
$cid = $_POST['dt-collSel'];

if($type=="1") {//INSERT
	$sql = "INSERT INTO dept (collID, deptName) VALUES ('$cid', '$dname');";
	mysqli_query($conn, $sql) or die(mysqli_error($conn));
	echo "<script type='text/javascript'>confirm('".$dname." was inserted into the database.');</script>";
} else if ($type=="2") {//UPDATE
	$sql = "UPDATE dept SET collID = '$cid', deptName = '$dname' WHERE deptID='$did'";
	mysqli_query($conn, $sql) or die(mysqli_error($conn));
	echo "<script type='text/javascript'>confirm('".$dname." was updated.');</script>";
} else {//DELETE
	$sql = "DELETE FROM dept WHERE deptID='$did'";
	mysqli_query($conn, $sql) or die(mysqli_error($conn));
	echo "<script type='text/javascript'>alert('".$dname." was DELETED!');</script>";
}
// Does query based off "if" statement
//Redirects to this page
ob_start();
include("tools.php");
ob_flush();
exit;
?>

</head>
<body></body>
</html>