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
/*    
	$table_name = "sections";
	$field_names = array("product_id", "level_id", "location_id", "instructor_id", "section_name", "section_date", "section_time", "max_seats", "section_id", "section_status", "seats_taken");
    $field_values = array($_POST['product_id'], $_POST['level_id'], $_POST['location_id'], $_POST['instructor_id'], $_POST['section_name'], convert_date_input($_POST['section_date']), $_POST['section_time'], $_POST['max_seats'], $_POST['section_id'], $_POST['section_status'], 0);
	if ($_POST["product_id"]) {
		//insert_form_data($table_name, $field_names);
        insert_data($table_name, $field_names, $field_values);
	}
 */
?>

<h1>Section Management</h1>

<p>This portion of the Ski Bradford Registration application is utilized to manage sections of customers.  Please use the form below to add individual sections to a date.  Please click <a href="">here</a> to create a daily schedule based upon an existing profile.</p>

<p>Required fields are <span class="bold">bold</span>.</p>

<?php
//do deletetion of there's a value in GET collection
/*
	if ($_GET["rowID"]) {
		$table_name = "sections";
		$id_field_name = "id";
		$id_field_type = "number";
		delete_row_data($table_name, $id_field_name, $_GET["rowID"], $id_field_type);
		print "<p>A section record has been deleted. The list below is of the remaining list of sections.</p>";
	} else {
		print "<p>The list below is of the current list of sections.</p>";
	}
*/    
 ?>
 <div align="center"><?php require("../../lib/forms/sections_profiles_form.php"); ?></div>
 <?php
     if ($_POST['section_list_date']) {
        $sql_string2 = "select product_id, location_id, instructor_id, section_name, section_time_id, max_seats, section_id, section_status, level_id, section_age_id from profile_sections where profile_id=" . $_POST['profile_id'];
        //print $sql_string2;
        $res = view_data_generic_sql($sql_string2);
        //print $res->numRows() . " is the number<br>";
        if ($res->numRows() > 0) {
		  enter_profile_section_data($res);
	   } else {
		print "<p class=bold >There are no sections entered in the application at this time.</p>";
	   }
     }
 
 //list the sections for that date
    if ($_POST['section_list_date']) {
        ///$sql_string = "select sections.id, sections.section_name, sections.section_date, sections.section_time, levels.level_name, sections.section_status from sections, levels where sections.level_id=levels.id and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "' and sections.section_time='" . $_POST['section_list_time'] . "'";
        //print $sql_string . "<br>";
    //} else {
        $sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status from sections, levels, section_times where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "' order by section_times.time_order, sections.section_name, levels.level_name";
        //print $sql_string . "<br>";
    
        $res = view_data_generic_sql($sql_string);
	   //print $res->numRows() . " is the number<br>";
	   if ($res->numRows() > 0) {
            display_section_data($res);
	   } else {
            print "<p class=bold >There are no sections entered in the application at this time.</p>";
	   }
    }
?>


<?php
	require_once("../../includes/admin_footer.php");
?>