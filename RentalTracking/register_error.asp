<% Response.Buffer = True %>
<!--#include virtual="/RentalTracking/includes/header.asp" -->
<!--#include file="lib/_lib_adodbDatabase.asp" -->
<script language="Javascript" src="/includes/lib/_lib_client_side_scripts.js"></script>
<script language="Javascript" src="/EventRegistration/includes/formcheck.js"></script>
<!--#include file="includes/_rentalFunctions.asp" -->
<!--#include file="includes/adovbs.inc" -->
<EMBED	src="crash.wav" autostart="true" hidden="true">

<h1>Ski Bradford Rental Tracking</h1>

<h2>Equipment Registration</h2>

<h3>Registration Error</h3>

<p class="warning_red">Transaction cancelled.  This piece of equipment is not registered.  Please register the equipment before renting or returning it.</p>

<p class="warning_red">To continue renting equipment, please click <a href="rentals.asp">here</a>.</p>

<p class="warning_red">To continue returning equipment, please click <a href="returning.asp">here</a>.</p>

<!--#include virtual="/RentalTracking/includes/index_footer.asp" -->