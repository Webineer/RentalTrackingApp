<script language='javascript' src='/rental_tracking/includes/popcalendar.js'></script>

<form method="POST" action="nonreturns.php" name="dateForm">
<table cellpadding="0" cellspacing="3" border="0">
<tr>
	<td><p>Operation Date:</p></td>
	<td><p><input type="text" name="the_date" id="the_date" size="10" maxchars="10" onFocus="popUpCalendar(this, this, 'yyyy-mm-dd');" /></p></td>
	<td><p><button type="submit">Get Report</button></p></td>
</tr>
</table>
</form>