<?php
//THE PURPOSE OF THIS .PHP FILE IS TO DYNAMICALLY POPULATE THE DEPT TABLES FOUND IN THE tools.php PAGE
//MORE INFO ON THIS TYPE OF METHOD: https://www.w3schools.com/php/php_ajax_database.asp

include "connect.php";
$type = intval($_GET['t']); //type of box that called this function
$str = intval($_GET['in']); //input string

$query="SELECT * FROM dept WHERE deptID='".$str."';";
if ($type==2) { 
	$query="SELECT * FROM college LEFT JOIN dept ON college.collID=dept.collID WHERE deptID='".$str."';";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result); $coll=$row['collID'];
	
	echo "<select name='dt-collSel' id='dt-collSel' style='width:95%;'><option value='-1'>- SELECT COLLEGE -</option>";
	$query="SELECT * FROM college ORDER BY collName ASC;";
}
if ($type==3) $query="SELECT COUNT(staff.staffID) AS output FROM college LEFT JOIN dept ON college.collID=dept.collID LEFT JOIN staff ON dept.deptID=staff.deptID WHERE dept.deptID='".$str."' AND staff.status <> 2;";

$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)) {
	if ($type==1) { echo "<input type='text' name='dt-dname' id='dt-dname' style='width:95%;' maxlength='50' pattern='[^><]+' value='".$row['deptName']."'/>"
			."<input type='hidden' name='hdid' id='hdid' value='".$row['deptID']."' />";
	} if ($type==2) {
		if ($coll==$row['collID']) echo "<option value = '".$row['collID']."' selected />".$row['collName']."</option>";
		else echo "<option value = '".$row['collID']."' />".$row['collName']."</option>";
	} if ($type==3){
		echo $row['output']; 
		$r2 = mysqli_query($conn, "SELECT * FROM dept WHERE deptID='".$str."';");
		while($row2 = mysqli_fetch_array($r2)) { echo " staffer(s) in ".$row2['deptName']; }
	}
}if ($type==2) echo "</select>";
mysqli_close($conn);
?>