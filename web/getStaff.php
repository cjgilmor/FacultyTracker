<?php
//THE PURPOSE OF THIS .PHP FILE IS TO DYNAMICALLY POPULATE THE STAFF TABLES FOUND IN THE tools.php PAGE
//MORE INFO ON THIS TYPE OF METHOD: https://www.w3schools.com/php/php_ajax_database.asp

include "connect.php";
$type = intval($_GET['t']); //type of box that called this function
$str = intval($_GET['in']); //input string

$query="SELECT * FROM staff WHERE staffID='".$str."';";
if ($type==2||$type==4) {
	$query="SELECT * FROM college LEFT JOIN dept ON college.collID=dept.collID LEFT JOIN staff ON dept.deptID=staff.deptID WHERE staffID='".$str."';";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result); $coll=$row['collID']; $dep=$row['deptID'];
	if ($type==2) { echo "<select name='s-coll' id='s-coll' style='width:95%;' onchange='getData(5,this.value)'><option value='-1'>- SELECT COLLEGE -</option>";
		$query="SELECT * FROM college ORDER BY collName ASC;";
	} else { echo "<select name='s-dept' id='s-dept' style='width:95%;'><option value='-1'>- SELECT DEPTARTMENT -</option>";
		$query="SELECT * FROM dept WHERE collID='".$coll."' ORDER BY deptName ASC;";
	}
}
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)) {
	if ($type==0) echo "<input type='text' name='uid' id='uid' value='".$row['staffID']."' disabled /><input type='hidden' name='huid' id='huid' value='".$row['staffID']."' />";
    if ($type==1) echo "<input type='text' name='fname' id='fname' style='width:95%;' maxlength='50' pattern='[^><]+' value = '".$row['fName']."'/>";
	if ($type==2) {
		if ($coll==$row['collID']) echo "<option value = '".$row['collID']."' selected />".$row['collName']."</option>";
		else echo "<option value = '".$row['collID']."' />".$row['collName']."</option>";
	} if ($type==3) echo "<input type='text' name='lname' id='lname' style='width:95%;' maxlength='50' pattern='[^><]+' value = '".$row['lName']."'/>";
	if ($type==4) {
		if ($dep==$row['deptID']) echo "<option value = '".$row['deptID']."' selected />".$row['deptName']."</option>";
		else echo "<option value = '".$row['deptID']."' />".$row['deptName']."</option>";
	} if ($type==5) echo "<input type='text' name='email' id='email' style='width:95%;' maxlength='50' pattern='[^><]+' value = '".$row['email']."'/>";
	if ($type==6) echo "<input type='text' name='office' id='office' style='width:95%;' maxlength='50' pattern='[^><]+' value = '".$row['office']."'/>";
	if ($type==7) echo "<input type='text' name='un' id='un' style='width:95%;' maxlength='16' pattern='[^><]+' value = '".$row['un']."'/>";
	if ($type==8) echo "<input type='text' name='pass' id='pass' size=32 pattern='[^><]+' value = '".$row['pw']."' style='width:50%;' disabled />";
	if ($type==9) { echo $row['office']; }// <-- TEST! INSERT BY value, INSTEAD OF innerHTML
	if ($type==10) { echo " : ".$row['fName']." ".$row['lName']; }
}if ($type==2||$type==4) echo "</select>";
mysqli_close($conn);
?>