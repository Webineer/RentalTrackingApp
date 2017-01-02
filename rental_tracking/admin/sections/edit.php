<?php
	require_once("../../includes/config.php");
	require_once("../includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	$table_name = "sections";
		
	//require_once("../includes/security.php");
	require_once("../../includes/admin_header.php");
	require_once("../../includes/admin_top_nav.php");
	require_once("../../lib/_lib_database.php");
	require_once("../../lib/_lib_data_display.php");
	require_once($pear_db_path);
?>

<h1>Section Management</h1>


<?php
//do deletetion of there's a value in GET collection
	if ($_POST["product_id"]) {
		$field_names = array("product_id", "level_id", "location_id", "instructor_id", "section_name", "section_date", "section_time_id", "max_seats", "section_id", "section_status", "section_age_id");
		$field_values = array($_POST['product_id'], $_POST['level_id'], $_POST['location_id'], $_POST['instructor_id'], $_POST['section_name'], convert_date_input($_POST['section_date']), $_POST['section_time'], $_POST['max_seats'], $_POST['section_id'], $_POST['section_status'], $_POST['section_age_id']);
        $id_field_name = "id";
		//update_form_data($table_name, $field_names, $id_field_name, $_POST["id"]);
        update_data($table_name, $field_names, $field_values, $id_field_name, $_POST["id"]); 
		print "<p>This record has been updated. Please use the form below to re-edit this section record.  Required fields are <span class=\"bold\">bold</span>.</p>";
	} else {
		print "<p>Please use the form below to edit section information.  Required fields are <span class=\"bold\">bold</span>.</p>";
	}
	
	$field_names = array("id", "product_id", "level_id", "location_id", "instructor_id", "section_name", "section_date", "section_time_id", "max_seats", "section_id", "section_status", "section_age_id");
	$id_field_name = "id";
	$id_field_type = "number";
	if ($_GET["rowID"]) {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_GET["rowID"], $id_field_type);
	} else {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_POST["id"], $id_field_type);
	}
	require("../../lib/forms/update_sections_form.php");
?>


<?php
	require_once("../../includes/admin_footer.php");
?>