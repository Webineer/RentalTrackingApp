<%

' create a function that we can use to grab info from the database
Function GetData(ConnectionString,SQLString)
  Set oConn = Server.CreateObject("ADODB.Connection")
  oConn.Open ConnectionString
	'Response.Write (SQLString)
  Set oRs = oConn.Execute(SQLString,lngRecs,adCmdText)
  'oRs.MoveFirst
  If oRs.BOF And oRs.EOF Then 
    listedData = noData
  Else
    listedData = oRs.GetRows
  End If
  ReDim colHeaders(oRs.Fields.Count)
  For i = 0 To oRs.Fields.Count - 1
    colHeaders(i) = replace(oRs.Fields(i).Name,"_"," ")
  Next
  oRs.Close: Set oRs = Nothing
  oConn.Close: Set oConn = Nothing
End Function

Sub EnterFormData(ConnectionString, TableName, Form2DbArray, DbType)
'This is a subroutine that takes a set of fields from a form and inserts
'it into a database.  This subroutine assumes that all of the form fields are
'being inserted into the database table.  This subroutine also assumes the following:

'ConnectionString is the DSN information, which includes the DSN name, db username, and db password.

'TableName is the name of the table in the database where the data is being inserted

'Form2DbArray is a preset array in the form that maps the form fields to the database fields (this
' array translates the form fields, as they appear in the form, to the database fields, respectively)
' defining to the subroutine the order of the form fields relative to the database fields (ORDER IS 
' IMPORTANT - use the form field order with the database field names)
'
'DbType defines to the script the type of database being inserted into; MSAccess or SQLServer are 
' the acceptable inputs.
'
	Dim SQLString, SQLString2, DateDelimiter, ParameterString, ValuesString
	'Dim NumFields
	
'Sets the Date delimiter;for Access db is (#); SQLServer uses (")
	If (DbType = "MSAccess") Then
		DateDelimiter = "#"
	Else
		DateDelimiter = "'"
	End If
 
'If no Table is defined, skip everything
	If (TableName <> "") Then

'This SQL search used to define the types of fields in the table
	    SQLString = "SELECT * FROM " & TableName
		'Response.Write SQLString & "<BR>"
'Open the DB Connection
	    Set oConn = Server.CreateObject("ADODB.Connection")
		oConn.Open ConnectionString
		'Set oRs = oConn.Execute(SQLString,lngRecs,adCmdText)

'Execute the SQL search of the table
		On Error Resume Next
		Set oRs = oConn.Execute(TableName,,adCmdTable)
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL Insert of the new data failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		Else
			Response.Write "<p>Successful Entry Completed!</p>"
		End If
		
'Tests to see how the table data is returned to the script
		'Begin building Insert String
		'ParameterString = PrimaryKey
		'ValuesString = "NULL"
		
		'NumFields = oRs.Fields.count
		'For Each oField In oRs.Fields
		'	Response.Write oField.Type & " - "
		'	Response.Write oField.Name & "<br>"
		'Next
		
'Tests to see how the form fields are being handled in the Request Object array
		'For Each Item In Request.Form
		'	Response.Write Item & " - "
		'	Response.Write Request.Form(Item) & "<br>"
		'Next
		'Response.Write "<br><br>"
		
'Begin to build the insert SQL statement by looking from form fields in the array
		For i = 1 To UBound(Form2DbArray)+1
			'Response.Write Request.Form(i) & "<br>"
	
'If ParameterString (insert order) is empty, first field in the series; if not, concatenate
			If (ParameterString = "") Then
				ParameterString = Form2DbArray(i-1)
			Else
				ParameterString = ParameterString & ", " & Form2DbArray(i-1)
			End If
			
'If the ValuesString (form values to be inserted in order) is empty, first field in series; if not, concatenate
			For Each oField In oRs.Fields
				If (ValuesString = "") Then
					If (oField.Name = Form2DbArray(i-1)) Then
						'Response.Write oField.Name & "&nbsp;" & oField.Type & "<br>"
						If (oField.Type = 200 OR oField.Type = 201 OR oField.Type = 202 OR oField.Type = 203) Then
							ValuesString = "'" & Replace(CStr(Request.Form(i)), "'", "&#039;" ) & "'"
						ElseIf (oField.Type = "135") Then
							ValuesString = DateDelimiter & Request.Form(i) & DateDelimiter
						Else
							ValuesString = Request.Form(i)
						End If
					End If
				Else
					If (oField.Name = Form2DbArray(i-1)) Then
						'Response.Write oField.Name & "&nbsp;" & oField.Type & "<br>"
						If (oField.Type = 200 OR oField.Type = 201 OR oField.Type = 202 OR oField.Type = 203) Then
							ValuesString = ValuesString & ", '" & Replace(CStr(Request.Form(i)), "'", "&#039;" ) & "'"
						ElseIf (oField.Type = "135") Then
							ValuesString = ValuesString & ", " & DateDelimiter & Request.Form(i) & DateDelimiter
						Else
							ValuesString = ValuesString & ", " & Request.Form(i)
						End If
					End If
				End If
			Next
		Next

'Build the final SQL insert statement				
		SQLString2 = "INSERT into " & TableName & " (" & ParameterString & ") VALUES (" & ValuesString & ")"
