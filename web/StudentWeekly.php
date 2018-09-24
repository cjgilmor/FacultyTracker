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
if(isset($_POST["dbox"]))
{
	$user = mysqli_real_escape_string($conn, $_POST["dbox"]);
	$sql = "Select * FROM staff where staffID=".$user;
	$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	$row = mysqli_fetch_array($result);

	$staffID = mysqli_real_escape_string($conn, $row['staffID']);
	$name = mysqli_real_escape_string($conn, $row['name']);
	
		
	//Gets the Id for the staff member
	$uid = $staffID;
	$name = $name;
}
?>
<title>Weekly Schedule <?php if(isset($name))echo "| " . $name; ?></title>
</head>

<body>

<div class="wrapper" align= "center">
 <?php include("headnav.php") ?>;
    
    <div id="space">
    <p>
    
    
     </p>
    </div>
<div id="white">
<form name="frmLoadUser" method="post" action="">
  <h3>&nbsp;</h3>
  <h3>&nbsp;</h3>
  
  <h3>Select Faculty:
    <select name="dbox" onchange="this.form.submit()">
      <option value="0">Select</option>
      <?php 
		$q1 = "SELECT * FROM staff";
		$result = mysqli_query($conn, $q1) or die(mysqli_error($conn));				
		while($row = mysqli_fetch_array($result))
		{ echo "<option value=" . $row['staffID'] . ">" . $row['name'] . " </option>"; }

	  ?>
    </select>
  </h3>
</form>
 



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
		
		$q2 = "SELECT event.Title, event.Start, event.End, event.eventID 
				FROM event
				WHERE event.Date = '$newdate' AND event.staffID = '$uid'
				ORDER BY event.Start";
				
		//All the results of the query is stored in this variable
		$result = mysqli_query($conn, $q2) or die(mysqli_error($conn));	
		//Goes through the results
		while($row = mysqli_fetch_array($result))
		{
			$eventID = mysqli_real_escape_string($conn, $row['eventID']);
			$title = mysqli_real_escape_string($conn, $row['Title']);
			$start = mysqli_real_escape_string($conn, $row['Start']);
			$end = mysqli_real_escape_string($conn, $row['End']);
			
			
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

<h2>
    <p>Weekly Schedule <?php if(isset($name))echo "for: ". $name; ?></p></h2>
  </div>
    <div align="center" class="week">
    <p> NOTICE! If you do not see a scheduled event, assume faculty member is not available.  </p>
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
        <td height="250">
        <table class="eventSel" width="155"><?php if(isset($uid))dayEvents("1",$uid);?></table></td>
	    <td><table class="eventSel" width="155"><?php if(isset($uid))dayEvents("2",$uid);?></table></td>
        <td><table class="eventSel" width="155"><?php if(isset($uid))dayEvents("3",$uid);?></table></td>
        <td><table class="eventSel" width="155"><?php if(isset($uid))dayEvents("4",$uid);?></table></td>
        <td valign="top"><table class="eventSel" width="155"><?php if(isset($uid))dayEvents("5",$uid);?></table></td>
      </tr>
    </table>
   
</div>
 	<?php include("footer.php") ?>
    </div>
</body>
</html>