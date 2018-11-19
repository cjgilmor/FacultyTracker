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
function getData(type,str) {
    if (str == "") { //REVERTS TO DEFAULT WHEN NO ENTRY IS SELECTED
		if (type==0||type==1){
			if (type==0) document.getElementById("dept-list").innerHTML = "<option value=\"\" selected >- SELECT DEPTARTMENT -</option>"; 
			document.getElementById("staff-list").innerHTML = "<option value=\"\" selected >- SELECT STAFF MEMBER -</option>";
		}if (type==2){
			document.getElementById("s-dept").innerHTML = "<option value=\"\" selected >- SELECT DEPTARTMENT -</option>"; 
		}
		return;
	} else {
		if (window.XMLHttpRequest) { // <- code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // <- code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {// <- No idea. Just go with it.
				if (type==0) document.getElementById("dept-list").innerHTML = this.responseText;
				else if (type==1) document.getElementById("staff-list").innerHTML = this.responseText;
				else if (type==2) document.getElementById("s-dept").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getData.php?t="+type+"&in="+str,true);
        xmlhttp.send();
    }
}
function getS(uid){
	getStaff(0, uid);
	getStaff(1, uid);
	getStaff(2, uid);
	getStaff(3, uid);
	getStaff(4, uid);
	getStaff(5, uid);
	getStaff(6, uid);
	getStaff(7, uid);
	getStaff(8, uid);
}

function getStaff(type, uid){
    if (uid == "") { //REVERTS TO DEFAULT WHEN NO ENTRY IS SELECTED
		return;
	} else {
		if (window.XMLHttpRequest) { // <- code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // <- code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {// <- No idea. Just go with it.
				document.getElementById("s"+type).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getStaff.php?in="+uid+"&t="+type,true);
        xmlhttp.send();
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
<body>

<form name="frmLoadUser" method="post" action="">
  <table>
		<td>
			<tr>
				<select id="coll-list" onchange="getData(0,this.value)">
					<option value="" selected >- SELECT COLLEGE -</option>
					<?php
						$result = mysqli_query($conn, "SELECT * FROM college;") or die(mysqli_error($conn));
						while($row = mysqli_fetch_array($result)) { echo "<option value=" . $row['collID'] . ">" . $row['collName'] . " </option>"; }
					?>
				</select>
			</tr><tr>
				<select id="dept-list" onchange="getData(1,this.value)"><option value="" selected >- SELECT DEPTARTMENT -</option></select>
			</tr><tr><!-- name="staff-list" is needed for POST functionality -->
				<select name="staff-list" id="staff-list" onchange="getS(this.value)"><option value="" selected >- SELECT STAFF MEMBER -</option></select>
			</tr>
		</td>
	</table>
</form>
<style>
	td {
		color:white;
	}
</style>
<hr />
<form id="staff-table" name="staff-table" method="post" action="susr.php">
  <table align="center" style="text-align:right" border="1" bordercolor="black" >
    <tr>
      <td>*First name:</td><td><span id="s1"><input type="text" name="fname" id="fname" style="width:100%;"/></span></td>
	  <td>*College:</td>
	  <td><span id="s2"><select name="s-coll" id="s-coll" style="width:100%" onchange="getData(2,this.value)">
			<option value="" selected >- SELECT COLLEGE -</option> 
			<?php
				$result = mysqli_query($conn, "SELECT * FROM college;") or die(mysqli_error($conn));
				while($row = mysqli_fetch_array($result)) { echo "<option value=" . $row['collID'] . ">" . $row['collName'] . " </option>"; }
			?> </select></span>
		</td>
    </tr>
    <tr>
      <td>*Last name:</td><td><span id="s3"><input type="text" name="lname" id="lname" style="width:100%;"/></span></td>
	  <td>*Department:</td><td><span id="s4"><select name="s-dept" id="s-dept" style="width:100%;"><option value="" selected >- SELECT DEPTARTMENT -</option></select></span></td>
    </tr>
	<tr>
      <td>E-mail:</td><td><span id="s5"><input type="text" name="email" id="email" style="width:100%;"/></span></td>
	  <td>Office:</td><td><span id="s6"><input type="text" name="office" id="office" style="width:100%;"/></span></td>
    </tr>
	<tr><td colspan="4" style="height:30px;" ><span id="s0" style="display:none"><input type="text" name="id" id="id" disabled /></td></tr>
	<tr><td>*Username:</td><td colspan="3"><span id="s7"><input type="text" name="user" id="user" style="width:100%;"/></td></span></tr>
	<tr><td>Current Password:</td><td colspan="3"><span id="s8"><input type="text" name="passO" id="passO" style="width:100%;" disabled value="test" /></span></td></tr>
	<tr><td colspan="4" style="height:30px;" ></td></tr>
	<tr><td>New Password:</td><td colspan="3"><input type="password" name="pass" id="pass" style="width:100%;"/></td></tr>
	<tr><td style="width:auto">Confirm Password:</td><td colspan="3"><input type="password" name="p2" id="p2" style="width:100%;" /></td></tr>
	<tr><td colspan="4" style="height:30px;" ></td></tr>
	<tr><td align="right"><input type="button" name="b1" id="b1" value="Submit Changes" /></td><td></td><td colspan="2" align="left"><input type="button" name="b2" id="b2" value="Create New User" /></td></tr>
  </table>
</form>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<?php include("footer.php"); ?>
</body>
</html>
