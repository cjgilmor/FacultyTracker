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
	
} else {
	date_default_timezone_set("America/New_York");
	$uid = $_SESSION['staffID'];
}

?>
<!-- APOLOGIES FOR THE HARD CODED ASTHETIC STYLE. RAN OUT OF TIME.-->
<html>
	<script>
		//CONFIRMS NO BAD ENTRY DATA, THEN SUBMITS
	function validateForm(){
		var	d1 = document.forms["mainForm"]["dateStart"].value;
		var	d2 = document.forms["mainForm"]["dateEnd"].value;
		var	t1 = document.forms["mainForm"]["timeStart"].value;
		var	t2 = document.forms["mainForm"]["timeEnd"].value;
		var	type = document.forms["mainForm"]["selType"].value;
		if (type==-1)  { alert("Select an event type."); return false; }
		else if (document.forms["mainForm"]["rbTimes"].value!=1 && d1 > d2 ) 
			{ alert("End date cannot come BEFORE start date."); return false; }
		else if (!document.forms["mainForm"]["cbAllDay"].checked && t1 > t2 ) 
			{ alert("End time cannot come BEFORE start time."); return false; }
		else if (!document.forms["mainForm"]["cbAllDay"].checked && t1 == t2 ) 
			{ alert("Start time and end time CANNOT be the same value."); return false; }
	}
	function showMultiple(str) {
		if (str == "") return; //DOES NOTHING WHEN NO ENTRY IS SELECTED
		else {
			if (str == 1) {document.getElementById("cbBox").style.display = "none";
			document.getElementById("edBox").style.display = "none";
			document.getElementById("sdBoxText").innerHTML="Date: ";
		} else {
			document.getElementById("cbBox").style.display = "inline";
			document.getElementById("edBox").style.display = "inline";
			document.getElementById("sdBoxText").innerHTML="Start Date: ";
			}
		}
	}
	function CheckAllDay() {
			document.forms["mainForm"]["timeStart"].disabled = document.forms["mainForm"]["cbAllDay"].checked;
			document.forms["mainForm"]["timeEnd"].disabled = document.forms["mainForm"]["cbAllDay"].checked;
	}
	function checkType(str) {
    if (str != 2) { //REVERTS TO DEFAULT WHEN NO ENTRY IS SELECTED
		return;
	} else {
		var uid = -1;
		<?php echo "uid = $uid;"?>
		if (window.XMLHttpRequest) { // <- code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // <- code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {// <- No idea. Just go with it.
				document.getElementById("txtName").value = "Office Hours";
				document.getElementById("txtPlace").value = this.responseText;
            }
        };
        xmlhttp.open("GET","getStaff.php?in="+uid+"&t=9",true);
        xmlhttp.send();
    }
}
	</script>
	<title>Add Event</title>
	<body style="background-color: rgb(40,14,157); font-family: 'Calibri'; color:white">
		<form name="mainForm" action="AddAppointment.php" onsubmit="return validateForm()" method="post">
			<table width="450">
				<tr><td colspan="2" height="80" style="text-align:center; font-size:30px; font-weight:bold; background-color:rgb(253,185,39); color:black; border-radius: 20px 50px;">Add Event</td>
				</tr>
					<td>Event Name: <input type="text" id="txtName" name="txtName" maxlength="50" pattern="[^><]+" required></td>
					<td>Place: <input type="text" id="txtPlace" name="txtPlace" maxlength="50" pattern="[^><]*"/></td>
				</tr><tr>
					<td colspan="2">
							This event is... <select id="selType" name="selType" onchange="checkType(this.value)">
												<option value='-1' selected >- SELECT TYPE -</option>
												<option value='1'>Classtime</option>
												<option value='2'>Office Hours</option>
												<option value='3'>Research</option>
												<option value='4'>Other</option>
											</select>
						</td>
				</tr><tr>
					<td colspan="2">
						This event is about...<br/>
						<textarea id="txtDesc" name="txtDesc" style="width:450px; height:125px; font-family:'Calibri';" maxlength="200"></textarea>
					</td>
				</tr>
		</table> <table width="450">
				<tr>
					<td colspan="2">
						This event happens...<br/>
						<input type="radio" id="rbTimes" name="rbTimes" onchange="showMultiple(1)" value="1" checked>...once.&emsp;
						<input type="radio" id="rbTimes" name="rbTimes" onchange="showMultiple(2)" value="2">...multiple times.
					</td>
				</tr><tr align="right" valign="top">
					<td>
						<span id="sdBoxText">Date: </span><input type="date" id="dateStart" name="dateStart" value="<?php echo date('Y-m-d'); ?>" /><br/>
						<div id="edBox" style="display:none">End Date: <input type="date" id="dateEnd" name="dateEnd" value="<?php echo date('Y-m-d'); ?>"/></div>
					</td><td>
						Start Time:<input type="time" id="timeStart" name="timeStart" value="08:00" /></br>
						End Time:<input type="time" id="timeEnd" name="timeEnd" value="08:50" /></br>
						All day? <input type="checkbox" id="cbAllDay" name="cbAllDay"  value="1" onchange="CheckAllDay()">
					</td>
				</tr><tr>
					<td colspan="2" height="25">
						<div id="cbBox" style="display:none">
							<input type="checkbox" name="cbMon" value="1">Monday&ensp;
							<input type="checkbox" name="cbTue" value="2">Tuesday&ensp;
							<input type="checkbox" name="cbWed" value="3">Wednesday&ensp;
							<input type="checkbox" name="cbThu" value="4">Thursday&ensp;
							<input type="checkbox" name="cbFri" value="5">Friday&ensp;
						</div>
					</td>
				</tr><tr>
					<td colspan="2">
						
					</td>
				</tr>
			</table> <table width="450">
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Submit">
					</td>
				</tr><tr>
					<td align="right">
						<input type="reset" value="Reset" onclick="showMultiple(1)">
					</td><td align="left">
						<input type="submit" value="Cancel" onclick="window.close()">
					</td>
				</tr><tr>
			</table>
		</form>
	</body>
</html>
