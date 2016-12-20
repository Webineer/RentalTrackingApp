<form method="POST" action="returnDo.asp" name="rental2Form" id="rental2Form">
<!-- form method="POST" action="" name="rentalForm" -->
<input type="hidden" name="DateCreated" id="DateCreated" value="<%=Date() & " " & FormatDateTime(Now(),4) %>">
<input type="hidden" name="Type" id="Type" value="in">
<p class="center">
<table cellpadding="5" cellspacing="0" border="0">
	<!-- tr>
		<td><span class="newshdr">Agreement Identifier</span></td>
		<td><input type="text" name="Agreement2ID" id="Agreement2ID" size="30" maxchars="100"></td>
	</tr>
	<tr><td colspan="2"><p class="center">OR</p></td></tr -->
	<tr>
		<td><p>Ski/Snowboad/Boot/Helmet Identifier</p></td>
		<td><input type="text" name="Equipment1ID" id="Equipment1ID" size="30" maxchars="100"></td>
	</tr>
	<!-- tr><td colspan="2"><p class="center">OR</p></td></tr>
	<tr>
		<td><span class="newshdr">Boot Identifier</span></td>
		<td><input type="text" name="Equipment2ID" id="Equipment2ID" size="30" maxchars="100"></td>
	</tr>
	<tr><td colspan="2"><p class="center"><button type="submit">Return</button></p></td></tr -->
</table>
</p>
</form>

<script language="Javascript">document.rental2Form.Equipment1ID.focus();setInterval('document.rental2Form.Equipment1ID.focus()', 3000)</script>