<?php

$state_names = array(
	"Alaska", "Alabama", "Arkansas", "Arizona", "California", "Colorado", 
	"Connecticut", "District of Columbia", "Delaware", "Florida", "Georgia", 
	"Hawaii", "Iowa", "Idaho", "Illinois", "Indiana", "Kansas", "Kentucky", 
	"Louisiana", "Massachusetts", "Maryland", "Maine", "Michigan", "Minnesota", 
	"Missouri", "Mississippi", "Montana", "North Carolina", "North Dakota", 
	"Nebraska", "New Hampshire", "New Jersey", "New Mexico", "Nevada", "New York", 
	"Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", 
	"South Dakota", "Tennessee", "Texas", "Utah", "Virginia", "Vermont", "Washington", 
	"Wisconsin", "West Virginia", "Wyoming"
);

$state_acronyms = array(
	"AK", "AL", "AR", "AZ", "CA", "CO", "CT", "DC", "DE", "FL", "GA", "HI", 
	"IA", "ID", "IL", "IN", "KS", "KY", "LA", "MA", "MD", "ME", "MI", "MN", 
	"MO", "MS", "MT", "NC", "ND", "NE", "NH", "NJ", "NM", "NV", "NY", "OH", 
	"OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VA", "VT", "WA", 
	"WI", "WV", "WY"
);

function convert_date_to_time($date_entry) {
	list ($the_year, $the_month, $the_day) = split ('[/.-]', $date_entry);
	$date_string = mktime(0, 0, 0, $the_month, $the_day, $the_year);
	return $date_string;
}

function convert_date_display($date_entry) {
	list ($the_year, $the_month, $the_day) = split ('[/.-]', $date_entry);
	$date_string = trim($the_month . "/" . $the_day . "/" . $the_year);
	return $date_string;
}

function convert_date_input($date_entry) {
	list ($the_month, $the_day, $the_year) = split ('[/.-]', $date_entry);
	$date_string = trim($the_year . "-" . $the_month . "-" . $the_day);
	return $date_string;
}

function read_directory($current_dir) {
	$directory = opendir($current_dir);
	
	while($file = readdir($directory)) {
		if ($file != "." && $file != "..") {
			print $file . "<br>";
		}
	}

	closedir($directory);
}