'Check for errors		
		'Response.Write ParameterString & "<br>"
		'Response.Write ValuesString & "<br>"
		'Response.Write SQLString2 & "<br><br>"
		
'Execute the SQL insertion
		On Error Resume Next
		oConn.Execute SQLString2
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL Insert of the new data failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		End If
		'Response.Write "<p>The insert has been done.</p>"
		
'Close the record set and the connection
		oRs.Close
    	Set oRs = Nothing
		oConn.Close
		Set oConn = Nothing
	End If

End Sub


Sub EnterData(ConnectionString, TableName, Data2DbArray, DataArray, DbType)
'This is a subroutine that takes a set of fields from a form and inserts
'it into a database.  This subroutine assumes that all of the form fields are
'being inserted into the database table.  This subroutine also assumes the following:

'ConnectionString is the DSN information, which includes the DSN name, db username, and db password.

'TableName is the name of the table in the database where the data is being inserted

'Data2DbArray is a preset array in the form that maps the data fields to the database fields (this
' array translates the form fields, as they appear in the form, to the database fields, respectively)
' defining to the subroutine the order of the form fields relative to the database fields (ORDER IS 
' IMPORTANT - use the form field order with the database field names)
'
'DbType defines to the script the type of database being inserted into; MSAccess or SQLServer are 
' the acceptable inputs.
'
	Dim SQLString, SQLString2, DateDelimiter, ParameterString, ValuesString
	'Dim NumFields
	
'Sets the Date delimiter;for Access db is (#); SQLServer uses (")
	If (DbType = "MSAccess") Then
		DateDelimiter = "#"
	Else
		DateDelimiter = "'"
	End If
 
'If no Table is defined, skip everything
	If (TableName <> "") Then

'This SQL search used to define the types of fields in the table
	    SQLString = "SELECT * FROM " & TableName
		
'Open the DB Connection
	    Set oConn = Server.CreateObject("ADODB.Connection")
		oConn.Open ConnectionString
		'Set oRs = oConn.Execute(SQLString,lngRecs,adCmdText)

'Execute the SQL search of the table
		On Error Resume Next
		Set oRs = oConn.Execute(TableName,,adCmdTable)
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL grab of the data fields failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		End If
		
'Tests to see how the table data is returned to the script
		'Begin building Insert String
		'ParameterString = PrimaryKey
		'ValuesString = "NULL"
		
		'NumFields = oRs.Fields.count
		'For Each oField In oRs.Fields
		'	Response.Write oField.Type & " - "
		'	Response.Write oField.Name & "<br>"
		'Next
		
'Tests to see how the form fields are being handled in the Request Object array
		'For Each Item In Request.Form
		'	Response.Write Item & " - "
		'	Response.Write Request.Form(Item) & "<br>"
		'Next
		'Response.Write "<br><br>"
		
'Begin to build the insert SQL statement by looking from form fields in the array
		For i = 1 To UBound(Data2DbArray)+1
			'Response.Write Request.Form(i) & "<br>"
	
'If ParameterString (insert order) is empty, first field in the series; if not, concatenate
			If (ParameterString = "") Then
				ParameterString = Data2DbArray(i-1)
			Else
				ParameterString = ParameterString & ", " & Data2DbArray(i-1)
			End If
			
'If the ValuesString (form values to be inserted in order) is empty, first field in series; if not, concatenate
			For Each oField In oRs.Fields
				If (ValuesString = "") Then
					If (oField.Name = Data2DbArray(i-1)) Then
						'Response.Write oField.Name & "&nbsp;" & oField.Type & "<br>"
						If (oField.Type = 200 OR oField.Type = 201 OR oField.Type = 202 OR oField.Type = 203) Then
							ValuesString = "'" & Replace(CStr(DataArray(i-1)), "'", "&#039;" ) & "'"
						ElseIf (oField.Type = "135") Then
							ValuesString = DateDelimiter & DataArray(i-1) & DateDelimiter
						Else
							ValuesString = DataArray(i-1)
						End If
					End If
				Else
					If (oField.Name = Data2DbArray(i-1)) Then
						'Response.Write oField.Name & "&nbsp;" & oField.Type & "<br>"
						If (oField.Type = 200 OR oField.Type = 201 OR oField.Type = 202 OR oField.Type = 203) Then
							ValuesString = ValuesString & ", '" & Replace(CStr(DataArray(i-1)), "'", "&#039;" ) & "'"
						ElseIf (oField.Type = "135") Then
							ValuesString = ValuesString & ", " & DateDelimiter & DataArray(i-1) & DateDelimiter
						Else
							ValuesString = ValuesString & ", " & DataArray(i-1)
						End If
					End If
				End If
			Next
		Next

'Build the final SQL insert statement				
		SQLString2 = "INSERT into " & TableName & " (" & ParameterString & ") VALUES (" & ValuesString & ")"
'Check for errors		
		'Response.Write ParameterString & "<br>"
		'Response.Write ValuesString & "<br>"
		'Response.Write SQLString2 & "<br><br>"
		
'Execute the SQL insertion
		On Error Resume Next
		oConn.Execute SQLString2
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL Insert of the new data failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		End If
		'Response.Write "<p>The insert has been done.</p>"
		
'Close the record set and the connection
		oRs.Close
    	Set oRs = Nothing
		oConn.Close
		Set oConn = Nothing
	End If

End Sub



