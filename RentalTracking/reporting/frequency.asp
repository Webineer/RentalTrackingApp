<% Response.Buffer = True %>

<!--#include virtual="/RentalTracking/includes/index_header.asp" -->
<!--#include virtual="/RentalTracking/lib/_lib_adodbDatabase.asp" -->
<!--#include virtual="/RentalTracking/includes/_rentalFunctions.asp" -->
<!--#include virtual="/RentalTracking/includes/adovbs.inc" -->

<%
	Dim NameArray, listedData, colHeaders(), SQLString, DataArray(), URL, NewKey
	Dim Form2DbArray(), TableName, DbType, KeyNames(3), Title, theHeaders(), noData, PrimaryKey, PrimaryValue
	Dim DateDelimiter, EquipmentValues, UsageValues
	noData = "Not Applicable"
	DbType = "MSAccess"
	DateDelimiter = "#"  'for MSAccess
	'DateDelimiter = "'"  'for SQLServer
	'ConnectionString = "DSN=RentaldB;UID=;PWD="
	'Get Equipment IDs from equipment table
	'SQLString = "SELECT DISTINCT equipment_id, equipment_name, equipment_id FROM equipment"
	SQLString = "SELECT DISTINCT equipment_id, ski_number, equipment_name, equipment_id FROM equipment"
	Call GetData(ConnectionString,SQLString)
	EquipmentValues = listedData
%>

<h1>Ski Bradford Rental Tracking</h1>

<h2>Equipment Usage</h2>
<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>
<tr><td>Equipment ID</td><td>Ski Number</td><td>Name</td><td>Usage</td></tr>
<%
'Check to see if the equipment is already in the database
	'numRecords = UBound(EquipmentValues,2)
    'numFields = UBound(EquipmentValues,1)
	'Response.Write numRecords & ", " & numFields & "<br>"
	'For i = 0 To numFields
	j=1
	For Each Item In EquipmentValues
		SQLString2 = "SELECT count(id) FROM transactions WHERE transaction_type='out' AND equipment1_id='" & Item & "'"
		'Response.Write SQLString2 & "<br>"
		Call GetData(ConnectionString,SQLString2)
		
		If IsArray(listedData) Then
			If (j = 4) Then
				Response.Write "<td>" & listedData(0,0) & "</td>"
				Response.Write "</tr>"
				j = 1
			ElseIf (j = 1) Then
				Response.Write "<tr style=""background-color:#ffffff;"">"
				Response.Write "<td>" & Item & "</td>"
				j=j+1
			Else
				Response.Write "<td>" & Item & "</td>"
				j=j+1
			End If
		Else
			Response.Write noData
		End If
	Next
%>
</table>

<!--#include virtual="/RentalTracking/includes/footer.asp" -->