function createDateRangeArray($strDateFrom,$strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.

    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

//This function takes a result object and displays the attributes
//in a table
function reset_open_seats($result_object) {
	while ($row = $result_object->fetchRow()) {    
//Get the number of registrants for this class
		
	}
}

//This function takes a result object and displays the attributes
//in a table
function display_data_table($result_object) {
	print "<div class=center><table cellpadding=5 cellspacing=0 border=0>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		foreach($row as $item) {
			print "<td><span class=no_indent>$item</span></td>";
		}
		print "</tr>";
	}
	
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_equipment_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Barcode</span></td>";
    print "<td><span class=center_bold>Name</span></td>";
	//print "<td><span class=center_bold>Address</span></td>";
	//print "<td><span class=center_bold>City</span></td>";
	//print "<td><span class=center_bold>State</span></td>";
	//print "<td><span class=center_bold>Zip Code</span></td>";
	//print "<td><span class=center_bold>Phone</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		//print stripslashes($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[7]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"edit.php?rowID=$row[0]\">Edit</a>&nbsp;&nbsp;";
        //print "<a href=\"sections_assignments.php?rowID=$row[0]\">Assignments</a></td>";
        //print "<a href=\"/instructors/admin/assignment/assignment_by_instructor.php?rowID=$row[0]\">Assignments</a></td>";
		print "</td></tr>";
	}
	
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_instructor_assignments_lessons_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
    print "<td><span class=center_bold>Date</span></td>";
	print "<td><span class=center_bold>Time</span></td>";
	print "<td><span class=center_bold>Level</span></td>";
	print "<td><span class=center_bold>Location</span></td>";
	print "<td><span class=center_bold>Instructor</span></td>";
	//print "<td><span class=center_bold>Phone</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		//print stripslashes($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . convert_date_display($row[2]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[6]) . " " . stripslashes($row[7]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[7]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]&type=lesson\">Delete</a></td>";
		//print "<a href=\"edit.php?rowID=$row[0]\">Edit</a>&nbsp;&nbsp;";
        //print "<a href=\"sections_assignments.php?rowID=$row[0]\">Assignments</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_instructor_assignments_programs_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Section Id/Barcode</span></td>";
    print "<td><span class=center_bold>Date</span></td>";
	//print "<td><span class=center_bold>Time</span></td>";
	//print "<td><span class=center_bold>Level</span></td>";
	//print "<td><span class=center_bold>Location</span></td>";
	print "<td><span class=center_bold>Instructor</span></td>";
	//print "<td><span class=center_bold>Phone</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		//print stripslashes($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . convert_date_display($row[2]) . "</span></td>";
        //print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[3]) . " " . stripslashes($row[4]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[7]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]&type=program\">Delete</a></td>";
		//print "<a href=\"edit.php?rowID=$row[0]\">Edit</a>&nbsp;&nbsp;";
        //print "<a href=\"sections_assignments.php?rowID=$row[0]\">Assignments</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_section_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
    print "<td><span class=center_bold>Date</span></td>";
    print "<td><span class=center_bold>Time</span></td>";
    print "<td><span class=center_bold>Ability</span></td>";
    //print "<td><span class=center_bold>Status</span></td>";
	//print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
        print "<td><span class=no_indent>" . convert_date_display($row[2]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
        //print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		//print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		//print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_helper_section_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
    print "<td><span class=center_bold>Pay %</span></td>";
    print "<td><span class=center_bold>Identifier</span></td>";
    //print "<td><span class=center_bold>Ability</span></td>";
    //print "<td><span class=center_bold>Status</span></td>";
	//print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
        //print "<td><span class=no_indent>" . convert_date_display($row[2]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
        //print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		//print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		//print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
        print "<td><a href=\"/instructors/barcode.php?sn=$row[1]&val=$row[3]\" target=\"_blank\">Barcode</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_instructor_usage_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
    print "<td><span class=center_bold>Instructor</span></td>";
	print "<td><span class=center_bold>Name</span></td>";
    print "<td><span class=center_bold>Date</span></td>";
    print "<td><span class=center_bold>Time</span></td>";
    print "<td><span class=center_bold>Ability</span></td>";
    print "<td><span class=center_bold>Status</span></td>";
	print "<td><span class=center_bold>Section ID</span></td>";
    
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
        print "<td><span class=no_indent>" . stripslashes($row[8]) . ", " . stripslashes($row[7]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
        print "<td><span class=no_indent>" . convert_date_display($row[2]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
        
		//print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		//print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_instructor_total_usage($begin_date, $end_date, $instructor_id) {
    
    $sql_string = "select count(sections.id) from sections where sections.instructor_id=" . $instructor_id . " and sections.section_date > '" . convert_date_input($begin_date) . "' and sections.section_date < '" . convert_date_input($end_date) . "'";
    //print $sql_string . "<br>";
    $res = view_data_generic_sql($sql_string);
    if ($res->numRows() > 0) {
	   while ($row = $res->fetchRow()) {
	       print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	       print "<tr bgcolor=#bbbbbb>";
           print "<td><span class=no_indent>Total number of sections taught</span></td>";
           print "<td><span class=no_indent>from " . $begin_date . "</span></td>";
           print "<td><span class=no_indent>to " . $end_date . ":</span></td>";
           print "<td><span class=no_indent>" . stripslashes($row[0]) . " sections.</span></td>";
           print "</tr>";
           print "</table></div>";
	   }
	}
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_instructor_usage_data2($result_object) {
    $temp_instructor = "";
    $output = "";
    $temp_total = 0;
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
    print "<td><span class=center_bold>Instructor</span></td>";
    //print "<td><span class=no_indent>" . stripslashes($row[8]) . ", " . stripslashes($row[7]) . "</span></td>";
    //print "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
    //print "</tr>";
    //print "<tr>";
    //print "<td></td>";
    print "<td><span class=center_bold>Date</span></td>";
	print "<td><span class=center_bold>Name</span></td>";
    
    print "<td><span class=center_bold>Time</span></td>";
    print "<td><span class=center_bold>Ability</span></td>";
    print "<td><span class=center_bold>Status</span></td>";
	print "<td><span class=center_bold>Section ID</span></td>";
    
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
        if ($temp_instructor == stripslashes($row[7])) {
            print "<td></td>";
        } else {
            print "<td><span class=no_indent>" . stripslashes($row[8]) . ", " . stripslashes($row[7]) . "</span></td>";
            $temp_instructor = stripslashes($row[7]);
        }
        
        print "<td><span class=no_indent>" . convert_date_display($row[2]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
        
		//print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		//print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_instructors_section_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
    print "<td><span class=center_bold>Date</span></td>";
    print "<td><span class=center_bold>Time</span></td>";
    print "<td><span class=center_bold>Ability</span></td>";
    print "<td><span class=center_bold>Status</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
        print "<td><span class=no_indent>" . convert_date_display($row[2]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		//print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<td><a href=\"assignments.php?rowID=$row[0]\">Assign Instructor</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_instructors_daily_data($result_object) {
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<td><span class=no_indent>" . stripslashes($row[0]) . "</span></td>";
	}
    return intval($row[0]);
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_profile_section_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
    //print "<td><span class=center_bold>Date</span></td>";
    print "<td><span class=center_bold>Time</span></td>";
    print "<td><span class=center_bold>Ability</span></td>";
    print "<td><span class=center_bold>Status</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
        //print "<td><span class=no_indent>" . convert_date_display($row[2]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}



//This function takes the result object from a db library function
//and parses it into the instructor table
function enter_profile_section_data($result_object) {
    $index = time();
	while ($row = $result_object->fetchRow()) {    
        $table_name = "sections";
        //$field_names = array("product_id", "level_id", "location_id", "instructor_id", "section_name", "section_date", "section_time", "max_seats", "section_id", "section_status", "seats_taken");
        $field_names = array("product_id", "level_id", "location_id", "instructor_id", "section_name", "section_date", "section_time_id", "max_seats", "section_id", "section_status", "seats_taken", "section_age_id");
        $types = array('integer', 'integer', 'integer', 'integer', 'text', 'date', 'integer', 'integer', 'integer', 'text', 'integer', 'integer');
        //$field_values = array($row[0], $row[8], $row[1], $row[2], $row[3], convert_date_input($_POST['section_list_date']), $row[4], $row[5], $row[6], $row[7], 0, $row[9]);
        $field_values = array($row[0], $row[8], $row[1], $row[2], $row[3], convert_date_input($_POST['section_list_date']), $row[4], $row[5], $index, $row[7], 0, $row[9]);
        insert_data($table_name, $field_names, $field_values, $types);
        $index++;
	}
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_reservation_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
    print "<td><span class=center_bold>Email</span></td>";
    print "<td><span class=center_bold>Product</span></td>";
    print "<td><span class=center_bold>Product Type</span></td>";
    print "<td><span class=center_bold>Meeting Time</span></td>";
    print "<td><span class=center_bold>Date</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . " " . stripslashes($row[2]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
        print "<td><span class=no_indent>" . convert_date_display($row[7]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_sales_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
    print "<td><span class=center_bold>Email</span></td>";
    print "<td><span class=center_bold>Product</span></td>";
    print "<td><span class=center_bold>Product Type</span></td>";
    print "<td><span class=center_bold>Meeting Time</span></td>";
    print "<td><span class=center_bold>Date</span></td>";
    print "<td><span class=center_bold>Sale($)</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
    $total_sales = 0;
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
        $total_sales = $total_sales + $row[8];
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . " " . stripslashes($row[2]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
        print "<td><span class=no_indent>" . convert_date_display($row[7]) . "</span></td>";
        print "<td><span class=no_indent>" . $row[8] . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
    print "<tr>";
	print "<td><span class=center_bold></span></td>";
    print "<td><span class=center_bold></span></td>";
    print "<td><span class=center_bold></span></td>";
    print "<td><span class=center_bold></span></td>";
    print "<td><span class=center_bold></span></td>";
    print "<td><span class=center_bold>Total:</span></td>";
    print "<td><span class=center_bold>$" . $total_sales . "</span></td>";
	print "<td><span class=center_bold></span></td>";
	print "</tr>";
	
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_reservation_report($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
    print "<td><span class=center_bold>Level</span></td>";
    print "<td><span class=center_bold>Product</span></td>";
    print "<td><span class=center_bold>Product Type</span></td>";
    print "<td><span class=center_bold>Meeting Time</span></td>";
    print "<td><span class=center_bold>Date</span></td>";
    print "<td><span class=center_bold>Age</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . " " . stripslashes($row[2]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
        print "<td><span class=no_indent>" . convert_date_display($row[7]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[8]) . "</span></td>";
		//print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<td><span class=no_indent><a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_product_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
    print "<td><span class=center_bold>Product</span></td>";
    print "<td><span class=center_bold>Product Description</span></td>";
    //print "<td><span class=center_bold>Meeting Time</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
        //print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"products_edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_level_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>" . ABILITY . " Name</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}



//This function takes the result object from a db library function
//and parses it into the instructor table
function display_time_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Time</span></td>";
    print "<td><span class=center_bold>Order</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_age_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Age</span></td>";
    print "<td><span class=center_bold>Order</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
        print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_user_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Username</span></td>";
	//print "<td><span class=center_bold>Security Level</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}



//This function takes the result object from a db library function
//and parses it into the instructor table
function display_room_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>" . ROOM . "</span></td>";
	print "<td><span class=center_bold>" . LOCATION . "</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]&locationID=$row[3]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"room_edit.php?rowID=$row[0]\">Edit</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_location_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
	print "<td><span class=center_bold>Description</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		//print "<a href=\"edit.php?rowID=$row[0]\">Edit</a>&nbsp;&nbsp;";
		//print "<a href=\"room.php?locationID=$row[0]\">" . ROOM_PLURAL . "</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_profile_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
	print "<td><span class=center_bold>Description</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\" onclick='return myConfirmation();'>Delete</a>&nbsp;&nbsp;";
		print "<a href=\"edit.php?rowID=$row[0]\">Edit</a></td>";
		//print "<a href=\"edit.php?rowID=$row[0]\">Edit</a>&nbsp;&nbsp;";
		//print "<a href=\"room.php?locationID=$row[0]\">" . ROOM_PLURAL . "</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_class_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>" . CATEGORY2 . "</span></td>";
	print "<td><span class=center_bold>" . CATEGORY1 . "</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"edit.php?rowID=$row[0]\">Edit</a>&nbsp;&nbsp;";
		print "<a href=\"schedule.php?classID=$row[0]\">Schedule</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_class_instance_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>" . CATEGORY2 . "</span></td>";
	print "<td><span class=center_bold>" . CATEGORY3 . " ID</span></td>";
	print "<td><span class=center_bold>" . ABILITY . "</span></td>";
	print "<td><span class=center_bold>" . CATEGORY3 . " Time</span></td>";
	print "<td><span class=center_bold>Open Seats</span></td>";
	//print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . $row[0] . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . $row[3] . "</span></td>";
		print "<td><span class=no_indent>" . $row[4] . "</span></td>";
		//print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?new_class_instance_id=$row[0]\">e</a>&nbsp;&nbsp;";
		//print "<a href=\"edit.php?rowID=$row[0]\">Edit</a>&nbsp;&nbsp;";
		//print "<td><a href=\"schedule.php?new_class_instance_id=$row[0]&old_class_instance_id=" . $_POST['old_class_instance_id'] . "&customer_id=" . $_POST['customer_id'] . "\">Schedule</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}



//This function takes the result object from a db library function
//and parses it into the instructor table
function display_new_class_instance_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>" . CATEGORY3 . " ID</span></td>";
	print "<td><span class=center_bold>" . ABILITY . "</span></td>";
	print "<td><span class=center_bold>" . CATEGORY3 . " Time</span></td>";
	print "<td><span class=center_bold>Open Seats</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . $row[0] . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . $row[3] . "</span></td>";
		//print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?new_class_instance_id=$row[0]\">e</a>&nbsp;&nbsp;";
		//print "<a href=\"edit.php?rowID=$row[0]\">Edit</a>&nbsp;&nbsp;";
		print "<td><a href=\"schedule.php?new_class_instance_id=$row[0]&old_class_instance_id=" . $_POST['old_class_instance_id'] . "&customer_id=" . $_POST['customer_id'] . "&registration_id=" . $_POST['registration_id'] . "\">Schedule</a></td>";
		print "</tr>";
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_registration_search_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>First Name</span></td>";
	print "<td><span class=center_bold>Last Name</span></td>";
	print "<td><span class=center_bold>" . CATEGORY3 . " Date</span></td>";
	print "<td><span class=center_bold>Time</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . convert_date_display($row[3]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
		print "<td>";
		print "<a href=\"change_registration.php?customer_id=$row[6]&class_instance_id=$row[5]&registration_id=$row[0]\">Change</a>&nbsp;&nbsp;";
		print "<a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]&class_instance_id=$row[5]\">Delete</a>&nbsp;&nbsp;";
		print "<a href=\"customer_info_edit.php?rowID=$row[6]\">Edit Customer Info</a>&nbsp;&nbsp;";
		if (stripslashes($row[8]) == "credit") {
			print "<a href=\"credit_info_edit.php?rowID=$row[7]&registration_id=$row[0]\">Edit Credit Info</a>";
		}
		print "</td>";
		
		print "</tr>";
	}
	
	print "</table></div>";
}



//This function takes the result object from a db library function
//and parses it into the instructor table
function display_payment_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
	//print "<td><span class=center_bold>Last Name</span></td>";
	print "<td><span class=center_bold>" . CATEGORY2 . "</span></td>";
	print "<td><span class=center_bold>" . CATEGORY3 . " Date</span></td>";
	print "<td><span class=center_bold>Time</span></td>";
	print "<td><span class=center_bold>Card Type</span></td>";
	print "<td><span class=center_bold>Card Number</span></td>";
	print "<td><span class=center_bold>Exp Date</span></td>";
	print "<td><span class=center_bold>Cardholder</span></td>";
	print "<td><span class=center_bold>Payment Status</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . " " . stripslashes($row[2]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
		print "<td><span class=no_indent>" . convert_date_display($row[4]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[7]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[8]) . "/" . stripslashes($row[9]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[10]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[11]) . "</span></td>";
		print "<td>";
		//print "<a href=\"change_registration.php?customer_id=$row[6]&class_instance_id=$row[5]&registration_id=$row[0]\">Change</a>&nbsp;&nbsp;";
		print "<a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Change Payment Status - Payment Authorized/Confirmed</a>";
		//print "<a href=\"customer_info_edit.php?rowID=$row[6]\">Edit Customer Info</a></td>";
		
		print "</tr>";
	}
	
	print "</table></div>";
}



//This function takes the result object from a db library function
//and parses it into the instructor table
function display_waiver_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>First Name</span></td>";
	print "<td><span class=center_bold>Last Name</span></td>";
	print "<td><span class=center_bold>" . CATEGORY2 . "</span></td>";
	print "<td><span class=center_bold>" . CATEGORY3 . " Date</span></td>";
	print "<td><span class=center_bold>Time</span></td>";
	print "<td><span class=center_bold>Waiver Status</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
		print "<td><span class=no_indent>" . convert_date_display($row[4]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
		print "<td>";
		//print "<a href=\"change_registration.php?customer_id=$row[6]&class_instance_id=$row[5]&registration_id=$row[0]\">Change</a>&nbsp;&nbsp;";
		print "<a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]\">Change Waiver Status - Waiver Signed</a>";
		//print "<a href=\"customer_info_edit.php?rowID=$row[6]\">Edit Customer Info</a></td>";
		
		print "</tr>";
	}
	
	print "</table></div>";
}



//This function takes the result object from a db library function
//and parses it into the instructor table
function display_cost_data($result_object) {
	while ($row = $result_object->fetchRow()) {
		print "<tr><td><p class=\"bold\">" . CATEGORY3 . " Cost:</p></td>";
		print "<td><p class=\"no_ident\">\$" . trim($row[0]) . "</p>";
		print "</td></tr>";
		print "<input type=\"hidden\" name=\"class_cost\" value=\"" . trim($row[0]) . "\">";
		if ($_GET['rentals'] == "y") {
			print "<tr><td><p class=\"bold\">Rental Fee:</p></td>";
			print "<td><p class=\"no_ident\">\$" . trim($row[1]) . "</p>";
			print "</td></tr>";
			print "<input type=\"hidden\" name=\"rental_fee\" value=\"" . trim($row[1]) . "\">";
			$total_cost = intval($row[0]) + intval($row[1]);
		} else {
			print "<tr><td><p class=\"bold\">Rental Fee:</p></td>";
			print "<td><p class=\"no_ident\">\$0</p>";
			print "</td></tr>";
			print "<input type=\"hidden\" name=\"rental_fee\" value=\"0\">";
			$total_cost = intval($row[0]);
		}
		print "<tr><td><p class=\"bold\">Total Cost:</p></td>";
		print "<td><p class=\"no_ident\">\$" . $total_cost . "</p>";
		print "</td></tr>";
		print "<input type=\"hidden\" name=\"total_cost\" value=\"" . $total_cost . "\">";
	}
	
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_instance_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>" . CATEGORY3 . " ID</span></td>";
	print "<td><span class=center_bold>Begin Date</span></td>";
	print "<td><span class=center_bold>End Date</span></td>";
	print "<td><span class=center_bold>Times</span></td>";
	print "<td><span class=center_bold>Max Size</span></td>";
	print "<td><span class=center_bold>" . LECTURER . "</span></td>";
	print "<td><span class=center_bold>" . ABILITY . "</span></td>";
	print "<td><span class=center_bold>" . LOCATION . "</span></td>";
	print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . $row[0] . "</span></td>";
		print "<td><span class=no_indent>" . convert_date_display($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . convert_date_display($row[3]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[7]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[8]) . "</span></td>";
		if ($_GET['classID']) {
			print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]&classID=" . $_GET['classID'] . "\">Delete</a>&nbsp;&nbsp;";
		} else {
			print "<td><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?rowID=$row[0]&classID=" . $_POST['class_id'] . "\">Delete</a>&nbsp;&nbsp;";
		}
		print "<a href=\"schedule_edit.php?rowID=$row[0]\">Edit</a>&nbsp;&nbsp;</td>";
		print "</tr>";
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_attendee_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
	//print "<td><span class=center_bold>Firstname</span></td>";
	//print "<td><span class=center_bold>Lastname</span></td>";
	print "<td><span class=center_bold>Age</span></td>";
	print "<td><span class=center_bold>Phone</span></td>";
	print "<td><span class=center_bold>Email</span></td>";
	print "<td><span class=center_bold>Address</span></td>";
	print "<td><span class=center_bold>City</span></td>";
	print "<td><span class=center_bold>State</span></td>";
	print "<td><span class=center_bold>Zip</span></td>";
	print "<td><span class=center_bold>Parent</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent><a href=transcript.php?cust_id=" . $row[10] . ">" . stripslashes($row[0]) . " " . stripslashes($row[1]) . "</a></span></td>";
		//print "<td><span class=no_indent>" . $row[1] . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[7]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[8]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[9]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[8]) . "</span></td>";
		print "<td><span class=no_indent><a href=customer_info_edit.php?rowID=" . $row[10] . ">Edit</a></span></td>";
		print "</td></tr>";
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_transcript_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>" . CATEGORY1 . "</span></td>";
	print "<td><span class=center_bold>" . CATEGORY2 . "</span></td>";
	print "<td><span class=center_bold>Date</span></td>";
	print "<td><span class=center_bold>Instructor</span></td>";
	print "<td><span class=center_bold>Cost</span></td>";
	print "<td><span class=center_bold>Payment Type</span></td>";
	print "<td><span class=center_bold>Payment Status</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . stripslashes($row[0]) . "</a></span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[1]) . "</span></td>";
		print "<td><span class=no_indent>" . convert_date_display($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
		print "</td></tr>";
	}
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_roster_data($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
	//print "<td><span class=center_bold>Firstname</span></td>";
	//print "<td><span class=center_bold>Lastname</span></td>";
	print "<td><span class=center_bold>Date</span></td>";
	print "<td><span class=center_bold>Day</span></td>";
	print "<td><span class=center_bold>" . CATEGORY1 . "</span></td>";
	print "<td><span class=center_bold>" . CATEGORY2 . "</span></td>";
	print "<td><span class=center_bold>Age</span></td>";
	print "<td><span class=center_bold>" . ABILITY . "</span></td>";
	print "<td><span class=center_bold>Time</span></td>";
	print "<td><span class=center_bold>" . LOCATION . "</span></td>";
	//print "<td><span class=center_bold>" . CATEGORY3 . " ID</span></td>";
	//print "<td><span class=center_bold>Actions</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . $row[0] . " " . $row[1] . "</span></td>";
		//print "<td><span class=no_indent>" . $row[1] . "</span></td>";
		print "<td><span class=no_indent>" . convert_date_display($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . date("l", convert_date_to_time($row[2])) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[9]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[7]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[8]) . "</span></td>";
		print "</td></tr>";
	}
	
	print "</table></div>";
}



//This function takes the result object from a db library function
//and parses it into the instructor table
function display_roster_data_program($result_object) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Name</span></td>";
	//print "<td><span class=center_bold>Firstname</span></td>";
	//print "<td><span class=center_bold>Lastname</span></td>";
	print "<td><span class=center_bold>Date</span></td>";
	print "<td><span class=center_bold>Day</span></td>";
	print "<td><span class=center_bold>" . CATEGORY1 . "</span></td>";
	//print "<td><span class=center_bold>" . CATEGORY2 . "</span></td>";
	print "<td><span class=center_bold>Age</span></td>";
	print "<td><span class=center_bold>" . ABILITY . "</span></td>";
	print "<td><span class=center_bold>Time</span></td>";
	print "<td><span class=center_bold>" . LOCATION . "</span></td>";
	print "<td><span class=center_bold>Phone</span></td>";
	print "<td><span class=center_bold>Address</span></td>";
	print "<td><span class=center_bold>Payment Status</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		print "<tr>";
		print "<td><span class=no_indent>" . $row[0] . " " . $row[1] . "</span></td>";
		//print "<td><span class=no_indent>" . $row[1] . "</span></td>";
		print "<td><span class=no_indent>" . convert_date_display($row[2]) . "</span></td>";
		print "<td><span class=no_indent>" . date("l", convert_date_to_time($row[2])) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[9]) . "</span></td>";
		//print "<td><span class=no_indent>" . stripslashes($row[3]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[4]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[5]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[6]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[7]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[10]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[11]) . "<br>" . stripslashes($row[12]) . ", " . stripslashes($row[13]) . " " . stripslashes($row[14]) . "</span></td>";
		print "<td><span class=no_indent>" . stripslashes($row[15]) . "</span></td>";
		print "</td></tr>";
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_label_data_date1($result_object) {
	$i = 0;
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		if ($i == 0) {
			print "<table cellpadding=0 cellspacing=0 border=0>";
			print "<tr>";
			print "<td>" . $row[0] . " " . $row[1] . "<br>";
			print date("l", convert_date_to_time($row[2])) . " " . stripslashes($row[3]) . "<br>";
			print stripslashes($row[9]) . ", " . stripslashes($row[6]) . ", " . stripslashes($row[7]) . "</td>";
			//print "</tr>";
			$i++;
		}
		
		//if (fmod($i, 30) == 0) {
		//	//print "<td><span class=no_indent>" . $row[0] . " " . $row[1] . "<br>";
		//	//print date("l", convert_date_to_time($row[2])) . " " . stripslashes($row[3]) . "<br>";
		//	//print stripslashes($row[9]) . ", " . stripslashes($row[6]) . ", " . stripslashes($row[7]) . "</span></td>";
		//	print "</tr>";
		//	print "</table>";
		//	print "<p style=\"page-break-before: always\">";
		//	print "<table cellpadding=0 cellspacing=0 border=0>";
		//	print "<tr>";
		//	$i++;
		//}
		
		if (fmod($i, 3) == 0) {
			if ($i != 0) {
				print "</tr><tr>";
			}
			print "<td>" . $row[0] . " " . $row[1] . "<br>";
			print date("l", convert_date_to_time($row[2])) . " " . stripslashes($row[3]) . "<br>";
			print stripslashes($row[9]) . ", " . stripslashes($row[6]) . ", " . stripslashes($row[7]) . "</td>";
			$i++;
		} else {
			print "<td>" . $row[0] . " " . $row[1] . "<br>";
			print date("l", convert_date_to_time($row[2])) . " " . stripslashes($row[3]) . "<br>";
			print stripslashes($row[9]) . ", " . stripslashes($row[6]) . ", " . stripslashes($row[7]) . "</td>";
			$i++;
		}
	}
	
	print "</tr></table>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_label_data_date($result_object) {
	print "<table cellpadding=0 cellspacing=0 border=0>";
	print "<tr><td>Label Row 1</td><td>Label Row 2</td><td>Lable Row 3</td></tr>";
	
	while ($row = $result_object->fetchRow()) {    
		print "<tr>";
		print "<td>" . $row[0] . " " . $row[1] . "</td>";
		print "<td>" . date("l", convert_date_to_time($row[2])) . " " . stripslashes($row[3]) . "</td>";
		print "<td>" . stripslashes($row[9]) . " " . stripslashes($row[6]) . " " . stripslashes($row[7]) . "</td>";
		print "</tr>";
	}
	print "</table>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_label_data_attendee($result_object) {
	print "<table cellpadding=0 cellspacing=0 border=0>";
	print "<tr><td>Label Row 1</td><td>Label Row 2</td><td>Lable Row 3</td></tr>";
	
	while ($row = $result_object->fetchRow()) {    
		print "<tr>";
		print "<td>" . $row[0] . " " . $row[1] . "</td>";
		print "<td>" . stripslashes($row[2]) . "</td>";
		print "<td>" . stripslashes($row[3]) . ", " . stripslashes($row[4]) . " " . stripslashes($row[5]) . "</td>";
		print "</tr>";
	}
	print "</table>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_label_email_attendee($result_object) {
	print "<table cellpadding=0 cellspacing=0 border=0>";
	print "<tr><td>First Name</td><td>Last Name</td><td>Email Address</td></tr>";
	
	while ($row = $result_object->fetchRow()) {    
		print "<tr>";
		print "<td>" . stripslashes($row[0]) . "</td>";
		print "<td>" . stripslashes($row[1]) . "</td>";
		print "<td>" . stripslashes($row[2]) . "</td>";
		print "</tr>";
	}
	print "</table>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_mailing_label_data_date($result_object) {
	print "<table cellpadding=0 cellspacing=0 border=0>";
	print "<tr><td>Label Row 1</td><td>Label Row 2</td><td>Lable Row 3</td></tr>";
	
	while ($row = $result_object->fetchRow()) {    
		print "<tr>";
		print "<td>" . $row[0] . " " . $row[1] . "</td>";
		print "<td>" . stripslashes($row[2]) . "</td>";
		print "<td>" . stripslashes($row[3]) . ", " . stripslashes($row[4]) . " " . stripslashes($row[5]) . "</td>";
		print "</tr>";
	}
	print "</table>";
}



//This function takes the result object from a db library function
//and parses it into the instructor table
function display_card_data_program($result_object) {
	print "<div valign=\"center\">";
	print "<div align=\"center\">";
	print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"1\" width=\"425\">";
	print "<tr>";
	//Begin count index
	$i=0;
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		if ($i == 0) {
			print "<tr>";
			print "<td colspan=\"8\">";
			print "<div align=\"center\"><span class=\"card_center_bold\">Program:&nbsp;" . stripslashes($row[3]) . "</span></div>";
			print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
			print "<tr>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Time:&nbsp;" . stripslashes($row[6]) . "</span>&nbsp;</td>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Location:&nbsp;" . stripslashes($row[7]) . "</span>&nbsp;</td>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Ability:&nbsp;" . stripslashes($row[5]) . "</span>&nbsp;</td>";
			print "</tr><tr>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Date:&nbsp;" . convert_date_display($row[2]) . "</span></td>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Day:&nbsp;" . date("l", convert_date_to_time($row[2])) . "</span></td>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Instructor:&nbsp;" . stripslashes($row[10]) . "&nbsp;" . stripslashes($row[11]) . "</span></td>";
			print "</tr></table>";
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td width=\"65%\"><span class=\"card_no_indent\">" . stripslashes($row[0]) . "&nbsp;" . stripslashes($row[1]) . "</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "</tr>";
			$i++;
		} else {
			print "<tr>";
			print "<td width=\"65%\"><span class=\"card_no_indent\">" . stripslashes($row[0]) . "&nbsp;" . stripslashes($row[1]) . "</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "</tr>";
			$i++;
		}
	}
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_equipment_history($result_object) {
	print "<div valign=\"center\">";
	print "<div align=\"center\">";
	//print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"1\" width=\"425\">";
	print "<tr>";
	//Begin count index
	$i = "none";
    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"40%\">";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		if ($i != $row[1]) {
            print "<tr><td colspan=\"4\"><br><br></td>";
			print "<tr>";
			print "<th colspan=\"3\" width=\"100%\">" . stripslashes($row[0]) . " - " . stripslashes($row[1]) . "</th>";
			print "</tr>";
			print "<tr>";
			print "<td><span class=\"card_no_indent\">" . stripslashes($row[0]) . "</span>&nbsp;</td>";
			print "<td><span class=\"card_no_indent\">" . stripslashes($row[1]) . "</span>&nbsp;</td>";
			print "<td><span class=\"card_no_indent\">" . stripslashes($row[2]) . "</span>&nbsp;</td>";
            print "<td><span class=\"card_no_indent\">" . stripslashes($row[3]) . "</span>&nbsp;</td>";
			print "</tr>";
			$i = $row[1];
		} else {
			print "<tr>";
			print "<td><span class=\"card_no_indent\">" . stripslashes($row[0]) . "</span>&nbsp;</td>";
			print "<td><span class=\"card_no_indent\">" . stripslashes($row[1]) . "</span>&nbsp;</td>";
			print "<td><span class=\"card_no_indent\">" . stripslashes($row[2]) . "</span>&nbsp;</td>";
            print "<td><span class=\"card_no_indent\">" . stripslashes($row[3]) . "</span>&nbsp;</td>";
			print "</tr>";
		}
	}
	print "</table></div>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_equipment_out($result_object) {
	print "<div valign=\"center\">";
	print "<div align=\"center\">";
	//print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"1\" width=\"425\">";
	print "<tr>";
	//Begin count index
	$i = "none";
    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"40%\">";
	while ($row = $result_object->fetchRow()) {    
		//print "id is " . $row[0] . "<br>";
		if ($i != $row[1]) {
		    if ($row[2] == "out") {
                //print "<tr><td colspan=\"4\"><br><br></td>";
	       		//print "<tr>";
		      	//print "<th colspan=\"3\" width=\"100%\">" . stripslashes($row[0]) . " - " . stripslashes($row[1]) . "</th>";
                //print "</tr>";
                print "<tr>";
                print "<th>" . stripslashes($row[0]) . "</th>";
                print "<th>" . stripslashes($row[1]) . "</th>";
                print "<th>" . stripslashes($row[2]) . "</th>";
                print "<th>" . stripslashes($row[3]) . "</th>";
                print "</tr>";
            }
			$i = $row[1];
		} else {
            //don't print any other info'
			//print "<tr>";
			//print "<td><span class=\"card_no_indent\">" . stripslashes($row[0]) . "</span>&nbsp;</td>";
			//print "<td><span class=\"card_no_indent\">" . stripslashes($row[1]) . "</span>&nbsp;</td>";
			//print "<td><span class=\"card_no_indent\">" . stripslashes($row[2]) . "</span>&nbsp;</td>";
            //print "<td><span class=\"card_no_indent\">" . stripslashes($row[3]) . "</span>&nbsp;</td>";
			//print "</tr>";
		}
	}
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_card_data_date($result_object) {
	
	//Begin count index
	$i=0;
	$k=0;
	//$temp_var = "none";

	while ($row = $result_object->fetchRow()) {
		if ($i == 0) {
			//print "</table></div>";
			//print "<br><br><br><br><br><br><br><br>";
			//if (fmod($k, 2) == 0) {
			//	print "<p style=\"page-break-before: always\">";
			//}
			//$k++;
			#print "</body></html><html><head></head><body>";
			#print "<html><head></head><body>";
			#print "<div valign=\"center\">";
			print "<div align=\"center\">";
			print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"black\" width=\"625\" class=\"card_table\">";
			#print "<tr>";
			print "<tr class=\"card_table\">";
			print "<td class=\"card_table\" colspan=\"8\">";
			//print "<div align=\"center\"><span class=\"card_center_bold\">Program:&nbsp;" . stripslashes($row[3]) . "</span></div>";
			print "<div align=\"center\"><span class=\"card_center_bold\">&nbsp;</span></div>";
			print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
			print "<tr>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Time:&nbsp;" . stripslashes($row[6]) . "</span>&nbsp;</td>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Location:&nbsp;" . stripslashes($row[7]) . "</span>&nbsp;</td>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Ability:&nbsp;" . stripslashes($row[5]) . "</span>&nbsp;</td>";
			print "</tr><tr>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Date:&nbsp;" . convert_date_display($row[2]) . "</span></td>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Day:&nbsp;" . date("l", convert_date_to_time($row[2])) . "</span></td>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Instructor:&nbsp;" . stripslashes($row[10]) . "&nbsp;" . stripslashes($row[11]) . "</span></td>";
			print "</tr></table>";
			print "</td>";
			print "</tr>";
			print "<tr class=\"card_table\">";
			print "<td class=\"card_table\" width=\"65%\"><span class=\"card_no_indent\">" . stripslashes($row[0]) . "&nbsp;" . stripslashes($row[1]) . "</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "</tr>";
			$i++;
		} else {
			print "<tr class=\"card_table\">";
			print "<td class=\"card_table\" width=\"65%\"><span class=\"card_no_indent\">" . stripslashes($row[0]) . "&nbsp;" . stripslashes($row[1]) . "</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "</tr>";
			$i++;
		}
	} 
	
	for ($j=$i; $j<=11; $j++) {
		print "<tr class=\"card_table\">";
		print "<td class=\"card_table\" width=\"65%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
		print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
		print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
		print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
		print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
		print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
		print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
		print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
		print "</tr>";
	}
			
	#print "</table></div>";
	
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_card_data_program2($result_object) {
	
	//Begin count index
	$i=0;
	$k=0;
	$temp_var = "none";
	while ($row = $result_object->fetchRow()) {
		//print $i . "<br>";
		if ($temp_var != stripslashes($row[8])) {
			for ($j=$i; $j<=11; $j++) {
				print "<tr class=\"card_table\">";
				print "<td class=\"card_table\" width=\"65%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
				print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
				print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
				print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
				print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
				print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
				print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
				print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
				print "</tr>";
			}
			$i=0;
			$temp_var = stripslashes($row[8]);
			//print $temp_var . "<br>";
		}
		//print "id is " . $row[0] . "<br>";
		if ($i == 0) {
			print "</table></div>";
			print "<br><br><br><br><br><br><br><br>";
			if (fmod($k, 2) == 0) {
				print "<p style=\"page-break-before: always\">";
			}
			$k++;
			#print "</body></html><html><head></head><body>";
			#print "<html><head></head><body>";
			#print "<div valign=\"center\">";
			print "<div align=\"center\">";
			print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"black\" width=\"625\" class=\"card_table\">";
			#print "<tr>";
			print "<tr class=\"card_table\">";
			print "<td class=\"card_table\" colspan=\"8\">";
			print "<div align=\"center\"><span class=\"card_center_bold\">Program:&nbsp;" . stripslashes($row[3]) . "</span></div>";
			print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
			print "<tr>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Time:&nbsp;" . stripslashes($row[6]) . "</span>&nbsp;</td>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Location:&nbsp;" . stripslashes($row[7]) . "</span>&nbsp;</td>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Ability:&nbsp;" . stripslashes($row[5]) . "</span>&nbsp;</td>";
			print "</tr><tr>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Date:&nbsp;" . convert_date_display($row[2]) . "</span></td>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Day:&nbsp;" . date("l", convert_date_to_time($row[2])) . "</span></td>";
			print "<td width=\"33%\"><span class=\"card_no_indent\">Instructor:&nbsp;" . stripslashes($row[10]) . "&nbsp;" . stripslashes($row[11]) . "</span></td>";
			print "</tr></table>";
			print "</td>";
			print "</tr>";
			print "<tr class=\"card_table\">";
			print "<td class=\"card_table\" width=\"65%\"><span class=\"card_no_indent\">" . stripslashes($row[0]) . "&nbsp;" . stripslashes($row[1]) . "</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "</tr>";
			$i++;
		} else {
			print "<tr class=\"card_table\">";
			print "<td class=\"card_table\" width=\"65%\"><span class=\"card_no_indent\">" . stripslashes($row[0]) . "&nbsp;" . stripslashes($row[1]) . "</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "<td class=\"card_table\" width=\"5%\"><span class=\"card_no_indent\">&nbsp;</span></td>";
			print "</tr>";
			$i++;
		}
	} 
	#print "</table></div>";
	
}



//This function takes the result object from a db library function
//and parses it into the instructor table
function display_program_availability_data_by_date($programs_array, $levels_array, $program_open_seats_array, $class_begin_date, $form_type) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>". CATEGORY2_PLURAL . "</span></td>";
	print "<td><span class=center_bold>" . ABILITY_PLURAL . "</span></td>";
	print "<td><span class=center_bold>Openings</span></td>";
	print "<td><span class=center_bold>Times (click to register)</span></td>";
	print "</tr>";
	for ($k=0; $k<count($programs_array); $k++) {
		if ($program_open_seats_array[$k] > 0) {
			print "<tr>";
			print "<td><span class=no_indent>" . get_one_data("classes", "class_name", "id", $programs_array[$k], "number") . "</span></td>";
			print "<td><span class=no_indent>" . get_one_data("levels", "level_name", "id", $levels_array[$k], "number") . "</span></td>";
			print "<td><span class=no_indent>" . $program_open_seats_array[$k] . "</span></td>";
			
			//$table_name_temp = "class_instance";
			//$field_names_temp = array("class_id", "class_time", "level_id");
			//$id_field_1_temp = "class_id";
			//$id_value_1_temp = $programs_array[$k];
			//$id_data_type_1_temp = "number";
			//$id_field_2_temp = "level_id";
			//$id_value_2_temp = $levels_array[$k];
			//$id_data_type_2_temp = "number";
			//$res_temp = view_data_where_double_distinct($table_name_temp, $field_names_temp, $id_field_1_temp, $id_value_1_temp, $id_data_type_1_temp, $id_field_2_temp, $id_value_2_temp, $id_data_type_2_temp);
			
			$sql_string_temp = "select distinct class_time, class_time from class_instance where class_id=" . $programs_array[$k];
			$sql_string_temp .= " and level_id=" . $levels_array[$k];
			$sql_string_temp .= " and class_begin_date='" . $class_begin_date . "'";
			$sql_string_temp .= " and open_seats>0";
			//print $sql_string_temp . "<br>";
			$res_temp = view_data_generic_sql($sql_string_temp);
			
			//print "<td><span class=no_indent><a href=\"customer_info.php?class_date=" . $_POST[''] . "&class_id=" . $programs_array[$k] . "&level_id=" . $levels_array[$k] . "\">Register</a></span></td>";
			print "<td><span class=no_indent>";
			display_program_times($res_temp, $programs_array[$k], $levels_array[$k], $form_type);
			print "</span></td>";
			print "</tr>";
		} else {
			//print "<td colspan=3><span class=center_bold>No other programs available at on this date.</span></td>";
		}
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_program_availability_data_by_program($class_id, $levels_array, $program_open_seats_array, $class_begin_date, $form_type) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	//print "<td><span class=center_bold>" . CATEGORY2_PLURAL . "</span></td>";
	print "<td><span class=center_bold>Ability Levels</span></td>";
	//print "<td><span class=center_bold>Openings</span></td>";
	print "<td><span class=center_bold>Times (click to register)</span></td>";
	print "</tr>";
	for ($k=0; $k<count($levels_array); $k++) {
		if ($program_open_seats_array[$k] > 0) {
			print "<tr>";
			//print "<td><span class=no_indent>" . get_one_data("classes", "class_name", "id", $programs_array[$k], "number") . "</span></td>";
			print "<td><span class=no_indent>" . get_one_data("levels", "level_name", "id", $levels_array[$k], "number") . "</span></td>";
			//print "<td><span class=no_indent>" . $program_open_seats_array[$k] . "</span></td>";
			
			$sql_string_temp = "select distinct class_time, class_time from class_instance where class_id=" . $class_id;
			$sql_string_temp .= " and level_id=" . $levels_array[$k];
			$sql_string_temp .= " and class_begin_date='" . $class_begin_date . "'";
			$sql_string_temp .= " and open_seats>0";
			//print $sql_string_temp . "<br>";
			$res_temp = view_data_generic_sql($sql_string_temp);
			
			print "<td><span class=no_indent>";
			//Need to convert the format of the date here because the date is
			//defined in the form as a database-friendly value but only need to do this
			//on the first run through; it carries over to future
			if ($k == 0) {
				$_POST['class_begin_date'] = convert_date_display($_POST['class_begin_date']);
			}
			display_program_times($res_temp, $class_id, $levels_array[$k], $form_type);
			print "</span></td>";
			print "</tr>";
		} else {
			//print "<td colspan=3><span class=center_bold>No other programs available at on this date.</span></td>";
		}
	}
	
	print "</table></div>";
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_change_program_availability_data_by_program($class_id, $levels_array, $program_open_seats_array, $class_begin_date, $form_type) {
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	//print "<td><span class=center_bold>Programs</span></td>";
	print "<td><span class=center_bold>Ability Levels</span></td>";
	print "<td><span class=center_bold>Openings</span></td>";
	print "<td><span class=center_bold>Times (click to register)</span></td>";
	print "</tr>";
	for ($k=0; $k<count($levels_array); $k++) {
		if ($program_open_seats_array[$k] > 0) {
			print "<tr>";
			//print "<td><span class=no_indent>" . get_one_data("classes", "class_name", "id", $programs_array[$k], "number") . "</span></td>";
			print "<td><span class=no_indent>" . get_one_data("levels", "level_name", "id", $levels_array[$k], "number") . "</span></td>";
			print "<td><span class=no_indent>" . $program_open_seats_array[$k] . "</span></td>";
			
			$sql_string_temp = "select distinct class_time, class_time from class_instance where class_id=" . $class_id;
			$sql_string_temp .= " and level_id=" . $levels_array[$k];
			$sql_string_temp .= " and class_begin_date='" . $class_begin_date . "'";
			$sql_string_temp .= " and open_seats>0";
			//print $sql_string_temp . "<br>";
			$res_temp = view_data_generic_sql($sql_string_temp);
			
			print "<td><span class=no_indent>";
			//Need to convert the format of the date here because the date is
			//defined in the form as a database-friendly value
			$_POST['class_begin_date'] = convert_date_display($_POST['class_begin_date']);
			display_program_times($res_temp, $class_id, $levels_array[$k], $form_type);
			print "</span></td>";
			print "</tr>";
		} else {
			//print "<td colspan=3><span class=center_bold>No other programs available at on this date.</span></td>";
		}
	}
	
	print "</table></div>";
}

function display_sections_form($the_time) {
    //$the_time = date('g');
    //$the_time = "9";
	//while ($row = $result_object->fetchRow()) {
	   //$row[0] = $temp_prod_id;
       //print $temp_prod_id . "<br>";
       
       //get applicable level ids
       //$res2 = get_levels_ids($the_time, $temp_prod_id);
       //$res2 = get_level_ids();
       
       //get sections
       //while ($row2 = $res2->fetchRow()) {
            //$sql_string_temp = "select id, section_name, max_seats, seats_taken from sections where section_time like '%" . $the_time . "%'";
            //$sql_string_temp .= " and section_status = 'open' and product_id=" . $row[0];
            $sql_string_temp = "select sections.id, sections.section_name, sections.max_seats, sections.seats_taken, levels.level_name, locations.location_name, products.product_cost, products.rental_fee from sections, levels, locations, products where sections.level_id=levels.id and sections.location_id=locations.id and sections.product_id=products.id";
            //$sql_string_temp .= " and sections.section_date ='" . date('Y-m-d') . "' and sections.section_time like '%" . $the_time . "%' and sections.section_status = 'open' and sections.product_id=" . $row[0];
            $sql_string_temp .= " and sections.section_date ='" . date('Y-m-d') . "' and sections.section_time_id =" . $the_time . " and sections.section_status = 'open'";
            //$sql_string_temp .= " and sections.product_id=" . $row[0] . " and sections.level_id=" . $row[1];
            //$sql_string_temp .= " and sections.section_date ='2012-08-30' and sections.section_time like '%" . $the_time . "%' and sections.section_status = 'open' and sections.product_id=" . $row[0];
            $sql_string_temp .= " order by sections.section_name, locations.location_name";
            //print $sql_string_temp . "<br>";
        
            $res_temp = view_data_generic_sql($sql_string_temp);
            if ($res_temp->numRows() > 0) {
                display_sections_available($res_temp);
            }  //else {
            //print "<p>No Sections Available At This Time</p>";
        //}
       
	//}
	
}


function display_sections_form_product_id($product_id, $the_time, $the_level) {
    //$the_time = date('g');
    //$the_time = "9";
    //get applicable level ids
    //$res2 = get_levels_ids($the_time, $product_id);
    //$res2 = get_level_ids();
	//while ($row8 = $res2->fetchRow()) {    
		//$sql_string_temp = "select id, section_name, max_seats, seats_taken from sections where section_time like '%" . $the_time . "%'";
        //$sql_string_temp .= " and section_status = 'open' and product_id=" . $row[0];
        $sql_string_temp2 = "select sections.id, sections.section_name, sections.max_seats, sections.seats_taken, levels.level_name, locations.location_name, products.product_cost, products.rental_fee from sections, levels, locations, products, section_ages where sections.level_id=levels.id and sections.location_id=locations.id and sections.product_id=products.id and sections.section_age_id=section_ages.id";
        //$sql_string_temp2 = "select sections.id, sections.section_name, sections.max_seats, sections.seats_taken, levels.level_name, locations.location_name from sections, levels, locations, products, section_ages where sections.level_id=levels.id and sections.location_id=locations.id and sections.product_id=products.id and sections.section_age_id=section_ages.id";
        //$sql_string_temp .= " and sections.section_date ='" . date('Y-m-d') . "' and sections.section_time like '%" . $the_time . "%' and sections.section_status = 'open' and sections.product_id=" . $row[0];
        //$sql_string_temp .= " and sections.section_date ='" . date('Y-m-d') . "' and sections.section_time_id =" . $the_time . " and sections.section_status = 'open' and sections.product_id=" . $product_id . " and sections.level_id=" . $the_level;
        $sql_string_temp2 .= " and sections.section_status = 'open' and sections.section_date ='" . date('Y-m-d') ."' and sections.product_id=" . $product_id . " and sections.section_time_id=" . $the_time . " and sections.level_id=" . $the_level;
        //$sql_string_temp .= " and sections.section_date ='2012-08-30' and sections.section_time like '%" . $the_time . "%' and sections.section_status = 'open' and sections.product_id=" . $row[0];
        $sql_string_temp2 .= " order by section_ages.age_order, sections.section_name, levels.level_name, locations.location_name";
        //print $sql_string_temp2 . "<br>";
        
        $res_temp2 = view_data_generic_sql($sql_string_temp2);
        if ($res_temp2->numRows() > 0) {
            display_sections_available($res_temp2);
        }  else {
            print "<option>No Sections Available At This Time</option>";
        }
	//}
	
}

function display_sections_available($result_object) {
	//print "<table cellpadding=0 cellspacing=0 border=0>";
    $temp_section_name = "none";
    $temp_section_level = "none";
	
	while ($row4 = $result_object->fetchRow()) {
        if ($row4[3] < $row4[2]) {
		  //print "<tr>";
		  //print "<div style=\"font-size:48 px\"><input class=\"bigButton\" type=\"radio\" name=\"section_id\" value=\"" . $row[0] . "\">" . $row[1] . " - " . $row[5] . " (" . $row[3] . " seats taken)</div><br /><br />";
		  ////print "<div style=\"font-size:48 px\"><input class=\"bigButton\" type=\"radio\" name=\"section_id\" value=\"" . $row4[0] . "\">" . $row4[1] . " - " . $row4[5] . " (" . $row4[4] . ")" . "</div><br /><br />";
		  //print "<td>" . stripslashes($row[2]) . "</td>";
		  //print "<td>" . stripslashes($row[3]) . "</td>";
		  //print "</tr>";
          if (($temp_section_name == $row4[1]) && ($temp_section_level == $row4[4])) {
            //do not show
          } else {
            print "<option value=\"" . $row4[0] . "\">" . $row4[1] . " - " . $row4[5] . " (" . $row4[4] . ")" . "</option>";  
            
            //print "<div style=\"font-size:42 px\"><input class=\"bigButton\" type=\"radio\" name=\"section_id\" value=\"" . $row4[0] . "\" onClick=\"getCost('" . $row4[0] . "');\">" . $row4[1] . " - " . $row4[5] . " (" . $row4[4] . ")" . "</div><br /><br />";  
            //print "<input type=\"hidden\" name=\"" . $row4[0] . "_cost\" id=\"" . $row4[0] . "_cost\" value=\"" . $row4[6] . "\">";
            //print "<input type=\"hidden\" name=\"" . $row4[0] . "_rent\" id=\"" . $row4[0] . "_rent\" value=\"" . $row4[7] . "\">";
            $temp_section_level = $row4[4];
            //print $temp_section_level . "<br>";
            $temp_section_name = $row4[1]; 
            //print $temp_section_name . "<br>";
          }
        }
        //print just one
        //break;
	}
    
	//print "</table>";
}

function display_sections_available_OLD($result_object) {
	//print "<table cellpadding=0 cellspacing=0 border=0>";
    $temp_section_name = "none";
    $temp_section_level = "none";
	
	while ($row4 = $result_object->fetchRow()) {
        if ($row4[3] < $row4[2]) {
		  //print "<tr>";
		  //print "<div style=\"font-size:48 px\"><input class=\"bigButton\" type=\"radio\" name=\"section_id\" value=\"" . $row[0] . "\">" . $row[1] . " - " . $row[5] . " (" . $row[3] . " seats taken)</div><br /><br />";
		  ////print "<div style=\"font-size:48 px\"><input class=\"bigButton\" type=\"radio\" name=\"section_id\" value=\"" . $row4[0] . "\">" . $row4[1] . " - " . $row4[5] . " (" . $row4[4] . ")" . "</div><br /><br />";
		  //print "<td>" . stripslashes($row[2]) . "</td>";
		  //print "<td>" . stripslashes($row[3]) . "</td>";
		  //print "</tr>";
          if (($temp_section_name == $row4[1]) && ($temp_section_level == $row4[4])) {
            //do not show
          } else {
            print "<div style=\"font-size:42 px\"><input class=\"bigButton\" type=\"radio\" name=\"section_id\" value=\"" . $row4[0] . "\" onClick=\"getCost('" . $row4[0] . "');\">" . $row4[1] . " - " . $row4[5] . " (" . $row4[4] . ")" . "</div><br /><br />";  
            print "<input type=\"hidden\" name=\"" . $row4[0] . "_cost\" id=\"" . $row4[0] . "_cost\" value=\"" . $row4[6] . "\">";
            print "<input type=\"hidden\" name=\"" . $row4[0] . "_rent\" id=\"" . $row4[0] . "_rent\" value=\"" . $row4[7] . "\">";
            $temp_section_level = $row4[4];
            //print $temp_section_level . "<br>";
            $temp_section_name = $row4[1]; 
            //print $temp_section_name . "<br>";
          }
        }
        //print just one
        //break;
	}
    
	//print "</table>";
}

function display_sections_monitor_OLD($result_object) {
	//print "<table cellpadding=0 cellspacing=0 border=0>";
    $temp_section_name = "none";
    $temp_section_level = "none";
	
	while ($row4 = $result_object->fetchRow()) {
        if ($row4[3] < $row4[2]) {
		  //print "<tr>";
		  //print "<div style=\"font-size:48 px\"><input class=\"bigButton\" type=\"radio\" name=\"section_id\" value=\"" . $row[0] . "\">" . $row[1] . " - " . $row[5] . " (" . $row[3] . " seats taken)</div><br /><br />";
		  ////print "<div style=\"font-size:48 px\"><input class=\"bigButton\" type=\"radio\" name=\"section_id\" value=\"" . $row4[0] . "\">" . $row4[1] . " - " . $row4[5] . " (" . $row4[4] . ")" . "</div><br /><br />";
		  //print "<td>" . stripslashes($row[2]) . "</td>";
		  //print "<td>" . stripslashes($row[3]) . "</td>";
		  //print "</tr>";
          //if (($temp_section_name == $row4[1]) && ($temp_section_level == $row4[4])) {
            //do not show
          //} else {
            print "<input type=\"radio\" name=\"section_id\" value=\"" . $row4[0] . "\">" . $row4[1] . " - " . $row4[5] . " (" . $row4[4] . ")" . "<br /><br />";  
            //$temp_section_level = $row4[4];
            //print $temp_section_level . "<br>";
            //$temp_section_name = $row4[1]; 
            //print $temp_section_name . "<br>";
          //}
        }
        //print just one
        //break;
	}
    
	//print "</table>";
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_sections_monitor($result_object) {
    $output = "";
    $temp_section_name = "none";
    $temp_section_level = "none";
    $temp_section_age = "none";
    $temp_section_location = "none";
    
    $temp_max_seats = 0;
    $temp_seats_taken = 0;
    $temp_seats_sum = 0;
    $temp_available_seats_sum = 0;
    $temp_location_count = 0;
    $display_sum = false;
    
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Level</span></td>";
    print "<td><span class=center_bold>Age</span></td>";
    print "<td><span class=center_bold>Location</span></td>";
    print "<td><span class=center_bold>Section</span></td>";
	print "<td><span class=center_bold>Seats Available</span></td>";
	print "<td><span class=center_bold>Action</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {
		//print "id is " . $row[0] . "<br>";
                //$temp_max_seats = get_total_max_seats($row[0], $row[3], $row[4]);
                //$temp_seats_taken = get_total_seats_taken($row[0], $row[3], $row[4]);
                //$temp_available_seats = $temp_max_seats - $temp_seats_taken;
				$temp_available_seats = $row[5] - $row[6];
                //$temp_available_seats_sum = $temp_available_seats_sum + $temp_available_seats;
                
                //if (($temp_section_level != $row[1]) && ($temp_section_age != $row[7]) && ($temp_section_location != $row[8])) {
                //if ($temp_section_location == $row[8]) {
                    //do nothing
                //} else {
                    //$temp_seats_sum = $temp_seats_sum + $temp_available_seats;
                //if ($temp_section_age == $row[7]) {
                    //$output .= "<tr bgcolor=gray><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Total Seats:</td><td>" . $temp_available_seats_sum . "</td></tr>";
                    //$output .= "<tr bgcolor=gray><td>" . $row[1] . "</td><td>" . $row[7] . "</td><td>" . $row[8] . "</td><td>&nbsp;</td><td>Total Seats:</td><td>" . $temp_available_seats_sum . "</td></tr>";
                    //$temp_available_seats_sum = 0;
                //}

                
                
                $output = "<tr>";
                if ($temp_available_seats <= 2) {
                    $output = "<tr bgcolor=yellow>";
                }
                
                if ($temp_available_seats == 0) {
                    $output = "<tr bgcolor=red>";
                }
                if ($temp_section_level == $row[1]) {
                    //$output .= "<td><span class=no_indent>&nbsp;</span></td>";   ///level
                    $output .= "<td valign=top>&nbsp;</td>";   ///level
                } else {
                    //$output .= "<td><span class=no_indent>" . $row[1] . "</span></td>";   ///level
                    $output .= "<td valign=top>" . $row[1] . "</td>";   ///level
                    //$output .= "<td>" . $row[1] . "(" . $temp_available_seats_sum . ")</td>";   ///level
                    $temp_section_level = $row[1];
                    //$temp_available_seats_sum = 0;
                }                             
                if ($temp_section_age == $row[7]) {
                    $output .= "<td valign=top><span class=no_indent>&nbsp;</span></td>";   ///age
                } else {
                    //$output .= "<td><span class=no_indent>" . $row[7] . "</span></td>";   ///age
                    $output .= "<td valign=top>" . $row[7] . "</td>";   ///age
                    //$output .= "<td>" . $row[7] . "(" . $temp_available_seats_sum . ")</td>";   ///age
                    //$output .= "<td colspan=5>Total: " . $temp_available_seats_sum . "</td></tr><tr><td></td><td>" . $row[7] . "</td>";   ///age
                    $temp_section_age = $row[7];
                    //$temp_available_seats_sum = 0;
                    //$display_sum = true;
                }
                if ($temp_section_location == $row[8]) {
                    $output .= "<td valign=top><span class=no_indent>&nbsp;</span></td>";   ///location
                    $temp_available_seats_sum = $temp_available_seats_sum + $temp_available_seats;
                    //$temp_available_seats_sum_temp = $temp_available_seats_sum;
                } else {
                    //$output .= "<td><span class=no_indent>" . $row[8] . "</span></td>";   ///location
                    $output .= "<td valign=top>" . $row[8] . "</td>";   ///location
                    //$output .= "<td>" . $row[8] . "(" . $temp_available_seats_sum . ")</td>";   ///location
                    $temp_section_location = $row[8];
                    $temp_available_seats_sum_temp = $temp_available_seats_sum;
                    $temp_available_seats_sum = 0;
                    $temp_available_seats_sum = $temp_available_seats_sum + $temp_available_seats;
                    //$display_sum = true;
                }
                
                //$output .= "<td><span class=no_indent>" . $row[0] . "</span></td>";   ///section
                //if ($temp_available_seats_sum < $temp_available_seats_sum_temp) {
                    $output .= "<td valign=top>" . $row[0] . "</td>";   ///section
                //} else {
                //    $output .= "<td valign=top>" . $row[0] . "<br><strong>(Total: " . $temp_available_seats_sum . ")</strong></td>";   ///section
                //}
                //$output .= "<td><span class=no_indent>" . $row[1] . "</span></td>"; 
                        
                //$output .= "<td><span class=no_indent>" . $temp_available_seats . "</span></td>";
                $output .= "<td valign=top>" . $temp_available_seats . "</td>";
                //$output .= "<td valign=top><a href=\"clone.php?prod_id=" . $row[2] . "&level_id=" . $row[3] . "&section_name=" . urlencode($row[0]) . "&time_id=" . $row[4] . "&age_id=" . $row[10] . "\">Clone</a>";
                $output .= "<td valign=top><a href=\"clone.php?prod_id=" . $row[2] . "&level_id=" . $row[3] . "&location_id=" . $row[9] . "&section_name=" . urlencode($row[0]) . "&time_id=" . $row[4] . "&age_id=" . $row[10] . "\">Clone</a>";
                //$output .= "<td><a href=\"clone.php?prod_id=" . $temp_prod_id . "&level_id=" . $temp_level_id . "&section_name=" . $temp_section_name . "&time_id=" . $temp_time_id . "\">Clone</a>";
                $output .= "</tr>";
                
                
                if ($temp_section_level == $row[1]) {
                    if (($temp_section_age == $row[7])) {
                        if ($temp_section_location == $row[8]) {
                
                //if ($temp_section_level == $row[1]) {
                //if (($temp_section_level == $row[1]) && ($temp_section_age != $row[7]) && ($temp_section_location == $row[8]) && ($temp_section_name == $row[0])) {
                //if (($temp_section_level == $row[1]) && ($temp_section_age == $row[7]) && ($temp_section_location != $row[8])) {
                //if (($temp_section_age == $row[7]) && ($temp_section_location == $row[8]) && ($temp_section_name != $row[0])) {
                            //$temp_available_seats_sum = 0;
                        } else {
                            //$temp_available_seats_sum = 0;
                            //$temp_available_seats_sum = $temp_available_seats;
                        }
                    }
                }
                
                //$temp_available_seats_sum = $temp_available_seats_sum + $temp_available_seats;
                //if (($temp_section_level == $row[1]) && ($temp_section_age != $row[7]) && ($temp_section_location != $row[8])) {
                //if (($temp_section_age != $row[7]) && ($temp_section_location != $row[8])) {
                //if ($temp_available_seats_sum < $temp_available_seats_sum_temp) {
                //if ($temp_section_location == $row[8]) {
                    //do nothing
                //} else {
                    //$temp_seats_sum = $temp_seats_sum + $temp_available_seats;
                //if ($temp_section_age == $row[7]) {
                    //$output .= "<tr bgcolor=gray><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Total Seats:</td><td>" . $temp_available_seats_sum . "</td></tr>";
                    //$output .= "<tr bgcolor=gray><td>" . $row[1] . "</td><td>" . $row[7] . "</td><td>" . $row[8] . "</td><td>&nbsp;</td><td>Total Seats:</td><td>" . $temp_available_seats_sum . "</td></tr>";
                    //$temp_available_seats_sum = 0;
                //}
                
                
                
                print $output;
            
	}
	print "</table></div>";
}

function display_signs_monitor($result_object) {
    $output = "";
    $temp_section_name = "none";
    $temp_section_level = "none";
    $temp_section_age = "none";
    $temp_section_location = "none";
    
    $temp_max_seats = 0;
    $temp_seats_taken = 0;
    $temp_seats_sum = 0;
    $temp_available_seats_sum = 0;
    $temp_location_count = 0;
    $display_sum = false;
    
	print "<div align=center><table cellpadding=5 cellspacing=0 border=0>";
	print "<tr>";
	print "<td><span class=center_bold>Level</span></td>";
    print "<td><span class=center_bold>Age</span></td>";
    print "<td><span class=center_bold>Location</span></td>";
    //print "<td><span class=center_bold>Section</span></td>";
	print "<td><span class=center_bold>Students</span></td>";
	print "<td><span class=center_bold>Instructor</span></td>";
	print "</tr>";
	while ($row = $result_object->fetchRow()) {
		//print "id is " . $row[0] . "<br>";
        //$temp_max_seats = get_total_max_seats($row[0], $row[3], $row[4]);
        //$temp_seats_taken = get_total_seats_taken($row[0], $row[3], $row[4]);
        //$temp_available_seats = $temp_max_seats - $temp_seats_taken;
		//$temp_available_seats = $row[5] - $row[6];
        //if (($temp_section_level == $row[1]) || ($temp_section_level == "none")) {
            //if (($temp_section_age == $row[7]) || ($temp_section_age == "none")) { 
                if (($temp_section_location == $row[8]) || ($temp_section_location == "none")) {
                    //$temp_available_se()ats_sum = 0;
                    $temp_section_location = $row[8];
                    $temp_section_age = $row[7];
                    $temp_section_level = $row[1];
                    $temp_seats_taken = $temp_seats_taken + $row[6];
                } else {
                    //if ($temp_seats_taken > 0) {
                        //$temp_available_seats_sum = 0;
                        //$temp_available_seats_sum = $temp_available_seats;
                        $output = "<tr>";
                        $output .= "<td valign=top>" . $temp_section_level . "</td>";   ///level
                        $temp_section_level = $row[1];
                        $output .= "<td valign=top>" . $temp_section_age . "</td>";   ///age
                        $temp_section_age = $row[7];
                        $output .= "<td valign=top>" . $temp_section_location . "</td>";   ///location
                        $temp_section_location = $row[8];
                        //$temp_available_seats_sum_temp = $temp_available_seats_sum;
                        //$temp_available_seats_sum = 0;
                        //$temp_available_seats_sum = $temp_available_seats_sum + $temp_available_seats;
                        //$output .= "<td valign=top>" . $row[0] . "</td>";   ///section
                        $output .= "<td valign=top>" . $temp_seats_taken . "</td>";
                        //$temp_seats_taken = $row[6];
                        $output .= "<td><input type=text name=boo id=boo size=50 maxchars=50 /></td>";
                        $output .= "</tr>";
                        print $output;  
                    //}
                    $temp_seats_taken = $row[6];
                }
            //}
        //}  
/*
        $output = "<tr>";
        $output .= "<td valign=top>" . $row[1] . "</td>";   ///level
        $temp_section_level = $row[1];
        $output .= "<td valign=top>" . $row[7] . "</td>";   ///age
        $temp_section_age = $row[7];
        $output .= "<td valign=top>" . $row[8] . "</td>";   ///location
        $temp_section_location = $row[8];
        //$temp_available_seats_sum_temp = $temp_available_seats_sum;
        //$temp_available_seats_sum = 0;
        //$temp_available_seats_sum = $temp_available_seats_sum + $temp_available_seats;
        $temp_seats_taken = $temp_seats_taken + $row[6];
        $output .= "<td valign=top>" . $row[0] . "</td>";   ///section
        $output .= "<td valign=top>" . $temp_seats_taken . "</td>";
        $output .= "<td><input type=text name=boo id=boo size=50 maxchars=50 /></td>";
        $output .= "</tr>";
        print $output; 
*/      
	}
    //print the last record
    //if ($temp_seats_taken > 0) {
        $output = "<tr>";
        $output .= "<td valign=top>" . $temp_section_level . "</td>";   ///level
        $temp_section_level = $row[1];
        $output .= "<td valign=top>" . $temp_section_age . "</td>";   ///age
        $temp_section_age = $row[7];
        $output .= "<td valign=top>" . $temp_section_location . "</td>";   ///location
        $temp_section_location = $row[8];
        //$temp_available_seats_sum_temp = $temp_available_seats_sum;
        //$temp_available_seats_sum = 0;
        //$temp_available_seats_sum = $temp_available_seats_sum + $temp_available_seats;
        //$output .= "<td valign=top>" . $row[0] . "</td>";   ///section
        $output .= "<td valign=top>" . $temp_seats_taken . "</td>";
        $temp_seats_taken = $row[6];
        $output .= "<td><input type=text name=boo id=boo size=50 maxchars=50 /></td>";
        $output .= "</tr>";
        print $output;
    //}
    
	print "</table></div>";
}


function display_privates_monitor($result_object) {
    $output = "";
    $temp_max_seats = 0;
    $temp_seats_taken = 0;
	while ($row = $result_object->fetchRow()) {
        $temp_max_seats = $temp_max_seats + $row[0];
        $temp_seats_taken = $temp_seats_taken + $row[1];
	}
	print "<td>" . $temp_max_seats . "</td><td>" . $temp_seats_taken . "</td>";
}


function get_total_max_seats($location_id, $the_level_id, $the_time_id, $the_age_id) {
    $sql_string_temp2 = "select max_seats from sections where section_date ='" . date('Y-m-d') ."' and location_id=" . $location_id . " and level_id=" . $the_level_id . " and section_age_id=" . $the_age_id . " and sections.section_time_id=" . $the_time_id;
    //$sql_string_temp2 = "select sum(max_seats) from sections where section_date ='" . date('Y-m-d') ."' and location_id=" . $location_id . " and level_id=" . $the_level_id . " and section_age_id=" . $the_age_id . " and sections.section_time_id=" . $the_time_id;
    
    //$sql_string_temp2 .= " order by section_name, level_id";
    //print $sql_string_temp2 . "<br>";
    $the_result = 0;    
    $res2 = view_data_generic_sql($sql_string_temp2);
    if ($res2->numRows() > 0) {
        while ($row2 = $res2->fetchRow()) {
            $the_result = $the_result + $row2[0];
        }
    } 
	return $the_result;
}

function get_total_seats_taken($location_id, $the_level_id, $the_time_id, $the_age_id) {
    $sql_string_temp2 = "select seats_taken from sections where section_date ='" . date('Y-m-d') ."' and location_id=" . $location_id . " and level_id=" . $the_level_id . " and section_age_id=" . $the_age_id . " and sections.section_time_id=" . $the_time_id;
    //$sql_string_temp2 = "select sum(seats_taken) from sections where section_date ='" . date('Y-m-d') ."' and location_id=" . $location_id . " and level_id=" . $the_level_id . " and section_age_id=" . $the_age_id . " and sections.section_time_id=" . $the_time_id;
    //$sql_string_temp2 .= " order by section_name, level_id";
    //print $sql_string_temp2 . "<br>";
    $the_result = 0;    
    $res2 = view_data_generic_sql($sql_string_temp2);
    if ($res2->numRows() > 0) {
        while ($row2 = $res2->fetchRow()) {
            $the_result = $the_result + $row2[0];
        }
    } 
	return $the_result;
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_select($result_object) {
	while ($row = $result_object->fetchRow()) {    
		print "<option value=\"" . $row[0] . "\">";
		print stripslashes($row[1]) . "</option>";
	}
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_select_selected($result_object, $selected_value) {
	while ($row = $result_object->fetchRow()) {    
		print "<option value=\"" . $row[0];
		if ($row[0] == $selected_value) {
			print "\" selected>";
		} else {
			print "\">";
		}
		print stripslashes($row[1]) . "</option>";
	}
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function display_program_times($result_object, $program_id, $level_id, $form_type) {
	$l = 0;
	while ($row = $result_object->fetchRow()) {    
		if ($l == 0) {
			print "<a href=\"customer_info.php?class_begin_date=" . $_POST['class_begin_date'] . "&class_id=" . $program_id . "&level_id=" . $level_id;
			print "&form_type=" . $form_type . "&class_time=" . urlencode($row[1]) . "\">" . $row[1] . "</a>";
			$l++;
		} else {
			//removed this because Neil did not want customer to choose specific classes
			//wanted to offer the customer only one class choice at a time - GFS 09/21/07
			//print ", <a href=\"customer_info.php?class_begin_date=" . $_POST['class_begin_date'] . "&class_id=" . $program_id . "&level_id=" . $level_id;
			//print "&form_type=" . $form_type . "&class_time=" . urlencode($row[1]) . "\">" . $row[1] . "</a>";
			$l++;
		}
	}
}

function get_number_of_out_equipment($the_date) {
    
    $sql_string2 = "select distinct equipment1_id from transactions where transaction_date = '" . $the_date . "'";
     //put into an array
    //$id_array = get_row_data_2_array_generic_sql($sql_string2);
    $res2 = view_data_generic_sql($sql_string2);
    $id_array = generate_array($res2);
    //display_array($id_array);
    
    //get the max id for each array element
    $j = 0;
    foreach ($id_array as $the_value) {
        $sql_string3 = "select max(id) from transactions where equipment1_id = " . $the_value . " and transaction_date = '" . $the_date . "'";
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
    
    return $l;
}

//This function takes the result object from a db library function
//and parses it into the instructor table
function generate_array($result_object) {
    $i = 0;
	while ($row = $result_object->fetchRow()) {    
		$result_array[$i] = $row[0];
        $i++;
	}
    
    return $result_array;
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_select_date($result_object) {
	while ($row = $result_object->fetchRow()) {    
		print "<option value=" . stripslashes($row[0]) . ">";
		print convert_date_display($row[1]) . "</option>";
	}
}


//This function takes the result object from a db library function
//and parses it into the instructor table
function display_select_date_selected($result_object, $selected_value) {
	while ($row = $result_object->fetchRow()) {    
		print "<option value=" . stripslashes($row[0]);
		if ($row[0] == $selected_value) {
			print " selected>";
		} else {
			print ">";
		}
		print convert_date_display($row[1]) . "</option>";
	}
}

//This function takes the result object returned by the database functions
//and returns the single row of data in an array called $row[]
function instructor_data_2_form($result_object) {
	$row = $result_object->fetchRow();
	return $row;
}

function states_select($selected_value, $state_names, $state_acronyms) {
	for ($i = 0; $i < count($state_names); $i++) { 
		if ($selected_value == $state_acronyms[$i]) {
			print "<option value=\"" . $state_acronyms[$i] . "\" selected>" . $state_names[$i] . "</option>";
		} else {
			print "<option value=\"" . $state_acronyms[$i] . "\">" . $state_names[$i] . "</option>";
		}
	}
}

function display_array($the_array) {
	foreach($the_array as $value) {
		print $value . "<br>";
	}
}

function sum_array($the_array) {
	$the_sum = 0;
	foreach($the_array as $value) {
		$the_sum = $the_sum + $value;
	}
	return $the_sum;
}

function clean_phone($the_phone) {
	$trans_array = array("(" => "", ")" => "", " " => "", "-" => "");
	//print "the phone number is " . $the_phone. "<br>";
	$translated_phone = strtr(trim($the_phone), $trans_array);
	//print "the first translated phone number is " . trim($translated_phone) . "<br>";
	return $translated_phone;
}


function clean_string($the_string) {
	$trans_array = array("'" => "`", "\\" => "");
	//print "the string is " . $the_string. "<br>";
	$translated_string = strtr(trim($the_string), $trans_array);
	//print "the first translated string is " . trim($translated_string) . "<br>";
	return $translated_string;
}

?>