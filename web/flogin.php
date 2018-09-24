<?php
/**
 * Created by PhpStorm.
 * User: Jasmine
 * Date: 4/8/2015
 * Time: 8:39 AM
 */
session_start();
include('connect.php');

//This gets the information that is entered in the Faculty Login.html page and stores it into variables
$username = strtolower($_POST['username']);
$password = strtolower($_POST['password']);

//Attempt to prevent mysql injection <--- REMEMBER THIS CONCEPT!!!
mysqli_real_escape_string($conn, $username);
mysqli_real_escape_string($conn, $password);

if (!$conn)
{ die('Unable to connect to MySQL' . mysqli_error($conn)); }
else
{
    //Sample Query that get the username from the staffID that matches the username that is inputted
    $query = "SELECT * FROM staff WHERE username='$username'";

    //All the results of the query is stored in this variable
    $result = mysqli_query($conn, $query);

    //This gets the information from result and puts it into an array
    $row = mysqli_fetch_array($result);

    //This validates the username and password to make sure it is in the database
	do{
   if (isset($username) && isset($password))
    {
	
      if ($username == $row['username'] & ($password == $row['password'] or md5($password) == $row['password']))
        {
            //If login was correct
            //Sets session to true
            $_SESSION['basic_is_logged_in'] = true;
            $_SESSION['staffID'] = $row['staffID'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['lvl'] = $row['level'];

            $loginName = $_SESSION['name'];

            //Redirects to this page
            ob_start();
            include("Administrator.php");
            ob_flush();
            exit;
        } else {
            //Will show 2 links to link back to the home page and login page
            include("menu.php");
            echo "<h4 style='text-align:center'>Wrong username or password </h4>";
        }//Ends 2nd if statement
    }//Ends 1st if statement
}
while(false);
}
//if( $username || trim($username) || $password|| trim($password) == '')
//{
//	include("menu.html");
//   echo "<h2>You did not fill out the required fields.</h2>";
//   break;
   
//}

//Closes the connection
mysqli_close($conn);
?>





