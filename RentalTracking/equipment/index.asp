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

<h2>Equipment Entry</h2>

<%
'Enter single equipment id for non-Skis
	If (Not IsEmpty(Request.Form("EquipmentId")) AND IsEmpty(Request.Form("Equipment2Id"))) Then

'Check to see if the equipment is already in the database
		'SQLString = "SELECT equipment_id FROM equipment WHERE equipment_id='" & Request.Form("EquipmentId") & "'"
		SQLString = "SELECT equipment_id FROM equipment WHERE equipment_id='" & Request.Form("EquipmentId") & "' OR equipment2_id='" & Request.Form("EquipmentId") & "'"
		'Response.Write SQLString & "<br>"
		Call GetData(ConnectionString,SQLString)
		If Not IsArray(listedData) Then
			'Map the form fields to the database table fields
			ReDim Form2DbArray(4)
			Form2DbArray(0) = "date_created"
			Form2DbArray(1) = "equipment_name"
			Form2DbArray(2) = "equipment_description"
			Form2DbArray(3) = "ski_number"
			Form2DbArray(4) = "equipment_id"
			
'Define the table in the database and the database type
			TableName = "equipment"
'Do data entry
			'Response.Write ConnectionString & "<br>"
			Call EnterFormData(ConnectionString, TableName, Form2DbArray, DbType)
		Else
			Response.Write "<p class=""warning_red"">This equipment is already entered into the application.</p>"
		End If
	End If
	
'Enter the second equipment id for Skis
	If Not IsEmpty(Request.Form("Equipment2Id")) Then

'Check to see if the equipment is already in the database
		'SQLString = "SELECT equipment2_id FROM equipment WHERE equipment2_id='" & Request.Form("Equipment2Id") & "'"
		SQLString = "SELECT equipment_id FROM equipment WHERE equipment_id='" & Request.Form("EquipmentId") & "' OR equipment2_id='" & Request.Form("EquipmentId") & "' OR equipment_id='" & Request.Form("Equipment2Id") & "' OR equipment2_id='" & Request.Form("Equipment2Id") & "'"
		'Response.Write SQLString & "<br>"
		Call GetData(ConnectionString,SQLString)
		If Not IsArray(listedData) Then
			'Map the form fields to the database table fields
			ReDim Form2DbArray(5)
			Form2DbArray(0) = "date_created"
			Form2DbArray(1) = "equipment_name"
			Form2DbArray(2) = "equipment_description"
			Form2DbArray(3) = "ski_number"
			Form2DbArray(4) = "equipment_id"
			Form2DbArray(5) = "equipment2_id"
			
'Define the table in the database and the database type
			TableName = "equipment"
'Do data entry
			'Response.Write ConnectionString & "<br>"
			Call EnterFormData(ConnectionString, TableName, Form2DbArray, DbType)

		Else
			Response.Write "<p class=""warning_red"">This equipment is already entered into the application.</p>"
		End If
	End If
%>


<!--#include virtual="/RentalTracking/lib/forms/equipment_form.asp" -->

<h2>Equipment Update</h2>

<!--#include virtual="/RentalTracking/lib/forms/equipment_search_form.asp" -->
<%	
'	End If
%>

</p>

<!-- End Content -->

<!--#include virtual="/RentalTracking/includes/footer.asp" -->