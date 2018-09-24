<?php
session_start();
//Checks to see if the user is logged into the system
if (!isset($_SESSION['basic_is_logged_in']) 
    || $_SESSION['basic_is_logged_in'] !== true) {

	//Redirects the user to the login page
    ob_start();
    include("flogin.php");
    ob_flush();
	exit;
	
}
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Faculty Tracker</title>

<SCRIPT TYPE="text/javascript">
<!--
window.focus();
//-->
</SCRIPT>
<link href="weekstyles.css" rel="stylesheet" type="text/css">
<link href="datepickerstyles.css" rel="stylesheet" type="text/css">

</head>
<body>
<div class="wrapper" align= "center">
	
    <?php include("headnav.php"); ?>
    

<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
<tr><td id="ds_calclass">
</td></tr>
</table>


<script type="text/javascript">
// <!-- <![CDATA[

// Project: Dynamic Date Selector (DtTvB) - 2006-03-16
// Script featured on JavaScript Kit- http://www.javascriptkit.com
// Code begin...
// Set the initial date.

var ds_i_date = new Date();
ds_c_month = ds_i_date.getMonth() + 1;
ds_c_year = ds_i_date.getFullYear();

// Get Element By Id
function ds_getel(id) {
	return document.getElementById(id);
}

// Get the left and the top of the element.
function ds_getleft(el) {
	var tmp = el.offsetLeft;
	el = el.offsetParent
	while(el) {
		tmp += el.offsetLeft;
		el = el.offsetParent;
	}
	return tmp;
}
function ds_gettop(el) {
	var tmp = el.offsetTop;
	el = el.offsetParent
	while(el) {
		tmp += el.offsetTop;
		el = el.offsetParent;
	}
	return tmp;
}

// Output Element
var ds_oe = ds_getel('ds_calclass');
// Container
var ds_ce = ds_getel('ds_conclass');

// Output Buffering
var ds_ob = ''; 
function ds_ob_clean() {
	ds_ob = '';
}
function ds_ob_flush() {
	ds_oe.innerHTML = ds_ob;
	ds_ob_clean();
}
function ds_echo(t) {
	ds_ob += t;
}

var ds_element; // Text Element...

var ds_monthnames = [
'January', 'February', 'March', 'April', 'May', 'June',
'July', 'August', 'September', 'October', 'November', 'December'
]; // You can translate it for your language.

var ds_daynames = [
'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'
]; // You can translate it for your language.

// Calendar template
function ds_template_main_above(t) {
	return '<table cellpadding="3" cellspacing="1" class="ds_tbl">'
	     + '<tr>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_py();">&lt;&lt;</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_pm();">&lt;</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_hi();" colspan="3">[Close]</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_nm();">&gt;</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_ny();">&gt;&gt;</td>'
		 + '</tr>'
	     + '<tr>'
		 + '<td colspan="7" class="ds_head">' + t + '</td>'
		 + '</tr>'
		 + '<tr>';
}

function ds_template_day_row(t) {
	return '<td class="ds_subhead">' + t + '</td>';
	// Define width in CSS, XHTML 1.0 Strict doesn't have width property for it.
}

function ds_template_new_week() {
	return '</tr><tr>';
}

function ds_template_blank_cell(colspan) {
	return '<td colspan="' + colspan + '"></td>'
}

function ds_template_day(d, m, y) {
	return '<td class="ds_cell" onclick="ds_onclick(' + d + ',' + m + ',' + y + ')">' + d + '</td>';
	// Define width the day row.
}

function ds_template_main_below() {
	return '</tr>'
	     + '</table>';
}

