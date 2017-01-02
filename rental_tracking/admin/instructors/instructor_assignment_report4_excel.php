<?php
	require_once("../../includes/config.php");
	//require_once("../includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	//require_once("../includes/security.php");
	//require_once("../../includes/admin_header.php");
	//require_once("../../includes/admin_top_nav.php");
	require_once("../../lib/_lib_database.php");
	require_once("../../lib/_lib_data_display.php");
	require_once($pear_db_path);
    $filename = "ExcelReport.xls";
    header('Content-type: application/ms-excel');
    header('Content-Disposition: attachment; filename=' . $filename);
 
    if ($_POST['section_begin_date'] && $_POST['section_end_date']) {
        if($_POST['instructor_id'] == "all") {
            //get the instructor ids
            $sql_string5 = "select id from instructors ORDER BY lastname";
            $res1 = view_data_generic_sql($sql_string5);
            if ($res1->numRows() > 0) {
                $instructor_id_array = generate_array($res1);
                //display_array($instructor_id_array);
            }
            //$sql_string = "select sections.id, sections.section_name, sections.section_date, sections.section_time, levels.level_name, sections.section_status from sections, levels where sections.level_id=levels.id and sections.section_date='" . convert_date_input($_POST['section_list_date']) . "'";
            //$sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status, sections.section_id, instructors.firstname, instructors.lastname from sections, levels, section_times, instructors where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.instructor_id=instructors.id and sections.section_date > '" . convert_date_input($_POST['section_begin_date']) . "' and sections.section_date < '" . convert_date_input($_POST['section_end_date']) . "' order by instructors.lastname, sections.section_date, section_times.time_order, sections.section_name, levels.level_name";

        //} else {
            print "<div align=center><table width=80% cellpadding=5 cellspacing=0 border=1>";
            //do date addition
            $the_begin_date = convert_date_input($_POST['section_begin_date']);
            $the_end_date = convert_date_input($_POST['section_end_date']);
            $the_print_date = $the_begin_date;
            //generate the date headers for table
            print "<tr><th><span class=no_indent>Emp Number</span></th><th><span class=no_indent>Lastname</span></th><th><span class=no_indent>Firstname</span></th>";
            while($the_print_date <= $the_end_date) {
                print "<th><span class=no_indent>" . convert_date_display($the_print_date) . "</span></th>";
                $the_new_date2 = strtotime('+1 day', strtotime($the_print_date));
                $the_print_date = date('Y-m-d', $the_new_date2);
                //print $the_current_date . "<br>";
            }
            print "<th><span class=no_indent>Total</span></th>";
            print "</tr>";
            
            for ($i = 0; $i < count($instructor_id_array); $i++) {
                //get instructor name and employee number
                $sql_string3 = "select instructor_barcode, lastname, firstname from instructors where id=" . $instructor_id_array[$i];
                //print $sql_string3 . "<br>";
                $instructor_info = get_one_row_data_array_generic_sql($sql_string3);
                list($barcode, $lastname, $firstname) = $instructor_info;
                //print "the product id is " . $product_id . "<br>";
                /*
                //do date addition
                $the_begin_date = convert_date_input($_POST['section_begin_date']);
                $the_end_date = convert_date_input($_POST['section_end_date']);
                $the_print_date = $the_begin_date;
                //generate the date headers for table
                print "<tr><th><span class=no_indent>Emp Number</span></th><th><span class=no_indent>Lastname</span></th><th><span class=no_indent>Firstname</span></th>";
                while($the_print_date <= $the_end_date) {
                    print "<th><span class=no_indent>" . convert_date_display($the_print_date) . "</span></th>";
                    $the_new_date2 = strtotime('+1 day', strtotime($the_print_date));
                    $the_print_date = date('Y-m-d', $the_new_date2);
                    //print $the_current_date . "<br>";
                }
                print "<th><span class=no_indent>Total</span></th>";
                print "</tr>";
                */
                
                $the_current_date = $the_begin_date;
                print "<tr><td><span class=no_indent>" . $barcode . "</span></td><td><span class=no_indent>" . $lastname . "</span></td><td><span class=no_indent>" . $firstname . "</span></td>";
                $the_total = 0;
                while ($the_current_date <= $the_end_date) {
                    $sql_string = "select count(id) from sections where section_date='" . $the_current_date . "' and instructor_id=" . $instructor_id_array[$i];
                    //print $sql_string . "<br>";
                    $res = view_data_generic_sql($sql_string);
                    //print $res->numRows() . " is the number<br>";
	               if ($res->numRows() > 0) {         
                        display_instructors_daily_data($res);
	               } else {
		              print "<td>0</td>";
	               }
                   $the_new_date = strtotime('+1 day', strtotime($the_current_date));
                   $the_current_date = date('Y-m-d', $the_new_date);
                   //print $the_current_date . "<br>";
                }
                //get the total for the date period
                $sql_string2 = "select count(id) from sections where section_date >= '" . $the_begin_date . "' and section_date <= '" . $the_end_date . "' and instructor_id=" . $instructor_id_array[$i];
                //print $sql_string2 . "<br>";
                //print $res->numRows() . " is the number<br>";
                $res2 = view_data_generic_sql($sql_string2);
                if ($res2->numRows() > 0) {         
                    display_instructors_daily_data($res2);
                } else {
                    print "<td>0</td>";
                }
                //print "<td><span class=no_indent>" . $the_total . "</span></td>";
                print "</tr>";
            }
            print "</table></div>";
        } else {

        }
        //print $sql_string . "<br>";
    } else {
        //$sql_string = "select sections.id, sections.section_name, sections.section_date, sections.section_time, levels.level_name, sections.section_status from sections, levels where sections.level_id=levels.id and sections.section_date='" . date('Y-m-d') . "'";
        //$sql_string = "select sections.id, sections.section_name, sections.section_date, section_times.time, levels.level_name, sections.section_status from sections, levels, section_times where sections.level_id=levels.id and sections.section_time_id=section_times.id and sections.section_date='" . date('Y-m-d') . "' order by section_times.time_order, sections.section_name, levels.level_name";
        //print $sql_string . "<br>";
        print "<p>No report available</p>";
    }
    
?>