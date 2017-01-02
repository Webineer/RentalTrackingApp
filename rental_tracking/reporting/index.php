<?php
	require_once("../includes/config.php");
	require_once("../includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	//require_once("../includes/security.php");
	require_once("../includes/index_header.php");
	require_once("../includes/top_nav.php");
	require_once("../lib/_lib_database.php");
	require_once("../lib/_lib_data_display.php");
	require_once($pear_db_path);
?>

<h1>Equipment Rental Tracking</h1>

<h2>Reporting</h2>

<p>Note:  These reports require that all rented equipment be entered into this application.  If a piece of equipment requires entry, please click <a href="../equipment/">here</a>.</p>

<h3>Rental Non-Returns Report</h3>

<p><?php require("../lib/forms/nonreturns_date_form.php"); ?></p>

<!-- h3>Equipment Usage Report</h3>

<p>< ?php require("../lib/forms/usage_form.php"); ?></p -->

<?php
	require_once("../includes/index_footer.php");
?>