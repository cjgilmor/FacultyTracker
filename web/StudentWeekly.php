<?php 
	include('connect.php');
	$name;
	$uid;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="300" />
<link href="calstyles.css" rel="stylesheet" type="text/css" />
<?php
if(isset($_POST["staff-list"]))
{
	$user = mysqli_real_escape_string($conn, $_POST["staff-list"]);
	$sql = "Select * FROM staff where staffID=".$user;
	$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	$row = mysqli_fetch_array($result);

	$staffID = mysqli_real_escape_string($conn, $row['staffID']);
		
	//Gets the Id for the staff member
	$uid = $staffID;
	//Sets Selected staff name
	$name = mysqli_real_escape_string($conn, $row['fName'])." ".mysqli_real_escape_string($conn, $row['lName']);
}
?>
<title>Weekly Schedule <?php if(isset($name))echo "| " . $name; ?></title>
<script>
function getData(type,str) {
    if (str == "") { //REVERTS TO DEFAULT WHEN NO ENTRY IS SELECTED
		if (type==0) document.getElementById("dept-list").innerHTML = "<option value='-1' selected >- SELECT DEPTARTMENT -</option>"; 
		document.getElementById("staff-list").innerHTML = "<option value='-1' selected >- SELECT STAFF MEMBER -</option>";
		return;
	} else {
		if (window.XMLHttpRequest) { // <- code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // <- code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {// <- No idea. Just go with it.
				if (type==0) document.getElementById("dept-list").innerHTML = this.responseText;
				else document.getElementById("staff-list").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getData.php?t="+type+"&in="+str,true);
        xmlhttp.send();
    }
}
function getE(uid) {
	if (uid=="") { getEvents("",uid); } 
	else {
		getEvents(1,uid);
		getEvents(2,uid);
		getEvents(3,uid);
		getEvents(4,uid);
		getEvents(5,uid);
	}
}
function getEvents(str, uid) {
    if (str == "") { //REVERTS TO DEFAULT WHEN NO ENTRY IS SELECTED
		document.getElementById("s1").innerHTML = "";
		document.getElementById("s2").innerHTML = ""; 
		document.getElementById("s3").innerHTML = ""; 
		document.getElementById("s4").innerHTML = ""; 
		document.getElementById("s5").innerHTML = ""; 
		return;
	} else {
		if (window.XMLHttpRequest) { // <- code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // <- code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {// <- No idea. Just go with it.
				document.getElementById("s"+str).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getEvents.php?in="+str+"&id="+uid,true);
        xmlhttp.send();
    }
}
</script>
</head>

<body>
<div class="wrapper" align= "center">
<?php include("headnav.php") ?>
<div id="white">
&nbsp;
<form name="frmLoadUser" method="post" action="">
  <table>
		<td>
			<tr>
				<select id="coll-list" onchange="getData(0,this.value)">
					<option value="" selected >- SELECT COLLEGE -</option>
					<?php
						$result = mysqli_query($conn, "SELECT * FROM college;") or die(mysqli_error($conn));
						while($row = mysqli_fetch_array($result)) { echo "<option value=" . $row['collID'] . ">" . $row['collName'] . " </option>"; }
					?>
				</select>
			</tr><tr>
				<select id="dept-list" onchange="getData(1,this.value)"><option value='-1' selected >- SELECT DEPTARTMENT -</option></select>
			</tr><tr><!-- name="staff-list" is needed for POST functionality -->
				<select name="staff-list" id="staff-list" onchange="getE(this.value)"><option value='-1' selected >- SELECT STAFF MEMBER -</option></select>
			</tr>
		</td>
	</table>
</form>
<p id="outtest"></p>
<?php
	//Function that puts the days of the week into the schedule
	function dayEvents($startDay, $uid)
	{
		include('connect.php');
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
			
			
			echo "<tr valign=top>";
			//This puts the results in the table
			$url = "descript.php";
			$url = $url . "?eventID=" . $eventID;
			$url = "window.open('".$url."','','width=310,height=355,0,status=0,scrollbars=1,left=500,top=20')";
			echo "<td><b><a href='javascript:void();' onClick=".$url.">" . $title . "</a></b><br/><small>". date("g:i a", strtotime($start)) . "-" . date("g:i a", strtotime($end)) . "</small></td>";
			echo "</tr>";
		}
	}
?>
<h3>
    <p>Weekly Schedule <?php if(isset($name))echo "for: ". $name; ?></p></h3>
  </div>
    <div align="center" class="week">
    <p> NOTICE! If an event is highlighted in green, the instructor is available.</br>If you do not see an event listed, assume they are not available. </p>
    <table class="weekly" width="800" height="314" border="2" cellpadding="1">
      <tr>
        <th height="25" colspan="5" bgcolor="gold"><center><font color="navy"> Agenda </font></center></th>
      </tr>
      <tr align="center">
        <td height="27" width="160" bgcolor="gold"><b><font color="navy"> Monday</font></b></td>
        <td width="160" bgcolor="gold"><b><font color="navy">Tuesday</font></b></td>
        <td width="160" bgcolor="gold"><b><font color="navy">Wednesday</font></b></td>
        <td width="160" bgcolor="gold"><b><font color="navy">Thursday</font></b></td>
        <td width="160" bgcolor="gold"><b><font color="navy">Friday</font></b></td>
      </tr>
      <tr align="center">
      <?php
	  
	  $date = date('Y-m-d');
	  //Time stamp
	  $ts = strtotime($date);
	  //Day of week
	  $dow = date('w', $ts);
	  $offset = $dow - 1;
	  
	  if ($offset<0)
	  {
		  $offset = 6;
	  }
	  //Calculate timestamp for Monday
	  $ts = $ts - $offset * 86400;
	  
	  $dayEvent = array();
	  for($i=0; $i<5; $ts+=86400, $i++)
	  {
		  echo "<td height='31'>" . date('m/d/Y', $ts) . "</td>";
	  }
	  
	  ?>
      </tr>
      <tr valign="top">
        <td height="250"><span id="s1"></span></td>
	    <td><span id="s2"></span></td>
        <td><span id="s3"></span></td>
        <td><span id="s4"></span></td>
        <td valign="top"><span id="s5"></span></td>
      </tr>
    </table>
   
</div>
 	<?php include("footer.php") ?>
    </div>
</body>
</html>