Sub UpdateFormData(ConnectionString, TableName, Form2DbArray, PrimaryKeyFieldName, PrimaryKeyFieldValue, DbType)
'This is a subroutine that takes a set of fields from a form and inserts
'it into a database.  This subroutine assumes that all of the form fields are
'being inserted into the database table.  This subroutine also assumes the following:

'ConnectionString is the DSN information, which includes the DSN name, db username, and db password.

'TableName is the name of the table in the database where the data is being inserted

'Form2DbArray is a preset array in the form that maps the form fields to the database fields (this
' array translates the form fields, as they appear in the form, to the database fields, respectively)
' defining to the subroutine the order of the form fields relative to the database fields (ORDER IS 
' IMPORTANT - use the form field order with the database field names)
'
'DbType defines to the script the type of database being inserted into; MSAccess or SQLServer are 
' the acceptable inputs.
'
	Dim SQLString, SQLString2, DateDelimiter, ValuesString
	'Dim NumFields
	
'Sets the Date delimiter;for Access db is (#); SQLServer uses (")
	If (DbType = "MSAccess") Then
		DateDelimiter = "#"
	Else
		DateDelimiter = "'"
	End If
 
'If no Table is defined, skip everything
	If (TableName <> "") Then

'This SQL search used to define the types of fields in the table
	    SQLString = "SELECT * FROM " & TableName
		
'Open the DB Connection
	    Set oConn = Server.CreateObject("ADODB.Connection")
		oConn.Open ConnectionString
		'Set oRs = oConn.Execute(SQLString,lngRecs,adCmdText)

'Execute the SQL search of the table
		On Error Resume Next
		Set oRs = oConn.Execute(TableName,,adCmdTable)
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL Insert of the new data failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		End If
		
'Tests to see how the table data is returned to the script
		'Begin building Insert String
		'ParameterString = PrimaryKey
		'ValuesString = "NULL"
		
		'NumFields = oRs.Fields.count
		'For Each oField In oRs.Fields
		'	Response.Write oField.Type & " - "
		'	Response.Write oField.Name & "<br>"
		'Next
		
'Tests to see how the form fields are being handled in the Request Object array
		'For Each Item In Request.Form
		'	Response.Write Item & " - "
		'	Response.Write Request.Form(Item) & "<br>"
		'Next
		'Response.Write "<br><br>"
		
'Begin to build the insert SQL statement by looking from form fields in the array
		For i = 1 To UBound(Form2DbArray)+1
			'Response.Write Request.Form(i) & "<br>"
			
'If the ValuesString (form values to be inserted in order) is empty, first field in series; if not, concatenate
			For Each oField In oRs.Fields
				If (ValuesString = "") Then
					If (oField.Name = Form2DbArray(i-1)) Then
						'Response.Write oField.Name & "&nbsp;" & oField.Type & "<br>"
						If (oField.Type = 200 OR oField.Type = 201 OR oField.Type = 202 OR oField.Type = 203) Then
							ValuesString = Form2DbArray(i-1) & "='" & Replace(CStr(Request.Form(i)), "'", "&#039;" ) & "'"
						ElseIf (oField.Type = "135") Then
							ValuesString = Form2DbArray(i-1) & "=" & DateDelimiter & Request.Form(i) & DateDelimiter
						Else
							ValuesString = Form2DbArray(i-1) & "=" & Request.Form(i)
						End If
					End If
				Else
					If (oField.Name = Form2DbArray(i-1)) Then
						'Response.Write oField.Name & "&nbsp;" & oField.Type & "<br>"
						If (oField.Type = 200 OR oField.Type = 201 OR oField.Type = 202 OR oField.Type = 203) Then
							ValuesString = ValuesString & ", " & Form2DbArray(i-1) & "='" & Replace(CStr(Request.Form(i)), "'", "&#039;" ) & "'"
						ElseIf (oField.Type = "135") Then
							ValuesString = ValuesString & ", " & Form2DbArray(i-1) & "=" & DateDelimiter & Request.Form(i) & DateDelimiter
						Else
							ValuesString = ValuesString & ", " & Form2DbArray(i-1) & "=" & Request.Form(i)
						End If
					End If
				End If
			Next
		Next

'Build the final SQL insert statement				
		'SQLString2 = "INSERT into " & TableName & " (" & ParameterString & ") VALUES (" & ValuesString & ")"
		SQLString2 = "UPDATE " & TableName & " SET " & ValuesString & " WHERE " & PrimaryKeyFieldName & "=" & PrimaryKeyFieldValue
'Check for errors		
		'Response.Write ParameterString & "<br>"
		'Response.Write ValuesString & "<br>"
		'Response.Write SQLString2 & "<br><br>"
		
'Execute the SQL insertion
		On Error Resume Next
		oConn.Execute SQLString2
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL Insert of the new data failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		End If
		Response.Write "<p>Update Successfully Completed!</p>"
		
'Close the record set and the connection
		oRs.Close
    	Set oRs = Nothing
		oConn.Close
		Set oConn = Nothing
	End If

End Sub


Sub UpdateRecord(ConnectionString, TableName, QueryString2DbArray, PrimaryKeyFieldName, DbType)
'This is a subroutine that takes a set of fields from a form and inserts
'it into a database.  This subroutine assumes that the first query string field is the primary key value 
'or identifier field of the record being updated and that all other query string fields are
'being updated in the database table.  This subroutine also assumes the following:

