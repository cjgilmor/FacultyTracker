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
		<title>Add Appointment</title>
	</head>

	<?php
		include('connect.php');
		function checkRepeat($uID, $date, $Stime, $Etime) {// FOR NEW EVENT
		include('connect.php'); // <-- CONNECT PHP FILE REQUIRED INSIDE FUNCTION
			mysqli_real_escape_string($conn, $uID);
			mysqli_real_escape_string($conn, $date);
			mysqli_real_escape_string($conn, $Stime);
			mysqli_real_escape_string($conn, $Etime);
			// DELETES ALL SAME STAFF EVENTS THAT CONFLICTS WITH THE CURRENT EVENT
			$testqry = "DELETE FROM events
						WHERE staffID = '$uID' AND eventDate = '$date' AND startTime <= '$Stime' AND endTime > '$Stime'
						OR staffID = '$uID' AND eventDate = '$date' AND startTime < '$Etime' AND endTime >= '$Etime'
						OR staffID = '$uID' AND eventDate = '$date' AND startTime >= '$Stime' AND endTime <= '$Etime'
						OR staffID = '$uID' AND eventDate = '$date' AND startTime <= '$Stime' AND endTime >= '$Etime'";
			mysqli_query($conn, $testqry);
		}
		function checkRepeat2($eID, $uID, $date, $Stime, $Etime) {// FOR EDIT EVENT
		include('connect.php'); // <-- CONNECT PHP FILE REQUIRED INSIDE FUNCTION
			mysqli_real_escape_string($conn, $uID);
			mysqli_real_escape_string($conn, $date);
			mysqli_real_escape_string($conn, $Stime);
			mysqli_real_escape_string($conn, $Etime);
			//DELETES ALL SAME STAFF EVENTS THAT CONFLICTS WITH THE CURRENT EVENT, EXCLUDING THE EVENT BEING EDITED
			$testqry = "DELETE FROM events
						WHERE eventID != '$eID' AND staffID = '$uID' AND eventDate = '$date' AND startTime <= '$Stime' AND endTime > '$Stime'
						OR eventID != '$eID' AND staffID = '$uID' AND eventDate = '$date' AND startTime < '$Etime' AND endTime >= '$Etime'
						OR eventID != '$eID' AND staffID = '$uID' AND eventDate = '$date' AND startTime >= '$Stime' AND endTime <= '$Etime'
						OR eventID != '$eID' AND staffID = '$uID' AND eventDate = '$date' AND startTime <= '$Stime' AND endTime >= '$Etime'";
			mysqli_query($conn, $testqry);
		}//USER INPUT SANITATION
		function test_input($data) {//Help to prevent Cross-Site Scripting attacks
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		//Variables for the data entered into the form
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$uID = test_input($_SESSION['staffID']);
			$eName = test_input($_POST['txtName']);
			$ePlace = test_input($_POST['txtPlace']);
			$eDesc = test_input($_POST['txtDesc']);
			$eDateStart = test_input($_POST['dateStart']);
			$eTimeStart = test_input($_POST['timeStart']);
			$eTimeEnd = test_input($_POST['timeEnd']);

			$eDays="";
			$eRepeat = test_input($_POST['rbTimes']);
			if ($eRepeat==2){
				$eDateEnd = test_input($_POST['dateEnd']);
				//SETS VARIABLE THAT IDENTIFIES WHAT DAYS  THE EVENT OCCURS (MULTIPLE ONLY)

				if(isset($_POST['cbMon']))$eDays.="M";
				if(isset($_POST['cbTue']))$eDays.="T";
				if(isset($_POST['cbWed']))$eDays.="W";
				if(isset($_POST['cbThu']))$eDays.="R";
				if(isset($_POST['cbFri']))$eDays.="F";
				/*
				REMEMBER THE 'strpos' FUNCTION!
				if ( strpos($eDays, 'M')!==false ) echo "This event happens on Mondays!";
				if ( strpos($eDays, 'T') ) echo "This event happens on Tuesdays!";
				etc...

				REMEMBER THE 'date(w)' FUNCTION!
				if ( date('w', strtotime($eDateStart)) == 1) echo "This event happens on Mondays!";
				if ( date('w', strtotime($eDateStart)) == 2) echo "This event happens on Tuesdays!";
				etc...	
				*/
				//IF NO REPEAT OCCURS, end date is set to start date
			} else $eDateEnd = test_input($_POST['dateStart']);
			/*EVENT TYPE:	
			0 = Overriding event and professor is available
			1 = Overriding event and professor is NOT available
			2 = NOT Overriding event and professor is available
			3 = NOT Overriding event and professor is NOT available
			*/
			if (isset($_POST['cbOvr'])){//IF OVERRIDE
				if (isset($_POST['cbAva']))$eType=0;//IF AVAILABLE
				else $eType=1;
			} else {
				if (isset($_POST['cbAva']))$eType=2;//IF AVAILABLE
				else $eType=3;
			}
		}
		$eventBlockID="";
		if(isset($_GET['edit']) && !empty($_GET['edit'])) {
			$edit = true; $editBlock = "";
			$eventID = mysqli_real_escape_string($conn, $_GET['edit']);
			if(isset($_GET['editBlock']) && $_GET['editBlock'] != NULL) {
				$editBlock = true;
				$eventBlockID = mysqli_real_escape_string($conn, $_GET['editBlock']);
			} else { $editBlock = false; }
		} else { $edit = false; $editBlock = false; }

		//To prevent script hacking
		mysqli_real_escape_string($conn, $eDesc);
		// This inserts the data into the database
		if($edit) checkRepeat2($eventID, $uID, $eDateStart, $eTimeStart, $eTimeEnd);
		else checkRepeat($uID, $eDateStart, $eTimeStart, $eTimeEnd);
		if ($eRepeat==1 || !$edit){ // INITAL UPLOAD WILL ONLY PROPERLY WORK IN ALL SCENARIOS IF IT IS A SINGLE EDIT OR A NEW EVENT
									//    This block MAY become redundant in later builds
			if($edit) {
				$query = "UPDATE events SET staffID = '$uID', typeID = '$eType', eventName = '$eName', eventPlace = '$ePlace', 
				eventDesc = '$eDesc', eventDate = '$eDateStart', startTime = '$eTimeStart', endTime = '$eTimeEnd' 
				WHERE eventID = '$eventID'"; 
			} else {
				$query = "INSERT INTO events(staffID, typeID, eventName, eventPlace, eventDesc, eventDate, startTime, endTime) 
				VALUES ('$uID', '$eType', '$eName', '$ePlace', '$eDesc', '$eDateStart', '$eTimeStart', '$eTimeEnd' )";
			}
			mysqli_query($conn, $query) or die(mysqli_error($conn));
			//ADVANCES DATE BY ONE DAY
			$eDateStart = date("Y-m-d", strtotime("$eDateStart +1 day"));
		}
		if ($eRepeat==2){ //IF THE INSERTION/EDIT REPEATS, THIS FUNCTION GRABS THE eventID OF THE RECENTLY INSERTED EVENT
			if ($editBlock) { 	// EDIT MULTI EVENT
								// IF UPDATING A BLOCK, DELETE OLD BLOCK
				$query = "DELETE FROM events WHERE eventBlockID='$eventBlockID'";
				$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
			} else {
				if ($edit){ // EDIT SINGLE EVENT TO MULTI
					$eventBlockID = $eventID;
					$query = "DELETE FROM events WHERE eventID='$eventBlockID'";
					$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
				}
				else { // NEW MULTI EVENT
					$query = "SELECT LAST_INSERT_ID()"; 
					$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
					$row = mysqli_fetch_array($result);
					$eventBlockID = mysqli_real_escape_string($conn, $row['LAST_INSERT_ID()']);
				} 
			}
		}
		while($eDateStart <= $eDateEnd) {
			//CHECKS IF CURRENT DAY IS ON THE $eDays VARIABLE
			if ( strpos($eDays, 'M')!== false && date('w', strtotime($eDateStart)) == 1 || //<--- Not sure what the logic gate "!==" does, but when M is in pos=0, 
				 strpos($eDays, 'T')!== false && date('w', strtotime($eDateStart)) == 2 || //     it is interptreted as FALSE. Without it, strpos($eDays, 'M')
				 strpos($eDays, 'W')!== false && date('w', strtotime($eDateStart)) == 3 || //     would ALWAYS fail (FALSE) if M in $eDays is the very first letter,
				 strpos($eDays, 'R')!== false && date('w', strtotime($eDateStart)) == 4 || //     which it always will be according to the site setup.
				 strpos($eDays, 'F')!== false && date('w', strtotime($eDateStart)) == 5 ){ //     strpos returns the POSITION of the item, not a boolean.
					checkRepeat($uID, $eDateStart, $eTimeStart, $eTimeEnd);
					$query = "INSERT INTO events(eventBlockID, staffID, typeID, eventName, eventPlace, eventDesc, eventDate, startTime, endTime) 
					VALUES ('$eventBlockID', '$uID', '$eType', '$eName', '$ePlace', '$eDesc', '$eDateStart', '$eTimeStart', '$eTimeEnd' )";
					// Inserts the entry into the database
					mysqli_query($conn, $query) or die(mysqli_error($conn));
			}
			//ADVANCES DATE BY ONE DAY
			$eDateStart = date("Y-m-d", strtotime("$eDateStart +1 day"));
		}
		if ($eRepeat==2 && !$edit || $eRepeat==2 && $edit && !$editBlock) {
			/*if ($edit) $query = "UPDATE events SET eventBlockID = $eventBlockID WHERE eventID = $eventID";
			else */
			$query = "UPDATE events SET eventBlockID = $eventBlockID WHERE eventID = $eventBlockID";
			mysqli_query($conn, $query) or die(mysqli_error($conn));
		} if ($eRepeat==1 && $edit) { // SINGLE EVENTS NEVER HAVE AN eventBlockID
			$query = "UPDATE events SET eventBlockID = NULL WHERE eventID = $eventID";
			mysqli_query($conn, $query) or die(mysqli_error($conn));
		}
	?>
	<script type="text/javascript">
		window.opener.location.href="week.php";
		self.close();
	</script>
</html>