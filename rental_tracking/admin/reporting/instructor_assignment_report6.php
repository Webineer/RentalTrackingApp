<?php
	require_once("../../includes/config.php");
	require_once("../includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	//require_once("../includes/security.php");
	require_once("../../includes/admin_header.php");
	require_once("../../includes/admin_top_nav.php");
	require_once("../../lib/_lib_database.php");
	require_once("../../lib/_lib_data_display.php");
	require_once($pear_db_path);
?>

<h1>Instructor Management</h1>

<h2>Instructor Payroll Report</h2>

<div align="center"><?php #require("../../lib/forms/instructors_assignments_list_form.php"); ?></div>
 <?php
    // let's print the international format for the en_US locale
    setlocale(LC_MONETARY, 'en_US');
    global $instructor_lesson_rate_hash_array, $instructor_private_rate_hash_array;
    //$instructor_barcode_hash_array = array(
    //"Jay Addision" => "0181", 
    //"David Alaimo" => "0001", 
    //"Laura Alartsky" => "1000"
    //);
    
    //$instructor_id_hash_array = array(
    //"Jay Addision" => "168", 
    //"David Alaimo" => "6", 
    //"Laura Alartsky" => "237"
    //);
    
    //create instructor hash, lesson rate hash, private rate hash, private requested rate hash array
    $sql_string4 = "select id, firstname, lastname, lesson_rate, private_rate, requested_private_rate, instructor_barcode from instructors where status = 'y' order by lastname";
    $res4 = view_data_generic_sql($sql_string4);
    while ($row4 = $res4->fetchRow()) {
        $temp1 = $row4[1] . " " . $row4[2] . " (" . $row4[6] . ")";
        $instructor_id_hash_array[$temp1] = $row4[0];
        $instructor_lesson_rate_hash_array[$temp1] = $row4[3];
        $instructor_private_rate_hash_array[$temp1] = $row4[4];
        $instructor_private_request_rate_hash_array[$temp1] = $row4[5];
    }
 
    //get helper percentage for helper hours using the helper section barcode as the hash key
    $sql_string8 = "select section_id, pay_percent from helper_sections";
    $res8 = view_data_generic_sql($sql_string8);
    while ($row8 = $res8->fetchRow()) {
        $helper_id_hash_array[$row8[0]] = $row8[1];
    }
    
    
    if ($_POST['begin_date']) {
        print "<p>This report includes the time period from " . $_POST['begin_date'] . " to " . $_POST['end_date'] . "</p>";
        $the_date_array = createDateRangeArray(convert_date_input($_POST['begin_date']), convert_date_input($_POST['end_date']));
        //display_array($my_date_array);
    } else {
        $the_date_array = array("2014-09-21", "2014-09-22", "2014-09-23", "2014-09-24", "2014-09-25", "2014-09-26", "2014-09-27");
    }
    
    //Cost totals
    $grand_total = 0;
    $grand_lesson_total = 0;
    $grand_private_total = 0;
    $grand_program_total = 0;
    $grand_lesson_program_total = 0;
    $grand_helper_total = 0;
    
    //Number totals
    $grand_num_total = 0;
    $grand_num_lesson_total = 0;
    $grand_num_private_total = 0;
    $grand_num_program_total = 0;
    $grand_num_lesson_program_total = 0;
    $grand_num_helper_total = 0;
    
    //print header of table
    print "<table cellspacing=0 cellpadding=2 border=1><th>Employee</th>";
    //print "<tr><th><span class=no_indent>Emp Number</span></th><th></th><th><span class=no_indent>Firstname</span></th>";
    //for ($i=0; $i<=6; $i++) {
    //    print "<th>" . convert_date_display($the_date_array[$i]) . "</th>";
        //print "<th>" . $instructor_id_hash_array[i] . "</th>";
    //}
   //print "<th>Total</th></tr>";
   print "<th>L</th><th>P</th><th>PR</th><th>H</th><th>Total</th></tr>";
    
    //get classes for each employee
    foreach($instructor_id_hash_array as $key => $value1) {
        //reset print buffer
        $temp_write_buffer = "";
        
        //print "<tr><td>" . $value1 . "</td>";
        //print "<tr><td>" . $key . "</td>";
        $temp_write_buffer = "<tr><td>" . $key . "</td>";
        
        //week total for each employee
        $employee_week_total = 0;
        $employee_lesson_week_total = 0;
        $employee_private_week_total = 0;
        $employee_private_request_week_total = 0;
        $employee_program_week_total = 0;
        $employee_lesson_program_week_total = 0;
        $employee_helper_week_total = 0;
        
        //week total number of lessons for each employee
        $employee_num_week_total = 0;
        $employee_num_lesson_week_total = 0;
        $employee_num_private_week_total = 0;
        $employee_num_private_request_week_total = 0;
        $employee_num_program_week_total = 0;
        $employee_num_lesson_program_week_total = 0;
        $employee_num_helper_week_total = 0;
        
        foreach($the_date_array as $value2) {
            //$sql_string = "select count(id) from sections where instructor_id = " . $value1 . " and section_date ='" . $value2 . "'";
            //$res = view_data_generic_sql($sql_string);
            //total of non-private classes
            //$sql_string2 = "select count(sections.id) from sections, products where products.id = sections.product_id and products.product_name not like '%PRIVATE%' and sections.instructor_id = " . $value1 . " and sections.section_date ='" . $value2 . "'";
            $sql_string2 = "select count(sections.id) from sections, products where products.id = sections.product_id and products.product_type = 'lesson' and sections.instructor_id = " . $value1 . " and sections.section_date ='" . $value2 . "'";
            //print $sql_string2 . "<br>";
            $res2 = view_data_generic_sql($sql_string2);
            //total of private classes
            //$sql_string3 =  "select count(sections.id) from sections, products where products.id = sections.product_id and products.product_name like '%PRIVATE%' and sections.instructor_id = " . $value1 . " and sections.section_date ='" . $value2 . "'";
            $sql_string3 =  "select count(sections.id) from sections, products where products.id = sections.product_id and products.product_type = 'private' and sections.instructor_id = " . $value1 . " and sections.section_date ='" . $value2 . "'";
            $res3 = view_data_generic_sql($sql_string3);
            //$row = $res->fetchRow();
            //$row2 = $res2->fetchRow();
            $row3 = $res3->fetchRow();
            
            //total of private-request classes
            //$sql_string3 =  "select count(sections.id) from sections, products where products.id = sections.product_id and products.product_name like '%PRIVATE%' and sections.instructor_id = " . $value1 . " and sections.section_date ='" . $value2 . "'";
            $sql_string5 =  "select count(sections.id) from sections, products where products.id = sections.product_id and products.product_type = 'private_request' and sections.instructor_id = " . $value1 . " and sections.section_date ='" . $value2 . "'";
            $res5 = view_data_generic_sql($sql_string5);
            //$row = $res->fetchRow();
            //$row2 = $res2->fetchRow();
            $row5 = $res5->fetchRow();
            
            //total of programs classes
            $sql_string6 =  "select count(id) from program_barcodes where instructor_id = " . $value1 . " and program_date ='" . $value2 . "'";
            //print $sql_string6 . "<br>";
            $res6 = view_data_generic_sql($sql_string6);
            $row6 = $res6->fetchRow();
            
            //total of helper classes
            //$sql_string7 =  "select count(id) from helper_barcodes where instructor_id = " . $value1 . " and helper_date ='" . $value2 . "'";
            //$res7 = view_data_generic_sql($sql_string7);
            //$row7 = $res7->fetchRow();
            //while (list($key, $val) = each($helper_id_hash_array)) {
            //    $sql_string8 =  "select count(id) from helper_barcodes where instructor_id = " . $value1 . " and helper_date ='" . $value2 . "' and helper_barcode ='" . $element['key'] . "'";
            //    $res8 = view_data_generic_sql($sql_string8);
            //    $row[$key] = $res8->fetchRow();
            //}
            //get number of 50% helper sections
            //$sql_string7 =  "select count(id) from helper_barcodes where instructor_id = " . $value1 . " and helper_date ='" . $value2 . "'";
            //$sql_string7 .= " and helper_barcode = '1450054706'";
            //$res7 = view_data_generic_sql($sql_string7);
            //$row7 = $res7->fetchRow();
            
            //get number of 75% helper sections
            //$sql_string8 =  "select count(id) from helper_barcodes where instructor_id = " . $value1 . " and helper_date ='" . $value2 . "'";
            //$sql_string8 .= " and helper_barcode = '1450054733'";
            //$res8 = view_data_generic_sql($sql_string8);
            //$row8 = $res8->fetchRow();
            
            //get number of 100% sections
            $sql_string9 =  "select count(id) from helper_barcodes where instructor_id = " . $value1 . " and helper_date ='" . $value2 . "'";
            //$sql_string9 .= " and helper_barcode = '1450054752'";
            //print $sql_string9 . "<br>";
            $res9 = view_data_generic_sql($sql_string9);
            $row9 = $res9->fetchRow();
            
            while ($row2 = $res2->fetchRow()) {
            //while ($row) {
                //print "<td>" . $row[0] . "/" . $row2[0] . "/" . $row3[0] . "</td>";
                //print "<td><div align=center>" . $row2[0] . "&nbsp;&nbsp;|&nbsp;&nbsp;" . $row3[0] . "</div></td>";
                //$temp_write_buffer .= "<td><div align=center>" . $row2[0] . "&nbsp;&nbsp;|&nbsp;&nbsp;" . $row3[0] . "&nbsp;&nbsp;|&nbsp;&nbsp;" . $row5[0] . "</div></td>";
                //$temp_write_buffer .= "<td><div align=center>" . intval($row2[0] * $instructor_lesson_rate_hash_array[$key]) . "&nbsp;&nbsp;|&nbsp;&nbsp;" . intval($row3[0] * $instructor_private_rate_hash_array[$key]) . "&nbsp;&nbsp;|&nbsp;&nbsp;" . intval($row5[0] * $instructor_private_request_rate_hash_array[$key]) . "&nbsp;&nbsp;|&nbsp;&nbsp;" . intval($row6[0] * $instructor_lesson_rate_hash_array[$key]) . "</div></td>";
                
                //$employee_week_total = $employee_week_total + $row[0];
                $employee_lesson_week_total = $employee_lesson_week_total + (intval($row2[0]) * floatval($instructor_lesson_rate_hash_array[$key]));
                //print "the lesson rate for " . $key . " is " . $instructor_lesson_rate_hash_array[$key] . "<br>";
                //print "the lesson total is " . $employee_lesson_week_total . " for " . $key . "<br>";
                $employee_private_week_total = $employee_private_week_total + (intval($row3[0]) * floatval($instructor_private_rate_hash_array[$key]));
                //print "the private rate for " . $key . " is " . $instructor_private_rate_hash_array[$key] . "<br>";
                //print "the private total is " . $employee_private_week_total . " for " . $key . "<br>";
                $employee_private_request_week_total = $employee_private_request_week_total + (intval($row5[0]) * floatval($instructor_private_request_rate_hash_array[$key]));
                //print "the private-request rate for " . $key . " is " . $instructor_lesson_rate_hash_array[$key] . "<br>";
                //print "the private-request total is " . $employee_private_request_week_total . " for " . $key . "<br>";
                $employee_program_week_total = $employee_program_week_total + (intval($row6[0]) * floatval($instructor_lesson_rate_hash_array[$key]));
                //print "the program rate for " . $key . " is " . $instructor_lesson_rate_hash_array[$key] . "<br>";
                //print "the program total is " . $employee_program_week_total . " for " . $key . "<br>";
                $employee_lesson_program_week_total = $employee_lesson_week_total + $employee_program_week_total;
                //print "the lesson program total is " . $employee_lesson_program_week_total . " for " . $key . "<br>";
                //to get helper week total we must total all of the different helper sections and their rates
                //$employee_helper_week_total = $employee_helper_week_total + (intval($row7[0]) * floatval($instructor_lesson_rate_hash_array[$key])/2);
                //$employee_helper_week_total = $employee_helper_week_total + (intval($row7[0]) * floatval($instructor_lesson_rate_hash_array[$key])) + (intval($row8[0]) * floatval(3*$instructor_lesson_rate_hash_array[$key])/4) + (intval($row9[0]) * floatval($instructor_lesson_rate_hash_array[$key]));
                $employee_helper_week_total = $employee_helper_week_total + (intval($row9[0]) * floatval($instructor_lesson_rate_hash_array[$key]));
                //print "the helper total is " . $employee_helper_week_total . " for " . $key . "<br>";
                
                //while (list($key, $val) = each($helper_id_hash_array)) {
                //    $employee_helper_week_total = $employee_helper_week_total + intval($employee_helper_week_total) + intval($row[$key][0] * ($helper_id_hash_array[$key]/100) * $instructor_lesson_rate_hash_array[$key]*100);
                //}
                
                //number values
                $employee_num_lesson_week_total = intval($employee_num_lesson_week_total) + intval($row2[0]);
                $employee_num_private_week_total = intval($employee_num_private_week_total) + intval($row3[0]);
                $employee_num_private_request_week_total = intval($employee_num_private_request_week_total) + intval($row5[0]);
                $employee_num_program_week_total = intval($employee_num_program_week_total) + intval($row6[0]);
                $employee_num_lesson_program_week_total = intval($employee_num_lesson_week_total) + intval($employee_num_program_week_total);
                $employee_num_helper_week_total = intval($employee_num_helper_week_total) + intval($row9[0]);  
                //$employee_num_helper_week_total = intval($employee_num_helper_week_total) + intval($row7[0]) + intval($row8[0]) + intval($row9[0]);    
            }
            
        }
        //$grand_total = $grand_total + $employee_week_total;
        $grand_lesson_total = $grand_lesson_total + $employee_lesson_week_total;
        $grand_private_total = $grand_private_total + $employee_private_week_total;
        $grand_private_request_total = $grand_private_request_total + $employee_private_request_week_total;
        $grand_program_total = $grand_program_total + $employee_program_week_total;
        $grand_lesson_program_total = $grand_lesson_program_total + $employee_lesson_program_week_total;
        $grand_helper_total = $grand_helper_total + $employee_helper_week_total;     
        
        //numbers
        $grand_num_lesson_total = intval($grand_num_lesson_total) + intval($employee_num_lesson_week_total);
        $grand_num_private_total = intval($grand_num_private_total) + intval($employee_num_private_week_total);
        $grand_num_private_request_total = intval($grand_num_private_request_total) + intval($employee_num_private_request_week_total);
        $grand_num_program_total = intval($grand_num_program_total) + intval($employee_num_program_week_total);
        $grand_num_lesson_program_total = intval($grand_num_lesson_program_total) + intval($employee_num_lesson_program_week_total);
        $grand_num_helper_total = intval($grand_num_helper_total) + intval($employee_num_helper_week_total);
        
        //$grand_total = $grand_total + (intval($grand_lesson_total) + intval($grand_private_total));
        
        //print "<td>" . $employee_week_total . "</td>";
        $employee_grand_week_total = $employee_private_week_total + $employee_private_request_week_total + $employee_program_week_total + $employee_lesson_program_week_total + $employee_helper_week_total;
        $employee_num_grand_week_total = $employee_num_lesson_week_total + $employee_num_private_week_total + $employee_num_private_request_week_total + $employee_num_program_week_total + $employee_num_lesson_program_week_total + $employee_num_helper_week_total;
        //print "<td align=center>$" . $employee_lesson_week_total . "(L)&nbsp;|&nbsp;$" . $employee_private_week_total . "(P)&nbsp;|&nbsp;$" . $employee_grand_week_total . "(T)</td>";
        //print "</tr>";
        //$temp_write_buffer .= "<td align=center>$" . $employee_lesson_week_total . "(L)&nbsp;|&nbsp;$" . $employee_private_week_total . "(P)&nbsp;|&nbsp;$" . $employee_private_request_week_total . "(PR)&nbsp;|&nbsp;$" . $employee_program_week_total . "(PROG)&nbsp;|&nbsp;$" . $employee_grand_week_total . "(T)</td></tr>";
        //$temp_write_buffer .= "<td align=center>$" . $employee_lesson_program_week_total . "(L+PROG)&nbsp;|&nbsp;$" . $employee_private_week_total . "(P)&nbsp;|&nbsp;$" . $employee_private_request_week_total . "(PR)&nbsp;|&nbsp;$" . $employee_grand_week_total . "(T)</td></tr>";
        //$temp_write_buffer .= "<td align=center>" . $employee_num_lesson_program_week_total . "(L+PROG)&nbsp;|&nbsp;" . $employee_num_private_week_total . "(P)&nbsp;|&nbsp;" . $employee_num_private_request_week_total . "(PR)&nbsp;|&nbsp;$" . $employee_num_helper_week_total . "(H)&nbsp;|&nbsp;$" . number_format(($employee_grand_week_total/100), 2, '.', '') . "(T)</td></tr>";
        //$temp_write_buffer .= "<td align=center>" . $employee_num_lesson_program_week_total . "(L+PROG)&nbsp;|&nbsp;" . $employee_num_private_week_total . "(P)&nbsp;|&nbsp;" . $employee_num_private_request_week_total . "(PR)&nbsp;|&nbsp;" . $employee_num_helper_week_total . "(H)&nbsp;|&nbsp;$" . money_format('%i', $employee_grand_week_total) . "(T)</td></tr>";
        $temp_write_buffer .= "<td align=center>" . $employee_num_lesson_program_week_total . "</td><td>" . $employee_num_private_week_total . "</td><td>" . $employee_num_private_request_week_total . "</td><td>" . $employee_num_helper_week_total . "</td><td>$" . money_format('%i', $employee_grand_week_total) . "</td></tr>";
        
        //check to see if employee taught any classes
        if ($employee_grand_week_total > 0) {
            print $temp_write_buffer;
        }
        
        
       //week total for each employee
        $employee_week_total = 0;
        $employee_lesson_week_total = 0;
        $employee_private_week_total = 0;
        $employee_private_request_week_total = 0;
        $employee_program_week_total = 0;
        $employee_lesson_program_week_total = 0;
        $employee_helper_week_total = 0;
        
        //week total number of lessons for each employee
        $employee_num_week_total = 0;
        $employee_num_lesson_week_total = 0;
        $employee_num_private_week_total = 0;
        $employee_num_private_request_week_total = 0;
        $employee_num_program_week_total = 0;
        $employee_num_lesson_program_week_total = 0;
        $employee_num_helper_week_total = 0;
        
        
        
        
           
    }
    //$grand_total = intval($grand_lesson_total) + intval($grand_private_total) + intval($grand_private_request_total) + intval($grand_program_total) + intval($grand_lesson_program_total) + intval($grand_helper_total);
    $grand_total = $grand_private_total + $grand_private_request_total + $grand_lesson_program_total + $grand_program_total + $grand_helper_total;
    //print "<tr><td colspan=" . (count($the_date_array)+1) . ">&nbsp;</td><th>" . $grand_total . "</th></tr>";
    //print "<tr><td colspan=" . (count($the_date_array)+1) . ">&nbsp;</td><th>$" . $grand_lesson_total . "(L)|$" . $grand_private_total . "(P)|$" . $grand_private_request_total . "(PR)|$" . $grand_program_total . "(PROG)|$" . $grand_total . "(T)</th></tr>";
    //print "<tr><td>&nbsp;</td><th>$" . $grand_lesson_total . "(L)|$" . $grand_private_total . "(P)|$" . $grand_private_request_total . "(PR)|$" . $grand_program_total . "(PROG)|$" . $grand_total . "(T)</th></tr>";
    //print "<tr><td>&nbsp;</td><th>$" . $grand_lesson_program_total . "(L+PROG)|$" . $grand_private_total . "(P)|$" . $grand_private_request_total . "(PR)|$" . $grand_total . "(T)</th></tr>";
    //print "<tr><td>&nbsp;</td><th>" . $grand_num_lesson_program_total . "(L+PROG)|" . $grand_num_private_total . "(P)|" . $grand_num_private_request_total . "(PR)|" . $grand_num_helper_total . "(H)|$" . number_format(($grand_total/100), 2, '.', '') . "(T)</th></tr>";
    //print "<tr><td>&nbsp;</td><th>" . $grand_num_lesson_program_total . "(L+PROG)|" . $grand_num_private_total . "(P)|" . $grand_num_private_request_total . "(PR)|" . $grand_num_helper_total . "(H)|$" . money_format('%i', $grand_total) . "(T)</th></tr>";
    print "<tr><td>&nbsp;</td><th>" . $grand_num_lesson_program_total . "</th><th>" . $grand_num_private_total . "</th><th>" . $grand_num_private_request_total . "</th><th>" . $grand_num_helper_total . "</th><th>$" . money_format('%i', $grand_total) . "</th></tr>";
    print "</table>";
    //print "<p>The All-Employees Total is " . $grand_total . "</p>";


    
?>


<?php
	require_once("../../includes/admin_footer.php");
?>