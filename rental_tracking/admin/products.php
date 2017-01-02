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
	
		
	$table_name = "products";
	//$field_names = array("product_name", "product_description", "product_type", "meeting_time", "product_cost", "discount_cost", "rental_fee", "redemption_area", "max_seats", "account_number");
	$field_names = array("product_name", "product_description", "product_type_id", "product_cost", "rental_fee", "account_number", "on_application", "product_type");
	if ($_POST["product_name"]) {
		insert_form_data($table_name, $field_names);
	}
?>

<!-- a href="< ?php print APP_ROOT; ?>guide/ability.php" target="_blank"><img align="right" src="< ?php print APP_ROOT; ?>images/help_icon.jpg" border="0"></a -->

<h1>Product Management</h1>

<p>This portion of the <?php print ORGANIZATION; ?> Lesson Registration application is utilized to
manage lesson <?php print ABILITY_PLURAL; ?>.  Please use the form below to enter <?php print ABILITY_PLURAL; ?> into the application.</p>

<p>Required fields are <span class="bold">bold</span>.</p>

<?php
//do deletetion of there's a value in GET collection
	if ($_GET["rowID"]) {
	
	//Check to see if this product is being used in a reservation; if so, don't delete
		$table_name = "sections";
		$field_names = array("id", "product_id");
		$id_field = "product_id";
		$id_value = $_GET["rowID"];
		$id_data_type = "number";
		$res = view_data_where($table_name, $field_names, $id_field, $id_value, $id_data_type);
	//if not, then delete the record
		if ($res->numRows() <= 0) {
			$table_name = "products";	
			$id_field_name = "id";
			$id_field_type = "number";
			delete_row_data($table_name, $id_field_name, $_GET["rowID"], $id_field_type);
			print "<p>A product record has been deleted. The list below is of the remaining list of products.</p>";
		} else {
			print "<p>There are still sections associated with this product.  Please remove sections associated with this product before attempting to delete it.</p>";
		}	
	} else {
		print "<p>The list below is of the current list of products.</p>";
	}
	$table_name = "products";
	$field_names = array("id", "product_name", "product_description", "product_cost", "account_number");
	$res = view_data($table_name, $field_names);
	//print $res->numRows() . " is the number<br>";
	if ($res->numRows() > 0) {
		display_product_data($res);
	} else {
		print "<p class=bold >There are no products entered in the application at this time.</p>";
	}
?>

<?php require("../lib/forms/product_form.php"); ?>


<?php
	require_once("../includes/admin_footer.php");
?>