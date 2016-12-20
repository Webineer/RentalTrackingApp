<%

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

Sub SendEmail(RecipientName, Message, RecipientMail)
	Dim NewMailObj

	'create the mail object and send the details
	Set NewMailObj=Server.CreateObject("CDONTS.NewMail")
	NewMailObj.From = "greg@webineering.com"
	NewMailObj.To = RecipientMail
	NewMailObj.Subject = "New message sent.." 
	NewMailObj.Body = "the name you entered was " & RecipientName & "<br>the email was " & RecipientMail & Message

	'you need to add the following lines FOR the mail to be sent in HTML format
	NewMailObj.BodyFormat = 0 
	NewMailObj.MailFormat = 0 
	NewMailObj.Send
	'Close the email object and free up resources 
	Set NewMailObj = nothing
	Response.write "The email was sent."

End Sub

Sub SendEmailForm()
	Dim name, email, message, NewMailObj
	name=request.form("name")
	email=request.form("email")
	message=request.form("message")

	'create the mail object and send the details
	Set NewMailObj=Server.CreateObject("CDONTS.NewMail")
	NewMailObj.From = "michael@codefixer.com"
	NewMailObj.To = "whoever_you_want_to_send_it_to@hotmail.com"
	NewMailObj.Subject = "New message sent.." 
	NewMailObj.Body = "the name you entered was " & name & _
	"<br>the email was " & email & _
	"<br>the message was " & message

	'you need to add the following lines FOR the mail to be sent in HTML format
	NewMailObj.BodyFormat = 0 
	NewMailObj.MailFormat = 0 
	NewMailObj.Send
	'Close the email object and free up resources 
	Set NewMailObj = nothing
	Response.write "The email was sent."

End Sub

%>