<% Response.Buffer = True %>
<!-- include virtual="/EventRegistration/includes/session.asp" -->
<!--#include virtual="/RentalTracking/includes/header.asp" -->
<!--#include file="lib/_lib_adodbDatabase.asp" -->
<script language="Javascript" src="/includes/lib/_lib_client_side_scripts.js"></script>
<script language="Javascript" src="/EventRegistration/includes/formcheck.js"></script>
<!--#include file="includes/_rentalFunctions.asp" -->
<!--#include file="includes/adovbs.inc" -->

<%
	Dim NameArray, listedData, colHeaders(), SQLString, DataArray(), URL, NewKey
	Dim Form2DbArray(), TableName, DbType, KeyNames(3), Title, theHeaders(), noData, PrimaryKey, PrimaryValue
	Dim DateDelimiter, EquipmentValues, UsageValues, ReturnedValue, RecipientName, Message, RecipientMail
	noData = "Not Applicable"
	DbType = "MSAccess"
	EquipmentValues = "0"
	'DateDelimiter = "#"  'for MSAccess
	DateDelimiter = "'"  'for SQLServer
	'ConnectionString = "DSN=RentaldB;UID=;PWD="
	'Get Equipment IDs from transaction table
	ReturnedValue = "no"
	'SQLString = "SELECT DISTINCT transactions.equipment1_id, equipment.equipment_name FROM transactions, equipment WHERE transactions.equipment1_id=equipment.equipment_id"
	SQLString = "SELECT COUNT(equipment1_id) FROM transactions WHERE transaction_date LIKE " & DateDelimiter & Date() & "%" & DateDelimiter & " AND transaction_type = 'out'"
	'SQLString = "SELECT COUNT(DISTINCT equipment1_id) FROM transactions"
	'Response.Write SQLString & "<br>"
	'Response.Write ConnectionString & "<br>"
    Call GetData(ConnectionString,SQLString)
   	EquipmentValues = listedData(0,0)
   	'Response.Write "rented is " & EquipmentValues
    
    SQLString2 = "SELECT COUNT(equipment1_id) FROM transactions WHERE transaction_date LIKE " & DateDelimiter & Date() & "%" & DateDelimiter & " AND transaction_type = 'in'"
	'Response.Write SQLString2 & "<br>"
	Call GetData(ConnectionString,SQLString2)
   	UsageValues = listedData(0,0)
   	'Response.Write "returned is " & UsageValues
   	
   	ReturnedValue = CInt(EquipmentValues) - CInt(UsageValues)
%>

<h1>Ski Bradford Rental Tracking</h1>

<p>Currently, there are <%=CStr(ReturnedValue) %> pieces of equipment rented out.</p>

<h2>Equipment Returns</h2>
<p>

<!--#include file="lib/forms/rental_form.asp" -->

</p>



<!-- End Content -->

<!--#include virtual="/RentalTracking/includes/index_footer.asp" -->