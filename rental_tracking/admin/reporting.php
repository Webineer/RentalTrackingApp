<?php
	require_once("../includes/config.php");
	require_once("includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	
	//require_once("../includes/security.php");
	require_once("../includes/admin_header.php");
	require_once("../includes/admin_top_nav.php");
	require_once("../lib/_lib_database.php");
	require_once("../lib/_lib_data_display.php");
	require_once($pear_db_path);
?>

<!-- a href="< ?php print APP_ROOT; ?>guide/ability.php" target="_blank"><img align="right" src="< ?php print APP_ROOT; ?>images/help_icon.jpg" border="0"></a -->

<h1>Reservation Reporting</h1>

<h2>Reservation Load Report</h2>

<p class="bold"><a href="daily_load_report.php">DAILY ATTENDANCE REPORT</a></p>
<p>Use the form below to enter the field values for this reservation report:</p>

<?php require("../lib/forms/load_form.php"); ?>

<h2>Unclaimed Reservations Report</h2>

<p class="bold"><a href="daily_unclaimed_report.php">DAILY UNCLAIMED RESERVATIONS REPORT</a></p>
<p>Use the form below to enter the field values for this reservation report:</p>

<?php require("../lib/forms/unclaimed_form.php")?>

<h2>Individual Customer Reports</h2>

<p>Use the form below to enter the field values for this reservation report:</p>

<?php require("../lib/forms/customer_search_form.php")?>

<p class="bold"><a href="daily_sales_report.php">DAILY SALES REPORT</a></p>
<p>Use the form below to enter the field values for this reservation report:</p>

<?php require("../lib/forms/sales_search_form.php")?>

<?php
	require_once("../includes/admin_footer.php");
?>