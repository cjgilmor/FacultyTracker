<html>
<head><link href="calstyles.css" rel="stylesheet" type="text/css" />
<?php

//THE PURPOSE OF THIS .PHP FILE IS TO DYNAMICALLY POPULATE THE EVENTS TABLES FOUND IN THE StudentWeekly.php PAGE
//MORE INFO ON THIS TYPE OF METHOD: https://www.w3schools.com/php/php_ajax_database.asp

include "connect.php";
$startDay = intval($_GET['in']); //type of box that called this function
$uid = intval($_GET['id']); //input string

//COPIED FROM ORIGINAL EVENT SELECTION

	//Function that puts the days of the week into the schedule
		// Gets the current date
		$newdate = date('Y-m-d');
	  	//Time stamp
	  	$ts = strtotime($newdate);
	
	  	//Day of week
	  	$dow = date('w', $ts);
	  	$offset = $dow - 1;
		if($offset < 0) $offset = 6;
	  	
		// Calculate timestamp for appropriate column
	 	$ts = $ts - $offset * 86400;	// Gets Mondays timestamp
		$startDay--;			// Fixes the start day's offset
		$ts = $ts + $startDay * 86400;	// Gets timestamp for current column
	
		// Gets YYYY-mm-dd format of $day
		$newdate = date('Y-m-d', $ts);
		
		$q2 = "SELECT * 
				FROM events
				WHERE eventDate = '$newdate' AND staffID = '$uid'
				ORDER BY startTime";
				
		//All the results of the query is stored in this variable
		$result = mysqli_query($conn, $q2) or die(mysqli_error($conn));	
		//Goes through the results
		while($row = mysqli_fetch_array($result))
		{
			$eventID = mysqli_real_escape_string($conn, $row['eventID']);
			$title = mysqli_real_escape_string($conn, $row['eventName']);
			$start = mysqli_real_escape_string($conn, $row['startTime']);
			$end = mysqli_real_escape_string($conn, $row['endTime']);
			
			echo "<table class='eventSel' width='100%'>";
			echo "<tr valign=top>";
			//This puts the results in the table
			$url = "descript.php";
			$url = $url . "?eventID=" . $eventID;
			$url = "window.open('".$url."','','width=310,height=355,0,status=0,scrollbars=1,left=500,top=20')";
			echo "<td><b><a href='javascript:void();' onClick=".$url.">" . $title . "</a></b><br/><small>". date("g:i a", strtotime($start)) . "-" . date("g:i a", strtotime($end)) . "</small></td>";
			echo "</tr>";
			echo "</table>";
		}
?></head>
</html>