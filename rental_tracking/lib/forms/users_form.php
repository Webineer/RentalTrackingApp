<!-- include the JavaScript form validation library -->
  <script language="JavaScript1.2" src="<?php print APP_ROOT; ?>lib/_formCheck.js" type="text/javascript"></script>
  <!-- include the JavaScript form validation script -->
  <script language="JavaScript1.2" src="<?php print APP_ROOT; ?>lib/_validateForm.js" type="text/javascript"></script>
  <script language="JavaScript1.2" type="text/javascript">
  <!--
  // make sure that required fields are not blank
  // will have to move these to php to enable server-side validation
  var requiredTextFields = new Array('username', 'password'); // null didn't work here
  //var requiredSelectFields = new Array('dgfState','dgfCountry','dgfCompanyOwnership');
  var requiredSelectFields = new Array('security_id');
  var requiredCheckboxFields = null; // or try null
  //-->
  </script>

<form method="POST" action="<?php print $_SERVER["SCRIPT_NAME"]; ?>" name="usersForm" onSubmit="return validateForm(this,requiredTextFields,requiredSelectFields,requiredCheckboxFields);">
				
				<p class="center">
				
				<table cellpadding="0" cellspacing="2" border="0">
				
				<tr>
				
					<td><p class="bold">User Name:</p></td>
					
					<td>
						<input type="text" name="username" id="username" size="40" maxchars="50" onfocus="window.status='Enter the user name';" onBlur="window.status='';">
					</td>
				
				</tr>
				
				<tr>
				
					<td><p class="bold">Password:</p></td>
					
					<td>
						<input type="text" name="password" id="password" size="40" maxchars="50" onfocus="window.status='Enter the user name';" onBlur="window.status='';">
					</td>
				
				</tr>
				
				<!-- tr>
				
					<td><p class="bold">Security Level:</p></td>
					
					<td>
						<select name="security_id" id="security_id" onfocus="window.status='Select a security level';" onBlur="window.status='';">
						<option>Select One</option>
						< ?php
							$field_names = array("id", "level_name");
							$table_name = "security";
							$res = view_data($table_name, $field_names);
							if ($res->numRows() > 0) {
								display_select($res);
							}
						 ?>
						</select>
					</td>
				
				</tr -->
				
				<tr><td colspan="2"><br><p class="center"><button type="submit">Enter</button></p></td></tr>
				
				</table>
	
				</p>
</form>
<script language="Javascript">document.usersForm.username.focus()</script>				