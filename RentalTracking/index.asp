<% Response.Buffer = True %>
<!--#include virtual="/RentalTracking/includes/index_header.asp" -->
<!--#include file="lib/_lib_adodbDatabase.asp" -->
<script language="Javascript" src="/includes/lib/_lib_client_side_scripts.js"></script>
<script language="Javascript" src="/EventRegistration/includes/formcheck.js"></script>
<!--#include file="includes/_rentalFunctions.asp" -->
<!--#include file="includes/adovbs.inc" -->

<h1>Ski Bradford Rental Tracking</h1>

<h2>Equipment Rental Tracking Administration</h2>
<p>
<a href="rentals.asp">Rentals</a><br />
<a href="returns.asp">Returns</a><br />
<a href="equipment">Enter Equipment</a><br />
<a href="reporting">Reporting</a>

<!-- include file="lib/forms/rental_form_3.asp" -->

</p>

<!--#include virtual="/RentalTracking/includes/index_footer.asp" -->