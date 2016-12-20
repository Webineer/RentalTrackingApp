<form method="POST" action="entryDo.asp" name="rentalForm">
<!-- form method="POST" action="" name="rentalForm" -->
<input type="hidden" name="DateCreated" id="DateCreated" value="<%=Date() & " " & FormatDateTime(Now(),4) %>">
<input type="hidden" name="Type" id="Type" value="out">
<!-- input type="hidden" name="AgreementID" id="AgreementID" value="< %=Request.Form("AgreementID") %>">
<input type="hidden" name="Equipment2ID" id="Equipment2ID"  value="< %=Request.Form("Equipment1ID") %>" -->

<p class="center">
<table cellpadding="5" cellspacing="0" border="0">
	<!-- tr>
		<td><span class="newshdr">Agreement Identifier</span></td>
		<td><p>< %=Request.Form("AgreementID") %></p></td>
	</tr>
	<tr>
		<td><span class="newshdr">Ski/Snowboard Identifier</span></td>
		<td><p>< %=Request.Form("Equipment1ID") %></p></td>
	</tr>
	<tr>
		<td><span class="newshdr">Boot Identifier</span></td>
		<td><input type="text" name="Equipment2ID" id="Equipment2ID" size="30" maxchars="100"></td>
	</tr -->
	<tr>
		<td><p>Ski/Snowboard/Boot/Helmet Identifier</p></td>
		<td><input type="text" name="Equipment1ID" id="Equipment1ID" size="30" maxchars="100"></td>
	</tr>
	<!-- tr><td colspan="2"><p class="center"><button type="submit">Enter Event</button></p></td></tr -->
</table>
</p>
</form>

<script language="Javascript">document.rentalForm.Equipment1ID.focus();setInterval('document.rentalForm.Equipment1ID.focus()', 3000)</script>
