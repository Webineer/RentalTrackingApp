<% Response.Buffer = True %>
<!--#include virtual="/RentalTracking/includes/header.asp" -->
<!--#include file="lib/_lib_adodbDatabase.asp" -->
<script language="Javascript" src="/includes/lib/_lib_client_side_scripts.js"></script>
<script language="Javascript" src="/EventRegistration/includes/formcheck.js"></script>
<!--#include file="includes/_rentalFunctions.asp" -->
<!--#include file="includes/adovbs.inc" -->
<EMBED	src="crash.wav" autostart="true" hidden="true">

<h1>Ski Bradford Rental Tracking</h1>

<h2>Equipment Returns</h2>

<h3>Return Error</h3>

<p class="warning_red">Transaction cancelled.  This piece of equipment is already returned.  To return this equipment, please rent it out first.</p>

<p class="warning_red">Please click <a class="warning_red" href="returns.asp">here</a> to continue returning equipment.</p>

<!--#include virtual="/RentalTracking/includes/index_footer.asp" -->