<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Instructor Administration</title>
	<link rel=stylesheet href="/instructors/includes/admin_app.css" TYPE="text/css"/>
    <link rel="stylesheet" href="/instructors/includes/calendar.css" />
    <script language="Javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script language="JavaScript" src="/instructors/includes/calendar_us.js"></script>
    <script language="JavaScript" src="/instructors/includes/FloatLayer.js"></script>
	<script>
        $(document).ready(function(){
        $(".test2").hide();
        
        $("#cart_button").click(function(){
            $(".test1").hide();
            $(".test2").show();
        });
        
        $("#form_button").click(function(){
            $(".test1").show();
            $(".test2").hide();
        });
});
</script>
 <style type="text/css">
  .bigButton {
    width: 25px;
    height: 25px;
    background-color:#aaaaaa;
  }
  
  .bigSelect {
    font-size:25px;
  }
  
</style>

<script lang="Javascript" >
new FloatLayer('floatlayer',800,300,10);

function detach(){
	lay=document.getElementById('floatlayer');
	l=getXCoord(lay);
	t=getYCoord(lay);
	lay.style.position='absolute';
	lay.style.top=t;
	lay.style.left=l;
	getFloatLayer('floatlayer').initialize();
	alignFloatLayers();
}

</script>

</head>

<BODY BGCOLOR="#FFFFFF">

<!-- BODY BGCOLOR=FFFFFF onLoad="detach()" onresize="alignFloatLayers()" onscroll="alignFloatLayers()">



<div id="floatlayer" style="width:20%;background:#d0d0ff;border:solid black 1px;padding:5px">
<h2>Cost Summary</h2>
Here is a summary of the total cost of this transaction:<br /><br />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><th>Product Cost:</th><td><div id="myLayer1">00</div></td></tr>
<tr><th>Rental Cost:</th><td><div id="myLayer2">00</div></td></tr>
<tr><td colspan="2"><hr /></td></tr>
<tr><th>Total Cost:</th><td><div id="myLayer3">00</div></td></tr>
</table>
</div -->


<DIV ALIGN="CENTER">

<TABLE CELLPADDING="3" CELLSPACING="0" BORDER="0">
<TR ALIGN=center>

	<TD>	
		<!-- IMG SRC="/reservation/images/ski1vsm.gif" WIDTH="59" HEIGHT="100" ALT="Skier">&nbsp;<IMG SRC="/reservation/images/bradfordvsm.jpg" BORDER="0" WIDTH="150" HEIGHT="115" ALT="Ski Bradford Logo">&nbsp;<IMG SRC="/reservation/images/board1vsm.gif" WIDTH="52" HEIGHT="98" ALT="Snowboarder"><BR><BR -->
		<FONT FACE="Arial" COLOR="green" SIZE="4"><B><I>Ski Bradford Instructor</I></B></FONT><BR><BR>
	</TD>
                
</TR>

<TR>
	<TD VALIGN="top">

<p>&nbsp;</p>
<!--Begin Page content-->
