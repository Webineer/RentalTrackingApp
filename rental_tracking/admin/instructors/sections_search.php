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
    
    //Get name of instructor
    /*
    if ($_GET['rowID']) {
        $sql_string8 = "select firstname, lastname from instructors where id=" . $_GET['rowID'];
    } else {
        $sql_string8 = "select firstname, lastname from instructors where id=" . $_POST['instructor_id'];
    }
    //print $sql_string8 . "<br>";
    $instructor_info = get_one_row_data_array_generic_sql($sql_string8);
    list($first_name, $last_name) = $instructor_info;
    */
?>

<h1>Instructor Management</h1>
<p>Please use the form below to find sections by barcode/section id.</p>

<?php
    //print "<h2>Assignment for " . $first_name . " " . $last_name . ":</h2>";
    require("../../lib/forms/section_barcode_search_form.php");
    
//do deletetion of there's a value in GET collection
	if ($_GET["rowID"]) {
	   if ($_GET['type'] == "lesson") {
	       $table_name = "sections";
	   } else {
	       $table_name = "program_barcodes";
	   }
		$id_field_name = "id";
		$id_field_type = "number";
		delete_row_data($table_name, $id_field_name, $_GET["rowID"], $id_field_type);
		print "<p>A section record has been deleted.</p>";
	} 
    
	if ($_POST["section_id"]) {
	   
       If ($_POST["section_type"] == "lesson") {
            //check the instructor_barcode field to see if it is already filled
            $sql_string7 = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, locations.location_name, instructors.firstname, instructors.lastname from sections, levels, locations, section_times, instructors";
            $sql_string7 .= " where sections.level_id=levels.id and sections.location_id=locations.id and sections.section_time_id=section_times.id and sections.instructor_id=instructors.id";
            $sql_string7 .= " and sections.section_date = '" . convert_date_input($_POST['section_date']) . "' and sections.section_id=" . $_POST['section_id'];
            //print $sql_string7 . "<br>";

	        $res = view_data_generic_sql($sql_string7);
	        //$res = view_data_join($table_names, $field_names, $join_field_1, $join_field_2);
	        //print $res->numRows() . " is the number<br>";
	        if ($res->numRows() > 0) {
		      display_instructor_assignments_lessons_data($res);
            } else {
		      print "<p class=bold >There are no assignments entered in the application for this date and barcode.</p>";
            }
	
        
       } else {
            $sql_string7 = "select program_barcodes.id, program_barcodes.program_barcode, program_barcodes.program_date, instructors.firstname, instructors.lastname from program_barcodes, instructors where program_barcodes.instructor_id=instructors.id and program_barcodes.program_date = '" . convert_date_input($_POST['section_date']) . "' and program_barcodes.program_barcode = '" . $_POST['section_id'] . "'";
            //print $sql_string7 . "<br>";
            $res = view_data_generic_sql($sql_string7);
	        //$res = view_data_join($table_names, $field_names, $join_field_1, $join_field_2);
	        //print $res->numRows() . " is the number<br>";
	        if ($res->numRows() > 0) {
		      display_instructor_assignments_programs_data($res);
            } else {
		      print "<p class=bold >There are no assignments entered in the application for this date and barcode.</p>";
            }
       }
       
       
       
    } else {  
        //print "<p class=bold >There are no sections entered in the application for this instructor and barcode.</p>";
    }
	
?>


<?php
	require_once("../../includes/admin_footer.php");
?>