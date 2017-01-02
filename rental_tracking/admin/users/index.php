<?php
	require_once("../../includes/config.php");
	require_once("../includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	//require_once("../includes/security.php");
	require_once("../../includes/admin_header.php");
	require_once("../../includes/admin_top_nav.php");
	require_once("../../lib/_lib_database.php");
	require_once("../../lib/_lib_data_display.php");
	require_once($pear_db_path);
    
	$table_name = "users";
	$field_names = array("username", "password");
	if ($_POST["username"]) {
		insert_form_data($table_name, $field_names);
	}
?>

<h1>User Management</h1>

<p>This portion of the Ski Bradford Registration application is utilized to manage users.  Please use the form below to create user accounts in the application.</p>

<p>Required fields are <span class="bold">bold</span>.</p>

<?php require("../../lib/forms/users_form.php"); ?>


<?php
//do deletetion of there's a value in GET collection
	if ($_GET["rowID"]) {
		$table_name = "users";
		$id_field_name = "id";
		$id_field_type = "number";
		delete_row_data($table_name, $id_field_name, $_GET["rowID"], $id_field_type);
		print "<p>A user record has been deleted. The list below is of the remaining list of users.</p>";
	} else {
		print "<p>The list below is of the current list of users.</p>";
	}
	
	//$table_names = "users, security";
	//$field_names = array("users.id", "users.username", "security.level_name");
	//$join_field_1 = "users.security_id";
	//$join_field_2 = "security.id";
	$table_name = "users";
	$field_names = array("id", "username", "security_id");
	$res = view_data($table_name, $field_names);
	//$res = view_data_join($table_names, $field_names, $join_field_1, $join_field_2);
	//print $res->numRows() . " is the number<br>";
	if ($res->numRows() > 0) {
		display_user_data($res);
	} else {
		print "<p class=bold >There are no users entered in the application at this time.</p>";
	}
?>


<?php
	require_once("../../includes/admin_footer.php");
?>