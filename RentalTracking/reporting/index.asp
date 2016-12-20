<% Response.Buffer = True %>

<!--#include virtual="/RentalTracking/includes/index_header.asp" -->
<!--#include virtual="/RentalTracking/lib/_lib_adodbDatabase.asp" -->
<!--#include virtual="/RentalTracking/includes/_rentalFunctions.asp" -->
<!--#include virtual="/RentalTracking/includes/adovbs.inc" -->

<%
	Dim NameArray, listedData, colHeaders(), SQLString, DataArray(), URL, NewKey
	Dim Form2DbArray(), TableName, DbType, KeyNames(3), Title, theHeaders(), noData, PrimaryKey, PrimaryValue
	Dim CoursePrice, CourseName, DateDelimiter
	noData = "There are no events scheduled at this time."
	DbType = "MSAccess"
	DateDelimiter = "#"  'for MSAccess
	'DateDelimiter = "'"  'for SQLServer
	'ConnectionString = "DSN=RentaldB;UID=;PWD="
%>

<h1>Ski Bradford Rental Tracking</h1>

<h2>Reporting</h2>

<p>Note:  These reports require that all rented equipment be entered into this application.  If a piece of equipment requires entry, please click <a href="../equipment/">here</a>.</p>

<p>
<ul>
	<li>Rental Non-Returns Report
	<!--#include virtual="/RentalTracking/lib/forms/nonreturns_date_form.asp" -->
	</li>
	<!-- li><a href="frequency.asp">Equipment Usage Report</a></li -->
	<li>Equipment Usage Report
	<!--#include virtual="/RentalTracking/lib/forms/usage_form.asp" -->
	</li>
</ul>
</p>


<!--#include virtual="/RentalTracking/includes/footer.asp" -->