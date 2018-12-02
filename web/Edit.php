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
//The connection to the database
include('connect.php');

if(!empty($_GET['eventID'])) {
    $eventID = $_GET['eventID'];
    // query the database to provide preselected defaults
    $query = "SELECT * FROM events WHERE eventID = ".mysqli_real_escape_string($conn, $eventID);
    $result = mysqli_query($conn, $query);
    if($result != false){
		
		//Declaring IF variables early;
		$cAllDay ="";
		$sT1="";$sT2="";$sT3="";$sT4="";
		$eBlock = NULL; $r1 = "checked"; $r2 = "";
		$cMon="";$cTue="";$cWed="";$cThu="";$cFri="";

        $data = mysqli_fetch_array($result);
        $eType = $data['typeID'];
		if ($eType==1||$eType==3||$eType==5||$eType==7)$cAllDay ="checked";
		if ($eType==1||$eType==2)$sT1 ="selected";
		if ($eType==3||$eType==4)$sT2 ="selected";
		if ($eType==5||$eType==6)$sT3 ="selected";
		if ($eType==7||$eType==8)$sT4 ="selected";
		$eName = $data['eventName'];
        $ePlace = $data['eventPlace'];
        $eDesc = $data['eventDesc'];
        $eDate = $data['eventDate']; $Date1=$eDate; $Date2=$eDate;
        $eStart = $data['startTime'];
        $eEnd = $data['endTime'];
		if ($data['eventBlockID']!= NULL){
			$r1 = ""; $r2 = "checked";
			$eBlock = $data['eventBlockID'];
			$query = "SELECT * FROM events WHERE eventBlockID = ".mysqli_real_escape_string($conn, $eBlock);
			$result = mysqli_query($conn, $query) or die(mysqli_error($conn));			
			while($row = mysqli_fetch_array($result)){
				if ( date('w', strtotime($row['eventDate'])) == 1)$cMon="checked";
				if ( date('w', strtotime($row['eventDate'])) == 2)$cTue="checked";
				if ( date('w', strtotime($row['eventDate'])) == 3)$cWed="checked";
				if ( date('w', strtotime($row['eventDate'])) == 4)$cThu="checked";
				if ( date('w', strtotime($row['eventDate'])) == 5)$cFri="checked";
				if ( $Date1 > $row['eventDate']) $Date1 = $row['eventDate'];
				if ( $Date2 < $row['eventDate']) $Date2 = $row['eventDate'];
			}
		}
    } else {}
} else {}
?>
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
			document.getElementById("sdBoxText").innerHTML="Date: <input type='date' name='dateStart' value='<?php echo $eDate ?>' />";
		} else {
			document.getElementById("cbBox").style.display = "inline";
			document.getElementById("edBox").style.display = "inline";
			document.getElementById("sdBoxText").innerHTML="Start Date: <input type='date' name='dateStart' value='<?php echo $Date1 ?>' />";
			}
		}
	}
	function blockUpdate(){
		document.getElementById("spanU1").innerHTML="This event is part of a block. Update...";
		document.getElementById("spanU2").innerHTML="<b> ...this event only.</b>";
		document.getElementById("spanU3").innerHTML="<b> ...all events in this block.</b>";
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
	<title>Edit Event</title>
	<body style="background-color: rgb(40,14,157); font-family: 'Calibri'; color:white">
		<form name="mainForm" action="AddAppointment.php<?php echo "?edit=$eventID&editBlock=$eBlock"; ?>" onsubmit="return validateForm()" method="post"> <!-- Please take note of the schema for action with parameters. -->
			<table width="450">
				<tr><td colspan="2" height="80" style="text-align:center; font-size:30px; font-weight:bold; background-color:rgb(253,185,39); color:black; border-radius: 20px 50px;">Edit Event</td>
				<tr>
					<td>Event Name: <input type="text" id="txtName" name="txtName" maxlength="50" pattern="[^><]+" value="<?php echo $eName ?>" required></td>
					<td>Place: <input type="text" id="txtPlace" name="txtPlace" maxlength="50" pattern="[^><]*" value="<?php echo $ePlace ?>"/></td>
				</tr><tr>
					<td colspan="2">
							This event is... <select id="selType" name="selType" onchange="checkType(this.value)">
												<option value='-1'>- SELECT TYPE -</option>
												<option value='1'<?php echo $sT1 ?>>Classtime</option>
												<option value='2'<?php echo $sT2 ?>>Office Hours</option>
												<option value='3'<?php echo $sT3 ?>>Research</option>
												<option value='4'<?php echo $sT4 ?>>Other</option>
											</select>
						</td>
				</tr><tr>
					<td colspan="2">
						This event is about...<br/>
						<textarea id="txtDesc" name="txtDesc" style="width:450px; height:125px; font-family:'Calibri';" maxlength="200"><?php echo $eDesc ?></textarea>
					</td>
				</tr>
		</table> <table width="450">
				<tr>
					<td colspan="2">
						<span id="spanU1">This event happens...</span><br/>
						<input type="radio" id="rbTimes" name="rbTimes" onchange="showMultiple(1)" value="1" <?php echo $r1 ?>><span id="spanU2">...once.</span>&emsp;
						<input type="radio" id="rbTimes" name="rbTimes" onchange="showMultiple(2)" value="2"<?php echo $r2 ?>><span id="spanU3">...multiple times.</span>
					</td>
				</tr><tr align="right" valign="top">
					<td>
						<span id="sdBoxText">Date: <input type="date" id="dateStart" name="dateStart" value="<?php echo $eDate ?>" /></span><br/>
						<div id="edBox" style="display:none">End Date: <input type="date" id="dateEnd" name="dateEnd" value="<?php echo $Date2 ?>"/></div>
					</td><td>
						Start Time:<input type="time" id="timeStart" name="timeStart" value="<?php echo $eStart; ?>" /></br>
						End Time:<input type="time" id="timeEnd" name="timeEnd" value="<?php echo $eEnd; ?>" /></br>
						All day? <input type="checkbox" id="cbAllDay" name="cbAllDay"  value="1" onchange="CheckAllDay()" <?php echo $cAllDay; ?>>
					</td>
				</tr><tr>
					<td colspan="2" height="25">
						<div id="cbBox" style="display:none">
							<input type="checkbox" name="cbMon" value="1" <?php echo $cMon; ?>>Monday&ensp;
							<input type="checkbox" name="cbTue" value="2" <?php echo $cTue; ?>>Tuesday&ensp;
							<input type="checkbox" name="cbWed" value="3" <?php echo $cWed; ?>>Wednesday&ensp;
							<input type="checkbox" name="cbThu" value="4" <?php echo $cThu; ?>>Thursday&ensp;
							<input type="checkbox" name="cbFri" value="5" <?php echo $cFri; ?>>Friday&ensp;
						</div>
					</td>
				</tr><tr>
				</tr>
			</table> <table width="450">
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Submit">
					</td>
				</tr><tr>
					<td align="right">
						<input type="reset" value="Reset" onclick="<?php if($eBlock != NULL) echo "showMultiple(2)"; else echo "showMultiple(1)" ?>">
					</td><td align="left">
						<input type="button" value="Cancel" onclick="window.close()">
					</td>
				</tr><tr>
			</table>
			<?php if($eBlock != NULL) echo "<script>showMultiple(2);blockUpdate();</script>"; 
				  echo"<script>CheckAllDay();</script>"
			?>
		</form>
	</body>
</html>