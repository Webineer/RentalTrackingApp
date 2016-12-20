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

'Check to see if you're adding a location record	
	If Not IsEmpty(Request.Form("EquipmentId")) Then
'Map the form fields to the database table fields
		ReDim Form2DbArray(5)
		Form2DbArray(0) = "date_modified"
		Form2DbArray(1) = "equipment_name"
		Form2DbArray(2) = "equipment_description"
		Form2DbArray(3) = "ski_number"
		Form2DbArray(4) = "equipment_id"
		Form2DbArray(5) = "equipment2_id"
	
		PrimaryKeyFieldName = "id"
		PrimaryKeyFieldValue = Request.Form("Id")
		
'Define the table in the database and the database type
		TableName = "equipment"
'Do data entry
		Call UpdateFormData(ConnectionString, TableName, Form2DbArray, PrimaryKeyFieldName, PrimaryKeyFieldValue, DbType)
	End If
		
	'If Not IsEmpty(Request.QueryString("rowId")) Then
'Get data from the db on this location and present the updated information
	If Not IsEmpty(Request.Form("Id")) Then
		SQLString = "SELECT equipment_name, equipment_description, ski_number, equipment_id, equipment2_id, id FROM equipment WHERE id=" & Request.Form("Id")
	Else
		'SQLString = "SELECT equipment_name, equipment_description, ski_number, equipment_id, id FROM equipment WHERE equipment_id='" & Request.Form("SearchId") & "'"
		
		'Get internal id to enter into the transactions table
		SQLString = "SELECT id FROM equipment WHERE equipment_id='" & Request.Form("SearchId") & "'"
		Call GetData(ConnectionString,SQLString)
		'InternalId = listedData
		If Not IsArray(listedData) Then
			SQLString = "SELECT id FROM equipment WHERE equipment2_id='" & Request.Form("SearchId") & "'"
			Call GetData(ConnectionString,SQLString)
			If Not IsArray(listedData) Then
				'listedData = "This equipment not registered."
				InternalID = 0
			Else
				InternalID = listedData(0,0)
			End If
		Else
			InternalID = listedData(0,0)
		End If
		'Response.Write InternalID & vbcrlf
		'Get data using id
		SQLString = "SELECT equipment_name, equipment_description, ski_number, equipment_id, equipment2_id, id FROM equipment WHERE id=" & InternalID	
		'Response.Write SQLString & vbcrlf
	End If
	'Response.Write SQLString & "<br>"
	Call GetData(ConnectionString,SQLString)

'Check to see if equipment is in the database	
	If Not IsArray(listedData) Then
		Response.Write "<p>No such equipment in the application. Please click <a href=""index.asp"">here</a> to return to Equipment Management.</p>"
	Else
%>

<!--#include virtual="/RentalTracking/lib/forms/equipment_update_form.asp" -->

<% End If %>

<!-- End Content -->

<!--#include virtual="/RentalTracking/includes/footer.asp" -->