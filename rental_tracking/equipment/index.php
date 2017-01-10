<?php
	require_once("../includes/config.php");
	require_once("../includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	//require_once("../includes/security.php");
	require_once("../includes/index_header.php");
	require_once("../includes/top_nav.php");
	require_once("../lib/_lib_database.php");
	require_once("../lib/_lib_data_display.php");
	require_once($pear_db_path);
    
	//$table_name = "equipment";
	//$field_names = array("date_created", "equipment_name", "equipment_description", "ski_number", "equipment_id");
    //$field_values = array($_POST['date_created'], $_POST['equipment_name'], $_POST['equipment_description'], $_POST['ski_number'], $_POST['equipment_id']);
    $sql_string9 = "insert into equipment (date_created, equipment_name, equipment_description, ski_number, equipment_id) values ('" . $_POST['date_created'] . "', '" . $_POST['equipment_name'] . "', '" . $_POST['equipment_description'] . "', '" . $_POST['ski_number'] . "', '" . $_POST['equipment_id'] . "')";
    //print $sql_string9 . "<br>";
	if ($_POST["equipment_name"]) {
		//insert_form_data($table_name, $field_names);
        //insert_data($table_name, $field_names, $field_values);
        insert_data_generic_sql($sql_string9);
	}

?>

<h1>Equipment Rental Tracking</h1>

<p>This portion of the Ski Bradford Equipment Rental Tracking application is utilized to manage rented equipment. Please use the form below to create equipment records in the application.</p>
 
<?php if ($_POST["equipment_name"]) { print "<p>A new equipment entry has been successfully processed</p>"; } ?>

<p>Required fields are <span class="bold">bold</span>.</p>

<?php require("../lib/forms/equipment_form.php"); ?>


<?php
//do deletetion of there's a value in GET collection
	if ($_GET["rowID"]) {
		$table_name = "equipment";
		$id_field_name = "id";
		$id_field_type = "number";
		delete_row_data($table_name, $id_field_name, $_GET["rowID"], $id_field_type);
		print "<p>An equipment record has been deleted. The list below is of the remaining pieces of equipment.</p>";
        print "<p>The list below is of the current list of equipment.</p>";
        require("../lib/forms/equipment_list_form.php");
        
    } elseif ($_POST['equip_id']) {
        $table_name = "equipment";
        $field_names = array("id", "equipment_id", "equipment_name");
        $id_field = "equipment_id";
        //$id_value = $_GET['instructor_id'];
        $id_value = $_POST['equip_id'];
        $id_data_type = "number";
        //$res = view_data($table_name, $field_names);
        $res = view_data_where($table_name, $field_names, $id_field, $id_value, $id_data_type);
        if ($res->numRows() > 0) {
            display_equipment_data($res);
        } else {
            print "<p class=bold >There is no piece of equipment entered in the application with that barcode.</p>";
        }
        
    } else {
		print "<p>The list below is of the current list of equipment.</p>";
        require("../lib/forms/equipment_list_form.php");
	}
	

	
?>


<?php
	require_once("../includes/index_footer.php");
?>