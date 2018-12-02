<?php
//MORE INFO ON THIS TYPE OF METHOD: https://www.w3schools.com/php/php_ajax_database.asp
session_start();
$type = intval($_GET['t']); //type of function
$str = intval($_GET['in']); //input string
if($type==1) $_SESSION['currColl'] = $str;
if($type==2) $_SESSION['currDept'] = $str;
if($type==3) $_SESSION['currStaff'] = $str;
if($type==4) $_SESSION['admColl_1'] = $str;
if($type==5) $_SESSION['admDept_1'] = $str;
if($type==6) $_SESSION['admStaff_1'] = $str;
if($type==7) $_SESSION['admColl_2'] = $str;
if($type==8) $_SESSION['admColl_3'] = $str;
if($type==9) $_SESSION['admDept_3'] = $str;
?>