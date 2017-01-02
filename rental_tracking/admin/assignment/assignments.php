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
?>

<h1>Instructor Management</h1>


<?php
    $table_name = "sections";
	if ($_POST["instructor_barcode"]) {
        
        //Get the instructor id to put into the 
        $sql_string6 = "select id from instructors where instructor_barcode = '" . $_POST['instructor_barcode'] . "'";
        $temp_instructor_id = get_one_data_generic_sql($sql_string6);
        print $temp_instructor_id . "<br>";
        
	    $field_names = array("instructor_barcode", "instructor_id");
		$field_values = array($_POST['instructor_barcode'], $temp_instructor_id);
        $id_field_name = "id";
		//update_form_data($table_name, $field_names, $id_field_name, $_POST["id"]);
        update_data($table_name, $field_names, $field_values, $id_field_name, $_POST["id"]); 
		print "<p>This record has been updated. Please use the form below to re-edit this section record.  Required fields are <span class=\"bold\">bold</span>. Please use this <a href=\"sections_search.php\">form</a> to confirm the assignments.</p>";
	} else {
		print "<p>Please use the form below to edit section information.  Required fields are <span class=\"bold\">bold</span>. Please use this <a href=\"sections_search.php\">form</a> to confirm the assignments.</p>";
	}
	
	$field_names = array("id", "product_id", "level_id", "location_id", "instructor_id", "section_name", "section_date", "section_time_id","max_seats", "section_id", "section_status", "instructor_barcode");
	$id_field_name = "id";
	$id_field_type = "number";
	if ($_GET["rowID"]) {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_GET["rowID"], $id_field_type);
	} else {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_POST["id"], $id_field_type);
	}
	require("../../lib/forms/update_instructor_sections_form.php");
?>


<?php
	require_once("../../includes/admin_footer.php");
?>