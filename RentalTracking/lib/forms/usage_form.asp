<form method="POST" action="number_frequency.asp" name="equipForm">

<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td valign="top"><p>Ski Number Series:</p>
	<td>
		<select name="EquipmentSeries" id="EquipmentSeries">
			<option value="All">All</option>
			<!--option value="1">100 Series</option>
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
		</select><br><br>[<a href="../equipment/numbers.asp">Enter Series</a>]
	</td>
	<td>
	<td valign="top">
		<select name="EquipmentName" id="EquipmentName">
			<option value="All">All</option>
			<option value="Skis">Skis</option>
			<option value="Snowboard">Snowboard</option>
			<option value="Boots">Boots</option>
		</select> 
	</td>
	</td>
	<td valign="top"><p><button type="submit">Run Report</button></p></td>
</tr>
</table>
</p>
</form>