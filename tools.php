<?php
session_start();

//Variables for Username, Password, Hostname

//Code for Our Server
include('connect.php');

//Checks to see if the user is logged into the system
if (!isset($_SESSION['basic_is_logged_in']) 
    || $_SESSION['basic_is_logged_in'] !== true) {

	//Redirects the user to the login page
    ob_start();
    include("flogin.php");
    ob_flush();
	exit;
	
}

//write query
if ($_POST["user"] != 0) {
	$user =  mysql_real_escape_string($_POST["user"]);
	$sql = "Select * FROM staff where staffID=".$user;
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	
	$name = $row['name'];
	$level = $row["level"];
	$pass = $row["password"];
	$username = $row["username"];
	$uid = $row['staffID'];
}
else {
	$name = "";
	$level = 2;
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Tools</title>
<link href="toolstyles.css" rel="stylesheet" type="text/css">
</head>
<div class="wrapper" align= "center">
	<?php include("headnav.php"); ?>
<div id="content">




<script type="text/javascript">
function displayIt()
{
	alert("called from Display");
	//var elmt = document.getElementsByName("Name");
	//elmt.value = "Name";
	
	//document.frmLoadUser.submit();
	return false;
}
function Save()
{
	alert("Password 2: " + document.pwd2);
	/*with(doucment.form1)
	{
		if(pwd1 == pwd2)
		{
			document.forms['form1'].submit();
		}
		else
		{
			alert("Passwords don't match");
			return false;
		}
	}*/
}
function Remove()
{

	var del = confirm("Are you sure you want to DELETE user?");
	
	if(del == true)
	{
		document.forms["form1"].submit();
	}
	else
	{
		return false;
	}
}
		</script>
</script>
</head>
<div id="dropdown">
<div id="links">
    <ul>
    <li>
      <a href='week.php'> Go to Your Schedule </a>
  	</li>
    <li> <a href="logout.php"> Logout </a> </p>
    </li>
    </ul>
    </div>
<?php

function dropbox()
{
	$qry = "SELECT * FROM staff";
	//All the results of the query is stored in this variable
	$result = mysql_query($qry) or die(mysql_error());				
	//Goes through the results
	while($row = mysql_fetch_array($result))
	{
			echo "<option value='" . $row['staffID'] . "'>" . $row['name'] . "</option>";
	}
	
	echo "<option selected='selected' value='NULL'>New user</option>";
}
?>
<body>


<form name="frmLoadUser" method="post" action="">
 <font color="#FFF"> Select user: </font>
    <select name="user">
	<?php dropbox(); ?>
</select>
  <input type="submit" name="load"  value="Load" />
  </form>
<hr />
<form id="form1" name="form1" method="post" action="susr.php">
  <table width="311">
    <tr>
      <td width="148"><div align="left">Name: </div></td>
      <td width="151"><input type="text" name="Name" id="Name" value="<?php echo $name; ?>"/></td>
    </tr>
    <tr>
      <td><div align="left">Username: </div></td>
      <td><input type="text" name="Username" id="Username" value="<?php echo $username; ?>" /></td>
    </tr>
    <tr>
      <td><div align="left">Password: </div></td>
      <td><input name="pwd1" type="password" id="pwd1" value="<?php echo $pass; ?>" maxlength="32" /></td>
    </tr>
    <tr>
      <td><div align="left">Re-Enter Password: </div></td>
      <td><input name="pwd2" type="password" id="pwd2" value="<?php echo $pass; ?>" maxlength="32" /></td>
    </tr>
    <tr>
      <td><div align="left">Level: </div></td>
      <td><select name="lvl" id="lvl">
      <?php
	  	$selected = "";
	  	for ($i=1; $i<=2; $i++) {
			if ($i == $level) {
				$selected = " SELECTED ";
			}
			else {
				$selected = "";
			}
			
			$label = "Administrator";
			if ($i == 2) {
				$label = "Regular";
			}
        	echo '<option '.$selected.' value="'.$i.'">'.$label.'</option>';
		}
		?>
        
      </select></td>
    </tr>
    <tr>
    <td><div align="left">
      <input type="hidden" name="hiddenField" id="hiddenField" value="<?php echo $uid; ?>" />
    </div></td>
    <td><p align="right">
      <input type="submit" name="save" id="save" value="Save" />
      <input type="button" onclick="Remove()" name="del" id="del" value="Delete" />
      </p></td>
  </table>
  <p>&nbsp;</p>
</form>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<?php include("footer.php"); ?>
</body>
</html>
