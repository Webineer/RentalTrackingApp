<!--
/*
SUMMARY:
validateForm.js is responsible for client-side validation of data gathering forms.
it invokes other library functionality defined in formChek.js

DETAIL:
validateForm.js has a main function validateForm() which checks through a list
of required text, and textarea fields to ensure that they are not empty.
The assumption is that if the value is blank, the user will have to change the
value, and an onChange handler within the form will validate the data value at 
the point of entry.

After those elements are validated to be non-empty, radio buttons are validated
to be non-empty

Then any required select elements are validated to be non-empty.

Next select lists are validated to contain a value other than 'separator' values
What this means is that there are often groups of choices in a select box which
are visually separated for the user by a line of dashes (and usually the value
attribute of such an option would be either '' or '--')  Thus, the value could
be non-empty, but still be invalid.  We check for this.  Works for any number
of dashes as the value.  

Checkboxes can be problematic if not created properly in the first place.  If 
the values are stored as an array in the database, or application, then the 
checkboxes must all share the same name attribute.  To get the value of these 
elements, you must code them with separate ID's, and then use the getElementById ()
method in JavaScript

Note that server side validation is performed separately, to handle non-script-
enabled browsers, and to ensure data integrity in the data processing aspects of
the application.


DEPENDENCIES:
'requiredTextFields' is an object (associative array) that is built by PHP code in
    the form file itself
formCheck.js - all functions referenced in this file are defined in formChek.js

USAGE:


AUTHOR: Greg Rundlett

VERSION: 2.0

LAST MODIFIED: 12/03/2002

CHANGELOG:
this file is intended to be used as a library file by an entire site.

validateForm() now takes four arguments
The first argument is the form object
The other three are arrays of element names for required elements.

requiredFields is now called requiredTextFields
requiredTextFields is complemented by a couple new arrays called 
requiredSelectFields and requiredCheckboxFields
which accomplish the same goal for select lists and checkboxes respectively.

Created functions for handling these new arguments

*/



/* 
validate that some value is selected for a required select element
*/
function isSelected(form, elemName) {
  theIndex = form.elements[elemName].selectedIndex;
  if (theIndex===undefined) {
    alert ('Please choose a value for the ' + fieldLabels[elemName] + ' drop-down list.');
    form.elements[elemName].focus();
    return false
  }
//  alert ('The element ' + elemName + ' has selectedIndex of ' + theIndex);
//  alert ('The value is ' + form.elements[elemName].options[selectedIndex].text);
  return true
}

/*
use this function to validate all select lists as being non-blank, and not on 'separator' values
*/
function validateAllSelects (form) {
  // validate that select boxes are not on separator values or blank
  for (i=0; i<form.length; i++) {
    //alert (form.elements[i].type);
    if ( form.elements[i].type=='select-one' || form.elements[i].type=='select-multiple') {
      listObjectName = form.elements[i].name;
      //alert ("the list object is " + listObjectName);
      theIndex = form.elements[listObjectName].selectedIndex;
      //alert ("item is " + theIndex);
	  displayedText = form.elements[listObjectName].options[theIndex].text;
      result = form.elements[listObjectName].options[theIndex].value;
//      alert ("result is " + result);
      if ( isSeparator(result) || result=='' ) {
        form.elements[i].focus();
        alert("Please choose another value in the " + fieldLabels[form.elements[i].name] + " select box." + "\n'" + form.elements[listObjectName].options[theIndex].text + "' is not valid.");
        return false
      } // end if
    } // end if
  } // end for
}

/**
 * validateThisSelect() will return true or false depending on the value of 
 * the select element.  It will return false if that value is either
 * blank (=='') or if the value is a 'separator value' @see isSeparator()
 * @param obj form the form object that we want to validate
 * @param string elemName is the name of the select element that we are validating
 * @return boolean depending on whether validation succeeds will return true or false
 **/
function validateThisSelect (form, elemName) {
  type = form.elements[elemName].type;
  theIndex = form.elements[elemName].selectedIndex;
  displayedText = form.elements[elemName].options[theIndex].text;
  result = form.elements[elemName].options[theIndex].value;
  if (!((type == 'select-one')||(type == 'select-multiple'))) {
    alert ('Incorrect element type passed to validateThisSelect():' + type);
	return false;
  }
  if ( isSeparator(result) || result=='' ) {
    form.elements[elemName].focus();
    alert("Please choose another value in the " + fieldLabels[elemName] + " select box." + "\n'" + displayedText + "' is not valid.");
    return false;
  } // end if
  return true;
}

