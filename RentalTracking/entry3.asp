<% Response.Buffer = True %>
<!-- include virtual="/EventRegistration/includes/session.asp" -->
<!--#include virtual="/RentalTracking/includes/index_header.asp" -->
<!--#include file="lib/_lib_adodbDatabase.asp" -->
<script language="Javascript" src="/includes/lib/_lib_client_side_scripts.js"></script>
<script language="Javascript" src="/EventRegistration/includes/formcheck.js"></script>
<!--#include file="includes/_rentalFunctions.asp" -->
<!--#include file="includes/adovbs.inc" -->

<h1>Ski Bradford Rental Tracking</h1>

<h2>Equipment Rentals</h2>

<!--#include file="lib/forms/rental_form_3.asp" -->

<!--#include virtual="/RentalTracking/includes/index_footer.asp" -->