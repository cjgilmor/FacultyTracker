<?php
session_start();

// if the user is logged in, unset the session
if (isset($_SESSION['basic_is_logged_in'])) {
   unset($_SESSION['basic_is_logged_in']);
}

// now that the user is logged out,
//Redirects the user to the login page
ob_start();
include("index.php");
ob_flush();
exit;
?>