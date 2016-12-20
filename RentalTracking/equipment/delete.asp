<% Response.Buffer = True %>

<!--#include virtual="/RentalTracking/includes/index_header.asp" -->
<!--#include virtual="/RentalTracking/lib/_lib_adodbDatabase.asp" -->
<!--#include virtual="/RentalTracking/includes/_rentalFunctions.asp" -->
<!--#include virtual="/RentalTracking/includes/adovbs.inc" -->

<h1>Ski Bradford Rental Tracking</h1>

<h2>Equipment Update</h2>

<%
	Dim NameArray, listedData, colHeaders(), SQLString, DataArray(), URL, NewKey
	Dim Form2DbArray(), TableName, DbType, KeyNames(3), Title, theHeaders(), noData, PrimaryKey, PrimaryValue
	Dim CoursePrice, CourseName, DateDelimiter
	noData = "There are no events scheduled at this time."
	DbType = "MSAccess"
	DateDelimiter = "#"  'for MSAccess
	'DateDelimiter = "'"  'for SQLServer
	'ConnectionString = "DSN=RentaldB;UID=;PWD="

'Delete the course record since no classes exist and no prerequisites exist
	TableName = "equipment"
	PrimaryKey = "id"
	PrimaryValue = Request.Form("Id")
	Call DeleteRecord(ConnectionString, TableName, PrimaryKey, PrimaryValue, DbType)
%>

<p>This equipment has been removed from the application.  To return to Equipment Management, click <a href="index.asp">here</a>.</p>

<!--#include virtual="/RentalTracking/includes/footer.asp" -->