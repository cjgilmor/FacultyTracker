<!doctype html>
<html>
<head>
<meta charset="utf-8">
<?php  include("connect.php"); ?>
<title>Faculty Tracker</title>
<!--[if lte IE 9]><script src="js/html5shiv.js"></script> <![endif]-->
<!--[if lte IE 8]><script src="js/html5shiv.js"></script> <![endif]-->
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<script>
function getData(type,str) {
    if (str == "-1") { //REVERTS TO DEFAULT WHEN NO ENTRY IS SELECTED
		if (type==0) document.getElementById("dept-list").innerHTML = "<option value='-1' selected >- SELECT DEPTARTMENT -</option>"; 
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
				else document.getElementById("staff-list").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getData.php?t="+type+"&in="+str,true);
        xmlhttp.send();
    }
}
function getGlance(str) {
    if (str == "-1") { //REVERTS TO DEFAULT WHEN NO ENTRY IS SELECTED
		document.getElementById("event-table-data").innerHTML = ""; 
		return;
	} else {
		if (window.XMLHttpRequest) { // <- code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // <- code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {// <- No idea. Just go with it.
				document.getElementById("event-table-data").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getGlance.php?in="+str,true);
        xmlhttp.send();
    }
}
</script>
<body>
<div class="wrapper" align= "center">
<?php include("headnav.php"); ?>
&nbsp;
<form name="frmLoadUser" method="post" action="">
  <table>
		<td>
			<tr>
				<select id="coll-list" onchange="getData(0,this.value)">
					<option value="-1" selected >- SELECT COLLEGE -</option>
					<?php
						$result = mysqli_query($conn, "SELECT * FROM college;") or die(mysqli_error($conn));
						while($row = mysqli_fetch_array($result)) { echo "<option value=" . $row['collID'] . ">" . $row['collName'] . " </option>"; }
					?>
				</select>
			</tr><tr>
				<select id="dept-list" onchange="getGlance(this.value)"><option value="-1" selected >- SELECT DEPTARTMENT -</option></select>
			</tr>
		</td>
	</table>
</form>	 
    <div id="content">
          <div id="at-a-glance">
         <label> At A Glance </label>
	
		<span id="event-table-data"></span>
	
         
		<p> NOTICE! If an event is highlighted in green, the instructor is available.</br>If you do not see them listed, assume they are not available. </p>
      </div> <!--End at a glance-->
    </div> <!--End main content-->
	&nbsp;

	<?php include("footer.php");?>
</div> <!--End wrappper class-->

</body>
</html>