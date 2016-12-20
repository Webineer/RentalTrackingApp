<form method="POST" action="index.asp" name="rental2Form" id="rental2Form">
<input type="hidden" name="DateCreated" id="DateCreated" value="<%=Request.Form("DateCreated") %>">
<input type="hidden" name="EquipmentName" id="EquipmentName" value="<%=Request.Form("EquipmentName") %>" >
<input type="hidden" name="EquipmentDescription" id="EquipmentDescription" value="<%=Request.Form("EquipmentDescription") %>" >
<input type="hidden" name="SkiNumber" id="SkiNumber" value="<%=Request.Form("SkiNumber") %>" >
<input type="hidden" name="EquipmentId" id="EquipmentId" value="<%=Request.Form("EquipmentId") %>" >
<p class="center">
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><p>Second Equipment ID</p></td>
		<td><input type="text" name="Equipment2ID" id="Equipment2ID" size="30"></td>
	</tr>
	<tr><td colspan="2"><p class="center"><button type="submit">Enter</button></p></td></tr>
</table>
</p>
</form>

<script language="Javascript">document.rental2Form.Equipment2ID.focus()</script>