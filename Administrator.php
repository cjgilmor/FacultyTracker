
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="adminstyles.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="wrapper" align= "center">
	
	<?php include("headnav.php");?>
    
    <div id="welcome">
    	<p> Welcome <span style="color: #044D98"><?php echo $loginName; ?></span></p><br>
        <hr>
        <div id="description">
        <p>Here you can add, modify, and delete anything to your schedule <span style="color: #FDB00E"> 
		</span><br>
   <ul>
   		<li>	<a style="color: #044D98" href="week.php"> Make Changes to Your Schedule </a> </li>
        <?php if($_SESSION['lvl'] == 1){ echo "<li><a href='tools.php'> Administrator Tools </a></li>";} ?>
        <li>    <a style="color: #044D98" href="logout.php"> Log Out </a> </li>
            
   </ul>
         </p>
        </div><!--End description-->
        </div> <!--End welcome statement-->
       <div>
<?php include("footer.php");?>
</div>


</body>
</html>
