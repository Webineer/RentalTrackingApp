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
	'SQLString = "SELECT id FROM equipment WHERE equipment_id='" & Request.Form("Equipment1ID") & "'"
	SQLString = "SELECT id FROM equipment WHERE equipment_id='" & Request.Form("Equipment1ID") & "' OR equipment2_id='" & Request.Form("Equipment1ID") & "'"
	Call GetData(ConnectionString,SQLString)
	'InternalId = listedData
	
	If Not IsArray(listedData) Then
		'If there is not matching id for equipment_id, then check equipment2_id
		'SQLString = "SELECT id FROM equipment WHERE equipment2_id='" & Request.Form("Equipment1ID") & "'"
		'Call GetData(ConnectionString,SQLString)
		'If Not IsArray(listedData) Then
			listedData = "This equipment not registered."
		'Else
		'	InternalID = listedData(0,0)
		'End If
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
		'Test to see if the equipment is returned already
		SQLString = "SELECT max(id) FROM transactions WHERE equipment1_id='" & InternalID & "'"
		'Response.Write(SQLString) & "<br>"
		Call GetData(ConnectionString,SQLString)
		
		'check to see if there is a previous transaction; if not, then send to error page
		If IsArray(listedData) Then
			'if there is a transaction, find the transaction type
			TransId = listedData(0,0)
			'Response.Write(listedData(0,0) & "<br>")
			'Response.Write(listedData(1,0) & "<br>")
			SQLString = "SELECT transaction_type FROM transactions WHERE id='" & TransId & "'"
			'Response.Write(SQLString) & "<br>"
			Call GetData(ConnectionString,SQLString)
			'Response.Write(listedData(0,0) & "<br>")
			TransType = CStr(listedData(0,0))
		Else
			'no previous transaction is an error condition; redirect to error page
			Response.Redirect("return_error.asp")			
		End If
		
		'check the transaction type and confirm that it is set to out
		If (StrComp(TransType,"in") = 0) Then
			Response.Redirect("return_error.asp")
			'Response.Write "<p class=""warning_red"">Transaction cancelled.  This piece of equipment is already returned.  Please click <a class=""warning_red"" href=""index.asp"">here</a> to rent the equipment.</p>"
		Else
			'Enter the transaction
			'Reformat the Data input
			ReDim DataArray(2)
			'DataArray(0) = Request.Form("DateCreated")
			DataArray(0) = Date() & " " & FormatDateTime(Now(),4)
			DataArray(1) = Request.Form("Type")
			DataArray(2) = InternalID
			'Response.Write Request.QueryString("rowId") & "<br>"
			Call EnterData(ConnectionString, TableName, Form2DbArray, DataArray, DbType)
			Response.Write "<p class=""warning"">Successful Entry Completed!</p>"
		End If
	Else
'Do not do data entry
		'Response.Write ConnectionString & "<br>"
		'Call EnterFormData(ConnectionString, TableName, Form2DbArray, DbType)
		Response.Redirect("register_error.asp")
		'Response.Write "<p class=""warning_red"">Transaction cancelled.  This piece of equipment is not registered.  Please click <a href=""equipment/index.asp"">here</a> to register the equipment.</p>"
	End If
%>

<p>
<!--#include file="lib/forms/rental_form.asp" -->
</p>


<!--#include virtual="/RentalTracking/includes/index_footer.asp" -->