'ConnectionString is the DSN information, which includes the DSN name, db username, and db password.

'TableName is the name of the table in the database where the data is being inserted

'QueryString2DbArray is a preset array from the Query String that maps the Query String fields to the database fields (this
' array translates the query string fields, as they appear in the query string, to the database fields, respectively)
' defining to the subroutine the order of the form fields relative to the database fields (ORDER IS 
' IMPORTANT - use the query string field order with the database field names)
'
'PrimaryKeyFieldName is the name of the database record field name that corresponds to the primary key of the database record that is being updated
'
'PrimaryKeyFieldValue is the value of the database record field that acts as the primary key in the database that
'specifies the database record that is being updated uniquely.
'
'DbType defines to the script the type of database being inserted into; MSAccess or SQLServer are 
' the acceptable inputs.
'
	Dim SQLString, SQLString2, DateDelimiter, ValuesString
	'Dim NumFields
	
'Sets the Date delimiter;for Access db is (#); SQLServer uses (")
	If (DbType = "MSAccess") Then
		DateDelimiter = "#"
	Else
		DateDelimiter = "'"
	End If
 
'If no Table is defined, skip everything
	If (TableName <> "") Then

'This SQL search used to define the types of fields in the table
	    SQLString = "SELECT * FROM " & TableName
		
'Open the DB Connection
	    Set oConn = Server.CreateObject("ADODB.Connection")
		oConn.Open ConnectionString
		'Set oRs = oConn.Execute(SQLString,lngRecs,adCmdText)

'Execute the SQL search of the table
		On Error Resume Next
		Set oRs = oConn.Execute(TableName,,adCmdTable)
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL Insert of the new data failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		End If
		
'Tests to see how the table data is returned to the script
		'Begin building Insert String
		'ParameterString = PrimaryKey
		'ValuesString = "NULL"
		
		'NumFields = oRs.Fields.count
		'For Each oField In oRs.Fields
		'	Response.Write oField.Type & " - "
		'	Response.Write oField.Name & "<br>"
		'Next
		
'Tests to see how the form fields are being handled in the Request Object array
		'For Each Item In Request.Form
		'	Response.Write Item & " - "
		'	Response.Write Request.Form(Item) & "<br>"
		'Next
		'Response.Write "<br><br>"
		
'Begin to build the insert SQL statement by looking from form fields in the array
		For i = 1 To UBound(QueryString2DbArray)+1
			'Response.Write Request.QueryString(i) & "<br>"
				
'If the ValuesString (form values to be inserted in order) is empty, first field in series; if not, concatenate
			For Each oField In oRs.Fields
				If (ValuesString = "") Then
					If (oField.Name = QueryString2DbArray(i-1)) Then
						'Response.Write oField.Name & "&nbsp;" & oField.Type & "<br>"
						If (oField.Type = 200 OR oField.Type = 201 OR oField.Type = 202 OR oField.Type = 203) Then
							ValuesString = QueryString2DbArray(i-1) & "='" & Replace(CStr(Request.QueryString(i+1)), "'", "&#039;" ) & "'"
						ElseIf (oField.Type = "135") Then
							ValuesString = QueryString2DbArray(i-1) & "=" & DateDelimiter & Request.QueryString(i+1) & DateDelimiter
						Else
							ValuesString = QueryString2DbArray(i-1) & "=" & Request.QueryString(i+1)
						End If
						'Response.Write ValuesString & "<br>"
					End If
				Else
					If (oField.Name = QueryString2DbArray(i-1)) Then
						'Response.Write oField.Name & "&nbsp;" & oField.Type & "<br>"
						If (oField.Type = 200 OR oField.Type = 201 OR oField.Type = 202 OR oField.Type = 203) Then
							ValuesString = ValuesString & QueryString2DbArray(i-1) & "='" & Replace(CStr(Request.QueryString(i+1)), "'", "&#039;" ) & "'"
						ElseIf (oField.Type = "135") Then
							ValuesString = ValuesString & QueryString2DbArray(i-1) & "=" & DateDelimiter & Request.QueryString(i+1) & DateDelimiter
						Else
							ValuesString = ValuesString & QueryString2DbArray(i-1) & "=" & Request.QueryString(i+1)
						End If
					End If
				End If
			Next
		Next

'Build the final SQL insert statement				
		'SQLString2 = "UPDATE " & TableName & " SET (" & ValuesString & ") WHERE " & PrimaryKeyFieldName & "=" & PrimaryKeyFieldValue
		SQLString2 = "UPDATE " & TableName & " SET " & ValuesString & " WHERE " & PrimaryKeyFieldName & "=" & Request.QueryString(1)
'Check for errors		
		'Response.Write ParameterString & "<br>"
		'Response.Write ValuesString & "<br>"
		'Response.Write SQLString2 & "<br><br>"
		
'Execute the SQL update
		On Error Resume Next
		oConn.Execute SQLString2
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL update of the data failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		End If
		'Response.Write "<p>The insert has been done.</p>"
		
'Close the record set and the connection
		oRs.Close
    	Set oRs = Nothing
		oConn.Close
		Set oConn = Nothing
	End If

End Sub



