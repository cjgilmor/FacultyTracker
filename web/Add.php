<!-- APOLOGIES FOR THE HARD CODED ASTHETIC STYLE. RAN OUT OF TIME.-->
<html>
	<script>
		//CONFIRMS NO BAD ENTRY DATA, THEN SUBMITS
	function validateForm(){
//		var rbt = document.forms["mainForm"]["rbTimes"].value;
		var	d1 = document.forms["mainForm"]["dateStart"].value;
		var	d2 = document.forms["mainForm"]["dateEnd"].value;
		var	t1 = document.forms["mainForm"]["timeStart"].value;
		var	t2 = document.forms["mainForm"]["timeEnd"].value;
//		if ( rbt==2 && d1 > d2 ) 
		if ( d1 > d2 ) 
			{ alert("End date cannot come BEFORE start date."); return false; }
		else if ( t1 > t2 ) 
			{ alert("End time cannot come BEFORE start time."); return false; }
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
	</script>
	<title>Add Event - alpha V0.8</title>
	<body style="background-color: rgb(40,14,157); font-family: 'Calibri'; color:white">
		<form name="mainForm" action="AddAppointment.php" onsubmit="return validateForm()" method="post">
			<table width="450">
				<tr><td colspan="2" height="80" style="text-align:center; font-size:30px; font-weight:bold; background-color:rgb(253,185,39); color:black; border-radius: 20px 50px;">Add Event</td>
				</tr>
					<td>Event Name: <input type="text" id="txtName" name="txtName" maxlength="50" pattern="[^><]+" required></td>
					<td>Place: <input type="text" id="txtPlace" name="txtPlace" maxlength="50" pattern="[^><]*"/></td>
				</tr><tr>
					<td colspan="2">
						This event is about...<br/>
						<textarea id="txtDesc" name="txtDesc" style="width:450px; height:125px; font-family:'Calibri';" maxlength="200"></textarea>
					</td>
				</tr><tr>
					<td colspan="2">
						Are you Available? <input type="checkbox" name="cbAva" value="1">
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
						End Time:<input type="time" id="timeEnd" name="timeEnd" value="08:50" />
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
						Override existing events? <input type="checkbox" name="cbOvr" value="1" checked >
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
