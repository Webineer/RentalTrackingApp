<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<?php
	require_once("../../includes/config.php");
	require_once("../includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	//require_once("../includes/security.php");
	//require_once("../../includes/admin_header.php");
	//require_once("../../includes/admin_top_nav.php");
	require_once("../../lib/_lib_database.php");
	require_once("../../lib/_lib_data_display.php");
	require_once($pear_db_path);
?>

<html>
<head>
	<title>Reservation Administration</title>
    <meta http-equiv="refresh" content="5">
	<link rel=stylesheet href="/registrar/includes/admin_app.css" TYPE="text/css">
	<script language="JavaScript" src="/registrar/includes/calendar_us.js"></script>
	<link rel="stylesheet" href="/registrar/includes/calendar.css" />
</head>
<BODY BGCOLOR=FFFFFF>
<DIV ALIGN="CENTER">

<TABLE CELLPADDING="3" CELLSPACING="0" BORDER="0">
<TR ALIGN=center>

	<TD>	
		<IMG SRC="/reservation/images/ski1vsm.gif" WIDTH="59" HEIGHT="100" ALT="Skier">&nbsp;<IMG SRC="/reservation/images/bradfordvsm.jpg" BORDER="0" WIDTH="150" HEIGHT="115" ALT="Ski Bradford Logo">&nbsp;<IMG SRC="/reservation/images/board1vsm.gif" WIDTH="52" HEIGHT="98" ALT="Snowboarder"><BR><BR>
		<FONT FACE="Arial" COLOR="green" SIZE="4"><B><I>Ski Bradford Reservation Administration</I></B></FONT><BR><BR>
	</TD>
                
</TR>

<TR>
	<TD VALIGN="top">

<p>&nbsp;</p>
<!--Begin Page content-->

<h1>Section Management - Monitor</h1>

<?php
	$table_name = "section_members";
	$field_names = array("id", "section_id", "reservation_id", "create_date");
	$res = view_data($table_name, $field_names);
	//$res = view_data_join($table_names, $field_names, $join_field_1, $join_field_2);
	//print $res->numRows() . " is the number<br>";
	if ($res->numRows() > 0) {
		display_section_data($res);
	} else {
		print "<p class=bold >There are no sections entered in the application at this time.</p>";
	}
?>


<?php
	//require_once("../../includes/admin_footer.php");
?>
<p>&nbsp;</p>
<p>&nbsp;</p>


	</TD>
</TR>
</TABLE>
</FORM>
</DIV>
<BR><BR>
<DIV ALIGN="center"><A HREF="Javascript:window:close();">Close</A></DIV>
</BODY>
</HTML>