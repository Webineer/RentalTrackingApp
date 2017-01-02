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

<p>This portion of the <?php print ORGANIZATION; ?> Reservation application is utilized to manage product reservations.  Please use the form below to confirm reservations in the application.</p>

<h2>Individual Customer Report</h2>

<?php
//do deletetion of there's a value in GET collection
	if ($_GET["rowID"]) {
		$table_name = "reservations";	
		$id_field_name = "id";
		$id_field_type = "number";
		delete_row_data($table_name, $id_field_name, $_GET["rowID"], $id_field_type);
		print "<p>The selected reservation has been deleted.</p>";	
	} 
    
//do list reservations that match the search criterion in the POST collection
	if ($_POST["level"]) {
	//print "the barcode value is " . $_POST['level'] . "<br>";
	   //$table_name = "products";
	   //$field_names = array("id", "product_name");
	   //$res = view_data($table_name, $field_names);
       $sql_string = "select reservations.id, reservations.firstname, reservations.lastname, reservations.email, products.product_name, products.product_type, products.meeting_time, reservations.reservation_date from reservations, products where reservations.product_id=products.id and ";
       
       if ($_POST['searchtype'] == "fn") {
            $sql_string = $sql_string . "reservations.firstname like '%" . $_POST['level'] . "%'";
       }
       
       if ($_POST['searchtype'] == "ln") { 
            $sql_string = $sql_string . "reservations.lastname like '%" . $_POST['level'] . "%'";
       }
       
       if ($_POST['searchtype'] == "e") { 
            $sql_string = $sql_string . "reservations.email like '%" . $_POST['level'] . "%'";
       } 
       
       if ($_POST['searchtype'] == "bc") {
            $sql_string6 = "select lastname, email from reservations where barcode_value='" . $_POST['level'] ."'";
            $product_info = get_one_row_data_array_generic_sql($sql_string6);
            //if (is_array($product_info)) {
			//	list($customer_lastname, $customer_email) = $product_info;
                $sql_string = $sql_string . "reservations.barcode_value = '" . $_POST['level'] . "'";
                //$sql_string = $sql_string . "reservations.lastname like '%" . $customer_lastname . "%'";
	        //} else {
                
            //}
       }
       //print $sql_string . "<br>";
       
       $res = view_data_generic_sql($sql_string);
	   //print $res->numRows() . " is the number<br>";
	   if ($res->numRows() > 0) {
		  display_reservation_data($res);
	   } else {
	       print "<p class=bold >There are no reservations that match that search criterion in the application at this time.</p>";
	   }
    }
?>


<?php
	require_once("../includes/admin_footer.php");
?>