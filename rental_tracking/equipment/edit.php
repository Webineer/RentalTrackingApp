<?php
	require_once("../includes/config.php");
	require_once("../includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	
	//$field_names = array("firstname", "lastname", "instructor_description", "instructor_barcode", "lesson_rate", "private_rate", "requested_private_rate", "status");
	//$field_types = array("char", "char", "char", "char", "char");
		
	//require_once("../includes/security.php");
	require_once("../includes/index_header.php");
	require_once("../includes/top_nav.php");
	require_once("../lib/_lib_database.php");
	require_once("../lib/_lib_data_display.php");
	require_once($pear_db_path);
?>

<h1>Rental Equipment Tracking Management</h1>


<?php
//do deletetion of there's a value in GET collection
    $table_name = "equipment";
	if ($_POST["equipment_name"]) {
		//$field_names = array("date_modified", "equipment_name", "equipment_description", "ski_number", "equipment_id");
		//$id_field_name = "id";
		//update_form_data($table_name, $field_names, $id_field_name, $_POST["id"]);
        $sql_string3 = "update equipment set date_modified = '" . $_POST['date_modified'] . "', equipment_name = '" . $_POST['equipment_name'] . "', equipment_description = '" . $_POST['equipment_description'] . "', ski_number = '" . $_POST['ski_number'] . "', equipment_id = '" . $_POST['equipment_id'] . "' where id = " . $_POST['id'];
        print $sql_string3 . "<br>";
        update_data_generic_sql($sql_string3);
		print "<p>This record has been updated. Please use the form below to re-edit this user record.  Required fields are <span class=\"bold\">bold</span>.</p>";
	} else {
		print "<p>Please use the form below to edit account information.  Required fields are <span class=\"bold\">bold</span>.</p>";
	}
	
	$field_names = array("id", "equipment_name", "equipment_description", "ski_number", "equipment_id");
	$id_field_name = "id";
	$id_field_type = "number";
	if ($_GET["rowID"]) {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_GET["rowID"], $id_field_type);
	} else {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_POST["id"], $id_field_type);
	}
	require("../lib/forms/update_equipment_form.php");
?>


<?php
	require_once("../includes/index_footer.php");
?>