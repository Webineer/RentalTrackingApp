<script language='javascript' src='/RentalTracking/includes/popcalendar.js'></script>

<form method="POST" action="nonreturns.asp" name="dateForm">
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><p>Operation Date:</p></td>
	<td><p><input type="text" name="DateEnd" id="DateEnd" size="10" maxchars="10" onFocus="popUpCalendar(this, this, 'm/d/yyyy');"></p></td>
	<td><p><button type="submit">Get Report</button></p></td>
</tr>
</table>
</form>