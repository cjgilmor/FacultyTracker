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

$type = $_POST['hf-c'];
$cid = $_POST['hcid'];

$cname = $_POST['ct-cname'];

if($type=="1") {//INSERT
	$sql = "INSERT INTO college (collName) VALUES ('$cname');";
	mysqli_query($conn, $sql) or die(mysqli_error($conn));
	echo "<script type='text/javascript'>confirm('".$cname." was inserted into the database.');</script>";
} else if ($type=="2") {//UPDATE
	$sql = "UPDATE college SET collName = '$cname' WHERE collID='$cid'";
	mysqli_query($conn, $sql) or die(mysqli_error($conn));
	echo "<script type='text/javascript'>confirm('".$cname." was updated.');</script>";
} else {//DELETE
	$sql = "DELETE FROM college WHERE collID='$cid'";
	mysqli_query($conn, $sql) or die(mysqli_error($conn));
	echo "<script type='text/javascript'>alert('".$cname." was DELETED!');</script>";
}
//Redirects to this page

echo "<script>document.location='tools.php';</script>";
exit;
?>

</head>
<body></body>
</html>