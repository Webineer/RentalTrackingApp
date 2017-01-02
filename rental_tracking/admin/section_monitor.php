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

<p>This portion of the <?php print ORGANIZATION; ?> Reservation application is utilized to manage product reservations.  Please use the form below to confirm reservations in the application.</p>

<!-- p>Required fields are <span class="bold">bold</span>.</p -->

<?php require("../lib/forms/sections_monitoring_form.php"); ?>

        <div align="center">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
             
                    <td>
						
						<?php

                                if ($_POST['time_choice']) {
                                    if ($_POST['prod_choice'] == "all") {
                                        $sql_string_temp = "select sections.section_name, levels.level_name, sections.product_id, sections.level_id, sections.section_time_id, sections.max_seats, sections.seats_taken from sections, levels";
                                        $sql_string_temp .= " where sections.level_id=levels.id and sections.section_date ='" . date('Y-m-d') . "' and sections.section_time_id =" . $_POST['time_choice'];
										//$sql_string_temp .= " where sections.level_id=levels.id and sections.section_date ='2013-01-02' and sections.section_time_id=" . $_POST['time_choice'];
                                        //$sql_string_temp .= " order by sections.section_name, levels.level_name";
                                        $sql_string_temp .= " order by sections.level_id, sections.section_age_id, sections.location_id, sections.section_name";
                                        //print $sql_string_temp . "<br>";
                                    } else {
                                        $sql_string_temp = "select sections.section_name, levels.level_name, sections.product_id, sections.level_id, sections.section_time_id, sections.max_seats, sections.seats_taken from sections, levels";
                                        $sql_string_temp .= " where sections.level_id=levels.id and sections.section_date ='" . date('Y-m-d') . "' and sections.product_id=" . $_POST['prod_choice'] . " and sections.section_time_id =" . $_POST['time_choice'];
										//$sql_string_temp .= " where sections.level_id=levels.id and sections.section_date ='2013-01-02' and sections.product_id=" . $_POST['prod_choice'] . " and sections.section_time_id=" . $_POST['time_choice'];
                                        //$sql_string_temp .= " order by sections.section_name, levels.level_name";
                                        $sql_string_temp .= " order by sections.level_id, sections.section_age_id, sections.location_id, sections.section_name";
                                        
                                        //print $sql_string_temp . "<br>";
                                    }
                                    
                                    $res_temp = view_data_generic_sql($sql_string_temp);
                                    if ($res_temp->numRows() > 0) {
                                        display_sections_monitor($res_temp);
                                    }

                                } 
                                
						 ?>
						
					</td>
                </tr>
            </table>
        </div>
        
        <script lang="Javascript" type="text/javascript">
            setTimeout(function() {document.registrarForm.submit();}, 60000);
        </script>

<?php
	require_once("../includes/admin_footer.php");
?>
