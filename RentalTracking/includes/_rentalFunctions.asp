<%

StateNames = Array("Alaska", "Alabama", "Arkansas", "Arizona", "California", "Colorado", "Connecticut", "District of Columbia", "Delaware", "Florida", "Georgia", "Hawaii", "Iowa", "Idaho", "Illinois", "Indiana", "Kansas", "Kentucky", "Louisiana", "Massachusetts", "Maryland", "Maine", "Michigan", "Minnesota", "Missouri", "Mississippi", "Montana", "North Carolina", "North Dakota", "Nebraska", "New Hampshire", "New Jersey", "New Mexico", "Nevada", "New York", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Virginia", "Vermont", "Washington", "Wisconsin", "West Virginia", "Wyoming")

StateAcronyms = Array("AK", "AL", "AR", "AZ", "CA", "CO", "CT", "DC", "DE", "FL", "GA", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA", "MA", "MD", "ME", "MI", "MN", "MO", "MS", "MT", "NC", "ND", "NE", "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VA", "VT", "WA", "WI", "WV", "WY")

Salutations = Array("Mr.", "Mrs.", "Ms.", "Dr.")

SecurityTypes = Array("Customer", "Partner", "Employee", "Instructor", "Registrar", "Administrator")

StatusTypes = Array("Active", "Inactive")

AttendanceTypes = Array("N", "Y")

BillingStatusTypes = Array("Unpaid", "Paid", "Pending")

PaymentStatusTypes = Array("Unpaid", "Paid", "Pending")

PaymentTypes = Array("Purchase Order", "Sales Order", "Credit Card", "Check", "Cash")

CommunicationsNameTypes = Array("AccountCreation", "AccountModified", "InterestListAddition", "InterestListRemoval", "PasswordRetrieval", "PaymentInformationRequest", "PaymentInformationReceived", "PaymentConfirmed", "Registration", "RegistrationConfirmed", "RegistrationRemoved", "Reminder", "General")


Sub displaySelect(theArray)
	For Each Item In theArray
		Response.Write "<option>" & Item & "</option>"
	Next
End Sub

Sub displaySelectSelected(theArray, SelectValue)
	For Each Item In theArray
		Response.Write "<option"
		If (Item = SelectValue) Then
			Response.Write " selected"
		End If
		Response.Write ">" & Item & "</option>"
	Next
End Sub

Sub displayValuesSelect(valuesArray, textArray)
	For x=0 To UBound(valuesArray)
		Response.Write "<option value=""" & valuesArray(x) & """>" & textArray(x) & "</option>"
	Next
End Sub


Sub displayValuesSelectSelected(valuesArray, textArray, SelectValue)
	For x=0 To UBound(valuesArray)
		Response.Write "<option value=""" & valuesArray(x) & ""
		If (valuesArray(x) = SelectValue) Then
			Response.Write " selected"
		End If
		Response.Write ">" & textArray(x) & "</option>"
	Next
End Sub

Sub syncWithOutlook(UserId, InstanceId)
	
	'Write to the Calendar file
	SQLString = "SELECT events.event_name, events.synopsis, event_instances.event_date_start, event_instances.event_date_end, locations.location_name FROM events, event_instances, registrations, locations"
	SQLString = SQLString & " WHERE registrations.instance_id = event_instances.instance_id"
	SQLString = SQLString & " AND event_instances.location_id = locations.location_id"
	SQLString = SQLString & " AND event_instances.event_id = events.event_id"
	SQLString = SQLString & " AND registrations.registrant = '" & UserId & "'"
	SQLString = SQLString & " AND registrations.instance_id = " & InstanceId
	'Response.Write SQLString & "<br>"
	Call GetData(ConnectionString,SQLString)
	
	'Response.ContentType = "iCalendar/text"
	'Response.AddHeader "Content-Disposition" , "ConcertoEvent.vcs"
	
	Response.Write "BEGIN:VCALENDAR" & vbcrlf
	Response.Write "VERSION:0.1" & vbcrlf
	Response.Write "BEGIN:VEVENT" & vbcrlf
	Response.Write "DTSTART:" & ConvertDateInput(listedData(2,0)) & "T083000" & vbcrlf
	Response.Write "DTEND:" & ConverDateInput(listedData(3,0)) & "T160000" & vbcrlf
	Response.Write "LOCATION;ENCODING=QUOTED-PRINTABLE:" & listedData(4,0) & vbcrlf
	Response.Write "SUMMARY;ENCODING=QUOTED-PRINTABLE:" & listedData(0,0) & vbcrlf
	Response.Write "DESCRIPTION;ENCODING=QUOTED-PRINTABLE:" & listedData(1,0) & vbcrlf
	Response.Write "PRIORITY:3" & vbcrlf
	Response.Write "END:VEVENT" & vbcrlf
	Response.Write "END:VCALENDAR" & vbcrlf

End Sub

Function numberOfSeats(InstanceId)
	Dim NumRecords
	'SQLString = "SELECT registration_id FROM registrations WHERE instance_id=" & InstanceId
	SQLString = "SELECT COUNT(registration_id) FROM registrations WHERE instance_id=" & InstanceId
	Call GetData(ConnectionString,SQLString)
	NumRecords = listedData(0,0)
		
	'Return number of registrants
	numberOfSeats=NumRecords
End Function

Function maxNumberOfSeats(InstanceId)
	Dim MaxSeats
	SQLString = "SELECT max_seats FROM event_instances WHERE instance_id=" & InstanceId
	Call GetData(ConnectionString,SQLString)
	MaxSeats = listedData(0,0)
		
	'Return seat limit
	maxNumberOfSeats=MaxSeats
End Function

Function createUser(NewFirstName, NewLastName, NewEmailAddress, NewSecurityValue)
	Dim NewUserName, NumRecords
'Generate a username
	NewUserName = Left(LCase(Trim(NewFirstName)), 1) & LCase(Trim(NewLastName))
	'Response.Write "created the new username of " & NewUserName & "<br>"

'Test to see if this username exists in the user table already, if so create another username
	SQLString = "SELECT User_ID FROM CRA_User WHERE Username='" & NewUserName & "'"
	Call GetData(ConnectionString,SQLString)
	'Response.Write "began first test of user table; listedData is " & IsArray(listedData) & "<br>"

	Do While IsArray(listedData)
		'Response.Write "listedData is an array<br>"
		'SQLString = "SELECT User_ID FROM CRA_User WHERE Username='" & NewUserName & "'"
		'Call GetData(ConnectionString,SQLString)
'Get number of rows returned and fix username
		'If IsArray(listedData) Then
			NumRecords = UBound(listedData,2)
			NewUserName = NewUserName & CStr(NumRecords+1)
			'Response.Write "the new username is " & NewUserName & "<br>"
			SQLString = "SELECT User_ID FROM CRA_User WHERE Username='" & NewUserName & "'"
			Call GetData(ConnectionString,SQLString)
			'Response.Write "began second test of user table; listedData is " & IsArray(listedData) & "<br>"
		'End If
	Loop
	
	If Not IsArray(listedData) Then
'Map the form fields to the database table fields
		ReDim Form2DbArray(10)
		Form2DbArray(0) = "Date_Created"
		Form2DbArray(1) = "Created_By"
		Form2DbArray(2) = "Date_Last_Updated"
		Form2DbArray(3) = "Last_Updated_By"
		Form2DbArray(4) = "CRA_SC_ID"
		Form2DbArray(5) = "Status"
		Form2DbArray(6) = "First_Name"
		Form2DbArray(7) = "Last_Name"
		Form2DbArray(8) = "Username"
		Form2DbArray(9) = "Password"
		Form2DbArray(10) = "Email_Address"
		
		ReDim DataArray(10)
		DataArray(0) = Date()
		DataArray(1) = Session("ValidUser")
		DataArray(2) = Date()
		DataArray(3) = Session("ValidUser")
		DataArray(4) = NewSecurityValue
		DataArray(5) = "Active" 'the default setting for new accounts
		DataArray(6) = NewFirstName
		DataArray(7) = NewLastName
		DataArray(8) = NewUserName
		DataArray(9) = LCase(Trim(NewFirstName)) & "1234"
		DataArray(10) = NewEmailAddress
		
'Define the table in the database and the database type
		TableName = "CRA_User"
'Do data entry
		'Call EnterFormData(ConnectionString, TableName, Form2DbArray, DbType)
		Call EnterData(ConnectionString, TableName, Form2DbArray, DataArray, DbType)
		Response.Write "<p>User " & NewFirstName & " " & NewLastName & " has been assigned a username of " & NewUserName & " and a password of " & LCase(Trim(NewFirstName)) & "1234. </p>"
	Else
		'Response.Write "<script language=Javascript>alert(""Cannot enter this user; username already in use."")</script>"
		Response.Write "<p><b>User information NOT entered.  This username already in use.</b></p>"
	End If
	
'Return Username
	createUser=NewUserName

End Function


Sub createRegistration(RegClassId, RegUserId, RegPaymentType, RegPrice, RegPriceCurrency)
	
'Enter new registration into database if no conflicts
'Map the form fields to the database table fields
				ReDim Form2DbArray(10)
				Form2DbArray(0) = "Date_Created"
				Form2DbArray(1) = "Created_By"
				Form2DbArray(2) = "Date_Last_Updated"
				Form2DbArray(3) = "Last_Updated_By"
				Form2DbArray(4) = "User_ID"
				Form2DbArray(5) = "Class_ID"
				Form2DbArray(6) = "Status"
				Form2DbArray(7) = "Payment_Type"
				Form2DbArray(8) = "Registration_Price"
				Form2DbArray(9) = "Registration_Price_Currency"
				Form2DbArray(10) = "Attended"
				
				ReDim DataArray(11)
				DataArray(0) = Date()
				DataArray(1) = Session("ValidUser")
				DataArray(2) = Date()
				DataArray(3) = Session("ValidUser")
				DataArray(4) = RegUserId
				DataArray(5) = RegClassId
				DataArray(6) = "Active"
				DataArray(7) = RegPaymentType
				DataArray(8) = RegPrice
				DataArray(9) = RegPriceCurrency
				DataArray(10) = "N"

'Define the table in the database and the database type
				TableName = "Registration"
'Do data entry
				'Call EnterFormData(ConnectionString, TableName, Form2DbArray, DbType)
				Call EnterData(ConnectionString, TableName, Form2DbArray, DataArray, DbType)
		Response.Write "<p>Registration for User " & RegUserId & " in " & RegClassId & " completed.</p>"
End Sub

Sub displayData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
				Case 1
					Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub


Sub displayUnreturnedData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
	'Response.Write numFields & "<br>"
	'Response.Write numRecords Mod 2 & "<br>"
	'If (((numRecords Mod 2) = 0) OR (listData(numFields,numRecords) = "out")) Then
	If (listData(numFields,numRecords) <> "in") Then
	    ' start a table 
	    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
	    ' spit out the table headers
	    ' prepend an empty first cell so we can number records
	    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
	    For i = 0 To numHeaders
	      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
	      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
	    Next
	    Response.Write "</tr>" & vbcrlf
	    ' spit out the listedData
	    for j=0 to numRecords
	      If (j MOD 2) Then ' alternate the row colors by using the modulus
		  	ReturnedValue = "yes"
	        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
			Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
	      Else
	        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
	      End If ' #CEDAEC or #B0C4DE
	      for i = 0 to numFields
	        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
	          Response.Write "<td>&nbsp;</td>" & vbcrlf
	        Else
				'If i = 0 Then
				'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
				'Else
	          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
				'End If
				Select Case i
					Case 0
						Response.Write "<td>" & listData(i,j) & "</td>"
						'Response.Write "<td><a href=""../returns.asp"">Return</a>"
						'Response.Write "&nbsp;&nbsp;<a href=""../entryDo.asp"">Re-Rent</a></td>"
						'Response.Write "<td>" & listData(i,j) & "</td>"
						'Response.Write "<td><a href=""../returnDo.asp?rowId=" & listData(i,j) & """>Return</a>"
						'Response.Write "&nbsp;&nbsp;<a href=""../entryDo.asp?rowId=" & listData(i,j) & """>Re-Enter</a></td>"
					Case 1
						'Response.Write "<td><a href=""returnDo.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
						Response.Write "<td>" & listData(i,j) & "</td>"
					Case Else
						Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
				End Select
	        End If
	      next
	      Response.Write "</tr>" & vbcrlf
	    next
	    ' close the table
		Response.Write "<tr style=""background-color:#ffffff;""><td colspan=5><a href=""../returns.asp"">Return</a>"
		Response.Write "&nbsp;&nbsp;<a href=""../entryDo.asp"">Re-Rent</a></td></tr>"
	    Response.Write "</table>" & vbcrlf
	End If
  End If
End Sub



Sub displayAdminView(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=300 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
				Case 1
					Response.Write "<td><a href=""registration/edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case 2
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub


Sub displayEventsView(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
 	Dim TempType
	TempType = "none"
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    'Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=300 align=center>" & vbcrlf
	Response.Write "<table border=0 cellpadding=2 cellspacing=1 width=""60%"" align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
	'for j=NumRecords to 0 step -1
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		'Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">&nbsp;</td>" & vbcrlf
      Else
        'Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">&nbsp;</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      'for i = 0 to numFields
	  for i = NumFields to 0 step -1
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
				Case 1
					Response.Write "<td><a href=""event_view.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case 2
					If (listData(i,j)<>TempType) Then
						Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
						TempType = listData(i,j)
					Else
						Response.Write "<td>&nbsp;</td>"
					End If
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub



Sub displayRegistrarView(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=300 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
				Case 1
					Response.Write "<td><a href=""classes/edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case 2
					Response.Write "<td>" & ConvertDateDisplay(listData(i,j)) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub


Sub displayInstructorView(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=300 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
				Case 1
					Response.Write "<td><br><form method=""POST"" name=""linkForm" & j & """ action=""attendance/index.asp""><input type=""hidden"" name=""SearchClassId"" value=""" & listData(i-1,j) & """><a href=""Javascript:document.linkForm" & j & ".submit()"">" & listData(i,j) & "</a></form></td>"

					'Response.Write "<td><a href=""attendance/edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case 2
					Response.Write "<td>" & ConvertDateDisplay(listData(i,j)) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub



Sub displayCommunicationsData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a>&nbsp;&nbsp;<a href=""send.asp?rowId=" & listData(i,j) & """>Send</a></td>"
				Case 1
					Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub




Sub displayTrackCourseData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
					Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?TrackId=" & listData(i,j) & "&CourseId=" & listData(i+1,j) & "&CourseOrder=" & listData(i+2,j) & """>Remove</a></td>"
				Case 1,2
					'Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
					'Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
				Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub



Sub displayCoursePrereqData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
					Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?CourseId=" & listData(i,j) & "&PrereqId=" & listData(i+1,j) & "&PrereqOrder=" & listData(i+2,j) & """>Remove</a></td>"
				Case 1,2
					'Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
					'Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
				Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub




Sub displayCourseInstructorData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
					Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?CourseId=" & listData(i,j) & "&UserId=" & listData(i+1,j) & """>Remove</a></td>"
				Case 3
					'Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
					'Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
					Response.Write "<td>" & listData(i,j) & ", " & listData(i-1,j) & "</td>" & vbcrlf
				Case 4
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
				Case Else
					'nothing
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub



Sub displayCourseInterestListEmailData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			'Select Case i
			'	Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?CourseId=" & listData(i,j) & "&UserId=" & listData(i+1,j) & """>Remove</a></td>"
			'	Case 3
					'Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
					'Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'		Response.Write "<td>" & listData(i,j) & ", " & listData(i-1,j) & "</td>" & vbcrlf
			'	Case 4
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'	Case Else
					'nothing
			'End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub




Sub displayLearningPathsData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a>&nbsp;&nbsp;<a href=""view.asp?rowId=" & listData(i,j) & """>View</a></td>"
					Response.Write "<td><a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a>,&nbsp;&nbsp;<a href=""view.asp?rowId=" & listData(i,j) & """>Events</a></td>"
					'Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case 1
					Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub



Sub displayEventsRegistrantsData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & """>Remove</a></td>"
					Response.Write "<td><a href=""delete.asp?rowId=" & listData(i,j) & "&eventId=" & Request.QueryString("rowId") & """>Remove</a></td>"
			'	Case 1
			'		Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub






Sub displayTrackCoursesData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			'Select Case i
			'	Case 0
			'		Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a>&nbsp;&nbsp;<a href=""view.asp?rowId=" & listData(i,j) & """>View</a></td>"
			'	Case 1
			'		Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
			'	Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub



Sub displaySignUpSheet(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=1 cellpadding=2 cellspacing=1 bordercolor=black width=700 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr bgcolor=black>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th bgcolor=white>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
       'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr bgcolor=black>" & vbcrlf & "<td bgcolor=white align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr bgcolor=black>" & vbcrlf & "<td bgcolor=white align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td bgcolor=white><font color=white>&nbsp;&nbsp;</font></td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			'Select Case i
			'	Case 0
			'		Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a>&nbsp;&nbsp;<a href=""view.asp?rowId=" & listData(i,j) & """>View</a></td>"
			'	Case 7
			''		Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
			'	Case Else
					Response.Write "<td bgcolor=white>" & listData(i,j) & "</td>" & vbcrlf
			'End Select
        End If
      next
      Response.Write "<td bgcolor=white><font color=white>&nbsp;&nbsp;&nbsp;&nbsp;</font></td></tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub


Sub displayCourseSheet(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=1 cellpadding=2 cellspacing=1 bordercolor=black width=700 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr bgcolor=black>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th bgcolor=white>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
       'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr bgcolor=black>" & vbcrlf & "<td bgcolor=white align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr bgcolor=black>" & vbcrlf & "<td bgcolor=white align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td bgcolor=white><font color=white>&nbsp;&nbsp;</font></td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			'Select Case i
			'	Case 0
			'		Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a>&nbsp;&nbsp;<a href=""view.asp?rowId=" & listData(i,j) & """>View</a></td>"
			'	Case 7
			''		Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
			'	Case Else
					Response.Write "<td bgcolor=white>" & listData(i,j) & "</td>" & vbcrlf
			'End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub




Sub displayLocationsData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
					Response.Write "<td><a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
				Case 1
					Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub


Sub displayClassesData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & """>Remove</a></td>"
					'Response.Write "<td><a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a>, <a href=""list.asp?rowId=" & listData(i,j) & """>Registrants</a></td>"
				'Case 1
				'	'Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & ConvertDateDisplay(listData(i,j)) & "</a></td>"
				'	Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & ConvertDateLong(listData(i,j)) & "</a></td>"
				Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub


Sub displayEventsData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
					Response.Write "<td><a href=""registration.asp?rowId=" & Request.QueryString("rowId") & "&" & "instanceId=" & listData(i,j) & """>Register</a></td>"
				Case 1
					'Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & ConvertDateDisplay(listData(i,j)) & "</a></td>"
					Response.Write "<td><a href=""instance_view.asp?rowId=" & listData(i-1,j) & """>" & ConvertDateLong(listData(i,j)) & "</a></td>"
				Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub


Sub displayRegistrationsData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
				Case 1
					Response.Write "<td>" & ConvertDateDisplay(listData(i,j)) & "</td>"
				Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub






Sub displayRegistrationsRemoveData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a></td>"
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a></td>"
				Case 1
					Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & ConvertDateDisplay(listData(i,j)) & "</a></td>"
				Case 2
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
				Case 3
					'nothing
				Case 4
					Response.Write "<td>" & listData(i-1,j) & " " & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub



Sub displayEventsChronologyData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=0 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		'Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">&nbsp;</td>" & vbcrlf
      Else
        'Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">&nbsp;</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a>,"
					''Response.Write "<td><a href=""event_view.asp?rowId=" & listData(i,j) & """>View</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""tracks.asp?rowId=" & listData(i,j) & """>Paths</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""prereqs.asp?rowId=" & listData(i,j) & """>Prereqs</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""instructors.asp?rowId=" & listData(i,j) & """>Instructors</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""list.asp?rowId=" & listData(i,j) & """>Registrants</a>"
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
					'Response.Write "<td>&nbsp;</td>" & vbcrlf
					Response.Write "</td>"
				Case 1
					'Response.Write "<td><a href=""event_view.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case 2
					'Response.Write "<td><a href=""event_view.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
					'Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
					'Response.Write "<td><a href=""event_view.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case 3
					'Response.Write "<td><a href=""event_view.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
					'Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
					Response.Write "<td><a href=""event_view.asp?rowId=" & listData(i,j) & """>" & listData(i-2,j) & "</a> - " & listData(i-1,j) & "</td>"
				Case 4
					'Response.Write "<td><a href=""event_view.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
					'Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
					Response.Write "<td><div align=center><a href=""instance_view.asp?rowId=" & listData(i,j) & """><img src=""images/view.gif"" border=0></a>&nbsp;<a href=""registration.asp?rowId=" & listData(i-1,j) & "&amp;instanceId=" & listData(i,j) & """><img src=""images/register.gif"" border=0></a></div></td>"
				Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub



Sub displayCourseData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 0
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a>"
					Response.Write "<td><a href=""edit.asp?rowId=" & listData(i,j) & """>Edit</a>,"
					'Response.Write "&nbsp;&nbsp;<a href=""tracks.asp?rowId=" & listData(i,j) & """>Paths</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""prereqs.asp?rowId=" & listData(i,j) & """>Prereqs</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""instructors.asp?rowId=" & listData(i,j) & """>Instructors</a>"
					Response.Write "&nbsp;&nbsp;<a href=""list.asp?rowId=" & listData(i,j) & """>Registrants</a>"
					Response.Write "</td>"
				Case 1
					Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
				Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub




Sub displayRosterData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 1
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>"
					Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>Attendance</a>"
					Response.Write "&nbsp;&nbsp;<a href=""certificate.asp?rowId=" & listData(i-1,j) & """ target=""_blank"">Certificate</a>"
					Response.Write "&nbsp;&nbsp;<a href=""view.asp?rowId=" & listData(i,j) & """>Transcript</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""prereqs.asp?rowId=" & listData(i,j) & """>Prereqs</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""instructors.asp?rowId=" & listData(i,j) & """>Instructors</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""list.asp?rowId=" & listData(i,j) & """>List</a>"
					Response.Write "</td>"
				Case 3
					Response.Write "<td><a href=""view.asp?rowId=" & listData(i-2,j) & """>" & listData(i-1,j) & "&nbsp;" & listData(i,j) & "</a></td>"
				Case 4
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub



Sub displayCourseRosterData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End If
			Select Case i
				Case 1
					'Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?rowId=" & listData(i,j) & "&amp;status=Inactive" & """>Remove</a>"
					Response.Write "<td><a href=""edit.asp?rowId=" & listData(i-1,j) & """>Attendance</a>"
					Response.Write "&nbsp;&nbsp;<a href=""certificate.asp?rowId=" & listData(i-1,j) & """ target=""_blank"">Certificate</a>"
					Response.Write "&nbsp;&nbsp;<a href=""view.asp?rowId=" & listData(i,j) & """>Transcript</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""prereqs.asp?rowId=" & listData(i,j) & """>Prereqs</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""instructors.asp?rowId=" & listData(i,j) & """>Instructors</a>"
					'Response.Write "&nbsp;&nbsp;<a href=""list.asp?rowId=" & listData(i,j) & """>List</a>"
					Response.Write "</td>"
				Case 3
					Response.Write "<td><a href=""view.asp?rowId=" & listData(i-2,j) & """>" & listData(i-1,j) & "&nbsp;" & listData(i,j) & "</a></td>"
				Case 4, 5
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			End Select
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub




Sub displayEblastData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th>" & FieldHeaders(i) & "</th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			'If i = 0 Then
			'	Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & """>Remove</a></td>"
			'Else
          	'	Response.Write "<td>" & listData(i,j) & "</td></tr>" & vbcrlf
			'End If
			'Select Case i
			'	Case 0
			'		Response.Write "<td><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetId=" & listData(i,j) & "&amp;assetActive=0" & """>Remove</a></td>"
			'	Case 1
			'		Response.Write "<td><a href=""equipment.asp?assetId=" & listData(i-1,j) & """>" & listData(i,j) & "</a></td>"
			'	Case Else
					Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
			'End Select
        End If
      next
      'Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub


Sub displayAdminAssetData(rptTitle, listData, FieldHeaders, FieldNames)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 bgcolor=CCCC99 width=600 align=center>" & vbcrlf
    ' spit out the table headers
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf & "<th>&nbsp;</th>" & vbcrlf
	 'For i = 0 To numHeaders-1    Change by GFS on 5/5/03
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      Response.Write "<th><a href=""" & Request.ServerVariables("SCRIPT_NAME") & "?assetOrder=" & FieldNames(i) & """>" & FieldHeaders(i) & "</a></th>" & vbcrlf
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
      End If ' #CEDAEC or #B0C4DE
      for i = 0 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
          Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub


Sub displayCheckboxData(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
    ' start a table 
    Response.Write "<table border=0 cellpadding=2 cellspacing=1 width=600 align=center><tr>" & vbcrlf
    ' spit out the listedData
	k=0
    For j=0 to numRecords
      For i = 1 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          'Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			Response.Write "<td><input type=checkbox name=""" & rptTitle & """ value=""" & listData(i-1,j) & """>" & listData(i,j) & "</td>"
			If Not (i MOD 4) Then
			 	Response.Write "</tr><tr>"
			End If
        End If
      Next
      'Response.Write "</tr>" & vbcrlf
    Next
    ' close the table
    Response.Write "</tr></table>" & vbcrlf
  End If
End Sub


Sub displaySelectData(listData)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<option>None Available</option>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
	k=0
    For j=0 to numRecords
      For i = 1 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          'Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			Response.Write "<option value=""" & listData(i-1,j) & """>" & listData(i,j) & "</option>"
        End If
      Next
    Next
  End If
End Sub

Sub displaySelectClassData(listData)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<option>None Available</option>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
	k=0
    For j=0 to numRecords
      For i = 2 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          'Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			Response.Write "<option value=""" & listData(i-2,j) & """>" & ConvertDateLong(listData(i-1,j)) & " " & listData(i,j) & "</option>"
        End If
      Next
    Next
  End If
End Sub


Sub displaySelectUserData(listData)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<option>None Available</option>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
	k=0
    For j=0 to numRecords
      For i = 2 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          'Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			Response.Write "<option value=""" & listData(i-2,j) & """>" & listData(i-1,j) & ", " & listData(i,j) & "</option>"
        End If
      Next
    Next
  End If
End Sub

Sub displaySelectDateData(listData)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<option>None Available</option>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
	k=0
    For j=0 to numRecords
      For i = 1 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          'Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			Response.Write "<option value=""" & listData(i-1,j) & """>" & ConvertDateDisplay(CStr(listData(i,j))) & "</option>"
        End If
      Next
    Next
  End If
End Sub


Sub displaySelectDataSelected(listData, selectedValue)
 ' check for empty set, spit out the "try again" message
 'Response.Write selectedValue & "<br>"
  If Not IsArray (listData) Then 
    Response.Write "<option>None Available</option>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
	k=0
    For j=0 to numRecords
      For i = 1 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          'Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			Response.Write "<option value=""" & listData(i-1,j) & """"
			If (listData(i-1,j) = selectedValue) Then
				Response.Write " selected"
			End If
			Response.Write ">" & listData(i,j) & "</option>"
        End If
      Next
    Next
  End If
End Sub


Sub displaySelectClassDataSelected(listData, selectedValue)
 ' check for empty set, spit out the "try again" message
 'Response.Write selectedValue & "<br>"
  If Not IsArray (listData) Then 
    Response.Write "<option>None Available</option>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
	k=0
    For j=0 to numRecords
      For i = 2 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          'Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			Response.Write "<option value=""" & listData(i-2,j) & """"
			If (listData(i-2,j) = selectedValue) Then
				Response.Write " selected"
			End If
			Response.Write ">" & ConvertDateLong(listData(i-1,j)) & " " & listData(i,j) & "</option>"
        End If
      Next
    Next
  End If
End Sub


Sub displaySelectUserDataSelected(listData, selectedValue)
 ' check for empty set, spit out the "try again" message
 'Response.Write selectedValue & "<br>"
  If Not IsArray (listData) Then 
    Response.Write "<option>None Available</option>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
	k=0
    For j=0 to numRecords
      For i = 2 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          'Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			Response.Write "<option value=""" & listData(i-2,j) & """"
			If (listData(i-2,j) = selectedValue) Then
				Response.Write " selected"
			End If
			Response.Write ">" & listData(i-1,j) & ", " & listData(i,j) & "</option>"
        End If
      Next
    Next
  End If
End Sub

Sub displaySelectDateDataSelected(listData, selectedValue)
 ' check for empty set, spit out the "try again" message
 'Response.Write selectedValue & "<br>"
  If Not IsArray (listData) Then 
    Response.Write "<option>None Available</option>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
	k=0
    For j=0 to numRecords
      For i = 1 to numFields
        If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
          'Response.Write "<td>&nbsp;</td>" & vbcrlf
        Else
			Response.Write "<option value=""" & listData(i-1,j) & """"
			If (listData(i-1,j) = selectedValue) Then
				Response.Write " selected"
			End If
			Response.Write ">" & ConvertDateDisplay(CStr(listData(i,j))) & "</option>"
        End If
      Next
    Next
  End If
End Sub


'Displays the options of a Yes/No Select list for the selected value
Sub displayYesNoSelect(selectedValue)
	'Response.Write VarType(selectedValue)
	If selectedValue=True Then
		Response.Write "<option value=""1"" selected>Yes</option>"
	Else
		Response.Write "<option value=""1"">Yes</option>"
	End If
	If selectedValue=False Then
		Response.Write "<option value=""0"" selected>No</option>"
	Else
		Response.Write "<option value=""0"">No</option>"
	End If

End Sub 

Sub MailNotice(mailTo, mailSubject, mailText, mailFrom)
	'Dim mailFrom
	'mailFrom = "webmaster@concerto.com"
	'Response.Write "cc is " & mailCC & "<br>"
	Set mailMessage = Server.CreateObject("CDONTS.NewMail")
	mailMessage.From = mailFrom
	mailMessage.To = mailTo
	'Response.Write mailTo & "<br>"
	mailMessage.cc = ""
	mailMessage.Subject = mailSubject
	mailMessage.Body = mailText
	mailMessage.Send 
	Set mailMessage = Nothing
	'Response.Write "the text if the message is " & mailText & "<br>"
End Sub


Sub GenerateMailNotice(ClassId, UserId, Recipient)
	Dim numFields, CommunicationsText, SubjectLine, SQLString, SendTo

'Get information about the registrations and registrants
	SQLString = "SELECT events.event_name, event_instances.event_date_start, event_instances.event_date_end, locations.location_name, locations.description, users.coordinator_name, users.coordinator_email"
	'SQLString = SQLString & ", Course.Course_Name, Class.Class_Date_Start, Registration.Payment_Type"
	'SQLString = SQLString & ", Registration.Payment_Status, Registration.Registration_Price, CRA_User.Email_Address, CRA_User.Username, CRA_User.Password"
	SQLString = SQLString & " FROM events, event_instances, locations, users"
	SQLString = SQLString & " WHERE events.event_id=event_instances.event_id"
	SQLString = SQLString & " AND event_instances.location_id=locations.location_id"
	SQLString = SQLString & " AND events.created_by=users.username"
	'SQLString = SQLString & " AND Registration.Registration_ID=" & RegistrationId
	'SQLString = SQLString & " AND Registration.User_ID=" & UserId
	SQLString = SQLString & " AND event_instances.instance_id=" & ClassId
	'SQLString = SQLString & " ORDER BY Registration.Registration_ID DESC"
	'Response.Write SQLString & "<br>"
	Call GetData(ConnectionString,SQLString)

	If Not IsArray (listedData) Then
	  	Response.Write "<p>No confirmation email sent.</p>"
		'Don't send an email
	Else
		'numFields = UBound(listedData,1)
		'Response.Write "numfields is " & numFields & "<br>"
		
		CommunicationsText = UserId & "," & vbcrlf & vbcrlf
		'CommunicationsText = listedData(0,0) & " " & listedData(1,0) & " " & listedData(2,0) & "," & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & "Good Day.  Your registration request for '" & listedData(0,0) & "' has been received.  A place has been reserved for you for this event.  "
		CommunicationsText = CommunicationsText & "Please review the following:" & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Event: " & listedData(0,0) & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Event Begin Date: " & ConvertDateLong(listedData(1,0)) & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Event End Date: " & ConvertDateLong(listedData(2,0)) & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Location: " & listedData(3,0) & ", " & listedData(4,0) & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & "If you have any questions regarding this assignment, please contact " & listedData(5,0) & " at " & listedData(6,0) & "." & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & "Regards," & vbcrlf & "Concerto Software"

		SendTo = Recipient
		SubjectLine = listedData(0,0) & " Event Registration"
		'Response.Write CommunicationsText & "<br>"
		'Response.Write SendTo & "<br>"
		Call MailNotice(SendTo, SubjectLine, CommunicationsText, listedData(6,0))
		Response.Write "<p>An email has been sent to you confirming your registration and containing a summary of your registration information.</p>"
		
		'Generate the Admin Email
		CommunicationsText = listedData(5,0) & "," & vbcrlf & vbcrlf
		'CommunicationsText = listedData(0,0) & " " & listedData(1,0) & " " & listedData(2,0) & "," & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & "Good Day.  A registration request for '" & listedData(0,0) & "' has been received from " & UserId & " whose email address is " & Recipient & ".  "
		CommunicationsText = CommunicationsText & "The following information was submitted:" & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Event: " & listedData(0,0) & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Event Begin Date: " & ConvertDateLong(listedData(1,0)) & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Event End Date: " & ConvertDateLong(listedData(2,0)) & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Location: " & listedData(3,0) & ", " & listedData(4,0) & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & "If you have any questions regarding this notification, please contact webmaster@concerto.com." & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & "Regards," & vbcrlf & "Concerto Software"
		SendTo = listedData(6,0)
		SubjectLine = listedData(0,0) & " Event Registration Submitted"
		Call MailNotice(SendTo, SubjectLine, CommunicationsText, "webmaster@concerto.com")
	End If
End Sub



Sub GenerateAdminMailNotice(ClassId, UserId, Recipient)
	Dim numFields, CommunicationsText, SubjectLine, SQLString, SendTo

'Get information about the registrations and registrants
	SQLString = "SELECT events.event_name, event_instances.event_date_start, event_instances.event_date_end, locations.location_name, locations.description, users.coordinator_name, users.coordinator_email"
	'SQLString = SQLString & ", Course.Course_Name, Class.Class_Date_Start, Registration.Payment_Type"
	'SQLString = SQLString & ", Registration.Payment_Status, Registration.Registration_Price, CRA_User.Email_Address, CRA_User.Username, CRA_User.Password"
	SQLString = SQLString & " FROM events, event_instances, locations, users"
	SQLString = SQLString & " WHERE events.event_id=event_instances.event_id"
	SQLString = SQLString & " AND event_instances.location_id=locations.location_id"
	SQLString = SQLString & " AND events.created_by=users.username"
	'SQLString = SQLString & " AND Registration.Registration_ID=" & RegistrationId
	'SQLString = SQLString & " AND Registration.User_ID=" & UserId
	SQLString = SQLString & " AND event_instances.instance_id=" & ClassId
	'SQLString = SQLString & " ORDER BY Registration.Registration_ID DESC"
	'Response.Write SQLString & "<br>"
	Call GetData(ConnectionString,SQLString)

	If Not IsArray (listedData) Then
	  	Response.Write "<p>No confirmation email sent.</p>"
		'Don't send an email
	Else
		'numFields = UBound(listedData,1)
		'Response.Write "numfields is " & numFields & "<br>"
		
		CommunicationsText = UserId & "," & vbcrlf & vbcrlf
		'CommunicationsText = listedData(0,0) & " " & listedData(1,0) & " " & listedData(2,0) & "," & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & "Good Day.  Your registration request for '" & listedData(0,0) & "' has been received.  A place has been reserved for you for this event.  "
		CommunicationsText = CommunicationsText & "Please review the following:" & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Event: " & listedData(0,0) & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Event Begin Date: " & ConvertDateLong(listedData(1,0)) & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Event End Date: " & ConvertDateLong(listedData(2,0)) & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Location: " & listedData(3,0) & ", " & listedData(4,0) & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & "If you have any questions regarding this assignment, please contact " & listedData(5,0) & " at " & listedData(6,0) & "." & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & "Regards," & vbcrlf & "Concerto Software"

		SendTo = Recipient
		SubjectLine = listedData(0,0) & " Event Registration"
		'Response.Write CommunicationsText & "<br>"
		'Response.Write SendTo & "<br>"
		'Call MailNotice(SendTo, SubjectLine, CommunicationsText, listedData(6,0))
		'Response.Write "<p>An email has been sent to you confirming your registration and containing a summary of your registration information.</p>"
		Call MailNotice(listedData(6,0), SubjectLine, CommunicationsText, "webmaster@concerto.com")
	End If
End Sub


Sub GenerateInstructorNotice(CourseId, InstructorId, ClassroomId)
	Dim numFields, CommunicationsText, SubjectLine, SQLString, SendTo
	
'Get the text of the message from the Communications Table
	'SQLString = "SELECT Comm_Text, Description FROM Communications WHERE Status='Active' AND Comm_Name='" & CommName & "'"
	''Response.Write SQLString & "<br>"
	'Call GetData(ConnectionString,SQLString)
	'CommunicationsText = Replace(listedData(0,0), "&#039;", "'")
	'SubjectLine = Replace(listedData(1,0), "&#039;", "'")
	''Response.Write CommunicationsText & "<br>"

'Get information about the class
	SQLString = "SELECT CRA_User.Salutation, CRA_User.First_Name, CRA_User.Last_Name, CRA_User.Email_Address"
	SQLString = SQLString & ", Course.Course_Name, Class.Class_Date_Start, Class.Class_Date_End, Classroom.Classroom_Name"
	SQLString = SQLString & " FROM CRA_User, Course, Class, Classroom"
	SQLString = SQLString & " WHERE Class.Instructor_ID=CRA_User.User_ID"
	SQLString = SQLString & " AND Course.Course_ID=Class.Course_ID"
	SQLString = SQLString & " AND Classroom.Classroom_ID=Class.Classroom_ID"
	SQLString = SQLString & " AND Class.Classroom_ID=" & ClassroomId
	SQLString = SQLString & " AND Class.Instructor_ID=" & InstructorId
	SQLString = SQLString & " AND Class.Course_ID=" & CourseId
	SQLString = SQLString & " ORDER BY Class.Class_ID DESC"
	'Response.Write SQLString & "<br>"
	Call GetData(ConnectionString,SQLString)

	If Not IsArray (listedData) Then
	  	Response.Write "<p>No attendees in this class.</p>"
	Else
		SendTo = listedData(3,0)
		SubjectLine = "New Class Assignment"
		CommunicationsText = listedData(0,0) & " " & listedData(1,0) & " " & listedData(2,0) & "," & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & "Good Day.  You have been assigned to teach the following:" & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Course: " & listedData(4,0) & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Class Start Date: " & ConvertDateDisplay(listedData(5,0)) & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Class End Date: " & ConvertDateDisplay(listedData(6,0)) & vbcrlf
		CommunicationsText = CommunicationsText & vbTab & "Classroom: " & listedData(7,0) & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & "If you have any questions regarding this assignment, please contact your local registrar." & vbcrlf & vbcrlf
		CommunicationsText = CommunicationsText & "Regards," & vbcrlf & "Concerto Educational Services"
		'Response.Write CommunicationsText & "<br>"
		'Response.Write SendTo & "<br>"
		Call MailNotice(SendTo, SubjectLine, CommunicationsText)
		
	End If
End Sub


Function GenerateUsageNumber(ConnectionString,EquipmentId)
	Dim SQLString3, Result
	Result = "0"
	'listedData2 = Result

'Get information from transactions table
	SQLString3 = "SELECT COUNT(id) FROM transactions WHERE equipment_id='" & EquipmentId & "'"
	'Response.Write SQLString3 & "<br>"
	Call GetData(ConnectionString,SQLString3)
	'Response.Write listedData2 & "<br>"
	'If IsArray(listedData2) Then
	'	Result = listedData2(0,0)		
	'End If
	
	GenerateUsageNumber = Result
End Function




Sub MailEblastAdmin(mailTo, mailSubject)
	Dim mailFrom, mailText, strKey, strValue, mailFooter
	mailFrom = "webmaster@davox.com"
	mailText = "The following information was forwarded from your intranet form:" & vbNewLine & vbNewLine
	mailFooter = "Thank you for using the Concerto Intranet.  Please refer any questions to the Web Team."
	
	For Each Item In Request.Form
		strKey = CStr(Item)
		strValue = CStr(Request.Form(Item))
		'Response.Write("The key is " & strKey & " and the value is " & strValue & "<BR>")
		If (Item <> "submit") Then
			If (strKey = "EblastType") Then
				mailText = mailText & strKey & ": " & EblastType & vbNewLine
			ElseIf (strKey = "ListType") Then
				mailText = mailText & strKey & ": " & ListType & vbNewLine
			Else
				mailText = mailText & strKey & ": " & strValue & vbNewLine
			End If
		End If
	Next
	
	mailText = mailText & vbNewLine & mailFooter
	Set mailMessage = Server.CreateObject("CDONTS.NewMail")
	mailMessage.From = mailFrom
	mailMessage.To = mailTo
	mailMessage.Bcc = "gscarfo@concerto.com"
	mailMessage.Subject = mailSubject
	mailMessage.Body = mailText
	mailMessage.Send 
	Set mailMessage = Nothing
End Sub



Function ConvertDateDisplay(DateEntry)
	Dim TempDate
	'Response.Write DateEntry & "<br>"
	TempDate = Split(DateEntry, "-")
	If IsArray(TempDate) Then
		DateString = TempDate(1) & "/" & TempDate(2) & "/" & TempDate(0)
	Else
		DateString = "Date Error"
	End If
	ConvertDateDisplay = DateString
End Function


Function ConvertDateInput(DateEntry)
	Dim TempDate
	'Response.Write DateEntry & "<br>"
	TempDate = Split(DateEntry, "/")
	If IsArray(TempDate) Then
		If (CStr(TempDate(0)) = "1") OR (CStr(TempDate(0)) = "2") OR (CStr(TempDate(0)) = "3") OR (CStr(TempDate(0)) = "4") OR (CStr(TempDate(0)) = "5") OR (CStr(TempDate(0)) = "6") OR (CStr(TempDate(0)) = "7") OR (CStr(TempDate(0)) = "8") OR (CStr(TempDate(0)) = "9") Then
			TempDate(0) = "0" & TempDate(0)
		End If
		
		'If (CStr(TempDate(1)) < "10") Then
		If (CStr(TempDate(1)) = "1") OR (CStr(TempDate(1)) = "2") OR (CStr(TempDate(1)) = "3") OR (CStr(TempDate(1)) = "4") OR (CStr(TempDate(1)) = "5") OR (CStr(TempDate(1)) = "6") OR (CStr(TempDate(1)) = "7") OR (CStr(TempDate(1)) = "8") OR (CStr(TempDate(1)) = "9") Then
			TempDate(1) = "0" & TempDate(1)
		End If
		DateString = TempDate(2) & "-" & TempDate(0) & "-" & TempDate(1)
	Else
		DateString = "Date Error"
	End If
	ConvertDateInput = DateString
End Function


Function ConvertDateLong(DateEntry)
	Dim TempDate
	'Response.Write DateEntry & "<br>"
	TempDate = Split(DateEntry, "/")
	If IsArray(TempDate) Then
		If (CStr(TempDate(0)) = "1") OR (CStr(TempDate(0)) = "2") OR (CStr(TempDate(0)) = "3") OR (CStr(TempDate(0)) = "4") OR (CStr(TempDate(0)) = "5") OR (CStr(TempDate(0)) = "6") OR (CStr(TempDate(0)) = "7") OR (CStr(TempDate(0)) = "8") OR (CStr(TempDate(0)) = "9") Then
			TempDate(0) = "0" & TempDate(0)
		End If
		
		'If (CStr(TempDate(1)) < "10") Then
		If (CStr(TempDate(1)) = "1") OR (CStr(TempDate(1)) = "2") OR (CStr(TempDate(1)) = "3") OR (CStr(TempDate(1)) = "4") OR (CStr(TempDate(1)) = "5") OR (CStr(TempDate(1)) = "6") OR (CStr(TempDate(1)) = "7") OR (CStr(TempDate(1)) = "8") OR (CStr(TempDate(1)) = "9") Then
			TempDate(1) = "0" & TempDate(1)
		End If
		
		TempDate(2) = "20" & TempDate(2)
		
		DateString = TempDate(0) & "/" & TempDate(1) & "/" & TempDate(2)
	Else
		DateString = "Date Error"
	End If
	ConvertDateLong = DateString
End Function


Function ConvertDateOutlook(DateEntry)
	Dim TempDate
	'Response.Write DateEntry & "<br>"
	TempDate = Split(DateEntry, "/")
	If IsArray(TempDate) Then
		If (CStr(TempDate(0)) = "1") OR (CStr(TempDate(0)) = "2") OR (CStr(TempDate(0)) = "3") OR (CStr(TempDate(0)) = "4") OR (CStr(TempDate(0)) = "5") OR (CStr(TempDate(0)) = "6") OR (CStr(TempDate(0)) = "7") OR (CStr(TempDate(0)) = "8") OR (CStr(TempDate(0)) = "9") Then
			TempDate(0) = "0" & TempDate(0)
		End If
		
		'If (CStr(TempDate(1)) < "10") Then
		If (CStr(TempDate(1)) = "1") OR (CStr(TempDate(1)) = "2") OR (CStr(TempDate(1)) = "3") OR (CStr(TempDate(1)) = "4") OR (CStr(TempDate(1)) = "5") OR (CStr(TempDate(1)) = "6") OR (CStr(TempDate(1)) = "7") OR (CStr(TempDate(1)) = "8") OR (CStr(TempDate(1)) = "9") Then
			TempDate(1) = "0" & TempDate(1)
		End If
		
		TempDate(2) = "20" & TempDate(2)
		
		DateString = TempDate(2) &  TempDate(0) & TempDate(1)
	Else
		DateString = "Date Error"
	End If
	ConvertDateOutlook = DateString
End Function

%>