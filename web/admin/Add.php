<?php
session_start();
//Checks to see if the user is logged into the system
if (!isset($_SESSION['basic_is_logged_in']) 
    || $_SESSION['basic_is_logged_in'] !== true) {

	//Redirects the user to the login page
    ob_start();
    include("FLogin.php");
    ob_flush();
	exit;
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<SCRIPT TYPE="text/javascript">
<!--
window.focus();
//-->
</SCRIPT>
<title>Add</title>
</head>
<body>

<style type="text/css">
.ds_box {
	background-color: #FFF;
	border: 1px solid #000;
	position: absolute;
	z-index: 32767;
}

.ds_tbl {
	background-color: #FFF;
}

.ds_head {
	background-color: #386AFF;
	color: #FFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	text-align: center;
	letter-spacing: 2px;
}

.ds_subhead {
	background-color: #F2CC81;
	color: #000;
	font-size: 11px;
	font-weight: bold;
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
	width: 28px;
}

.ds_cell {
	background-color: #FFFF7A;
	color: #000;
	font-size: 12px;
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
	padding: 5px;
	cursor: pointer;
}

.ds_cell:hover {
	background-color: #F3F3F3;
} /* This hover code won't work for IE */
form 
{
	padding-left: 7px;
}
</style>

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
</head>

<body>
<h2>
Add Appointment
</h2>
<h4>
<i>Please fill out each field for adding an appointment. </i>
</h4>
<hr />

<script language="JavaScript" type="text/javascript">

function addEnd()
{
	document.getElementByName("EndDate").disabled=false;
}

function checkForm()
{
   var cTitle, cStartTime, cEndTime, cLocation;
   with(window.document.Appointment)
   {
      cTitle    = Title;
      cStartTime   = STime;
      cEndTime = ETime;
      cLocation = Location;
   }
	

   if(trim(cTitle.value) == '')
   {
      alert('Please enter in a Title');
      cTitle.focus();
      return false;
   }
   else if(trim(cStartTime.value) >= trim(cEndTime.value))
   {
      alert('Please enter in a valid time');
      alert("Start time "+cStartTime.value);
	  alert("End time " + cEndTime.value);
	  cStartTime.focus();
      return false;
   }
   else if(trim(cLocation.value) == '')
   {
      alert('Please enter in a location');
      cLocation.focus();
      return false;
   }
   else
   {	   
      /*cTitle.value    = trim(cTitle.value);
      cStartTime.value   = trim(cStartTime.value);
      cEndTime.value = trim(cEndTime.value);
      cLocation.value = trim(cLocation.value);*/	  
	  document.forms["Appointment"].submit();
      //return true;
   }
}

function trim(str)
{
   return str.replace(/^\s+|\s+$/g,'');
}

</script>
   
<form name="Appointment" action="AddAppointment.php" method="post">
  <p>
    <label for="Title">Title:</label>
      <input name="Title" type="text" id="Title" size="30" />
      <label for="Type">Type:</label>
      <select name="Type" id="Type">
        <option value="1">Class</option>
        <option value="2">Out of Office</option>
        <option value="3">Lunch</option>
        <option value="4">Office</option>
        <option value="5">Meeting</option>
      </select>
    </label>
    <label>
      <input type="checkbox" name="adhoc" value="1">Override
    </label>
  </p>
  <p>
    <label for="When">Start Date:
      <input name="When" value="<?php echo date("Y-m-d")?>" id="When" style="cursor: text" onfocus="ds_sh(this);" onclick="ds_sh(this);"/>
    </label>
    <label for="STime">From: 
      <select value="<?php echo date("H:i"); ?>" name="STime" id="select">
      <script type="text/javascript">
	  var init = 5;
	  
	  for(init; init < 24; init++)
	  {
		  
		  if(init <= 11)
		  {
			  if(init<10){init = "0" + init;}
			  document.write("<option value=" + init + ":00:00>" + init + ":00 am</option>");
			  document.write("<option value=" + init + ":30:00>" + init + ":30 am</option>");
		  }

		  else if(init == 12)
		  {
			document.write("<option value=" + init + ":00:00>" + init + ":00 am</option>");

		  }
		  else
		  {
			  document.write("<option value=" + init + ":00:00>" + (init - 12) + ":00 pm </option>");
			  document.write("<option value=" + init + ":30:00>" + (init - 12) + ":30 pm </option>");
		  }
	  }
	  </script>
      </select>
      <label for="ETime">To:</label>
      <select name="ETime" size="1" id="select">
      <script type="text/javascript">
	  var init2 = 5;
	  
	  for(init2; init2 < 24; init2++)
	  {
		  
		  if(init2 <= 12)
		  {
			  if(init2<10){init2 = "0" + init2;}			  
			  document.write("<option value=" + init2 + ":00:00>" + init2 + ":00 am</option>");
			  document.write("<option value=" + init2 + ":30:00>" + init2 + ":30 am</option>");
		  }
		  else
		  {
			  document.write("<option value=" + init2 + ":00:00>" + (init2 - 12) + ":00 pm </option>");
			  document.write("<option value=" + init2 + ":30:00>" + (init2 - 12) + ":30 pm </option>");
		  }
	  }
	  
	  </script>
      
      </select>
    </label>
  </p>Repeats: 
  <select onchange="addEnd()" name="Repeat">
  <option value="0">Does not repeat</option>
  <option value="1">Weekly</option>
  </select>
    <label> End Date:
      <input name="EndDate" value="<?php echo date("Y-m-d");?>" style="cursor: text" onfocus="ds_sh(this);" onclick="ds_sh(this);"/>
  </label>
  <p>
    <label>Location:
      <input type="text" size="49" name="Location" id="Location" />
    </label>
  </p>
  <p>
    <label>Description: <br />
      <textarea name="Description" cols="55" rows="3" id="Description">No description</textarea>
    </label>
  </p>
  <p>.</p>
    <label>
      <input type="button" onClick="return checkForm()" name="cmdSubmit" value="Submit"/>
    </label>
  </label>
  <label>
    <input type="reset" name="button2" id="button2" value="Reset" />
  </label>
  </p>
</p>
</form>
</body>
</html>
