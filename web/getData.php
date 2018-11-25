<?php

//THE PURPOSE OF THIS .PHP FILE IS TO DYNAMICALLY POPULATE THE DROPDOWN LISTS FOUND IN THE StudentWeekly.php AND tools.php PAGES
//MORE INFO ON THIS TYPE OF METHOD: https://www.w3schools.com/php/php_ajax_database.asp

include "connect.php";
$type = intval($_GET['t']); //type of box that called this function
$str = intval($_GET['in']); //input string

//$type = 0 means that the department box will populate.
//ELSE ($type = 1) means that the staff box will populate.
//If possible, this box can be expanded to incorporate more dropbox populations

if ($type==0||$type==2){ 
	$query="SELECT * FROM dept WHERE collID='".$str."' ORDER BY deptName ASC;";
	echo "<option value='-1' selected >- SELECT DEPTARTMENT -</option>";
} else {
	$query="SELECT * FROM staff WHERE deptID='".$str."' AND status <> '2' ORDER BY lName ASC;";
	echo "<option value='-1' selected >- SELECT STAFF MEMBER -</option>";
}

$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)) {
    if ($type==0||$type==2) echo "<option value=" . $row['deptID'] . ">" . $row['deptName'] . "</option>";
	else echo "<option value=" . $row['staffID'] . ">" . $row['lName'] . ", ".$row['fName']."</option>";
}
mysqli_close($conn);
?>