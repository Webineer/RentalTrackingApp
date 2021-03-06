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
 
 <?php
        $sql_string = "select id from sections where id > 117635";
        //print $sql_string . "<br>";
    
        $res = view_data_generic_sql($sql_string);
	   //print $res->numRows() . " is the number<br>";
	   if ($res->numRows() > 0) {
           $index = time();
	       while ($row = $res->fetchRow()) {    
                $table_name = "sections";
                //$field_names = array("product_id", "level_id", "location_id", "instructor_id", "section_name", "section_date", "section_time", "max_seats", "section_id", "section_status", "seats_taken");
                $field_names = array("section_id");
                //$field_values = array($row[0], $row[8], $row[1], $row[2], $row[3], convert_date_input($_POST['section_list_date']), $row[4], $row[5], $row[6], $row[7], 0, $row[9]);
                $field_values = array($index);
                $id_field_name = "id";
                $id_field_value = $row[0];
                update_data($table_name, $field_names, $field_values, $id_field_name, $id_field_value);
                print "section id for row number " . $row[0] . " updated to be " . $index . "<br>";
                $index++;
	       }
           //print "section id for row number " . $row[0] . " updated to be " . $index . "<br>";
	   } else {
            print "<p class=bold >There are no section ids changed.</p>";
	   }
?>


<?php
	require_once("../../includes/admin_footer.php");
?>