<?php

//THE PURPOSE OF THIS .PHP FILE IS TO DYNAMICALLY POPULATE THE DROPDOWN LISTS FOUND IN THE StudentWeekly.php AND tools.php PAGES
//MORE INFO ON THIS TYPE OF METHOD: https://www.w3schools.com/php/php_ajax_database.asp

include "connect.php";
$type = intval($_GET['t']); //type of box that called this function
$str = intval($_GET['in']); //input string
$sel = intval($_GET['s']); //selected item (FOR SESSION VARIABLES)

//$type = 1 means that the college box will populate.
//$type = 2 means that the department box will populate.
//ELSE ($type = 3) means that the staff box will populate.
//If possible, this box can be expanded to incorporate more dropbox populations

//tools.php TYPE ADJUSTMENT
if ($type==4||$type==6||$type==7) $type=1;
if ($type==5||$type==8) $type=2;

if ($type==1){ 
	$query="SELECT * FROM college ORDER BY collName ASC;";
	echo "<option value='-1' "; if ($sel==-1) echo "selected "; echo ">- SELECT COLLEGE -</option>";
} else if ($type==2){ 
	$query="SELECT * FROM dept WHERE collID='".$str."' ORDER BY deptName ASC;";
	echo "<option value='-1' "; if ($sel==-1) echo "selected "; echo ">- SELECT DEPTARTMENT -</option>";
} else {
	$query="SELECT * FROM staff WHERE deptID='".$str."' AND status <> '2' ORDER BY lName ASC;";
	echo "<option value='-1' "; if ($sel==-1) echo "selected "; echo ">- SELECT STAFF MEMBER -</option>";
}

$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)) {
	if ($type==1) { echo "<option value=" . $row['collID'] . " "; if ($sel==$row['collID']) echo "selected "; echo ">" . $row['collName'] . "</option>"; }
	else if ($type==2) { echo "<option value=" . $row['deptID'] . " "; if ($sel==$row['deptID']) echo "selected "; echo ">" . $row['deptName'] . "</option>"; }
	else { echo "<option value=" . $row['staffID'] . " "; if ($sel==$row['staffID']) echo "selected "; echo ">" . $row['lName'] . ", ".$row['fName']."</option>"; }
}
mysqli_close($conn);
?>