<?php
	require_once("../includes/config.php");
	require_once("includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	$table_name = "reservations";
	//$field_names = array("level");
	//$field_types = array("char");
		
	//require_once("../includes/security.php");
	require_once("../includes/admin_header.php");
	require_once("../includes/admin_top_nav.php");
	require_once("../lib/_lib_database.php");
	require_once("../lib/_lib_data_display.php");
	require_once($pear_db_path);
?>

<!-- a href="< ?php print APP_ROOT; ?>guide/ability.php" target="_blank"><img align="right" src="< ?php print APP_ROOT; ?>images/help_icon.jpg" border="0"></a -->

<h1>Reservation Management</h1>


<?php
//do deletetion of there's a value in GET collection
	if ($_POST["id"]) {
		$field_names = array("payment_confirm", "firstname", "lastname", "age", "phone", "email", "address", "city", "state", "zip", "ability_level");
        $field_values = array($_POST["payment_confirm"], $_POST["firstname"], $_POST["lastname"], $_POST["age"], $_POST["phone"], $_POST["email"], $_POST["address"], $_POST["city"], $_POST["state"], $_POST["zip"], $_POST["ability_level"]);
		$id_field_name = "id";
        update_data($table_name, $field_names, $field_values, $id_field_name, $_POST["id"]);
		print "<p>This record has been updated. Please use the form below to re-edit this reservation.  Required fields are <span class=\"bold\">bold</span>.</p>";
	} else {
		print "<p>Please use the form below to edit reservation.  Required fields are <span class=\"bold\">bold</span>.</p>";
	}
	
	$field_names = array("id", "product_id", "rentals", "product_cost", "rental_cost", "total_cost", "reservation_date", "barcode_value", "payment_confirm", "firstname", "lastname", "age", "phone", "email", "address", "city", "state", "zip", "ability_level");
	$id_field_name = "id";
	$id_field_type = "number";
	if ($_GET["rowID"]) {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_GET["rowID"], $id_field_type);
	} else {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_POST["id"], $id_field_type);
	}
	require("../lib/forms/update_reservation_form.php");
?>


<?php
	require_once("../includes/admin_footer.php");
?>