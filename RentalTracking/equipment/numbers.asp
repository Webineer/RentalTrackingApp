<% Response.Buffer = True %>

<!--#include virtual="/RentalTracking/includes/index_header.asp" -->
<!--#include virtual="/RentalTracking/lib/_lib_adodbDatabase.asp" -->
<!--#include virtual="/RentalTracking/includes/_rentalFunctions.asp" -->
<!--#include virtual="/RentalTracking/includes/adovbs.inc" -->

<%
	Dim NameArray, listedData, colHeaders(), SQLString, DataArray(), URL, NewKey
	Dim Form2DbArray(), TableName, DbType, KeyNames(3), Title, theHeaders(2), noData, PrimaryKey, PrimaryValue
	Dim CoursePrice, CourseName, DateDelimiter
	noData = "There are no events scheduled at this time."
	DbType = "MSAccess"
	DateDelimiter = "#"  'for MSAccess
	'DateDelimiter = "'"  'for SQLServer
	'ConnectionString = "DSN=RentaldB;UID=;PWD="
%>

<h1>Ski Bradford Rental Tracking</h1>

<h2>Number Series Entry</h2>

<%
	If Not IsEmpty(Request.Form("SeriesID")) Then
		'Map the form fields to the database table fields
		ReDim Form2DbArray(2)
		Form2DbArray(0) = "date_created"
		Form2DBArray(1) = "number_value"
		Form2DbArray(2) = "number_series"
''Reformat the Date input
'		ReDim DataArray(2)
'		DataArray(0) = Request.Form("DateCreated")
'		DataArray(1) = Request.Form("SeriesID")
'		DataArray(2) = Request.Form("SeriesName")
'Define the table in the database and the database type
		TableName = "numbers"
'Do data entry
		'Response.Write ConnectionString & "<br>"
		Call EnterFormData(ConnectionString, TableName, Form2DbArray, DbType)
		'Call EnterData(ConnectionString, TableName, Form2DbArray, DataArray, DbType)
	End If
	
'Delete the Location Record
	If Not IsEmpty(Request.QueryString("rowId")) Then
		TableName = "numbers"
		PrimaryKey = "id"
		PrimaryValue = Request.QueryString("rowId")
		Call DeleteRecord(ConnectionString, TableName, PrimaryKey, PrimaryValue, DbType)
	End If
%>

<!--#include virtual="/RentalTracking/lib/forms/numbers_form.asp" -->

<%	
'Present an updated listing of series
		SQLString = "SELECT id, number_value, number_series FROM numbers"
		SQLString = SQLString & " ORDER BY number_value"
		'Response.Write SQLString & "<br>"
		Title = "Number Series"
		theHeaders(0) = "Actions"
		theHeaders(1) = "Value"
		theHeaders(2) = "Series Name"
		'Response.Write SQLString & "<br>"
		'Response.Write ConnectionString & "<br>"
		'Response.Write Request.Form("rowId") & " is asset type.<br>"
		Response.Write "<br><br>"
		Call GetData(ConnectionString,SQLString)
		Call displayClassesData(Title, listedData, theHeaders)
%>

</p>

<!-- End Content -->

<!--#include virtual="/RentalTracking/includes/footer.asp" -->