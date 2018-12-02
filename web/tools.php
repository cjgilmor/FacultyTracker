<?php
if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}

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

//POPULATES DROPDOWN BOXES
function getData(type,str) {
    if (str == "-1") { //REVERTS TO DEFAULT WHEN NO ENTRY IS SELECTED
		if (type==0||type==1){
			if (type==0) document.getElementById("dept-list").innerHTML = "<option value='-1' selected >- SELECT DEPTARTMENT -</option>"; 
			document.getElementById("staff-list").innerHTML = "<option value='-1' selected >- SELECT STAFF MEMBER -</option>";
		}if (type==2){
			document.getElementById("s-dept").innerHTML = "<option value='-1' selected >- SELECT DEPTARTMENT -</option>"; 
		}if (type==3)
			document.getElementById("dept-list3").innerHTML = "<option value='-1' selected >- SELECT DEPTARTMENT -</option>"; 
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
				else if (type==3) document.getElementById("dept-list3").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getData.php?t="+type+"&in="+str,true);
        xmlhttp.send();
    }
}

function CheckValidity(str,type){
	if (type==1){
		if (document.getElementById("fname").value=="") { return false; }
		else if (document.getElementById("fname").value=="") { return false; }
		else if (document.getElementById("s-dept").value==-1) { return false; }
		else if (document.getElementById("un").value==""<?php
			$result = mysqli_query($conn, "SELECT un, staffID FROM staff;") or die(mysqli_error($conn));
			while($row = mysqli_fetch_array($result)) { echo " || document.getElementById('un').value=='".$row['un']."' && ( str==1||document.getElementById('huid').value!='".$row['staffID']."')"; }
		?>) { return false; }
		else if (str==1 && document.getElementById("pass").value=="") { return false; }
		else return true;
	}if (type==2){
		if (document.getElementById("ct-cname").value=="") { return false; }
		else return true;
	}if (type==3){
		if (document.getElementById("dt-dname").value=="") { return false; }
		else if (document.getElementById("dt-collSel").value==-1) { return false; }
		else return true;
	}
}
function Add(type){
	if (type==1) document.forms["staff-table"].submit();
	if (type==2) document.forms["coll-table"].submit();
	if (type==3) document.forms["dept-table"].submit();
}
function Save(type){
	if (type==1) {
		var sav = confirm("Are you sure you want to save changes to the selected user?");
		if(sav == true) { document.forms["staff-table"].submit(); } else { return false; }
	}if (type==2) {
		var sav = confirm("Are you sure you want to save changes to the selected college?");
		if(sav == true) { document.forms["coll-table"].submit(); } else { return false; }
	}if (type==3) {
		var sav = confirm("Are you sure you want to save changes to the selected department?");
		if(sav == true) { document.forms["dept-table"].submit(); } else { return false; }
	}
}
function Remove(type){
	if (type==1) {
		var del = confirm("Are you sure you want to DELETE this user? This CANNOT be undone.");
		if(del == true) { document.forms["staff-table"].submit(); } else { return false; }
	} 	if (type==2) {
		var del = confirm("Are you sure you want to DELETE this college? This CANNOT be undone.");
		if(del == true) { document.forms["coll-table"].submit(); } else { return false; }
	}	if (type==3) {
		var del = confirm("Are you sure you want to DELETE this department? This CANNOT be undone.");
		if(del == true) { document.forms["dept-table"].submit(); } else { return false; }
	}
}
function ClickStaff(str){
	document.getElementById("hf-s").value=str;
	if (CheckValidity(str,1)){
		if (str==1) return Add(1);
		else if (str==2) return Save(1);
		else if (str==3) return Remove(1);
	} else alert("You are missing one or more required fields.\n\nUsernames MUST be unique!\nNew users MUST have a password!");
}
function ClickCollege(str){
	document.getElementById("hf-c").value=str;
	if (CheckValidity(str,2)){
		if (str==1) return Add(2);
		else if (str==2) return Save(2);
		else if (str==3) return Remove(2);
	} else alert("College name cannot be blank.");
}
function ClickDept(str){
	document.getElementById("hf-d").value=str;
	if (CheckValidity(str,3)){
		if (str==1) return Add(3);
		else if (str==2) return Save(3);
		else if (str==3) return Remove(3);
	} else alert("You are missing one or more required fields.");
}

