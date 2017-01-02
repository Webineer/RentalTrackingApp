<script language='javascript' src='/rental_tracking/includes/popcalendar.js'></script>

<form method="POST" action="<?php print $_SERVER["SCRIPT_NAME"]; ?>" name="equipForm">
<input type="hidden" name="date_created" id="date_created" value="<?php print date('Y-m-d'); ?>" />

<p class="center" name="paraOne" id="paraOne">
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><p>Equipment Name:</p>
	<td>
		<select name="equipment_name" id="equipment_name">
			<!-- option>Select One</option -->
			<option value="Skis" >Skis</option>
			<option value="Snowboard" >Snowboard</option>
			<option value="Boots" >Boots</option>
            <option value="Helmet" >Helmet</option>
		</select> 
	</td>
</tr>
<tr>
	<td colspan="2"><textarea name="equipment_description" id="equipment_description" cols="55" rows="5" onFocus="this.value=''">Enter Description Here</textarea></td>
</tr>
<tr>
	<td><p>Equipment Number:</p></td>
	<td><input type="text" name="ski_number" id="ski_number" size="30" /></td>
</tr>
<tr>
	<td><p>Equipment ID:</p></td>
	<td><input type="text" name="equipment_id" id="equipment_id" size="30" /></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" value="Enter" /></td>
</tr>
</table>
</p>
</form>
<script language="Javascript">document.equipForm.SkiNumber.focus() //;alert(document.equipForm.EquipmentName.selectedIndex)</script>
