<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Description</title>
<link href="datepickerstyles.css" rel="stylesheet" type="text/css">
<link href="popupstyles.css" rel="stylesheet" type="text/css">
</head>

<?php 
//The connection to the database
function results()
{
	include('connect.php');
	$event = $_GET['eventID'];
	$qry = "SELECT * FROM event WHERE eventID = '$event'";
	//All the results of the query is stored in this variable
	$result = mysqli_query($conn, $qry);
	//Goes through the results
	while($row = mysqli_fetch_array($result))
	{
		echo "<table>";
		echo "<tr><td valign=top align=left><b>Title: </b></td><td>" . $row['Title'] . "</td>";
		echo "<tr><td align=left><b>Date: </b></td><td>" . $row['Date'] . "</td>";
		echo "<tr><td align=left><b>Time: </b></td><td>" . $row['Start'] . " - " . $row['End'] . "</td>";
		//echo "<br/><br/>";
		echo "<tr><td align=left><b>Location: </b></td><td>" . $row['Location'] . "</td>";
		//echo "<br><br>";
		echo "<tr><td valign=top align=left><b>Description: </b></td><td>" . $row['Description'] . "</td>";
		echo "</table>";
	}
}
?>
<body>
<div id="header">
<h2>Description</h2>
<hr>
</div>
<br />

<?php results(); ?>
<br /><br />
<a href="javascript:window.close()">Close Window</a>
</body>
</html>
