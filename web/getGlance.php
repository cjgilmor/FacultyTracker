<?php
//THE PURPOSE OF THIS .PHP FILE IS TO DYNAMICALLY POPULATE THE AT A GLANCE LIST FOUND IN THE index.php PAGE
//MORE INFO ON THIS TYPE OF METHOD: https://www.w3schools.com/php/php_ajax_database.asp
include "connect.php";
$str = intval($_GET['in']); //input string
	$query = "SELECT * FROM events, staff
			WHERE events.staffID = staff.staffID
			AND staff.deptID = $str
			AND CURDATE() = events.eventDate
			AND CURTIME() BETWEEN events.startTime AND events.endTime";

$result = mysqli_query($conn, $query);		
	//Have a query to get all the events that are going on now that are adhoc and not adhoc
	//Check to see if the staff member has an adhoc event going on
	//If he does then print out that result
	//If he doesnt then print out the regular event
	
	//Goes through the results
	echo "<table class='weekly' width=600 border=2;><tr><th> Faculty Name </th> <th> Current Location </th> <th> Until</th> </tr>";
	while($row = mysqli_fetch_array($result)) {	
			echo "<tr>";
			if ($row['typeID']==0||$row['typeID']==2) $color="lightgreen"; else $color="white";
			//This puts the results in the table
			echo "<td align='center' style='background-color:$color;'>".$row['fName']." ".$row['lName']."</td>";
			echo "<td align='center' style='background-color:$color;'>".$row['eventName']." (".$row['eventPlace'].")</td>";
			echo "<td align='center' style='background-color:$color;'>".date('g:i a', strtotime($row['endTime']))."</td>";
			echo "</tr>";	
	}echo "</table>";
mysqli_close($conn);
?>