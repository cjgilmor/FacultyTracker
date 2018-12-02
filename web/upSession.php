<?php
//MORE INFO ON THIS TYPE OF METHOD: https://www.w3schools.com/php/php_ajax_database.asp
session_start;
$type = intval($_GET['t']); //type of function
$str = intval($_GET['in']); //input string
if($type==1) $_SESSION['currColl'] = $str;
if($type==2) $_SESSION['currDept'] = $str;
if($type==3) $_SESSION['currStaff'] = $str;
	
?>