<?php
	require_once("../includes/config.php");
	require_once("includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	$table_name = "products";
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

<h1>Product Management</h1>


<?php
//do deletetion of there's a value in GET collection
	if ($_POST["id"]) {
		//$field_names = array("product_name", "product_description", "product_type", "meeting_time", "product_cost", "discount_cost", "rental_fee", "redemption_area", "max_seats", "account_number");
        $field_names = array("product_name", "product_description", "product_cost", "rental_fee", "account_number", "product_type_id", "on_application", "product_type");
        //$field_values = array($_POST["product_name"], $_POST["product_description"], $_POST["product_type"], $_POST["meeting_time"], $_POST["product_cost"], $_POST["discount_cost"], $_POST["rental_fee"], $_POST["redemption_area"], $_POST["max_seats"], $_POST["account_number"]);
		$field_values = array($_POST["product_name"], $_POST["product_description"], $_POST["product_cost"], $_POST['rental_fee'], $_POST["account_number"], $_POST["product_type_id"], $_POST['on_application'], $_POST['product_type']);
		$id_field_name = "id";
        update_data($table_name, $field_names, $field_values, $id_field_name, $_POST["id"]);
		print "<p>This product record has been updated. Please use the form below to re-edit this product information.  Required fields are <span class=\"bold\">bold</span>.</p>";
	} else {
		print "<p>Please use the form below to edit the product information.  Required fields are <span class=\"bold\">bold</span>.</p>";
	}
	
	//$field_names = array("id", "product_name", "product_description", "product_type", "meeting_time", "product_cost", "discount_cost", "rental_fee", "redemption_area", "max_seats", "account_number");
	$field_names = array("id", "product_name", "product_description", "product_cost", "rental_fee", "account_number", "product_type_id", "on_application", "product_type");
	$id_field_name = "id";
	$id_field_type = "number";
	if ($_GET["rowID"]) {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_GET["rowID"], $id_field_type);
	} else {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_POST["id"], $id_field_type);
	}
	require("../lib/forms/update_product_form.php");
?>


<?php
	require_once("../includes/admin_footer.php");
?>