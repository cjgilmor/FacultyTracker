<?php
session_start();
//Checks to see if the user is logged into the system
if (!isset($_SESSION['basic_is_logged_in']) 
    || $_SESSION['basic_is_logged_in'] !== true) {

	//Redirects the user to the login page
    ob_start();
    include("floginTest.php");
    ob_flush();
	exit;
	
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
//The connection to the database
include('connect.php');

	$selected_db = mysql_select_db($databaseName, $con);

	
		if ($_POST['check'] != 0) 
		{					
			if(isset($_POST['check']))
			{
				foreach($_POST['check'] as $eventID)
				{
					mysql_query("DELETE FROM event WHERE eventID = '$eventID'") or die(mysql_error());
				}
			}
				
		}

		
	
	
	function dayEvents($startDay)
	{
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
		$query2 = "SELECT event.Title, event.Start, event.End, event.eventID 
				FROM event
				WHERE event.Date = '$newdate' AND event.staffID = '$_SESSION[staffID]'
				ORDER BY event.Start";
				
		//All the results of the query is stored in this variable
		$result = mysql_query($query2);
		//Goes through the results
		while($row = mysql_fetch_array($result))
		{
			echo "<tr>";
			//This puts the results in the table
			echo "<td><input type='checkbox' name='check[]' value='" . $row['eventID'] . "'></td>";
			$url = "descript.php";
			$url = $url . "?eventID=" . $row['eventID'];
			$url = "window.open('".$url."','','width=310,height=355,0,status=0,scrollbars=1,left=500,top=20')";
			echo "<td><b><a href='javascript:void();' onClick=".$url.">" . $row['Title'] . "</a></b><br/><small>". date("g:i a", strtotime($row['Start'])) . "-" . date("g:i a", strtotime($row['End'])) . "</small></td>";			
			echo "</tr>";
		}
	}	

?>
<center>
    <table class="weekly" width="800" height="344" border="2" cellpadding="1">
      <tr>
        <th height="25" colspan="5" bgcolor="gold"><center><font color="navy"> Agenda </center></th>
      </tr>
      <tr class="days" align="center">
        <td height="27" width="160" bgcolor="gold"><b><font color="navy"> Monday</td>
        <td width="160" bgcolor="gold"><b><font color="navy">Tuesday</td>
        <td width="160" bgcolor="gold"><b><font color="navy">Wednesday</td>
        <td width="160" bgcolor="gold"><b><font color="navy">Thursday</td>
        <td width="160" bgcolor="gold"><b><font color="navy">Friday</td>
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
	  
	  echo "</tr>";
	  ?>
		
        <script type="text/javascript">
		function Remove()
		{
		  	var del = confirm("Are you sure you want to delete appointment?");
		  
		  	if(del == true)
		  	{
				document.forms["modify"].submit();
		  	}
		  	else
		  	{
			 	return false;
		  	}
		}
		</script>

	
	<form name="modify" method="post" action="week.php">
      <tr valign="top">
        <td height="250">
        <table class="eventSel" width="155"><?php dayEvents("1");?></table></td>
	    <td><table class="eventSel" width="158"><?php dayEvents("2");?></table></td>
        <td><table class="eventSel" width="158"><?php dayEvents("3");?></table></td>
        <td><table class="eventSel" width="158"><?php dayEvents("4");?></table></td>
        <td><table class="eventSel" width="158"><?php dayEvents("5");?></table></td>
      </tr>
      <tr>
      <td height="27" colspan="5" valign="middle">
      <div align="left">
        <input type='button' value="New" onClick=window.open("Add.php","","width=515,height=460,0,status=0,left=50,top=20");>
	<input type='button' value="Edit"
onClick=window.open("Edit.php","","width=515,height=460,0,status=0,left=50,top=20");>
        <input name="del" type="button" onClick=Remove(); value="Delete" />
      </div>
      </form>
      
      </td>
    </table>
</body>
</html>