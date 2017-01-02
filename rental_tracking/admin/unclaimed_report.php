<?php
	require_once("../includes/config.php");
	require_once("includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	
	//require_once("../includes/security.php");
	require_once("../includes/agent_header.php");
	require_once("../includes/admin_top_nav.php");
	require_once("../lib/_lib_database.php");
	require_once("../lib/_lib_data_display.php");
	require_once($pear_db_path);
?>

<!-- a href="< ?php print APP_ROOT; ?>guide/ability.php" target="_blank"><img align="right" src="< ?php print APP_ROOT; ?>images/help_icon.jpg" border="0"></a -->

<h1>Reservation Reporting</h1>

<?php
//do list reservations that match the search criterion in the POST collection
	if ($_POST["unc_product_type"]) {
	//Get the total number of reservations for this time period
       $sql_string7 = "select count(reservations.id) from reservations, products where reservations.product_id=products.id and ";
       $sql_string7 = $sql_string7 . "products.product_name = '" . $_POST['unc_product_name'] . "' and ";
       $sql_string7 = $sql_string7 . "products.product_type = '" . $_POST['unc_product_type'] . "' and ";
       //check payment_confirm field = n which means that the reservation has not been claimed
       $sql_string7 = $sql_string7 . "reservations.payment_confirm = 'n' and ";
       $sql_string7 = $sql_string7 . "reservations.reservation_date <= '" . convert_date_input($_POST['unc_end_date']) . "' and reservations.reservation_date >= '" . convert_date_input($_POST['unc_begin_date']) . "'";
       //print $sql_string7 . "<br>";
  
        $load_count = get_one_row_data_array_generic_sql($sql_string7);
        list($load) = $load_count;
?>
        <div align="center">
        <table align="center" cellpadding="10" cellspacing="0" border="1">
        <tr>
            <td>
                <h2><?php print $_POST['unc_product_name']; ?></h2>
                <h2><?php print $_POST['unc_product_type']; ?></h2>
                <h2><?php print $_POST['unc_begin_date'] ?> - <?php print $_POST['unc_end_date']; ?></h2>
            </td>
            <td>
                <p style="font-size:34px; text-align: center;"><?php print $load; ?></p>
                <p>reservations</p>
            </td>
        </tr>
        
        </table>
        </div>
<?php
        
        //print "<h2>The total load for " . $_POST['product_name'] . " at/on " . $_POST['product_type'] . " from " . $_POST['begin_date'] . " to " . $_POST['end_date'] . ": " . $load . "</h2>";
        print "<p>&nbsp;</p><p>The following reservations meet this reporting criteria:</p>";
   //Get list of the reservations that meet this search criteria     
       $sql_string = "select reservations.id, reservations.firstname, reservations.lastname, reservations.ability_level, products.product_name, products.product_type, products.meeting_time, reservations.reservation_date, reservations.age from reservations, products where reservations.product_id=products.id and ";
       $sql_string = $sql_string . "products.product_name = '" . $_POST['unc_product_name'] . "' and ";
       $sql_string = $sql_string . "products.product_type = '" . $_POST['unc_product_type'] . "' and ";
       $sql_string = $sql_string . "reservations.payment_confirm = 'n' and ";
       $sql_string = $sql_string . "reservations.reservation_date <= '" . convert_date_input($_POST['unc_end_date']) . "' and reservations.reservation_date >= '" . convert_date_input($_POST['unc_begin_date']) . "'";
       //print $sql_string . "<br>";
       
       $res = view_data_generic_sql($sql_string);
	   //print $res->numRows() . " is the number<br>";
	   if ($res->numRows() > 0) {
		  display_reservation_report($res);
	   } else {
	       print "<p class=bold >There are no reservations that match that search criterion in the application at this time.</p>";
	   }
    }
?>


<?php
	require_once("../includes/admin_footer.php");
?>