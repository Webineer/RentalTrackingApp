<% Response.Buffer = True %>
<!-- include virtual="/EventRegistration/includes/session.asp" -->
<!--#include virtual="/RentalTracking/includes/index_header.asp" -->
<!--#include file="lib/_lib_adodbDatabase.asp" -->
<script language="Javascript" src="/includes/lib/_lib_client_side_scripts.js"></script>
<script language="Javascript" src="/EventRegistration/includes/formcheck.js"></script>
<!--#include file="includes/_rentalFunctions.asp" -->
<!--#include file="includes/adovbs.inc" -->

<h1>Ski Bradford Rental Tracking</h1>

<h2>Equipment Returns</h2>


<%
	Dim NameArray, listedData, colHeaders(), SQLString, DataArray(), URL, NewKey
	Dim Form2DbArray(), TableName, DbType, KeyNames(3), Title, theHeaders(), noData, PrimaryKey, PrimaryValue
	Dim CoursePrice, CourseName, DateDelimiter
	noData = "There are no events scheduled at this time."
	DbType = "MSAccess"
	DateDelimiter = "#"  'for MSAccess
	'DateDelimiter = "'"  'for SQLServer
	'ConnectionString = "DSN=RentaldB;UID=;PWD="
	
	'Get internal id to enter into the transactions table
	SQLString = "SELECT id FROM equipment WHERE equipment_id='" & Request.Form("Equipment1ID") & "'"
	Call GetData(ConnectionString,SQLString)
	'InternalId = listedData
	If Not IsArray(listedData) Then
		SQLString = "SELECT id FROM equipment WHERE equipment2_id='" & Request.Form("Equipment1ID") & "'"
		Call GetData(ConnectionString,SQLString)
		If Not IsArray(listedData) Then
			listedData = "This equipment not registered."
		Else
			InternalID = listedData(0,0)
		End If
	Else
		InternalID = listedData(0,0)
	End If
	'Response.Write InternalID & vbcrlf

	'Map the form fields to the database table fields
	ReDim Form2DbArray(2)
	Form2DbArray(0) = "transaction_date"
	Form2DbArray(1) = "transaction_type"
	'Form2DbArray(2) = "agreement_id"
	'Form2DbArray(3) = "equipment2_id"
	Form2DbArray(2) = "equipment1_id"
		
'Define the table in the database and the database type
	TableName = "transactions"
	
	'If (InternalID <> "This equipment not registered.") Then
	If IsArray(listedData) Then
		'Reformat the Data input
		ReDim DataArray(2)
		'DataArray(0) = Request.Form("DateCreated")
		DataArray(0) = Date() & " " & FormatDateTime(Now(),4)
		DataArray(1) = Request.Form("Type")
		DataArray(2) = InternalID
		'Response.Write Request.QueryString("rowId") & "<br>"
		Call EnterData(ConnectionString, TableName, Form2DbArray, DataArray, DbType)
		Response.Write "<p>Successful Entry Completed!</p>"
	Else
'Do not do data entry
		'Response.Write ConnectionString & "<br>"
		'Call EnterFormData(ConnectionString, TableName, Form2DbArray, DbType)
		Response.Write "<p>Transaction cancelled.  This piece of equipment is not registered.  Please click <a href=""equipment/index.asp"">here</a> to register the equipment.</p>"
	End If
%>

<p>
<!--#include file="lib/forms/rental_form.asp" -->
</p>


<!--#include virtual="/RentalTracking/includes/index_footer.asp" -->