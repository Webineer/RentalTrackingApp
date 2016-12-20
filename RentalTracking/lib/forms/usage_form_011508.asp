<form method="POST" action="number_frequency.asp" name="equipForm">

<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><p>Ski Number Series:</p>
	<td>
		<select name="EquipmentSeries" id="EquipmentSeries">
			<!-- option value="1">100 Series</option>
			<option value="2">200 Series</option>
			<option value="3">300 Series</option>
			<option value="4">400 Series</option>
			<option value="5">500 Series</option -->
			
<% 
	SQLString = "SELECT number_value, number_series FROM numbers"
	SQLString = SQLString & " ORDER BY number_value"
	Call GetData(ConnectionString,SQLString)
	Call displaySelectData(listedData)
%>
		</select> [<a href="../equipment/numbers.asp">Enter More Series</a>]
	</td>
	<td><p><button type="submit">Run Report</button></p></td>
</tr>
</table>
</p>
</form>