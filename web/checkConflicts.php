<?php

//THE PURPOSE OF THIS .PHP FILE IS TO DYNAMICALLY POPULATE THE EVENTS TABLES FOUND IN THE StudentWeekly.php PAGE
//MORE INFO ON THIS TYPE OF METHOD: https://www.w3schools.com/php/php_ajax_database.asp

include "connect.php";
$uid = intval($_GET['uid']);
$eid = intval($_GET['eid']);
$ebid = intval($_GET['ebid']);
$d1 = intval($_GET['d1']);
$d2 = intval($_GET['d2']);
$t1 = intval($_GET['t1']);
$t2 = intval($_GET['t2']);

	$out = 0;
	$query = "SELECT eventID FROM events
				WHERE staffID = '$uID' AND eventDate => '$d1' AND eventDate =< '$d2' AND startTime <= '$Stime' AND endTime > '$Stime'
				OR staffID = '$uID' AND eventDate => '$d1' AND eventDate =< '$d2' AND startTime < '$Etime' AND endTime >= '$Etime'
				OR staffID = '$uID' AND eventDate => '$d1' AND eventDate =< '$d2' AND startTime >= '$Stime' AND endTime <= '$Etime'
				OR staffID = '$uID' AND eventDate => '$d1' AND eventDate =< '$d2' AND startTime <= '$Stime' AND endTime >= '$Etime'";
	if ($ebid != -1){
	$query = "SELECT eventID FROM events
				WHERE staffID = '$uID' AND eventBlockID != $ebid AND eventDate => '$d1' AND eventDate =< '$d2' AND startTime <= '$Stime' AND endTime > '$Stime'
				OR staffID = '$uID' AND eventBlockID != $ebid AND eventDate => '$d1' AND eventDate =< '$d2' AND startTime < '$Etime' AND endTime >= '$Etime'
				OR staffID = '$uID' AND eventBlockID != $ebid AND eventDate => '$d1' AND eventDate =< '$d2' AND startTime >= '$Stime' AND endTime <= '$Etime'
				OR staffID = '$uID' AND eventBlockID != $ebid AND eventDate => '$d1' AND eventDate =< '$d2' AND startTime <= '$Stime' AND endTime >= '$Etime'";
	else if ($eid != -1){
	$query = "SELECT eventID FROM events
				WHERE staffID = '$uID' AND eventID != $eid AND eventDate => '$d1' AND eventDate =< '$d2' AND startTime <= '$Stime' AND endTime > '$Stime'
				OR staffID = '$uID' AND eventID != $eid AND eventDate => '$d1' AND eventDate =< '$d2' AND startTime < '$Etime' AND endTime >= '$Etime'
				OR staffID = '$uID' AND eventID != $eid AND eventDate => '$d1' AND eventDate =< '$d2' AND startTime >= '$Stime' AND endTime <= '$Etime'
				OR staffID = '$uID' AND eventID != $eid AND eventDate => '$d1' AND eventDate =< '$d2' AND startTime <= '$Stime' AND endTime >= '$Etime'";
	$result = mysqli_query($conn, $query);
	while($row = mysqli_fetch_array($result)) { $out++; }
	echo $out;
		}
?>