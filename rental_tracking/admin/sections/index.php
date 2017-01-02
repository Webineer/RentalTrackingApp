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
    
	$table_name = "helper_sections";
	$field_names = array("section_name", "section_id", "pay_percent");
    $field_values = array($_POST['section_name'], $_POST['section_id'], $_POST['pay_percent']);
	if ($_POST["section_name"]) {
		//insert_form_data($table_name, $field_names);
        insert_data($table_name, $field_names, $field_values);
	}
?>

<h1>Section Management</h1>

<p>This portion of the Ski Bradford Registration application is utilized to manage sections of customers.  Please use the form below to add individual sections to a date.  Please click <a href="profiles.php">here</a> to create a daily schedule based upon an existing profile.</p>

<p>Required fields are <span class="bold">bold</span>.</p>

<table cellpadding="0" cellspacing="0" border="0" width="80%">
<tr>
    <td><?php require("../../lib/forms/helper_sections_form.php"); ?></td>
    <!-- td valign="top"><a href="" onclick="Javascript:window.open('monitor.php','Monitor','left=200,top=200,width=600,height=600,resizable=0');"><img src="/reservation/images/monitor_btn.jpg" alt="Monitor Button" width="400" height="200"></a></td -->
</tr>
</table>

<?php
//do deletetion of there's a value in GET collection
	if ($_GET["rowID"]) {
		$table_name = "helper_sections";
		$id_field_name = "id";
		$id_field_type = "number";
		delete_row_data($table_name, $id_field_name, $_GET["rowID"], $id_field_type);
		print "<p>A helper section record has been deleted. The list below is of the remaining list of helper sections.</p>";
	} else {
		print "<p>The list below is of the current list of helper sections.</p>"; 
	}
        $sql_string2 = "select id, section_name, pay_percent, section_id from helper_sections";
        $res = view_data_generic_sql($sql_string2);
	   //print $res->numRows() . " is the number<br>";
	   if ($res->numRows() > 0) {
		  display_helper_section_data($res);
	   } else {
		  print "<p class=bold >There are no helper sections entered in the application at this time.</p>";
	   }
    
 ?>
 <p>&nbsp;</p>
 <hr width="80%"/>
 <p>&nbsp;</p>
 <div align="center"><?php require("../../lib/forms/sections_list_form.php"); ?></div>
 <?php
	//$table_names = "users, security";
	//$field_names = array("users.id", "users.username", "security.level_name");
	//$join_field_1 = "users.security_id";
	//$join_field_2 = "security.id";
	//$table_name = "sections";
	//$field_names = array("id", "section_name", "section_time", "max_seats", "section_status");
	//$res = view_data($table_name, $field_names);
	//$res = view_data_join($table_names, $field_names, $join_field_1, $join_field_2);
    //$sql_string = "select sections.id, sections.section_name, sections.section_date, sections.section_time, levels.level_name, sections.section_status from sections, levels where sections.level_id=levels.id";
    
    if ($_POST['section_list_date'] && $_POST['section_list_time']) {
        if($_POST['section_list_time'] == "all") {
            //$sql_string = "select sections.id, sections.section_name, sections.section_date, sections.section_time, levels.level_name, sections.section_status from sections, levels where sections.level_id=levels.id and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "'";
            $sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status from sections, levels, section_times where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "' order by section_times.time_order, sections.section_name, levels.level_name";
        } else {
            //$sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status from sections, levels, section_times where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "' and sections.section_time='" . $_POST['section_list_time'] . "'";
            $sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status from sections, levels, section_times where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "' and sections.section_time_id=" . $_POST['section_list_time'] . " order by sections.section_name, levels.level_name";
        }
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
		display_section_data($res);
	} else {
		print "<p class=bold >There are no sections entered in the application for today.</p>";
	}
?>


<?php
	require_once("../../includes/admin_footer.php");
?>