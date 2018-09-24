<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Faculty Tracker</title>
<!--[if lte IE 9]><script src="js/html5shiv.js"></script> <![endif]-->
<!--[if lte IE 8]><script src="js/html5shiv.js"></script> <![endif]-->
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="wrapper" align= "center">
	
<?php include("headnav.php");?>

    <div id="welcome">
    	<p> Welcome to the  <span style="color: #044D98">Computer Science Faculty/Staff Tracker</span></p><br>
        
        <hr>
        <div id="description">
        <p>We provide an effective tool that will allow  students to be able to easily determine <span style="color: #FDB00E"> when and where 
		</span>they can meet with the  <span style="color:#FDB00E"> faculty and staff </span> of the Computer Science department at  North 	Carolina 
		Agricultural and Technical State University. The faculty and staff are able to  <span style="color: #FDB00E"> add, modify, and delete </span> 
		their available hours and locations to the system.  The students can then view all of the provided  <span style="color: #FDB00E">schedules. </span></p>
        </div><!--End description-->
        </div> <!--End welcome statement-->
       
    <div id="content">
          <div id="at-a-glance">
         <label> Faculty At A Glance </label>
          <p> Check here to see what professors are currently available </p> <br>
          
          <?php

include('connect.php');

	//Creates the table to display our results of the query
	echo "<table class='weekly' width=600 border=2><tr><th> Faculty Name </th> <th> Current Location </th> <th> Until</th> </tr>";
	
	//Sets Current Time
	$current = time();
	$here = getdate();
	
	//The querty to get the staff names, events, locations, start and end times from the database
	//to check if the events are taking place right now
	$query1 = "SELECT staff.Name, event.Title, event.Location, event.Start, event.End, event.Ahoc
				FROM staff
				INNER JOIN event
				ON staff.staffID = event.staffID
				WHERE CURDATE() = event.Date
				AND CURTIME() BETWEEN event.Start AND event.End
				ORDER BY event.Ahoc desc";
				
	//All the results of the query is stored in this variable
	$con = mysqli_connect($hostname, $dbusername, $dbpassword, $databaseName);
	$result = mysqli_query($con, $query1);	
				
	//Have a query to get all the events that are going on now that are adhoc and not adhoc
	//Check to see if the staff member has an adhoc event going on
	//If he does then print out that result
	//If he doesnt then print out the regular event
		
	$oldStaffID = 0;
	
	//Goes through the results	
	while($row = mysqli_fetch_array($result))
	{										
			echo "<tr>";
			//This puts the results in the table
			echo "<td align='center'>" . $row['Name'] . "</td>";
			if($row['Ahoc'] == 1)
			{
				
				
				
				echo "<td align='center'>" . "<b>[Override] </b>". $row['Title'] . " (". $row['Location'] . ")" . "</td>";
				echo "<td align='center'>" . "<b>[Override] </b>".  date("g:i a", strtotime($row['End'])). " </td>";
			}
			else
			{
				echo "<td align='center'>" . $row['Title'] . " (". $row['Location'] . ")" . "</td>";
				echo "<td align='center'>" .  date("g:i a", strtotime($row['End'])) . " </td>";
			}
			echo "</tr>";
			
	}
	
	//Closes off the table
	echo "</table>";

?>
         
		<p> NOTICE! Assume faculty member is not available if you do not see them listed </p>
        <label> <a href = "Help.php"> Download our Android App </a> <label>
      </div> <!--End at a glance-->
	<div id="info-boxes">
    	<table>
  <tbody>
    <tr>
      <th scope="col">&nbsp;
      <div id="About-box">
      	<h4>About</h4>
        <hr>
        <p> Learn more about the project and the amazing people who created it</p>
        <div id="learn">
        <a href="About.php">
  			<img src="images/LearnMore.jpg" alt="About Page">
			</a>
        <!---<input type="button" id="Learn" value="Learn More">-->
        </div>
      </div></th>
      <th scope="col">&nbsp;
      <div id="Faculty-box">
      	<h4>Faculty</h4>
        <hr>
        <p> Faculty and staff can add, modify, and delete their schedules</p>
        <div id="login">
        <a href="FacultyLogin.html">
  			<img src="images/LoginHere.jpg" alt="Faculty Page">
			</a>
        <!---<input type="button" id="Learn" value="Learn More">-->
        </div>
      </div></th>
      <th scope="col">&nbsp;<div id="Students-box">
      	<h4>Students</h4>
        <hr>
        <p> View the schedule of your desired professor(s) or staff member.</p>
        <div id="Student">
        <a href="StudentWeekly.php">
  			<img src="images/ViewSchedules.jpg" alt="Faculty Page">
			</a>
        <!---<input type="button" id="Learn" value="Learn More">-->
        </div>
      </div></th>
		  </tr>
		  </tbody>
	  </table>
	  </div><!--End info boxes-->

    </div> <!--End main content-->
	<?php include("footer.php");?>





</div> <!--End wrappper class-->

</body>
</html>
