<!-- include the JavaScript form validation library -->
  <script language="JavaScript1.2" src="<?php print APP_ROOT; ?>lib/_formCheck.js" type="text/javascript"></script>
  <!-- include the JavaScript form validation script -->
  <script language="JavaScript1.2" src="<?php print APP_ROOT; ?>lib/_validateForm.js" type="text/javascript"></script>
  <script language='javascript' src='<?php print APP_ROOT; ?>includes/popcalendar.js'></script>
  <script language="JavaScript1.2" type="text/javascript">
  <!--
  // make sure that required fields are not blank
  // will have to move these to php to enable server-side validation
  var requiredTextFields = new Array('level'); // null didn't work here
  //var requiredSelectFields = new Array('dgfState','dgfCountry','dgfCompanyOwnership');
  var requiredSelectFields = null;
  var requiredCheckboxFields = null; // or try null
  //-->
  </script>
 
<form method="POST" action="<?php print $_SERVER["SCRIPT_NAME"]; ?>" name="levelForm" onSubmit="return validateForm(this,requiredTextFields,requiredSelectFields,requiredCheckboxFields);">
				
				<p class="center">
				
				<table cellpadding="0" cellspacing="2" border="0">
				
				<tr>
                    <td><p class="bold">Enter Barcode Of The Equipment To Be Reviewed:</p></td>
                    
                    <td>
                    
					   <input type="text" name="equip_id" id="equip_id" size="20" maxchars="50" onfocus="window.status='Enter the equipment barcode';" onBlur="window.status='';" />
					   <!-- select name="equip_id" id="combobox" onfocus="window.status='Enter the instructor';" onBlur="window.status='';">
                            <option value=""></option>              
                            < ?php
								//$field_names = array("id", "program_name");
								//$res = view_data($table_name, $field_names);
								$sql_string5 = "select id, CONCAT(equipment_id, ' - ', equipment_name) from equipment ORDER BY equipment_id";
								$res = view_data_generic_sql($sql_string5);
								if ($res->numRows() > 0) {
									display_select_selected($res, $_POST['equip_id']);
								}
						  ?>
                        </select -->
                    
                    </td>
                    <!-- td><p class="center"><button type="submit">Enter</button></p></td -->
                </tr>
				
				</table>
	
				</p>
</form>	
<script lang="Javascript" type="text/javascript">document.levelForm.equip_id.focus();</script>			