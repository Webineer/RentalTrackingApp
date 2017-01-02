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
//get all products for the day
    $the_date = date('Y-m-d');
    $newdate = strtotime( '+1 day' , strtotime( $the_date ) ) ;
    $the_date = date('Y-m-j' , $newdate );
    //print $the_date . "<br>";
    //$the_date = "2011-10-16";
    print "<h2>Daily Unclaimed Reservation Report for " . convert_date_display($the_date) . "</h2>";
    
    $sql_string3 = "select distinct reservations.product_id, products.product_name, products.product_type, products.meeting_time from reservations, products where reservations.product_id=products.id and reservations.reservation_date = '" . $the_date . "' order by products.product_name, products.product_type";
    //print $sql_string3 . "<br>";
	$res2 = view_data_generic_sql($sql_string3);
    
    //get the load information for each product sold for the day
    if ($res2->numRows() > 0) {
	//Get the total number of reservations for this time period
        while ($row2 = $res2->fetchRow()) {
            $sql_string7 = "select count(reservations.id) from reservations, products where reservations.product_id=products.id and ";
            $sql_string7 = $sql_string7 . "products.product_name = '" . $row2[1] . "' and ";
            $sql_string7 = $sql_string7 . "products.product_type = '" . $row2[2] . "' and ";
            //check payment_confirm field = n which means that the reservation has not been claimed
            $sql_string7 = $sql_string7 . "reservations.payment_confirm = 'n' and ";
            $sql_string7 = $sql_string7 . "reservations.reservation_date = '" . $the_date . "'";
            //print $sql_string7 . "<br>";
  
            $load_count = get_one_row_data_array_generic_sql($sql_string7);
            list($load) = $load_count;
?>
        <div align="center" style="margin-bottom: 20px;">
        <table align="center" cellpadding="10" cellspacing="0" border="1">
        <tr>
            <td>
                <h2><?php print $row2[1]; ?></h2>
                <h2><?php print $row2[2]; ?></h2>
                <h2><?php print $row2[3]; ?></h2>
            </td>
            <td>
                <p style="font-size:34px; text-align: center;"><?php print $load; ?></p>
                <p>Unclaimed Reservations</p>
            </td>
        </tr>
        
        </table>
        </div>
<?php

            //Get list of the reservations that meet this search criteria     
            $sql_string = "select reservations.id, reservations.firstname, reservations.lastname, reservations.ability_level, products.product_name, products.product_type, products.meeting_time, reservations.reservation_date, reservations.age from reservations, products where reservations.product_id=products.id and ";
            $sql_string = $sql_string . "products.product_name = '" . $row2[1] . "' and ";
            $sql_string = $sql_string . "products.product_type = '" . $row2[2] . "' and ";
            $sql_string = $sql_string . "reservations.payment_confirm = 'n' and ";
            $sql_string = $sql_string . "reservations.reservation_date = '" . $the_date . "'";
            //print $sql_string . "<br>";
       
           $res = view_data_generic_sql($sql_string);
	       //print $res->numRows() . " is the number<br>";
	       if ($res->numRows() > 0) {
	       	  display_reservation_report($res);
	       } else {
	          print "<p class=bold >There are no reservations that match that search criterion in the application at this time.</p>";
	       }
        }
               
    } else {
        print "<p>No unclaimed reservations for today.</p>";
    }
?>


<?php
	require_once("../includes/admin_footer.php");
?>