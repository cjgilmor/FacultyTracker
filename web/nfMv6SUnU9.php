<?php
	//Variables for Username, Password, Hostname
	//Code for Our Server
	$dbusername = 'ft_admin';
	$dbpassword = 'GXPE8MEWK0';

	//Variables for my local database on localhost
	$hostname = 'localhost';
	$databaseName = 'ft2018';

	//Code to connect to the database
	$conn = new mysqli($hostname, $dbusername, $dbpassword, $databaseName);
		
	//If it couldnt connect to the database, the error message will tell us why	
	if ($conn->connect_error) {
		die("DIE: Connection failed: " . $conn->connect_error);
	}
?>