Sub UpdateData(ConnectionString, TableName, Data2DbArray, DataArray, PrimaryKeyFieldName, PrimaryKeyFieldValue, PrimaryKeyFieldType, DbType)
'This is a subroutine that takes a set of fields from a form and inserts
'it into a database.  This subroutine assumes that the first query string field is the primary key value 
'or identifier field of the record being updated and that all other query string fields are
'being updated in the database table.  This subroutine also assumes the following:

'ConnectionString is the DSN information, which includes the DSN name, db username, and db password.

'TableName is the name of the table in the database where the data is being inserted

'QueryString2DbArray is a preset array from the Query String that maps the Query String fields to the database fields (this
' array translates the query string fields, as they appear in the query string, to the database fields, respectively)
' defining to the subroutine the order of the form fields relative to the database fields (ORDER IS 
' IMPORTANT - use the query string field order with the database field names)
'
'PrimaryKeyFieldName is the name of the database record field name that corresponds to the primary key of the database record that is being updated
'
'PrimaryKeyFieldValue is the value of the database record field that acts as the primary key in the database that
'specifies the database record that is being updated uniquely.
'
'DbType defines to the script the type of database being inserted into; MSAccess or SQLServer are 
' the acceptable inputs.
'
	Dim SQLString, SQLString2, DateDelimiter, ValuesString
	'Dim NumFields
	
'Sets the Date delimiter;for Access db is (#); SQLServer uses (")
	If (DbType = "MSAccess") Then
		DateDelimiter = "#"
	Else
		DateDelimiter = "'"
	End If
 
'If no Table is defined, skip everything
	If (TableName <> "") Then

'This SQL search used to define the types of fields in the table
	    SQLString = "SELECT * FROM " & TableName
		
'Open the DB Connection
	    Set oConn = Server.CreateObject("ADODB.Connection")
		oConn.Open ConnectionString
		'Set oRs = oConn.Execute(SQLString,lngRecs,adCmdText)

'Execute the SQL search of the table
		On Error Resume Next
		Set oRs = oConn.Execute(TableName,,adCmdTable)
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL Insert of the new data failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		End If
		
'Tests to see how the table data is returned to the script
		'Begin building Insert String
		'ParameterString = PrimaryKey
		'ValuesString = "NULL"
		
		'NumFields = oRs.Fields.count
		'For Each oField In oRs.Fields
		'	Response.Write oField.Type & " - "
		'	Response.Write oField.Name & "<br>"
		'Next
		
'Tests to see how the form fields are being handled in the Request Object array
		'For Each Item In Request.Form
		'	Response.Write Item & " - "
		'	Response.Write Request.Form(Item) & "<br>"
		'Next
		'Response.Write "<br><br>"
		
'Begin to build the insert SQL statement by looking from form fields in the array
		For i = 1 To UBound(Data2DbArray)+1
			'Response.Write Request.QueryString(i) & "<br>"
				
'If the ValuesString (form values to be inserted in order) is empty, first field in series; if not, concatenate
			For Each oField In oRs.Fields
				If (ValuesString = "") Then
					If (oField.Name = Data2DbArray(i)) Then
						'Response.Write oField.Name & "&nbsp;" & oField.Type & "<br>"
						If (oField.Type = 200 OR oField.Type = 201 OR oField.Type = 202 OR oField.Type = 203) Then
							ValuesString = Data2DbArray(i) & "='" & Replace(CStr(DataArray(i)), "'", "&#039;" ) & "'"
						ElseIf (oField.Type = "135") Then
							ValuesString = Data2DbArray(i) & "=" & DateDelimiter & DataArray(i) & DateDelimiter
						Else
							ValuesString = Data2DbArray(i) & "=" & DataArray(i)
						End If
						'Response.Write ValuesString & "<br>"
					End If
				Else
					If (oField.Name = Data2DbArray(i)) Then
						'Response.Write oField.Name & "&nbsp;" & oField.Type & "<br>"
						If (oField.Type = 200 OR oField.Type = 201 OR oField.Type = 202 OR oField.Type = 203) Then
							ValuesString = ValuesString & ", " & Data2DbArray(i) & "='" & Replace(CStr(DataArray(i)), "'", "&#039;" ) & "'"
						ElseIf (oField.Type = "135") Then
							ValuesString = ValuesString & ", " & Data2DbArray(i) & "=" & DateDelimiter & DataArray(i) & DateDelimiter
						Else
							ValuesString = ValuesString & ", " & Data2DbArray(i) & "=" & DataArray(i)
						End If
					End If
				End If
			Next
		Next

'Build the final SQL insert statement
		If (PrimaryKeyFieldType = "char" OR PrimaryKeyFieldType = "CHAR" OR PrimaryKeyFieldType = "Char" OR PrimaryKeyFieldType = "Character") Then				
			SQLString2 = "UPDATE " & TableName & " SET " & ValuesString & " WHERE " & PrimaryKeyFieldName & "='" & PrimaryKeyFieldValue & "'"
		Else
			SQLString2 = "UPDATE " & TableName & " SET " & ValuesString & " WHERE " & PrimaryKeyFieldName & "=" & PrimaryKeyFieldValue
		End If
		'SQLString2 = "UPDATE " & TableName & " SET " & ValuesString & " WHERE " & PrimaryKeyFieldName & "=" & Request.QueryString(1)
