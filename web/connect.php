<?php
	//Variables for Username, Password, Hostname
	//Code for Our Server
	$dbusername = 'c2facultytracker';
	$dbpassword = '2015fTracker$';

	//Variables for my local database on localhost
	$hostname = 'localhost';
	$databaseName = 'c2facultytracker';

	//Code to connect to the database
	$conn = new mysqli($hostname, $dbusername, $dbpassword, $databaseName);
		
	//If it couldnt connect to the database, the error message will tell us why	
	if ($conn->connect_error) {
		die("DIE: Connection failed: " . $con->connect_error);
	}
?>
