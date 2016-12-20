<form method="POST" action="<%=Request.ServerVariables("SCRIPT_NAME") %>" name="numberForm" id="numberForm">
<input type="hidden" name="DateCreated" id="DateCreated" value="<%=Date() %>">
<p class="center">
<table cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td><p>Series Identifier</p></td>
		<td><input type="text" name="SeriesID" id="SeriesID" size="2" maxchars="5">00</td>
	</tr>
	<tr>
		<td><p>Series Name</p></td>
		<td><input type="text" name="SeriesName" id="SeriesName" value=" Series" size="30" maxchars="100"></td>
	</tr>
	<tr><td colspan="2"><p class="center"><button type="submit">Enter</button></p></td></tr>
</table>
</p>
</form>

<script language="Javascript">document.numberForm.SeriesID.focus()</script>