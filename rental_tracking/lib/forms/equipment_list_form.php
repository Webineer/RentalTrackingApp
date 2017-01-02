<!-- include the JavaScript form validation library -->
  <script language="JavaScript1.2" src="<?php print APP_ROOT; ?>lib/_formCheck.js" type="text/javascript"></script>
  <!-- include the JavaScript form validation script -->
  <script language="JavaScript1.2" src="<?php print APP_ROOT; ?>lib/_validateForm.js" type="text/javascript"></script>
  <script language='javascript' src='<?php print APP_ROOT; ?>includes/popcalendar.js'></script>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
  <script>
	(function( $ ) {
		$.widget( "custom.combobox", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-combobox-toggle ui-corner-right" )
					.mousedown(function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.click(function() {
						input.focus();

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input
					.val( "" )
					.attr( "title", value + " didn't match any item" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
	})( jQuery );

	$(function() {
		$( "#combobox" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#combobox" ).toggle();
		});
	});
	</script>
  <style>
	.custom-combobox {
		position: relative;
		display: inline-block;
	}
	.custom-combobox-toggle {
		position: absolute;
		top: 0;
		bottom: 0;
		margin-left: -1px;
		padding: 0;
	}
	.custom-combobox-input {
		margin: 0;
		padding: 5px 10px;
	}
	</style>
<form method="POST" action="<?php print $_SERVER["SCRIPT_NAME"]; ?>" name="levelForm" onSubmit="return validateForm(this,requiredTextFields,requiredSelectFields,requiredCheckboxFields);">
				
				<p class="center">
				
				<table cellpadding="0" cellspacing="2" border="0">
				
				<tr>
                    <td><p class="bold">Enter Barcode Of The Equipment To Be Reviewed:</p></td>
                    
                    <td>
                    <div class="ui-widget">
					   <!-- input type="text" name="section_time" id="section_time" size="20" value="< ?php print date('g'); ?><!-- " maxchars="50" onfocus="window.status='Enter the time';" onBlur="window.status='';" -->
					   <select name="equip_id" id="combobox" onfocus="window.status='Enter the instructor';" onBlur="window.status='';">
                            <option value=""></option>              
                            <?php
								//$field_names = array("id", "program_name");
								//$res = view_data($table_name, $field_names);
								$sql_string5 = "select id, CONCAT(equipment_id, ' - ', equipment_name) from equipment ORDER BY equipment_id";
								$res = view_data_generic_sql($sql_string5);
								if ($res->numRows() > 0) {
									display_select_selected($res, $_POST['equip_id']);
								}
						  ?>
                        </select>
                    </div>
                    </td>
                    <td><p class="center"><button type="submit">Enter</button></p></td>
                </tr>
				
				</table>
	
				</p>
</form>				