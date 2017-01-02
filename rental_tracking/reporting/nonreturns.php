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
?>

<h1>Equipment Rental Tracking</h1>

<h2>Reporting</h2>

<?php
    //current date
    //$the_date = date('Y-m-d');
    //$the_date = "2016-12-30";
    //history of piece of equipment for the day
    $sql_string = "select equipment.equipment_name, transactions.equipment1_id, transactions.transaction_type from transactions, equipment where transactions.equipment1_id=equipment.id and transactions.equipment1_id in (select distinct equipment1_id from transactions where transaction_date = '" . $_POST['the_date'] . "') ORDER BY transactions.equipment1_id, transactions.id";
    
    //get the set of equipment rented for the day
    $sql_string2 = "select distinct equipment1_id from transactions where transaction_date = '" . $_POST['the_date'] . "'";
    
    //put into an array
    //$id_array = get_row_data_2_array_generic_sql($sql_string2);
    $res2 = view_data_generic_sql($sql_string2);
    $id_array = generate_array($res2);
    //display_array($id_array);
    
    //get the max id for each array element
    $j = 0;
    foreach ($id_array as $the_value) {
        $sql_string3 = "select max(id) from transactions where equipment1_id = " . $the_value;
        $max_id_array[$j] = get_one_data_generic_sql($sql_string3); 
        $j = $j + 1;       
    }
    //print "<br>";
    //display_array($max_id_array);
    
    //get the transaction type for each max id record
    $k = 0;
    foreach ($max_id_array as $the_value2) {
        $sql_string4 = "select transaction_type from transactions where id = " . $the_value2;
        $max_id_value_array[$k] = get_one_data_generic_sql($sql_string4);
        $k = $k + 1;
    }
    ////print "<br>";
    //display_array($max_id_value_array);
    //print "<br>";
    
    //count how many values are OUT
    $l = 0;
    foreach($max_id_value_array as $the_value3) {
        //print $the_value3 . "<br>";
        if ($the_value3 == "out") {
            $l = $l + 1;
        } 
    }
    print "<h2>The total number of pieces of equipment out is: " . $l . "</h2>";
    
    print "<p>Please see the equipment rental summary below:</p>";
    $res = view_data_generic_sql($sql_string);
    display_equipment_history($res);
    
?>


<?php
	require_once("../includes/index_footer.php");
?>