// This one draws calendar...
function ds_draw_calendar(m, y) {
	// First clean the output buffer.
	ds_ob_clean();
	// Here we go, do the header
	ds_echo (ds_template_main_above(ds_monthnames[m - 1] + ' ' + y));
	for (i = 0; i < 7; i ++) {
		ds_echo (ds_template_day_row(ds_daynames[i]));
	}
	// Make a date object.
	var ds_dc_date = new Date();
	ds_dc_date.setMonth(m - 1);
	ds_dc_date.setFullYear(y);
	ds_dc_date.setDate(1);
	if (m == 1 || m == 3 || m == 5 || m == 7 || m == 8 || m == 10 || m == 12) {
		days = 31;
	} else if (m == 4 || m == 6 || m == 9 || m == 11) {
		days = 30;
	} else {
		days = (y % 4 == 0) ? 29 : 28;
	}
	var first_day = ds_dc_date.getDay();
	var first_loop = 1;
	// Start the first week
	ds_echo (ds_template_new_week());
	// If sunday is not the first day of the month, make a blank cell...
	if (first_day != 0) {
		ds_echo (ds_template_blank_cell(first_day));
	}
	var j = first_day;
	for (i = 0; i < days; i ++) {
		// Today is sunday, make a new week.
		// If this sunday is the first day of the month,
		// we've made a new row for you already.
		if (j == 0 && !first_loop) {
			// New week!!
			ds_echo (ds_template_new_week());
		}
		// Make a row of that day!
		ds_echo (ds_template_day(i + 1, m, y));
		// This is not first loop anymore...
		first_loop = 0;
		// What is the next day?
		j ++;
		j %= 7;
	}
	// Do the footer
	ds_echo (ds_template_main_below());
	// And let's display..
	ds_ob_flush();
	// Scroll it into view.
	ds_ce.scrollIntoView();
}

// A function to show the calendar.
// When user click on the date, it will set the content of t.
function ds_sh(t) {
	// Set the element to set...
	ds_element = t;
	nu_element = document.getElementsByName('EndDate');
	// Make a new date, and set the current month and year.
	var ds_sh_date = new Date();
	ds_c_month = ds_sh_date.getMonth() + 1;
	ds_c_year = ds_sh_date.getFullYear();
	// Draw the calendar
	ds_draw_calendar(ds_c_month, ds_c_year);
	// To change the position properly, we must show it first.
	ds_ce.style.display = '';
	// Move the calendar container!
	the_left = ds_getleft(t);
	the_top = ds_gettop(t) + t.offsetHeight;
	ds_ce.style.left = the_left + 'px';
	ds_ce.style.top = the_top + 'px';
	// Scroll it into view.
	ds_ce.scrollIntoView();
}

// Hide the calendar.
function ds_hi() {
	ds_ce.style.display = 'none';
}

