<?php
	require_once("../../includes/config.php");
	require_once("../includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	$table_name = "users";
	$field_names = array("username", "password", "security_id");
	$field_types = array("char", "char", "number");
		
	//require_once("../includes/security.php");
	require_once("../../includes/admin_header.php");
	require_once("../../includes/admin_top_nav.php");
	require_once("../../lib/_lib_database.php");
	require_once("../../lib/_lib_data_display.php");
	require_once($pear_db_path);
?>

<h1>User Management</h1>


<?php
//do deletetion of there's a value in GET collection
	if ($_POST["username"]) {
		$field_names = array("username", "password", "security_id");
		$id_field_name = "id";
		update_form_data($table_name, $field_names, $id_field_name, $_POST["id"]);
		print "<p>This record has been updated. Please use the form below to re-edit this user record.  Required fields are <span class=\"bold\">bold</span>.</p>";
	} else {
		print "<p>Please use the form below to edit account information.  Required fields are <span class=\"bold\">bold</span>.</p>";
	}
	
	$field_names = array("id", "username", "password", "security_id");
	$id_field_name = "id";
	$id_field_type = "number";
	if ($_GET["rowID"]) {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_GET["rowID"], $id_field_type);
	} else {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_POST["id"], $id_field_type);
	}
	require("../../lib/forms/update_users_form.php");
?>


<?php
	require_once("../../includes/admin_footer.php");
?>