//THIS AND NEXT FUNCTION POPULATE THE USER CONTROL PANEL
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
    if (uid == "-1") { //REVERTS TO DEFAULT WHEN NO ENTRY IS SELECTED
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

//THIS AND NEXT FUNCTION POPULATE THE COLLEGE CONTROL PANEL
function getC(cid){
	getCollege(1, cid);
	getCollege(2, cid);
	getCollege(3, cid);
	document.getElementById("ct-sav").style = "display:inline";
	document.getElementById("ct-del").style = "display:inline";
}
function getCollege(type, cid){
    if (cid == "-1") { //REVERTS TO DEFAULT WHEN NO ENTRY IS SELECTED
		return;
	} else {
		if (window.XMLHttpRequest) { // <- code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // <- code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {// <- No idea. Just go with it.
				document.getElementById("c"+type).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getCollege.php?in="+cid+"&t="+type,true);
        xmlhttp.send();
    }
}
//THIS AND NEXT FUNCTION POPULATE THE COLLEGE CONTROL PANEL
function getD(did){
	getDept(1, did);
	getDept(2, did);
	getDept(3, did);
	document.getElementById("dt-sav").style = "display:inline";
	document.getElementById("dt-del").style = "display:inline";
}
function getDept(type, did){
    if (did == "-1") { //REVERTS TO DEFAULT WHEN NO ENTRY IS SELECTED
		return;
	} else {
		if (window.XMLHttpRequest) { // <- code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // <- code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {// <- No idea. Just go with it.
				document.getElementById("d"+type).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getDept.php?in="+did+"&t="+type,true);
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
<br/>
<table align="center" style=" align:left; text-align:right; " cellpadding="5" border="2">
	<style>
		td,th {
			color:white;
			border:0;
		}
	</style>
	<tr>
		<td rowspan="2">
			<!--START USER CONTROL TABLE-->
			<form id="staff-table" name="staff-table" method="post" action="cStaff.php">
				<table align="center" style=" align:left; text-align:right; " cellpadding="5" border="2">
					<input type="hidden" name="hf-s" id="hf-s" value="0" />
					<th colspan=4 align=center>User Control</th>
					<tr>
						<td colspan="4" style="height:50px;" align=center>
							<table>
								<td>
									<tr>
										<select id="coll-list" onchange="getData(0,this.value)">
											<option value='-1' selected >- SELECT COLLEGE -</option>
											<?php
												$result = mysqli_query($conn, "SELECT * FROM college;") or die(mysqli_error($conn));
												while($row = mysqli_fetch_array($result)) { echo "<option value=" . $row['collID'] . ">" . $row['collName'] . " </option>"; }
											?>
										</select>
									</tr><tr>
										<select id="dept-list" onchange="getData(1,this.value)"><option value='-1' selected >- SELECT DEPTARTMENT -</option></select>
									</tr><tr><!-- name="staff-list" is needed for POST functionality -->
										<select name="staff-list" id="staff-list" onchange="getS(this.value)"><option value='-1' selected >- SELECT STAFF MEMBER -</option></select>
									</tr>
								</td>
							</table>
						</td>
					</tr><tr>
						<td>*First name:</td><td align=left><span id="s1"><input type="text" name="fname" id="fname" style="width:95%;" maxlength="50" pattern="[^><]+" /></span></td>
						<td>*College:</td><td align=left><span id="s2"><select name="s-coll" id="s-coll" style="width:95%;" onchange="getData(2,this.value)">
							<option value='-1' selected >- SELECT COLLEGE -</option> 
							<?php
								$result = mysqli_query($conn, "SELECT * FROM college;") or die(mysqli_error($conn));
								while($row = mysqli_fetch_array($result)) { echo "<option value=" . $row['collID'] . ">" . $row['collName'] . " </option>"; }
							?> </select></span>
						</td>
					</tr><tr>
						<td>*Last name:</td><td align=left><span id="s3"><input type="text" name="lname" id="lname" style="width:95%;" maxlength="50" pattern="[^><]+" /></span></td>
						<td>*Department:</td><td align=left><span id="s4"><select name="s-dept" id="s-dept" style="width:95%;"><option value='-1' selected >- SELECT DEPTARTMENT -</option></select></span></td>
					</tr><tr>
						<td>E-mail:</td><td align=left><span id="s5"><input type="text" name="email" id="email" style="width:95%;" maxlength="50" pattern="[^><]+" /></span></td>
						<td>Office:</td><td align=left><span id="s6"><input type="text" name="office" id="office" style="width:95%;" maxlength="50" pattern="[^><]+"/></span></td>
					</tr><tr>
						<td><i>ID:</i></td><td colspan="3" align=left><span id="s0"><input type="text" name="uid" id="uid" disabled /><input type="hidden" name="huid" id="huid" value="" /></span></td>
					</tr><tr>
						<td>*Username:</td><td colspan="3" align=left><span id="s7"><input type="text" name="un" id="un" style="width:95%;" maxlength="16" pattern="[^><]+" /></td></span>
					</tr><tr>
						<td><i>Current Password:</i></td><td colspan="3" align=left><span id="s8"><input type="text" name="passO" id="passO" style="width:50%;" disabled /></span></td>
					</tr><tr>
						<td colspan="4" style="height:30px;" ></td>
					</tr><tr>
						<td>New Password:</td><td colspan="3" align=left><input type="password" name="pass" id="pass" size=32 pattern="[^><]+" /></td>
					</tr><tr>
						<td colspan="4" style="height:30px;" ></td>
					</tr><tr>
						<td align="right"><input type="button" name="btnAdd" id="btnAdd" value="Add New User with Current Data" onclick="ClickStaff(1)" style="width:150px; white-space: normal;"/></td>
						<td><span id="sav" style="display:none"><input type="button" name="btnSave" id="btnSave" value="Submit Changes to Selected User" onclick="ClickStaff(2)" style="width:150px; white-space: normal;"/></span></td>
						<td align="left"><span id="del" style="display:none"><input type="button" name="btnDel" id="btnDel" value="Delete Selected User" onclick="ClickStaff(3)" style="width:150px; white-space: normal;"/></span></td>
					</tr>
				</table>
			</form>
			<!--END USER CONTROL TABLE-->
		</td><td>
			<!--START COLLEGE CONTROL TABLE-->
			<form id="coll-table" name="coll-table" method="post" action="cColl.php">
			<input type="hidden" name="hf-c" id="hf-c" value="0" />
				<table align="center" style=" align:left; text-align:right;" cellpadding="5" border="2">
					<th colspan=3 align=center>College Control</th>
					<tr>
						<td colspan=3 style="height:50px;" align=center>
							<select id="ct_coll-list" onchange="getC(this.value)">
								<option value='-1' selected >- SELECT COLLEGE -</option>
								<?php
									$result = mysqli_query($conn, "SELECT * FROM college;") or die(mysqli_error($conn));
									while($row = mysqli_fetch_array($result)) { echo "<option value=" . $row['collID'] . ">" . $row['collName'] . " </option>"; }
								?>
							</select>
						</td>
					</tr><tr>
						<td colspan=3 align=left style="padding-left: 5em; font-size: 10px;"><span id="c2"></span></td>
					</tr><tr>
						<td colspan=3 align=left style="padding-left: 5em; font-size: 10px;"><span id="c3"></span></td>
					</tr><tr>
						<td>*College Name:</td><td align=left colspan=2><span id="c1"><input type="text" name="ct-cname" id="ct-cname" style="width:95%;" maxlength="50" pattern="[^><]+" /><input type='hidden' name='hcid' id='hcid' value="" /></span></td>
					</tr><tr>
						<td align="right"><input type="button" name="btnAddCT" id="ct-btnAddCT" value="Add New College with Current Data" onclick="ClickCollege(1)" style="width:150px; white-space: normal;"/></td>
						<td><span id="ct-sav" style="display:none"><input type="button" name="btnSaveCT" id="btnSaveCT" value="Submit Changes to Selected College" onclick="ClickCollege(2)" style="width:150px; white-space: normal;"/></span></td>
						<td align="left"><span id="ct-del" style="display:none"><input type="button" name="btnDelCT" id="btnDelCT" value="Delete Selected College" onclick="ClickCollege(3)" style="width:150px; white-space: normal;"/></span></td>
					</tr>
				</table>
			</form>
			<!--END COLLEGE CONTROL TABLE-->
		</td>
	</tr><tr>
		<td>
			<!--START DEPARTMENT CONTROL TABLE-->
			<form id="dept-table" name="dept-table" method="post" action="cDept.php">
			<input type="hidden" name="hf-d" id="hf-d" value="0" />
				<table align="center" style=" align:left; text-align:right;" cellpadding="5" border="2">
					<th colspan=3 align=center>Department Control</th>
					<tr>
						<td colspan=3 style="height:50px;" align=center>
							<table>
								<td>
									<tr>
										<select id="coll-list3" onchange="getData(3,this.value)">
											<option value='-1' selected >- SELECT COLLEGE -</option>
											<?php
												$result = mysqli_query($conn, "SELECT * FROM college;") or die(mysqli_error($conn));
												while($row = mysqli_fetch_array($result)) { echo "<option value=" . $row['collID'] . ">" . $row['collName'] . " </option>"; }
											?>
										</select>
									</tr><tr>
										<select id="dept-list3" onchange="getD(this.value)"><option value='-1' selected >- SELECT DEPTARTMENT -</option></select>
									</tr>
								</td>
							</table>
						</td>
					</tr><tr>
						<td colspan=3 align=left style="padding-left: 5em; font-size: 10px;"><span id="d3"></span></td>
					</tr><tr>
						<td>*College:</td><td align=left colspan=2><span id="d2"><select name="dt-collSel" id="dt-collSel" style="width:95%;">
							<option value='-1' selected >- SELECT COLLEGE -</option> 
							<?php
								$result = mysqli_query($conn, "SELECT * FROM college;") or die(mysqli_error($conn));
								while($row = mysqli_fetch_array($result)) { echo "<option value=" . $row['collID'] . ">" . $row['collName'] . " </option>"; }
							?> </select></span>
						</td>
					</tr><tr>
						<td>*Departmant Name:</td><td align=left colspan=2><span id="d1"><input type="text" name="dt-dname" id="dt-dname" style="width:95%;" maxlength="50" pattern="[^><]+" /><input type='hidden' name='hdid' id='hdid' value="" /></span></td>
					</tr><tr>
						<td align="right"><input type="button" name="btnAddDT" id="btnAddDT" value="Add New Department with Current Data" onclick="ClickDept(1)" style="width:150px; white-space: normal;"/></td>
						<td><span id="dt-sav" style="display:none"><input type="button" name="btnSaveDT" id="btnSaveDT" value="Submit Changes to Selected Department" onclick="ClickDept(2)" style="width:150px; white-space: normal;"/></span></td>
						<td align="left"><span id="dt-del" style="display:none"><input type="button" name="btnDelDT" id="btnDelDT" value="Delete Selected Department" onclick="ClickDept(3)" style="width:150px; white-space: normal;"/></span></td>
					</tr>
				</table>
			</form>
			<!--END DEPARTMENT CONTROL TABLE-->
		</td>
	</tr>
</table>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php include("footer.php"); ?>
</body>
</html>
