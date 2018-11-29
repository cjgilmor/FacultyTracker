<?php
//THE PURPOSE OF THIS .PHP FILE IS TO DYNAMICALLY POPULATE THE COLLEGE TABLES FOUND IN THE tools.php PAGE
//MORE INFO ON THIS TYPE OF METHOD: https://www.w3schools.com/php/php_ajax_database.asp

include "connect.php";
$type = intval($_GET['t']); //type of box that called this function
$str = intval($_GET['in']); //input string

$query="SELECT * FROM college WHERE collID='".$str."';";
if ($type==2) $query="SELECT COUNT(dept.deptID) AS output FROM college LEFT JOIN dept ON college.collID=dept.collID WHERE college.collID='".$str."';";
if ($type==3) $query="SELECT COUNT(staff.staffID) AS output FROM college LEFT JOIN dept ON college.collID=dept.collID LEFT JOIN staff ON dept.deptID=staff.deptID WHERE college.collID='".$str."' AND staff.status <> 2;";

$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)) {
	if ($type==1) { 
		echo "<input type='text' name='ct-cname' id='ct-cname' style='width:95%;' maxlength='50' pattern='[^><]+' value='".$row['collName']."' />"
			."<input type='hidden' name='hcid' id='hcid' value='".$row['collID']."' />";
	} else { 
		echo $row['output']; 
		$r2 = mysqli_query($conn, "SELECT * FROM college WHERE collID='".$str."';");
		while($row2 = mysqli_fetch_array($r2)) {
			if ($type==2) echo " department(s) in ".$row2['collName']; 
			if ($type==3) echo " staffer(s) in ".$row2['collName']; 
		}
	}
}
mysqli_close($conn);
?>