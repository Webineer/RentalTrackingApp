<form method="POST" action="entry2.asp" name="rentalForm">
<!-- form method="POST" action="" name="rentalForm" -->

<p class="center">
<table cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td><p>Agreement Identifier</p></td>
		<td><input type="text" name="AgreementID" id="AgreementID" size="30" maxchars="100" ></td>
	</tr>
	<!-- tr>
		<td><span class="newshdr">Ski/Snowboad Identifier</span></td>
		<td><input type="text" name="Equipment1ID" id="Equipment1ID" size="30" maxchars="100" value="< %=Request.Form("Equipment1ID") %>"></td>
	</tr>
	<tr>
		<td><span class="newshdr">Boot Identifier</span></td>
		<td><input type="text" name="Equipment2ID" id="Equipment2ID" size="30" maxchars="100" value="< %=Request.Form("Equipment2ID") %>"></td>
	</tr>
	<tr><td colspan="2"><p class="center"><button type="submit">Enter Event</button></p></td></tr -->
</table>
</p>
</form>

<script language="Javascript">document.rentalForm.AgreementID.focus()</script>