/*
 make sure that radio buttons have a checked value
 we do this by collecting all the radioButton group names
 then traversing the list of possible elements to see if one is checked
 Note: it is assumed that all radio button elements REQUIRE a value, so 
 we don't bother with passing in names of 'required' radio button elements
*/
function isRadioChecked(form) {
  // initialize an array that will hold all the names of the radio button groups
  radioButtonGroups = new Array();
  for (i=0; i<form.length; i++) {
    //alert (form.elements[i].type);
    if ( form.elements[i].type=='radio') {
      formObjectName = form.elements[i].name;
      //alert ("the form object is " + formObjectName);
      alreadyFound = false;
      for (j=0; j<radioButtonGroups.length; j++) {
        if (radioButtonGroups[j]==formObjectName) {
          alreadyFound=true;
          break;
        }
      }
      if (!alreadyFound) {radioButtonGroups.push(formObjectName);}
    } // end if
  } // end for
  //alert (radioButtonGroups[0]);
  //alert (radioButtonGroups.length);

  for (k=0; k<radioButtonGroups.length; k++) {
    somethingChecked = false;  // initialize whether one value is checked in each radio group
    radioOptions = form.elements[radioButtonGroups[k]].length;
    //alert ("there are " + radioOptions + " options available for this radio button group");
    for (counter=0; counter<radioOptions; counter++) {
      result = form.elements[radioButtonGroups[k]][counter].checked;
      //alert ("result is " + result);
      if (result) {
        somethingChecked = true;
        break;
      }
      else {
        emptyRadio = form.elements[radioButtonGroups[k]][counter];
      }

    }
    if ( !somethingChecked ) {
      emptyRadio.focus();
      alert("You must choose a value for the '" + fieldLabels[emptyRadio.name] + "' radio button group.");
      return false
    } // end if
  } // end for
  return true
}


/*
  isChecked(form, elemName)
  
  SUMMARY:
  Validate that at least one checkbox element is checked.
  Checkboxes operate independently, and only are coordinated
  by using the convention of giving them the same name.
  Find out how many checkboxes in this form share the given name
  for those that match, add their id to an array.
  Then pass those id's to the getElementById() function to see
  if any of them are checked.
  
  USAGE:
  onSubmit="isChecked(this,'dgfFunctionalRole[]')"
*/
function isChecked(form, elemName){
  formName = form.name; // what is the name of this form?
  bChecked=false;
  countElements = form.length;
  checkBoxIds = new Array();
  for (i=0; i<countElements; i++) {
    if ((form.elements[i].type=="checkbox")&& (form.elements[i].name==elemName)) {
      checkBoxIds.push(form.elements[i].id);
    }
  }
  howManyCheckBoxes = checkBoxIds.length;
  for (z=0; z<howManyCheckBoxes; z++) {
    bChecked = eval('document.getElementById(\'' + checkBoxIds[z] + '\').checked');
    if (bChecked) {
//      alert ('You checked ' + checkBoxIds[z]);
      break  // we found at least one checked, our work here is done
    }
  }
  if (!bChecked) {
    // since javascript needs [] included in the element name, but php interprets it as an array
	// we need to strip off the [] from the name to find the element in the fieldLabels array
	elemName = elemName.replace(/\[\]/,'');
    alert('Please check at least one option for the ' + fieldLabels[elemName] + ' question.');
/*  
 optional functionality, would have to check the current form element index,
 then loop backwards to find an element that can focus (text or textarea)
 and focus on that element
    // bring focus to the element above (can't focus on checkbox)
    form.elements['dgfPhoneFax'].focus();
*/
    return false
  }
  return true
}



function validateForm (form, requiredTextFields, requiredSelectFields, requiredCheckboxFields) {
  whatForm = (form.name);
  if ( (typeof requiredTextFields == 'object') && (requiredTextFields != null) ) {
    for (i=0; i<requiredTextFields.length; i++) {
      if ( eval('isWhitespace(form.elements["' + requiredTextFields[i] + '"].value)') ) {
        eval('form.elements["' + requiredTextFields[i] + '"].focus()');
        alert ("A required field:\n" + fieldLabels[requiredTextFields[i]] + "\n was left blank. \n Please try again.");
        return false
      } // end if
    } // end for
  }
  
  // validate that all radio buttons have at least one checked option
  if (!isRadioChecked (form)) return false;

  // loop through the required select elements, validating whether something
  // is selected at all, then check that what is selected is valid.
  if ( (typeof requiredSelectFields == 'object') && (requiredSelectFields != null) ) {
    for (i=0; i<requiredSelectFields.length; i++) {
      if (!isSelected(form, requiredSelectFields[i])) return false;
	  if (!validateThisSelect (form, requiredSelectFields[i])) return false;
    }
  }
  // validate that at least one value is checked for required checkbox groups
  // requiredCheckboxFields was passed as an array, as it should be
  if ( (typeof requiredCheckboxFields == 'object') && (requiredCheckboxFields != null) ) {
    for (i=0; i<requiredCheckboxFields.length; i++) {
      if(!isChecked(form, requiredCheckboxFields[i])) return false;
    }
  }
  // requiredCheckboxFields was passed as a string, or null
  else if (requiredCheckboxFields !=null) {
    if(!isChecked(form, requiredCheckboxFields)) return false;
  }

}  // end validation function



-->