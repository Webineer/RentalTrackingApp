<script language='javascript' src='/includes/popcalendar.js'></script>
<script language="Javascript">
<!-- being hiding --
function checkClassForm() {
	
		//alert("We are here!")
		errIndex = 0
		
		checkClassCourseId()
		checkClassDateStart()
		checkClassDateEnd()
		checkClassMinSeats()
		checkClassMaxSeats()
		checkClassPrice()
		checkClassCurrency()
				
		//alert(errIndex)
		if (errIndex == 1) {
			alert("Please review the inputs in the noted fields.")
			return false
		}
		return true
	}
//-- end hiding -->
</script>

<form method="POST" action="<%=Request.ServerVariables("SCRIPT_NAME") %>" name="equipForm">
<input type="hidden" name="DateLastUpdated" id="DateLastUpdated" value="<%=Date() %>">

<p class="center" name="paraOne" id="paraOne">
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><p>Equipment Name:</p>
	<td>
		<select name="EquipmentName" id="EquipmentName">
			<option value="Skis" <% If CStr(listedData(0,0)) = "Skis" Then Response.Write "selected" End If %> >Skis</option>
			<option value="Snowboard" <% If CStr(listedData(0,0)) = "Snowboard" Then Response.Write "selected" End If %> >Snowboard</option>
			<option value="Boots" <% If CStr(listedData(0,0)) = "Boots" Then Response.Write "selected" End If %> >Boots</option>
            <option value="Helmet" <% If CStr(listedData(0,0)) = "Helmet" Then Response.Write "selected" End If %> >Helmet</option>
		</select> 
	</td>
</tr>
<tr>
	<td colspan="2"><textarea name="EquipmentDescription" id="EquipmentDescription" cols="55" rows="5"><%=listedData(1,0) %></textarea></td>
</tr>
<tr>
	<td><p>Equipment Number:</p></td>
	<td><input type="text" name="SkiNumber" id="SkiNumber" size="30" value="<%=listedData(2,0) %>"></td>
</tr>
<tr>
	<td><p>Equipment ID:</p></td>
	<td><input type="text" name="EquipmentId" id="EquipmentId" size="30" value="<%=listedData(3,0) %>"></td>
</tr>
<tr>
	<td><p>Equipment ID #2:</p></td>
	<td><input type="text" name="Equipment2Id" id="Equipment2Id" size="30" value="<%=listedData(4,0) %>"></td>
</tr>
<tr><td colspan="2"><br></td></tr>
<tr>
	<td align="center"><input type="submit" value="Update"></td>
	<td align="center"><input type="submit" value="Delete" onclick="document.equipForm.action='delete.asp'"></td>
</tr>
</table>
</p>
<input type="hidden" name="Id" id="Id" value="<%=listedData(5,0) %>">
</form>
<script language="Javascript">document.equipForm.EquipmentId.focus()</script>