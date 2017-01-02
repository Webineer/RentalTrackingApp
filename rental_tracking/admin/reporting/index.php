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
    
    //Get name of instructor
 /*
    if ($_GET['rowID']) {
        $sql_string8 = "select firstname, lastname from instructors where id=" . $_GET['rowID'];
        //print $_GET['rowID'] . "<br>";
    } else {
        $sql_string8 = "select firstname, lastname from instructors where id=" . $_POST['instructor_id'];
        //print $_POST['instructor_id'] . "<br>";
    }
    //print $sql_string8 . "<br>";
    $instructor_info = get_one_row_data_array_generic_sql($sql_string8);
    list($first_name, $last_name) = $instructor_info;
 */
 
?>
<script type="text/javascript">
    var my_image = new Image();
    my_image.src = '/instructors/images/avatar-black.gif';
</script>

<script>
$(document).ready(function(){
       
    //var rotation = function (){
    //    $("#progress_img").rotate({
    //        angle:0, 
    //        animateTo:360, 
    //        callback: rotation,
    //        easing: function (x,t,b,c,d){        // t: current time, b: begInnIng value, c: change In value, d: duration
    //            return c*(t/d)+b;
    //        }
    //    });
    //}
    //rotation();
    //this one works
    //$( "button" ).click(function() {
    //    var pb = document.getElementById("progress_gif");
    //    pb.innerHTML = '<img id="progress_img" src="/instructors/images/avatar-black.gif" />';
    //    pb.style.display = 'inline';
    //    //$("#progress_gif").show();
    //    $("#profilesForm").hide();
    //    //rotation();
    //});
    
    //$(function() {
    //  $('#progress_img').rotate();
    //  var angle = 0;
    //  setInterval(function() {
    //        angle = 60 - angle;
    //        $('#progress_img').rotate({animateTo: angle});
    //  }, 1000); // Every one second
    //});

    
});

</script>
<h1>Instructor Management</h1>
<p>To run an individual instructor activity report, please click <a href="instructor_assignment_report7.php">here</a>.</p>
<h2>Reports</h2>

<!-- button id="test">Hi</button -->
<?php
    //if ($_POST['begin_date']) {
    //    $my_date_array = 0;
    //    
    //    print $_POST['begin_date'] . " and " . $_POST['end_date'] . "<br>";
    //      
    //    $my_date_array = createDateRangeArray(convert_date_input($_POST['begin_date']), convert_date_input($_POST['end_date']));
    //    
    //    display_array($my_date_array);
    //}
 
	require("../../lib/forms/instructors_reports_form.php");
?>

<div name="progress_gif" id="progress_gif" style="position: relative; top: -50px; left: 30px; display: none;">
    <!-- img id="progress_img" src="/instructors/images/avatar-black.gif" / -->
</div>


<?php
	require_once("../../includes/admin_footer.php");
?>