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
	
	function changeAction() {
		if ((document.equipForm.EquipmentName.selectedIndex == 0) || (document.equipForm.EquipmentName.selectedIndex == 2)) {
			document.equipForm.action = "enterEquipment.asp"	
		}	
	}
//-- end hiding -->
</script>

<form method="POST" action="<%=Request.ServerVariables("SCRIPT_NAME") %>" onSubmit="changeAction()" name="equipForm">
<input type="hidden" name="DateCreated" id="DateCreated" value="<%=Date() %>">
<!-- input type="hidden" name="DateLastUpdated" id="DateLastUpdated" value="< %=Date() %>" -->

<p class="center" name="paraOne" id="paraOne">
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><p>Equipment Name:</p>
	<td>
		<select name="EquipmentName" id="EquipmentName">
			<!-- option>Select One</option -->
			<option value="Skis" <% If (Request.Form("EquipmentName")="Skis") Then Response.Write "selected" End If %> >Skis</option>
			<option value="Snowboard" <% If (Request.Form("EquipmentName")="Snowboard") Then Response.Write"selected" End If %> >Snowboard</option>
			<option value="Boots" <% If (Request.Form("EquipmentName")="Boots") Then Response.Write "selected" End If %> >Boots</option>
            <option value="Helmet" <% If (Request.Form("EquipmentName")="Helmet") Then Response.Write "selected" End If %> >Helmet</option>
		</select> 
	</td>
</tr>
<tr>
	<td colspan="2"><textarea name="EquipmentDescription" id="EquipmentDescription" cols="55" rows="5" onFocus="this.value=''">Enter Description Here</textarea></td>
</tr>
<tr>
	<td><p>Equipment Number:</p></td>
	<td><input type="text" name="SkiNumber" id="SkiNumber" size="30"></td>
</tr>
<tr>
	<td><p>Equipment ID:</p></td>
	<td><input type="text" name="EquipmentId" id="EquipmentId" size="30"></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" value="Enter"></td>
</tr>
</table>
</p>
</form>
<script language="Javascript">document.equipForm.SkiNumber.focus() //;alert(document.equipForm.EquipmentName.selectedIndex)</script>
