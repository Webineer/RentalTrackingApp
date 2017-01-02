<?php
	require_once("includes/config.php");
	//require_once("includes/session.php");
	//require_once("includes/index_header.php");
	//require_once("includes/top_nav.php");
	//print "the security value is " . $_SESSION["security_value"] . "<br>";
	
	require_once("lib/_lib_database.php");
	require_once("lib/_lib_data_display.php");
	require_once($pear_db_path);
?>
<html>
<head>
	<title><?php print ORGANIZATION; ?> - Equipment Rental Tracking Management Application</title>
	<link rel="stylesheet" href="./includes/rental_app.css" type="text/css" />
	<script language="JavaScript" src="./includes/reg_app.js"></script>
</head>
<body>
<br><br>
<div align="center">
<table CELLSPACING="0" CELLPADDING="2" BORDER="0">
	<TR ALIGN=center>
		<TD><IMG SRC="./images/ski1sm.gif" ALT="Skier"></TD>
		<TD ALIGN="center"><IMG SRC="./images/bradfordsm.jpg" BORDER="0" WIDTH="300" HEIGHT="231" ALT="Ski Bradford Logo"><BR></TD>
		<TD><IMG SRC="./images/board1.gif" ALT="Snowboarder"></TD>
	</TR>
</table>
</div>
<div style="margin-left: 40px; height: 60%; width: 100%">
<a href="guide/configuration.php"><img align="right" src="./images/help_icon.jpg" border="0"></a>

<h1><?php print ORGANIZATION; ?> Equipment Rental Tracking Application</h1>

<p>Welcome to the <?php print ORGANIZATION; ?> Equipment Rental Tracking Application. This application is used to manage <?php print CATEGORY2_PLURAL; ?>.  Please utilize the links below 
to access different modules of this application.</p>

<p>
    <a href="rentals.php">Rentals</a><br />
    <a href="returns.php">Returns</a><br />
    <a href="equipment">Enter Equipment</a><br />
    <a href="reporting">Reporting</a>
</p>


<?php require_once("includes/index_footer.php"); ?>