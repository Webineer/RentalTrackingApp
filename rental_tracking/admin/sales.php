<?php
	require_once("../includes/config.php");
	require_once("includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	
	//require_once("../includes/security.php");
	require_once("../includes/agent_header.php");
	require_once("../includes/admin_top_nav.php");
	require_once("../lib/_lib_database.php");
	require_once("../lib/_lib_data_display.php");
	require_once($pear_db_path);
?>

<!-- a href="< ?php print APP_ROOT; ?>guide/ability.php" target="_blank"><img align="right" src="< ?php print APP_ROOT; ?>images/help_icon.jpg" border="0"></a -->

<h1>Reservation Reporting</h1>

<p>This portion of the <?php print ORGANIZATION; ?> Reservation application is utilized to manage product reservations.  Please use the form below to list reservation sales for the time period from <?php print $_POST['sales_begin_date']; ?> to <?php print $_POST['sales_end_date']; ?>.</p>

<h2>Sales Report</h2>

<?php
//do list reservations that match the search criterion in the POST collection
	if ($_POST["sales_end_date"]) {
	//print "the barcode value is " . $_POST['level'] . "<br>";
	   //$table_name = "products";
	   //$field_names = array("id", "product_name");
	   //$res = view_data($table_name, $field_names);
       $sql_string = "select reservations.id, reservations.firstname, reservations.lastname, reservations.email, products.product_name, products.product_type, products.meeting_time, reservations.create_date, reservations.total_cost from reservations, products where reservations.product_id=products.id and ";
       $sql_string = $sql_string . "reservations.create_date <= '" . convert_date_input($_POST['sales_end_date']) . "' and reservations.create_date >= '" . convert_date_input($_POST['sales_begin_date']) . "'";

       //print $sql_string . "<br>";
       
       $res = view_data_generic_sql($sql_string);
	   //print $res->numRows() . " is the number<br>";
	   if ($res->numRows() > 0) {
		  display_sales_data($res);
	   } else {
	       print "<p class=bold >There are no sales that match that search criterion in the application at this time.</p>";
	   }
    }
?>


<?php
	require_once("../includes/admin_footer.php");
?>