'Check for errors		
		Response.Write ParameterString & "<br>"
		Response.Write ValuesString & "<br>"
		Response.Write SQLString2 & "<br><br>"
		
'Execute the SQL update
		On Error Resume Next
		oConn.Execute SQLString2
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL update of the data failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		End If
		'Response.Write "<p>The insert has been done.</p>"
		
'Close the record set and the connection
		oRs.Close
    	Set oRs = Nothing
		oConn.Close
		Set oConn = Nothing
	End If

End Sub



Sub UpdateDataGenericSQL(ConnectionString, SQLString)
'This is a subroutine that takes a set of fields from a form and inserts
'it into a database.  This subroutine assumes that the first query string field is the primary key value 
'or identifier field of the record being updated and that all other query string fields are
'being updated in the database table.  This subroutine also assumes the following:

'ConnectionString is the DSN information, which includes the DSN name, db username, and db password.

	'Dim SQLString
	'Dim NumFields
	
'Open the DB Connection
	    Set oConn = Server.CreateObject("ADODB.Connection")
		oConn.Open ConnectionString
		'Set oRs = oConn.Execute(SQLString,lngRecs,adCmdText)
		
'Execute the SQL update
		On Error Resume Next
		oConn.Execute SQLString
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL update of the data failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		End If
		'Response.Write "<p>The insert has been done.</p>"
		
'Close the record set and the connection
		oRs.Close
    	Set oRs = Nothing
		oConn.Close
		Set oConn = Nothing

End Sub




Sub DeleteRecord(ConnectionString, TableName, PrimaryKeyFieldName, PrimaryKeyFieldValue, DBType)
	Dim SQLString, SQLString2, WhereString, FieldDelimiter, DateDelimiter
	
'Sets the Date delimiter;for Access db is (#); SQLServer uses (")
	If (DbType = "MSAccess") Then
		DateDelimiter = "#"
	Else
		DateDelimiter = "'"
	End If
 
'If no Table is defined, skip everything
	If (TableName <> "") Then
	
'This SQL search used to define the types of fields in the table
		SQLString = "SELECT " & PrimaryKeyFieldName & " FROM " & TableName
			
'Open the DB Connection
    	Set oConn = Server.CreateObject("ADODB.Connection")
		oConn.Open ConnectionString
		'Set oRs = oConn.Execute(SQLString,lngRecs,adCmdText)

'Execute the SQL search of the table
		On Error Resume Next
		Set oRs = oConn.Execute(TableName,,adCmdTable)
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL Insert of the new data failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		End If
			
'If the ValuesString (form values to be inserted in order) is empty, first field in series; if not, concatenate
		For Each oField In oRs.Fields
			If (oField.Name = PrimaryKeyFieldName) Then
				If (oField.Type = 200 OR oField.Type = 201) Then
					FieldDelimiter = "'"
				ElseIf (oField.Type = "135") Then
					FieldDelimiter = DateDelimiter
				Else
					FieldDelimiter = ""
				End If
			End If
		Next
		
'Build the Where Statement
		WhereString = "(" & PrimaryKeyFieldName & "=" & FieldDelimiter & PrimaryKeyFieldValue & FieldDelimiter & ")"
		'Response.Write = WhereString & "<br>"	
		
'Build the SQL statement
		SQLString2 = "DELETE FROM " & TableName & " WHERE " & WhereString
		'Response.Write SQLString2 & "<br>"

'Delete the record	
		On Error Resume Next
		oConn.Execute SQLString2
		'oConn.Execute("DELETE from TableName WHERE (IDNumber =" & Request.QueryString("ID") & ")")
		If (oConn.Errors.Count > 0) Then
			For Index = 0 To (oConn.Errors.Count - 1)
				Response.Write "<P>The SQL Insert of the new data failed.  Read the following.<BR>"
				Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
				Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
				Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
				Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
			Next
		End If
		'Response.Write "<p>The insert has been done.</p>"
	
'Close the record set and the connection
		oRs.Close
    	Set oRs = Nothing
		oConn.Close
		Set oConn = Nothing
	End If
	
End Sub
		

Sub DeleteRecordGenericSQL(ConnectionString, SQLString)
			
'Open the DB Connection
    Set oConn = Server.CreateObject("ADODB.Connection")
	oConn.Open ConnectionString

'Delete the record	
	On Error Resume Next
	oConn.Execute SQLString
	'oConn.Execute("DELETE from TableName WHERE (IDNumber =" & Request.QueryString("ID") & ")")
	If (oConn.Errors.Count > 0) Then
		For Index = 0 To (oConn.Errors.Count - 1)
			Response.Write "<P>The SQL Insert of the new data failed.  Read the following.<BR>"
			Response.Write "Error Number: " & oConn.Errors(Index).Number & "<BR>"
			Response.Write "Description: " & oConn.Errors(Index).Description & "<BR>"
			Response.Write "Native Error: " & oConn.Errors(Index).NativeError & "<BR>"
			Response.Write "SQL State: " & oConn.Errors(Index).SQLState & "</P>"
		Next
	End If
	'Response.Write "<p>The insert has been done.</p>"
	
'Close the record set and the connection
	oRs.Close
   	Set oRs = Nothing
	oConn.Close
	Set oConn = Nothing
End Sub
		

