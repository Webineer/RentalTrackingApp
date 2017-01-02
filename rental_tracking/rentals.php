<?php
	require_once("includes/config.php");
	require_once("includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
		
	//require_once("../includes/security.php");
	require_once("includes/index_header.php");
	require_once("includes/top_nav.php");
	require_once("lib/_lib_database.php");
	require_once("lib/_lib_data_display.php");
	require_once($pear_db_path);
?>

<h1>Ski Bradford Rental Tracking</h1>

<h2>Equipment Rental Tracking Administration</h2>


<?php
//enter equipment id into transactions table
	if ($_POST["equipment_id"]) {
	   //get the equipment id and confirm that the equipment is in the database
        $table_name = "equipment";
        $data_fields = array("id", "equipment_name");
        $id_field = "equipment_id";	
        $id_value = $_POST['equipment_id'];	
        $id_data_type = "char";
        //$equipment_id = get_one_data($table_name, $data_field, $id_field, $id_value, $id_data_type);
        list($equipment_id, $equipment_name) = get_one_row_data_array($table_name, $data_fields, $id_field, $id_value, $id_data_type);
        //print $equipment_id . " and " . $equipment_name . "<br>";
        
        //if there is an id, then enter in the transactions table; if not, post error message
        //if (is_null($equipment_id) || is_empty($equipment_id)) {
        if (is_null($equipment_id)) {
            print "<p class=\"warning_red\">Transaction cancelled.  This piece of equipment not registered.</p>";            
        } else {
            //Ready to enter into the transactions table
            $table_name = "transactions";
            $field_names = array("equipment1_id", "transaction_type", "transaction_date");
            $field_values = array($equipment_id, "out", date('Y-m-d'));
            //print "the equip id is " . $equipment_id . " and the date is " . date('Y-m-d') . "<br>";
            insert_data($table_name, $field_names, $field_values); 
            print "<p class=\"warning\">" . $equipment_name . " (Equipment Id #" . $_POST['equipment_id'] . ") Rented!</p>";
	   }
    } else {
		print "<p>Please use the form below to register a rental of equipment.  Required fields are <span class=\"bold\">bold</span>.</p>";
	}
	
	//$field_names = array("id", "product_id", "level_id", "location_id", "instructor_id", "section_name", "section_date", "section_time_id", "max_seats", "section_id", "section_status", "section_age_id");
	//$id_field_name = "id";
	////$id_field_type = "number";
	//if ($_GET["rowID"]) {
	//	$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_GET["rowID"], $id_field_type);
	//} else {
	//	$row = get_one_row_data_array($table_name, $field_names,$id_field_name, $_POST["id"], $id_field_type);
	//}
	require("lib/forms/rental_form.php");
?>
</div>

<?php
	require_once("includes/index_footer.php");
?>