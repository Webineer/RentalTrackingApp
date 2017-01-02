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

<p>This portion of the Ski Bradford Registration application is utilized to manage instructors.  Please use the form below to create user accounts in the application.</p>

<p>Required fields are <span class="bold">bold</span>.</p>

<?php require("../../lib/forms/sections_instructors_list_form.php"); ?>


<?php
    if ($_POST['section_list_date'] && $_POST['section_list_time'] && $_POST['section_list_product_id']) {
        
        $sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status from sections, levels, section_times where sections.level_id=levels.id and sections.section_time_id=section_times.id";
        
        if ($_POST['section_list_date']) {
             $sql_string .= " and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "'";   
        } else {
            $sql_string .= " and sections.section_date='" . date('Y-m-d') . "'";
        }
        
        if($_POST['section_list_time'] != "all") {
            //$sql_string = "select sections.id, sections.section_name, sections.section_date, sections.section_time, levels.level_name, sections.section_status from sections, levels where sections.level_id=levels.id and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "'";
            //$sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status from sections, levels, section_times where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "' order by section_times.time_order, sections.section_name, levels.level_name";
        //} else {
            //$sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status from sections, levels, section_times where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "' and sections.section_time='" . $_POST['section_list_time'] . "'";
            $sql_string .= " and sections.section_time_id=" . $_POST['section_list_time'];
        }
        
        if ($_POST['section_list_product_id'] != "all") {
            $sql_string .= " and sections.product_id=" . $_POST['section_list_product_id'];
        }
        
        $sql_string .= " order by section_times.time_order, sections.section_name, levels.level_name";
        //print $sql_string . "<br>";
    } else {
        //$sql_string = "select sections.id, sections.section_name, sections.section_date, sections.section_time, levels.level_name, sections.section_status from sections, levels where sections.level_id=levels.id and sections.section_date='" . date('Y-m-d') . "'";
        $sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status from sections, levels, section_times where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.section_date='" . date('Y-m-d') . "' order by section_times.time_order, sections.section_name, levels.level_name";
        //print $sql_string . "<br>";
    }
    
    
    //print $sql_string . "<br>";
    $res = view_data_generic_sql($sql_string);
	//print $res->numRows() . " is the number<br>";
	if ($res->numRows() > 0) {
		display_instructors_section_data($res);
	} else {
		print "<p class=bold >There are no sections entered in the application at this time.</p>";
	}
?>


<?php
	require_once("../../includes/admin_footer.php");
?>