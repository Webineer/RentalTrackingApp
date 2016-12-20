<% 
	Response.Buffer = True
%>

<!-- include virtual="/RentalTracking/includes/index_header.asp" -->
<!--#include virtual="/RentalTracking/lib/_lib_adodbDatabase.asp" -->
<!-- include virtual="/RentalTracking/lib/_lib_cdontsEmail.asp" -->
<!--#include virtual="/RentalTracking/includes/_rentalFunctions.asp" -->
<!--#include virtual="/RentalTracking/includes/adovbs.inc" -->

<%
	Dim NameArray, listedData, colHeaders(), SQLString, DataArray(), URL, NewKey
	Dim Form2DbArray(), TableName, DbType, KeyNames(3), Title, theHeaders(), noData, PrimaryKey, PrimaryValue
	Dim DateDelimiter, EquipmentValues, UsageValues, ReturnedValue, RecipientName, Message, RecipientMail
	noData = "Not Applicable"
	DbType = "MSAccess"
	'DateDelimiter = "#"  'for MSAccess
	DateDelimiter = "'"  'for SQLServer
	'ConnectionString = "DSN=RentaldB;UID=;PWD="
	'Get Equipment IDs from transaction table
	ReturnedValue = "no"
	'SQLString = "SELECT DISTINCT transactions.equipment1_id, equipment.equipment_name FROM transactions, equipment WHERE transactions.equipment1_id=equipment.equipment_id"
	SQLString = "SELECT DISTINCT equipment1_id FROM transactions"
	Call GetData(ConnectionString,SQLString)
	EquipmentValues = listedData
	Response.ContentType = "application/vnd.ms-excel"
%>

<h1>Ski Bradford Rental Tracking</h1>

<h2>Unreturned Equipment</h2>
<!-- table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>
<tr><td>ID</td><td>Equipment</td><td>Usage</td></tr -->
<%
'Check to see if the equipment is already in the database
	'numRecords = UBound(EquipmentValues,2)
    'numFields = UBound(EquipmentValues,1)
	'Response.Write numRecords & ", " & numFields & "<br>"
	'For i = 0 To numFields
	j=1
	For Each Item In EquipmentValues
		'SQLString2 = "SELECT equipment1_id, transaction_date, transaction_type FROM transactions WHERE transaction_date LIKE " & DateDelimiter & Date() & "%" & DateDelimiter & " AND equipment1_id='" & Item & "' ORDER BY transaction_date"
		'SQLString2 = "SELECT equipment.ski_number, transactions.equipment1_id, transactions.transaction_date, transactions.transaction_type FROM transactions, equipment WHERE transactions.equipment1_id=equipment.equipment_id and transactions.transaction_date LIKE " & DateDelimiter & Date() & "%" & DateDelimiter & " AND transactions.equipment1_id='" & Item & "' ORDER BY transactions.transaction_date"
		'SQLString2 = "SELECT equipment.ski_number, transactions.equipment1_id, transactions.transaction_date, transactions.transaction_type FROM transactions, equipment WHERE transactions.equipment1_id=equipment.id and transactions.transaction_date LIKE " & DateDelimiter & Date() & "%" & DateDelimiter & " AND transactions.equipment1_id='" & Item & "' ORDER BY transactions.transaction_date"
		If (Request.Form("DateEnd") = "") Then
			SQLString2 = "SELECT equipment.ski_number, equipment.id, transactions.transaction_date, transactions.transaction_type FROM transactions, equipment WHERE transactions.equipment1_id=equipment.id and transactions.transaction_date LIKE " & DateDelimiter & Date() & "%" & DateDelimiter & " AND transactions.equipment1_id='" & Item & "' ORDER BY transactions.transaction_date"
		Else
			SQLString2 = "SELECT equipment.ski_number, equipment.id, transactions.transaction_date, transactions.transaction_type FROM transactions, equipment WHERE transactions.equipment1_id=equipment.id and transactions.transaction_date LIKE " & DateDelimiter & Request.Form("DateEnd") & "%" & DateDelimiter & " AND transactions.equipment1_id='" & Item & "' ORDER BY transactions.transaction_date"
		End If
		'Response.Write SQLString2 & "<br>"
		Call GetData(ConnectionString,SQLString2)
		
		If IsArray(listedData) Then
			'numFields2 = UBound(listedData,1)
			'Response.Write listedData(0,0) & "<br>"
			'Response.Write listedData(1,0) & "<br>"
			'Response.Write listedData(numFields2,0) & "<br>"
			'For k=2 To numFields2 Step 2
			'	Response.Write listedData(k,0) & "<br>"
			'Next
			Title = ""
			ReDim theHeaders(3)
			theHeaders(0) = "Equipment Number"
			'theHeaders(1) = Item
			theHeaders(1) = "Internal ID"
			theHeaders(2) = "Rental History"
			theHeaders(3) = "Status"
			
			'Response.Write SQLString & "<br>"
			'Response.Write ConnectionString & "<br>"
			'Response.Write Request.Form("rowId") & " is asset type.<br>"
			'Response.Write "<br><br>"		
			Call displayUnreturnedData(Title, listedData, theHeaders)
		Else
			'Response.Write "<p>All Equipment Returned.</p>"
		End If
	Next
	
	If (ReturnedValue = "no") Then
		'Response.Write "<p>All Equipment Returned.</p>"
	End If

%>
<!-- /table -->

<script language="Javascript">document.window.print(); </script>

<!-- include virtual="/RentalTracking/includes/footer.asp" -->