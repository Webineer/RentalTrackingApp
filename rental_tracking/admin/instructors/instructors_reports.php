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
        //print $_GET['rowID'] . "<br>";
    } else {
        $sql_string8 = "select firstname, lastname from instructors where id=" . $_POST['instructor_id'];
        //print $_POST['instructor_id'] . "<br>";
    }
    //print $sql_string8 . "<br>";
    $instructor_info = get_one_row_data_array_generic_sql($sql_string8);
    list($first_name, $last_name) = $instructor_info;
 */
 


?>

<h1>Instructor Management</h1>
<p>Reports</p>

<?php
    if ($_POST['begin_date']) {
        $my_date_array = 0;
        
        print $_POST['begin_date'] . " and " . $_POST['end_date'] . "<br>";
          
        $my_date_array = createDateRangeArray(convert_date_input($_POST['begin_date']), convert_date_input($_POST['end_date']));
        
        display_array($my_date_array);
    }
    
/*
    print "<h2>Assignment for " . $first_name . " " . $last_name . ":</h2>";
    
	if ($_POST["section_id"]) {
	   
       //For lessons that are already inputted into the application, check to see if the barcode exists, then update the record
       if ($_POST['section_type'] == "l") {
        
            //check the instructor_barcode field to see if it is already filled
            $sql_string7 = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, locations.location_name from sections, levels, locations, section_times";
            $sql_string7 .= " where sections.level_id=levels.id and sections.location_id=locations.id and sections.section_time_id=section_times.id";
            $sql_string7 .= " and sections.section_date='" . convert_date_input($_POST['section_date']) . "'";
            $sql_string7 .= " and sections.section_id=" . $_POST['section_id'];
            //print $sql_string7 . "<br>";
            $section_info = get_one_row_data_array_generic_sql($sql_string7);
            list($id, $section_name, $section_date, $section_time, $level_name, $location_name) = $section_info;
            //print $id . "<br>";
            //print $_POST['instructor_id'] . "<br>";
            
            //test to see if there's a lesson associated with the section _id
            if (isset($id)) {	      
                $table_name = "sections";
                $field_names = array("instructor_id");
                $field_values = array($_POST['instructor_id']);
                //$id_field_name = "section_id";
                $id_field_name = "id";
                $types = array("integer");
                //update_form_data($table_name, $field_names, $id_field_name, $_POST["id"]);
                //update_data($table_name, $field_names, $field_values, $id_field_name, $_POST["section_id"]); 
                update_data($table_name, $field_names, $field_values, $id_field_name, $id);
                print "<p>This record has been updated. Please use the form below to re-edit this section record.  Required fields are <span class=\"bold\">bold</span>.</p>";
            } else {
                print "<p>No section associated with this barcode.</p>";
            }        
        } else {
        //this is setup for program barcodes and their entry into the sections table
        
        //test to see if this program barcode has been used before
            $sql_string9 = "select id from program_barcodes where program_barcode = '" . $_POST['section_id'] . "'";
            $program_info = get_one_row_data_array_generic_sql($sql_string9);
            list($program_id) = $program_info;
            
            //if prgram_id exists, do not allow; print warning that this barcode is used
            if (isset($program_id)) {
                print "<p>An instructor has already been assigned to this program (barcode).</p>";
            } else {
            //enter into program_barcodes table to be added to the salary reports    
                $table_name = "program_barcodes";
                $field_names = array("program_barcode", "instructor_id", "program_date");
                $field_values = array($_POST['section_id'], $_POST['instructor_id'], convert_date_input($_POST['section_date']));
                insert_data($table_name, $field_names, $field_values);
                print "<p>A program (barcode) assignment to this instructor completed.</p>";    
            }
        }
        
	} else {
		print "<p>No section information provided.</p>";
	}
	
	$field_names = array("id", "product_id", "level_id", "location_id", "instructor_id", "section_name", "section_date", "section_time_id","max_seats", "section_id", "section_status", "instructor_barcode");
	$id_field_name = "id";
	$id_field_type = "number";
	if ($_GET["rowID"]) {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_GET["rowID"], $id_field_type);
	} else {
		$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_POST["id"], $id_field_type);
	}
*/
	require("../../lib/forms/instructors_reports_form.php");
?>


<?php
	require_once("../../includes/admin_footer.php");
?>