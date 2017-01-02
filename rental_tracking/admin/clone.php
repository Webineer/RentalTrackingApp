<?php
	require_once("../includes/config.php");
	require_once("includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	
	//require_once("../includes/security.php");
	require_once("../includes/admin_header.php");
	require_once("../includes/admin_top_nav.php");
	require_once("../lib/_lib_database.php");
	require_once("../lib/_lib_data_display.php");
	require_once($pear_db_path);
    
        
	$table_name = "sections";
	$field_names = array("product_id", "level_id", "location_id", "instructor_id", "section_name", "section_date", "section_time_id", "max_seats", "section_id", "section_status", "seats_taken", "section_age_id");
    $field_values = array($_POST['product_id'], $_POST['level_id'], $_POST['location_id'], $_POST['instructor_id'], $_POST['section_name'], convert_date_input($_POST['section_date']), $_POST['section_time_id'], $_POST['max_seats'], $_POST['section_id'], $_POST['section_status'], 0, $_POST['section_age_id']);
    //print "the product id is " . $_POST["product_id"] . "<br>";
	if ($_POST["product_id"]) {
		//insert_form_data($table_name, $field_names);
        insert_data($table_name, $field_names, $field_values);
	}
?>

<!-- a href="< ?php print APP_ROOT; ?>guide/ability.php" target="_blank"><img align="right" src="< ?php print APP_ROOT; ?>images/help_icon.jpg" border="0"></a -->

<h1>Registrar Management</h1>

<p>This portion of the <?php print ORGANIZATION; ?> Reservation application is utilized to manage product reservations.  Please use the form below to confirm reservations in the application.</p>

<!-- p>Required fields are <span class="bold">bold</span>.</p -->

<?php 
    if ($_POST["product_id"]) {
        print "<p>The cloned section has been added. Click <a href=\"section_monitor.php\">here</a> to return to the monitor.</p>";
    } else {
        require("../lib/forms/clone_sections_form.php");   
    } 
?>


<?php
	require_once("../includes/admin_footer.php");
?>