// Moves to the next month...
function ds_nm() {
	// Increase the current month.
	ds_c_month ++;
	// We have passed December, let's go to the next year.
	// Increase the current year, and set the current month to January.
	if (ds_c_month > 12) {
		ds_c_month = 1; 
		ds_c_year++;
	}
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the previous month...
function ds_pm() {
	ds_c_month = ds_c_month - 1; // Can't use dash-dash here, it will make the page invalid.
	// We have passed January, let's go back to the previous year.
	// Decrease the current year, and set the current month to December.
	if (ds_c_month < 1) {
		ds_c_month = 12; 
		ds_c_year = ds_c_year - 1; // Can't use dash-dash here, it will make the page invalid.
	}
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the next year...
function ds_ny() {
	// Increase the current year.
	ds_c_year++;
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the previous year...
function ds_py() {
	// Decrease the current year.
	ds_c_year = ds_c_year - 1; // Can't use dash-dash here, it will make the page invalid.
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Format the date to output.
function ds_format_date(d, m, y) {
	// 2 digits month.
	m2 = '00' + m;
	m2 = m2.substr(m2.length - 2);
	// 2 digits day.

	d2 = '00' + d;
	d2 = d2.substr(d2.length - 2);
	// YYYY-MM-DD
	return y + '-' + m2 + '-' + d2;
}

// When the user clicks the day.
function ds_onclick(d, m, y) {
	// Hide the calendar.
	ds_hi();
	// Set the value of it, if we can.
	if (typeof(ds_element.value) != 'undefined') {
		ds_element.value = ds_format_date(d, m, y);
	// Maybe we want to set the HTML in it.
	} else if (typeof(ds_element.innerHTML) != 'undefined') {
		ds_element.innerHTML = ds_format_date(d, m, y);
	// I don't know how should we display it, just alert it to user.
	} else {
		alert (ds_format_date(d, m, y));
	}
}

// And here is the end.

// ]]> -->
</script>

<?php
	//The connection to the database
	include('connect.php');
	
/*	if ($_POST['check'] != 0) {					
		if(isset($_POST['check'])) {
			foreach($_POST['check'] as $eventID) {
				mysqli_query($conn, "DELETE FROM event WHERE eventID = '$eventID'") or die(mysqli_error($conn));
			}
		}		
	}*/
		
	function dayEvents($startDay)
	{
		include('connect.php');
/*		if(null !== trim($_POST['When'])){
			$newdate = date('Y-m-d');
		} else{	// Gets the current date
		$newdate = $_POST['When'];
	}*/
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
		$result = mysqli_query($conn, $query2);
		//Goes through the results
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			//This puts the results in the table
			echo "<td><input type='checkbox' name='check[]' value='" . $row['eventID'] . "'></td>";
			$aurl = "Edit.php";
			$aurl = $aurl . "?eventID=" . $row['eventID'];
			$aurl = "window.open('".$aurl."','','width=500,height=420,0,status=0,scrollbars=0,left=50,top=20')";
			$url = "descript.php";
			$url = $url . "?eventID=" . $row['eventID'];
			$url = "window.open('".$url."','','width=310,height=355,0,status=0,scrollbars=1,left=500,top=20')";
			echo "<td><b><a href='javascript:void();' onClick=".$url.">" . $row['Title'] . "</a></b><br/><small>". date("g:i a", strtotime($row['Start'])) . "-" . date("g:i a", strtotime($row['End'])) . "</small></td>";			
			echo "<td><a href='javascript:void();' onClick=".$aurl.">Edit</a>";
			echo "</tr>";
		}
	}	
?>
    <h2>Weekly Schedule</h2>
   	<p>
    <form name="Date" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"" method="post" target="_self">
     <label for="When">View Date:
      <input name="When" value="<?php echo htmlspecialchars(date("Y-m-d"));?>" id="When" style="cursor: text" onfocus="ds_sh(this);" onclick="ds_sh(this);"/>
      <input type="submit" formtarget="frame">
     </label>
     </form>
  
    <div id="links">
    <ul>
    <li>
        <?php if($_SESSION['lvl'] == 1){ echo "<li><a href='tools.php'> Administrator Tools </a></li>";} ?>
  
    <li> <a href="logout.php"> Logout </a> </p>
    </li>
    </ul>
    </div>
    <hr/>
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
//	  	if("" == trim($_POST['When'])){ $newdate = date('Y-m-d'); } 
//		else{ $newdate =  $_POST['When']; }

//	  $date = $newdate;
	  $date = date('Y-m-d');
	  //Time stamp
	  $ts = strtotime($date);
	  //Day of week
	  $dow = date('w', $ts);
	  $offset = $dow - 1;
	  
	  if ($offset<0) { $offset = 6; }
	  //Calculate timestamp for Monday
	  $ts = $ts - $offset * 86400;
	  
	  $dayEvent = array();
	  for($i=0; $i<5; $ts+=86400, $i++)
	  { echo "<td height='31'>" . date('m/d/Y', $ts) . "</td>"; }
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
        <input name="del" type="button" onClick=Remove(); value="Delete" />
      </div>
      </form>
      
      </td>
    </table>
    <p><script type="text/javascript"> 
/*
Live Date Script- 
Â© Dynamic Drive (www.dynamicdrive.com)
For full source code, installation instructions, 100's more DHTML scripts, and Terms Of Use,
visit http://www.dynamicdrive.com
*/
 
 
var dayarray=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
 
function getthedate(){
var mydate=new Date()
var year=mydate.getYear()
if (year < 1000)
year+=1900
var day=mydate.getDay()
var month=mydate.getMonth()
var daym=mydate.getDate()
if (daym<10)
daym="0"+daym
var hours=mydate.getHours()
var minutes=mydate.getMinutes()
var seconds=mydate.getSeconds()
var dn="AM"
if (hours>=12)
dn="PM"
if (hours>12){
hours=hours-12
}
if (hours==0)
hours=12
if (minutes<=9)
minutes="0"+minutes
if (seconds<=9)
seconds="0"+seconds
//change font size here
var cdate="<small><font color='FFF' face='Arial'><b>"+dayarray[day]+", "+montharray[month]+" "+daym+", "+year+" "+hours+":"+minutes+":"+seconds+" "+dn
+"</b></font></small>"
if (document.all)
document.all.clock.innerHTML=cdate
else if (document.getElementById)
document.getElementById("clock").innerHTML=cdate
else
document.write(cdate)
}
if (!document.all&&!document.getElementById)
getthedate()
function goforit(){
if (document.all||document.getElementById)
setInterval("getthedate()",1000)
}
 
</script>
  </center>
</h2>
  <span id="clock"></span>
  <?php include("footer.php"); ?>
</body>
</html>