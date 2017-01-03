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
        $data_fields = array("id", "equipment_name", "ski_number");
        $id_field = "equipment_id";	
        $id_value = $_POST['equipment_id'];	
        $id_data_type = "char";
        //$equipment_id = get_one_data($table_name, $data_field, $id_field, $id_value, $id_data_type);
        list($equipment_id, $equipment_name, $equipment_number) = get_one_row_data_array($table_name, $data_fields, $id_field, $id_value, $id_data_type);
        //print $equipment_id . " and " . $equipment_name . "<br>";
        
        //if there is an id, then enter in the transactions table; if not, post error message
        //if (is_null($equipment_id) || is_empty($equipment_id)) {
        if (is_null($equipment_id)) {
            print "<p class=\"warning_red\">Transaction cancelled.  This piece of equipment not registered.</p>";            
        } else {
            //Ready to enter into the transactions table
            $table_name = "transactions";
            $field_names = array("equipment1_id", "transaction_type", "transaction_date", "transaction_time");
            $field_values = array($equipment_id, "out", date('Y-m-d'), date('g:h:s'));
            //print "the equip id is " . $equipment_id . " and the date is " . date('Y-m-d') . "<br>";
            insert_data($table_name, $field_names, $field_values); 
            //print "<p class=\"warning\">" . $equipment_name . " (Equipment Id #" . $_POST['equipment_id'] . ") Rented!</p>";
            //print "<p class=\"warning\">" . $equipment_name . " (Equipment #" . $equipment_number . ") Rented!</p>";
            print "<p class=\"warning\">OUT!</p>";
	   }
    } else {
		print "<p>Please enter a barcode for rental.</p>";
	}
	
	//require("lib/forms/rental_form.php");
?>
</div>

<script language="Javascript">setTimeout("location.assign('rentals.php')", 2000);</script>

<?php
	require_once("includes/index_footer.php");
?>