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

<p>This portion of the Ski Bradford Registrar application is utilized to generate a report illustrating the sections each instructor has attended over a particular time period.</p>

<p>Required fields are <span class="bold">bold</span>.</p>

<div align="center"><?php require("../../lib/forms/instructors_assignments_list_form.php"); ?></div>
 <?php
 
    if ($_POST['section_begin_date'] && $_POST['section_end_date']) {
        if($_POST['instructor_id'] == "all") {
            //$sql_string = "select sections.id, sections.section_name, sections.section_date, sections.section_time, levels.level_name, sections.section_status from sections, levels where sections.level_id=levels.id and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "'";
            $sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status, sections.section_id, instructors.firstname, instructors.lastname from sections, levels, section_times, instructors where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.instructor_id=instructors.id and sections.section_date > '" . convert_date_input($_POST['section_begin_date']) . "' and sections.section_date < '" . convert_date_input($_POST['section_end_date']) . "' order by instructors.lastname, sections.section_date, section_times.time_order, sections.section_name, levels.level_name";
        } else {
            //$sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status from sections, levels, section_times where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "' and sections.section_time='" . $_POST['section_list_time'] . "'";
            $sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status, sections.section_id, instructors.firstname, instructors.lastname from sections, levels, section_times, instructors where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.instructor_id=instructors.id and sections.section_date > '" . convert_date_input($_POST['section_begin_date']) . "' and sections.section_date < '" . convert_date_input($_POST['section_end_date']) . "' and sections.instructor_id=" . $_POST['instructor_id'] . " order by instructors.lastname, sections.section_date, section_times.time_order, sections.section_name, levels.level_name";
        }
        //print $sql_string . "<br>";
    } else {
        //$sql_string = "select sections.id, sections.section_name, sections.section_date, sections.section_time, levels.level_name, sections.section_status from sections, levels where sections.level_id=levels.id and sections.section_date='" . date('Y-m-d') . "'";
        //$sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status from sections, levels, section_times where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.section_date='" . date('Y-m-d') . "' order by section_times.time_order, sections.section_name, levels.level_name";
        //print $sql_string . "<br>";
        print "<p>No report available</p>";
    }
    //print $sql_string . "<br>";
    $res = view_data_generic_sql($sql_string);
	//print $res->numRows() . " is the number<br>";
	if ($res->numRows() > 0) {
		display_instructor_usage_data($res);
	} else {
		print "<p class=bold >There are no sections entered in the application at this time.</p>";
	}
?>


<?php
	require_once("../../includes/admin_footer.php");
?>