Sub displayTableData(rptTitle, listData, FieldHeaders)
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
          Response.Write "<td>" & listData(i,j) & "</td>" & vbcrlf
        End If
      next
      Response.Write "</tr>" & vbcrlf
    next
    ' close the table
    Response.Write "</table>" & vbcrlf
  End If
End Sub

Sub displayTableDataFSC(rptTitle, listData, FieldHeaders)
 ' check for empty set, spit out the "try again" message
  If Not IsArray (listData) Then 
    Response.Write "<h2>" & noData & "</h2>"
  Else
    numRecords = UBound(listData,2)
    numFields = UBound(listData,1)
    numHeaders = UBound(FieldHeaders)
   'Response.Write "<h3>" & rptTitle & "</h3>" & vbcrlf
    ' start a table 
    Response.Write "<table border=1 cellpadding=2 cellspacing=1 width=600 align=center>" & vbcrlf
    ' spit out the table headers
	Response.Write "<tr><td colspan=66 valign=top><h3>" & rptTitle & "</h3></td></tr>" & vbcrlf
    ' prepend an empty first cell so we can number records
    Response.Write "<tr>" & vbcrlf '& "<th  bgcolor=CCC879>&nbsp;</th>" & vbcrlf
	 'For i = 0 To numHeaders-1    Change by GFS on 5/5/03
    For i = 0 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      If (i < 3) Then
	  	Response.Write "<th rowspan=2 bgcolor=CCCCCC>" & FieldHeaders(i) & "</th>" & vbcrlf
	  ElseIf (i = 3) Then
	  	Response.Write "<th bgcolor=FFFF00 colspan=10>Number of Dispatches</th>" & vbcrlf
	  ElseIf (i = 13) Then
	  	Response.Write "<th bgcolor=CCFFCC colspan=10>Time Spent in Hours for Dispatches (Travel Time included)</th>" & vbcrlf
	  ElseIf (i = 23) Then
	  	Response.Write "<th bgcolor=FFFF00 colspan=14>Number of Customer Visits</th>" & vbcrlf
	  ElseIf (i = 37) Then
	  	Response.Write "<th bgcolor=CCFFCC colspan=14>Time Spent in Hours for Visits (Travel Time included)</th>" & vbcrlf
	  ElseIf (i = 51) Then
	  	Response.Write "<th bgcolor=FFFF00 colspan=5>Remote Support - Hours Scheduled</th>" & vbcrlf
	  ElseIf (i = 56) Then
	  	Response.Write "<th bgcolor=CCFFCC colspan=5>Remote Support - Hours Worked</th>" & vbcrlf
	  ElseIf (i = 61) Then
	  	Response.Write "<th bgcolor=CCCCCC colspan=5>Non Site Hours Taken</th>" & vbcrlf
	  End If
    Next
    Response.Write "</tr>" & vbcrlf
    Response.Write "<tr>" & vbcrlf '& "<th  bgcolor=CCCCCC>&nbsp;</th>" & vbcrlf
	 'For i = 0 To numHeaders-1    Change by GFS on 5/5/03
    For i = 3 To numHeaders
      ' lets strip out the first 'word' in the field name, b/c it's meaningless to the user
      'If (i < 3) Then
	  	'Response.Write "<th rowspan=2 bgcolor=CCCCCC>" & FieldHeaders(i) & "</th>" & vbcrlf
	  If (i < 13) Then
	  	Response.Write "<td align=center valign=top>" & FieldHeaders(i) & "</td>" & vbcrlf
	  ElseIf (i < 23) Then
	  	Response.Write "<td align=center valign=top>" & FieldHeaders(i) & "</td>" & vbcrlf
	  ElseIf (i < 37) Then
	  	Response.Write "<td align=center valign=top>" & FieldHeaders(i) & "</td>" & vbcrlf
	  ElseIf (i < 51) Then
	  	Response.Write "<td align=center valign=top>" & FieldHeaders(i) & "</td>" & vbcrlf
	  ElseIf (i < 56) Then
	  	Response.Write "<td align=center valign=top>" & FieldHeaders(i) & "</td>" & vbcrlf
	  ElseIf (i < 61) Then
	  	Response.Write "<td align=center valign=top>" & FieldHeaders(i) & "</td>" & vbcrlf
	  Else
	  	Response.Write "<td align=center valign=top>" & FieldHeaders(i) & "</td>" & vbcrlf
	  End If
    Next
    Response.Write "</tr>" & vbcrlf
    ' spit out the listedData
    for j=0 to numRecords
      If (j MOD 2) Then ' alternate the row colors by using the modulus
        'Response.Write "<tr style=""background-color:#7b9bcc;"">" & vbcrlf & "<td align=""right"">" & j+1 & "</td>" & vbcrlf
		Response.Write "<tr style=""background-color:#ffffff;"">" '& vbcrlf & "<td align=""right"">&nbsp;</td>" & vbcrlf
      Else
        Response.Write "<tr style=""background-color:#ffffff;"">" '& vbcrlf & "<td align=""right"">&nbsp;</td>" & vbcrlf
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

