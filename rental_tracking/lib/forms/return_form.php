<!-- include the JavaScript form validation library -->
  <!-- script language="JavaScript1.2" src="/reservation/lib/_formCheck.js" type="text/javascript"></script>
  <!-- include the JavaScript form validation script -->
  <!-- script language="JavaScript1.2" src="/reservation/lib/_validateForm.js" type="text/javascript"></script>
  <script language="JavaScript1.2" type="text/javascript">
  <!--
  // make sure that required fields are not blank
  // will have to move these to php to enable server-side validation
  var requiredTextFields = new Array('product_name', 'product_description', 'meeting_time', 'product_cost', 'discount_cost', 'rental_fee', 'max_seats', 'account_number'); // null didn't work here
  var requiredSelectFields = new Array('product_type_id');
  //var requiredSelectFields = null;
  var requiredCheckboxFields = null; // or try null
  // -->
  <!-- /script -->

<!-- form method="POST" action="< ?php print $_SERVER["SCRIPT_NAME"]; ?>" name="rentalForm" -->
<form method="POST" action="returns_do.php" name="returnForm" >
				
    <p class="center">
				
        <table cellpadding="0" cellspacing="2" border="0">
				
        <tr>
            <td><p class="bold">Ski/Snowboard/Boot/Helmet Identifier</p></td>
            <td><input type="text" name="equipment_id" id="equipment_id" size="30" maxchars="100" /></td>			
        </tr>
        
        </table>
	
    </p>
    
</form>

<script language="Javascript">document.returnForm.equipment_id.focus()</script>