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
    
	$table_name = "instructors";
	$field_names = array("firstname", "lastname", "instructor_description", "instructor_barcode", "lesson_rate", "private_rate", "requested_private_rate", "status");
	if ($_POST["firstname"]) {
		insert_form_data($table_name, $field_names);
	}
    
    //print "instructor id is " . $_POST['instructor_id'] . "<br>";
    //print "combobox is " . $_POST['combobox'] . "<br>";
?>

<h1>Instructor Management</h1>

<p>This portion of the Ski Bradford Registration application is utilized to manage instructors.  Click <a href="instructors_reports.php">here</a> to generate assignment and payroll reports.  Click <a href="/instructors/admin/assignment/instructors_sections_list.php">here</a> to assign instructors to each section.  Please use the form below to create instructor records in the application.</p>
 

<p>Required fields are <span class="bold">bold</span>.</p>

<?php require("../../lib/forms/instructors_form.php"); ?>


<?php
//do deletetion of there's a value in GET collection
	if ($_GET["rowID"]) {
		$table_name = "instructors";
		$id_field_name = "id";
		$id_field_type = "number";
		delete_row_data($table_name, $id_field_name, $_GET["rowID"], $id_field_type);
		print "<p>A instructor record has been deleted. The list below is of the remaining list of instructors.</p>";
        
    } elseif ($_POST['instructor_id']) {
        $table_name = "instructors";
        $field_names = array("id", "lastname", "firstname");
        $id_field = "id";
        //$id_value = $_GET['instructor_id'];
        $id_value = $_POST['instructor_id'];
        $id_data_type = "number";
        //$res = view_data($table_name, $field_names);
        $res = view_data_where($table_name, $field_names, $id_field, $id_value, $id_data_type);
        if ($res->numRows() > 0) {
            display_instructor_data($res);
        } else {
            print "<p class=bold >There are no instructors entered in the application at this time.</p>";
        }
        
    } else {
		//print "<p>The list below is of the current list of instructors.</p>";
        require("../../lib/forms/instructors_list_form.php");
	}
	

	
?>


<?php
	require_once("../../includes/admin_footer.php");
?>