'This function takes the specified record of the data captured from the GetData subroutine 
'and assigns it to the dataArray array so that it may be utilized within an ASP page 
'as a one-dimensional array
Sub RecordDataToArray(listData)
	If Not IsArray (listData) Then 
    	'Response.Write "No Data"
		dataArray = Null
	Else
		'numRecords = UBound(listData,2)
		numFields = UBound(listData,1)
		'numHeaders = UBound(FieldHeaders)
	
		For i = 0 to numFields
    	    If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
    	      'Response.Write "No Data" & vbcrlf
			  dataArray = Null
    	    Else
    	      'Response.Write "<p>" & listData(i,j) & "</p>" & vbcrlf
			  ReDim dataArray(numFields)
			  dataArray(i) = listData(i,j)
    	    End If
    	Next
	End If
End Sub


'This function takes the specified record of the data captured from the GetData subroutine 
'and assigns it to the dataArray array so that it may be utilized within an ASP page 
'as a one-dimensional array
Sub ColumnDataToArray(listData)
	If Not IsArray (listData) Then 
    	'Response.Write "No Data"
		dataArray = Null
	Else
		numRecords = UBound(listData,2)
		'numFields = UBound(listData,1)
		'numHeaders = UBound(FieldHeaders)
	
		For j = 0 to numRecords
    	    If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
    	      'Response.Write "No Data" & vbcrlf
			  dataArray = Null
    	    Else
    	      'Response.Write "<p>" & listData(i,j) & "</p>" & vbcrlf
			  ReDim dataArray(numRecords)
			  dataArray(i) = listData(i, j)
    	    End If
    	Next
	End If
End Sub

'This function takes the specified record of the data captured from the GetData subroutine 
'and prints the column so that it may be utilized within an ASP page 
Sub PrintRecordData(listData)
	If Not IsArray (listData) Then 
    	Response.Write "No Data"
	Else
		'numRecords = UBound(listData,2)
		numFields = UBound(listData,1)
		'numHeaders = UBound(FieldHeaders)
	
		For i = 0 to numFields
    	    If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
    	      Response.Write "No Data" & "<br>" & vbcrlf
    	    Else
    	      Response.Write "<p>" & listData(i,j) & "</p>" & vbcrlf
			  'Response.Write "<p>" & TypeName(listData(i,j)) & "</p>" & vbcrlf
    	    End If
    	Next
	End If
End Sub


'This function takes the specified record of the data captured from the GetData subroutine 
'and prints the record so that it may be utilized within an ASP page 
Sub PrintColumnData(listData)
	If Not IsArray (listData) Then 
    	Response.Write "No Data"
	Else
		'numRecords = UBound(listData,2)
		numFields = UBound(listData,1)
		'numHeaders = UBound(FieldHeaders)
	
		For j = 0 to numFields
    	    If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
    	      Response.Write "No Data" & "<br>" & vbcrlf
    	    Else
    	      Response.Write "<p>" & listData(i,j) & "</p>" & vbcrlf
    	    End If
    	Next
	End If
End Sub


'This function takes the specified record of the data captured from the GetData subroutine 
'and assigns it to the Session Object so that it may be utilized within an ASP page.  The 
'KeyNames array must be initialized in the page that calls out this function.  KeyNames holds
'the names of the session variables
Sub RecordDataToSession(listData, KeyNames)
	If Not IsArray (listData) Then 
    	'Response.Write "No Data"
		dataArray = Null
		'Session.Abandon
	Else
		'numRecords = UBound(listData,2)
		numFields = UBound(listData,1)
		'numHeaders = UBound(FieldHeaders)
	
		For i = 0 to numFields
    	    If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
    	      'Response.Write "No Data" & vbcrlf
			  'dataArray = Null
    	    Else
    	      'Response.Write "<p>" & listData(i,j) & "</p>" & vbcrlf
			  Session.Contents.Item(KeyNames(i)) = listData(i,j)
    	    End If
    	Next
	End If
End Sub


'This function takes the specified record of the data captured from the GetData subroutine 
'and assigns it to the Session Object so that it may be utilized within an ASP page.  The 
'KeyNames array must be initialized in the page that calls out this function.  KeyNames holds
'the names of the session variables
Sub ColumnDataToSession(listData, KeyNames)
	If Not IsArray (listData) Then 
    	'Response.Write "No Data"
		dataArray = Null
	Else
		numRecords = UBound(listData,2)
		'numFields = UBound(listData,1)
		'numHeaders = UBound(FieldHeaders)
	
		For i = 0 to numRecords
    	    If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
    	      'Response.Write "No Data" & vbcrlf
			  'dataArray = Null
    	    Else
    	      'Response.Write "<p>" & listData(i,j) & "</p>" & vbcrlf
			  Session.Contents.Item(KeyNames(i)) = listData(i,j)
    	    End If
    	Next
	End If
End Sub


'This function takes the specified record of the data captured from the GetData subroutine 
'and prints it out to a select list so that it may be utilized within an ASP page 
'as a one-dimensional array
Sub PrintColumnsToSelect(listData)
	If Not IsArray (listData) Then 
    	Response.Write "No Data"
	Else
		numRecords = UBound(listData,2)
		'numFields = UBound(listData,1)
		'numHeaders = UBound(FieldHeaders)
	
		For j = 0 to numRecords
    	    If Trim(listData(i,j))="" Then ' if the data is empty write a nbsp
    	    	Response.Write "No Data" & "<br>" & vbcrlf
    	    Else
    	    	Response.Write "<option value=""" & listData(i,j) & """>" & listData(i+1,j) & "</option>" & vbcrlf
    	    End If
    	Next
	End If
End Sub


%>