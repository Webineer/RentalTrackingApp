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
?>

<!-- a href="< ?php print APP_ROOT; ?>guide/ability.php" target="_blank"><img align="right" src="< ?php print APP_ROOT; ?>images/help_icon.jpg" border="0"></a -->

<h1>Registrar Management</h1>

<p>This portion of the <?php print ORGANIZATION; ?> Registrar application is utilized to manage product reservations.  Please use the form below to confirm reservations in the application. To view the section monitor, please click <a href="section_monitor.php">here</a>.</p>


        <div align="center">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
             
                    <td>
						<table cellspacing=10 cellpadding=0 border=0><tr><th>Type</th><th>Available Seats</th><th>Seats Taken</th></tr>
						<?php

                                if ($_POST['time_choice']) {
                                    //Private Ski Students
                                    //$sql_string_temp = "select sections.max_seats, sections.seats_taken from sections, product_types, products";
                                    //$sql_string_temp .= " where sections.product_id=products.id and products.product_type_id=product_types.id";
                                    //$sql_string_temp .= " and sections.section_date ='" . date('Y-m-d') . "' and product_types.type_name='Ski' and products.product_name like 'P%' and sections.section_time_id=" . $_POST['time_choice'];
                                    $sql_string_temp = "select max_seats, seats_taken from sections";
                                    $sql_string_temp .= " where section_date ='" . date('Y-m-d') . "'";
                                    $sql_string_temp .= " and (product_id=37 or product_id=96 or product_id=97 or product_id=112 or product_id=114)";
                                    $sql_string_temp .= " and section_time_id=" . $_POST['time_choice'];
                                    //print $sql_string_temp . "<br>";
                                    
                                    $res_temp = view_data_generic_sql($sql_string_temp);
                                    print "<tr>";
                                    if ($res_temp->numRows() > 0) {
                                        print "<td>Private Ski Students</td>";
                                        display_privates_monitor($res_temp);
                                    }
                                    print "</tr>";
                                    
                                    //Private Snowboard Students
                                    //$sql_string_temp = "select sections.max_seats, sections.seats_taken from sections, product_types, products";
                                    //$sql_string_temp .= " where sections.product_id=products.id and products.product_type_id=product_types.id";
                                    //$sql_string_temp .= " and sections.section_date ='" . date('Y-m-d') . "' and product_types.type_name='Snowboard' and products.product_name like 'P%' and sections.section_time_id=" . $_POST['time_choice'];
                                    $sql_string_temp = "select max_seats, seats_taken from sections";
                                    $sql_string_temp .= " where section_date ='" . date('Y-m-d') . "'";
                                    $sql_string_temp .= " and (product_id=113 or product_id=115 or product_id=117 or product_id=119 or product_id=121)";
                                    $sql_string_temp .= " and section_time_id=" . $_POST['time_choice'];
                                    //print $sql_string_temp . "<br>";
                                    
                                    $res_temp = view_data_generic_sql($sql_string_temp);
                                    print "<tr>";
                                    if ($res_temp->numRows() > 0) {
                                        print "<td>Private Snowboard Students</td>";
                                        display_privates_monitor($res_temp);
                                    }
                                    print "</tr>";
                                } 
                                
						 ?>
						</table>
					</td>
                </tr>
            </table>
        </div>
        
        <script lang="Javascript" type="text/javascript">
            //setTimeout(function() {document.registrarForm.submit();}, 60000);
        </script>

<?php
	require_once("../includes/admin_footer.php");
?>
