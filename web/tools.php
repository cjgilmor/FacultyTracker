<?php

if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}

//Variables for Username, Password, Hostname

//Code for Our Server
include('nfMv6SUnU9.php');
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
}function Add(){
	document.forms["staff-table"].submit();
}
function Save(){
	var sav = confirm("Are you sure you want to save changes to user?");
	if(sav == true) {
		document.forms["staff-table"].submit();
	} else {
		return false;
	}
}
function Remove(){
	var del = confirm("Are you sure you want to DELETE user? This CANNOT be undone.");
	if(del == true) {
		document.forms["staff-table"].submit();
	} else {
		return false;
	}
}function Click(str){
	
	document.getElementById("hf").value=str;
	if (str==0) return Add();
	else if (str==1) return Save();
	else if (str==2) return Remove();
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
	document.getElementById("sav").style = "display:inline";
	document.getElementById("del").style = "display:inline";
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
<style>
	td,th {
		color:white;
		border:0;
	}
</style>
<hr />
<form id="staff-table" name="staff-table" method="post" action="susr.php">
<input type="hidden" name="hf" id="hf" value="0" />
  <table align="center" style=" align:left; text-align:right; " cellpadding="5" border="2">
  <th colspan=4 align=center>User Control</th>
  <tr><td colspan="4" style="height:50px;" align=center>
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

  </td></tr>
    <tr>
      <td>*First name:</td><td align=left><span id="s1"><input type="text" name="fname" id="fname" style="width:95%;" maxlength="50" pattern="[^><]+" /></span></td>
	  <td>*College:</td>
	  <td align=left><span id="s2"><select name="s-coll" id="s-coll" style="width:95%;" onchange="getData(2,this.value)">
			<option value="" selected >- SELECT COLLEGE -</option> 
			<?php
				$result = mysqli_query($conn, "SELECT * FROM college;") or die(mysqli_error($conn));
				while($row = mysqli_fetch_array($result)) { echo "<option value=" . $row['collID'] . ">" . $row['collName'] . " </option>"; }
			?> </select></span>
		</td>
    </tr>
    <tr>
      <td>*Last name:</td><td align=left><span id="s3"><input type="text" name="lname" id="lname" style="width:95%;" maxlength="50" pattern="[^><]+" /></span></td>
	  <td>*Department:</td><td align=left><span id="s4"><select name="s-dept" id="s-dept" style="width:95%;"><option value="" selected >- SELECT DEPTARTMENT -</option></select></span></td>
    </tr>
	<tr>
      <td>E-mail:</td><td align=left><span id="s5"><input type="text" name="email" id="email" style="width:95%;" maxlength="50" pattern="[^><]+" /></span></td>
	  <td>Office:</td><td align=left><span id="s6"><input type="text" name="office" id="office" style="width:95%;" maxlength="50" pattern="[^><]+"/></span></td>
    </tr>
	<tr><td><i>ID:</i></td><td colspan="3" align=left><span id="s0"><input type="text" name="uid" id="uid" disabled /><input type="hidden" name="huid" id="huid" value="" /></span></td></tr>
	<tr><td>*Username:</td><td colspan="3" align=left><span id="s7"><input type="text" name="un" id="un" style="width:95%;" maxlength="16" pattern="[^><]+" /></td></span></tr>
	<tr><td><i>Current Password:</i></td><td colspan="3" align=left><span id="s8"><input type="text" name="passO" id="passO" size=32 disabled /></span></td></tr>
	<tr><td colspan="4" style="height:30px;" ></td></tr>
	<tr><td>New Password:</td><td colspan="3" align=left><input type="password" name="pass" id="pass" size=32 pattern="[^><]+" /></td></tr>
	<tr><td colspan="4" style="height:30px;" ></td></tr>
	<tr><td align="right">
		<input type="button" name="btnAdd" id="btnAdd" value="Add New User with Current Data" onclick="Click(0)" /></td><td>
		<span id="sav" style="display:none"><input type="button" name="btnSave" id="btnSave" value="Submit Changes to Selected User" onclick="Click(1)" /></span></td><td align="left">
		<span id="del" style="display:none"><input type="button" name="btnDel" id="btnDel" value="Delete Selected User" onclick="Click(2)" /></span></td></tr>
  </table>
</form>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<?php include("footer.php"); ?>
</body>
</html>
