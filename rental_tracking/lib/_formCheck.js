<!-- 
// This file originally from Netscape.
// modified by Greg Rundlett.  Greg@Rundlett.com


var reWhitespace = /^\s+$/;
var reLetter = /^[a-zA-Z]$/;
var reAlphabetic = /^[a-zA-Z]+$/;
// setup a regular expression that matches ONLY word character input
var reWord = /^[\w]+$/;
var reAlphanumeric = /^[a-zA-Z0-9]+$/;
var reDigit = /^\d$/;
// a regex that matches digits (emphasis on plural)
var reNum = /^[\d]+$/;
var reLetterOrDigit = /^([a-zA-Z]|\d)$/;
var reInteger = /^\d+$/;
var rePostalCode = /^[\d\w\ \-]+$/;
var reSignedInteger = /^(\+|-)?\d+$/;
var reFloat = /^((\d+(\.\d*)?)|((\d*\.)?\d+))$/;
var reSignedFloat = /^(((\+|-)?\d+(\.\d*)?)|((\+|-)?(\d*\.)?\d+))$/;
var reEmail = /^.+\@.+\..+$/;  // for anything more robust, see validateEmail libs
// var reEmail = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

// setup a regex that matches the 'separator' value in a select list
var reSeparator = /^[-]+$/;



var digits = "0123456789";                                  
var lowercaseLetters = "abcdefghijklmnopqrstuvwxyz";
var uppercaseLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
var letters = lowercaseLetters + uppercaseLetters;
/* note
because we set up these string variables, we can also use them in the test suite to programmatically check whether our functions are working across all posible
values.  For example, this code in the test suite checks the "isLetterOrDigit" function using all uppercaseletters
  for (var i = 0; i < 26; i++) {
    document.write("<P>B" + i + ")" +  isLetterOrDigit (uppercaseLetters.charAt(i)));
  }
*/
var whitespace = " \t\n\r";
var phoneNumberDelimiters = "()- .x";
var validUSPhoneChars = digits + phoneNumberDelimiters;
var validWorldPhoneChars = digits + phoneNumberDelimiters + "+";
var SSNDelimiters = "- ";
var validSSNChars = digits + SSNDelimiters;
var digitsInSocialSecurityNumber = 9;
var digitsInUSPhoneNumber = 10;
var ZIPCodeDelimiters = " -";
var validZIPCodeChars = digits + ZIPCodeDelimiters;
var validPostalCodeChars = validZIPCodeChars + letters;
var digitsInZIPCode1 = 5;
var digitsInZIPCode2 = 9;
var creditCardDelimiters = " -";
var mPrefix = "You did not enter a value into the ";
var mSuffix = " field. This is a required field. Please enter it now.";
var sUSLastName = "Last Name";
var sUSFirstName = "First Name";
var sWorldLastName = "Family Name";
var sWorldFirstName = "Given Name";
var sGeneralName = "Name";
var sTitle = "Title";
var sCompanyName = "Company Name";
var sUSAddress = "Street Address";
var sWorldAddress = "Address";
var sCity = "City";
var sStateCode = "State Code";
var sWorldState = "State, Province, or Prefecture";
var sCountry = "Country";
var sZIPCode = "ZIP Code";
var sWorldPostalCode = "Postal Code";
var sPhone = "Phone Number";
var sFax = "Fax Number";
var sDateOfBirth = "Date of Birth";
var sExpirationDate = "Expiration Date";
var sEmail = "Email";
var sSSN = "Social Security Number";
var sCreditCardNumber = "Credit Card Number";
var sOtherInfo = "Other Information";
var iStateCode = "This field must be a valid two character U.S. state abbreviation (like MA for Massachusetts). Please reenter it now.";
var iZIPCode = "This field must be a 5 or 9 digit U.S. ZIP Code (like 01950). Please reenter it now.";
var iPostalCode = "This field must be a Postal Code (letters, digits, spaces and dashes allowed).  Please reenter it now.";
var iUSPhone = "This field must be a 10 digit U.S. phone number (like 800 555 1212). Please reenter it now.";
var iWorldPhone = "This field must be a valid international phone number. Please reenter it now.";
var iSSN = "This field must be a 9 digit U.S. social security number (like 123 45 6789). Please reenter it now.";
var iEmail = "This field must be a valid email address (like yourname@company.com). Please reenter it now.";
var iCreditCardPrefix = "This is not a valid ";
var iCreditCardSuffix = " credit card number.  Please reenter it now.";
var iDay = "This field must be a day number between 1 and 31.  Please reenter it now.";
var iMonth = "This field must be a month number between 1 and 12.  Please reenter it now.";
var iYear = "This field must be a 2 or 4 digit year number.  Please reenter it now.";
var iDatePrefix = "The Day, Month, and Year for ";
var iDateSuffix = " do not form a valid date.  Please reenter them now.";
var iAlpha = "This field only accepts letters of the English alphabet.  Please try again.";
var iAlphaNumeric = "This field only accepts letters of the English alphabet, and digits (like '2fast4U').  Please try again.";
var pEntryPrompt = "Please enter ";
var pStateCode = "2 character State code (like MA).";
var pZIPCode = "5 or 9 digit U.S. ZIP Code (like 01950-4004).";
var pUSPhone = "10 digit U.S. phone number (like 800 555 1212).";
var pWorldPhone = "international phone number.";
var pSSN = "9 digit U.S. social security number (like 123 45 6789).";
var pEmail = "valid email address (like yourname@example.com).";
var pCreditCard = "valid credit card number.";
var pDay = "day number between 1 and 31.";
var pMonth = "month number between 1 and 12.";
var pYear = "2 or 4 digit year number.";
var pAlpha = "value using the characters in the English alphabet only";
var pAlphaNumeric = "value using letters and digits only";
var defaultEmptyOK = false;

var fieldLabels = new Object();
fieldLabels['firstname'] = 'First Name';
fieldLabels['lastname'] = 'Last Name';
fieldLabels['product_name'] = 'Product Name';
fieldLabels['product_description'] = 'Product Description';
fieldLabels['product_type'] = 'Product Type';
fieldLabels['meeting_time'] = 'Meeting Time';
fieldLabels['product_cost'] = 'Product Cost';
fieldLabels['max_seats'] = 'Maximum Attendees';
fieldLabels['discount_cost'] = 'Discounted Cost';
fieldLabels['rental_fee'] = 'Rental Fee';
fieldLabels['redemption_area'] = 'Redemption Area';
fieldLabels['phone'] = 'Phone Number';
fieldLabels['rentals'] = 'Will you need rentals?';
fieldLabels['location_name'] = 'Location Name';
fieldLabels['location_id'] = 'Location Name';
fieldLabels['begin_date'] = 'Begin Date';
fieldLabels['end_date'] = 'End Date';
fieldLabels['email'] = 'Email Address';
fieldLabels['card_type'] = 'Credit Card Type';
fieldLabels['card_number'] = 'Credit Card Number';
fieldLabels['cardholder'] = 'Credit Card Holder';
fieldLabels['vin_number'] = 'Credit Card Security Code';
fieldLabels['age'] = 'Age';
fieldLabels['address'] = 'Street Address';
fieldLabels['city'] = 'City';
fieldLabels['state'] = 'State';
fieldLabels['zip'] = 'Zip Code';
fieldLabels['waiver_signature'] = 'Waiver Confirmation';
fieldLabels['reservation_date'] = 'Date Of Use';
fieldLabels['account_number'] = 'Account Number';
fieldLabels['ability_level'] = 'Ability';
fieldLabels['section_list_date'] = 'Date';
fieldLabels['profile_id'] = 'Profile';
fieldLabels['section_list_time'] = 'Time';
fieldLabels['time_choice'] = 'Time';
fieldLabels['section_id'] = 'Open Section';


function makeArray(n) {
  for (var i = 1; i <= n; i++) {
    this[i] = 0;
  } 
  return this;
}

var daysInMonth = makeArray(12);
daysInMonth[1] = 31;
daysInMonth[2] = 29;   
daysInMonth[3] = 31;
daysInMonth[4] = 30;
daysInMonth[5] = 31;
daysInMonth[6] = 30;
daysInMonth[7] = 31;
daysInMonth[8] = 31;
daysInMonth[9] = 30;
daysInMonth[10] = 31;
daysInMonth[11] = 30;
daysInMonth[12] = 31;
var USStateCodeDelimiter = "|";
var USStateCodes = "AL|AK|AS|AZ|AR|CA|CO|CT|DE|DC|FM|FL|GA|GU|HI|ID|IL|IN|IA|KS|KY|LA|ME|MH|MD|MA|MI|MN|MS|MO|MT|NE|NV|NH|NJ|NM|NY|NC|ND|MP|OH|OK|OR|PW|PA|PR|RI|SC|SD|TN|TX|UT|VT|VI|VA|WA|WV|WI|WY|AE|AA|AE|AE|AP";

function isItEmpty(s) {
  return ((s == null) || (s.length == 0));
}
function isWhitespace (s) {
  return (isItEmpty(s) || reWhitespace.test(s));
}
function stripCharsInRE (s, bag) {
  return s.replace(bag, "");
}
function stripCharsInBag (s, bag) {
  var i;
  var returnString = "";
  for (i = 0; i < s.length; i++){   
    var c = s.charAt(i);
    if (bag.indexOf(c) == -1) returnString += c;
  }
  return returnString;
}
function stripCharsNotInBag (s, bag) {
  var i;
  var returnString = "";
  for (i = 0; i < s.length; i++){   
    var c = s.charAt(i);
    if (bag.indexOf(c) != -1) returnString += c;
  }
  return returnString;
}
function stripWhitespace (s) {
  return stripCharsInBag (s, whitespace);
}
/* function charInString (c, s){
  for (i = 0; i < s.length; i++){
    if (s.charAt(i) == c) return true;
    }
  return false;
}
*/
function stripInitialWhitespace (s) {
  var i = 0;
  while ((i < s.length) && (whitespace.indexOf(s.charAt(i)) != -1))
    i++;
  return s.substring (i, s.length);
}
function isLetter (c) {
  return reLetter.test(c);
}
function isDigit (c) {
  return reDigit.test(c);
}
function isLetterOrDigit (c) {
  return reLetterOrDigit.test(c);
}
function isInteger (s) {
  var i;
  if (isItEmpty(s)) {
    if (isInteger.arguments.length == 1) {
      return defaultEmptyOK;
    }
    else {
     return (isInteger.arguments[1] == true);
    }
  }
  return reInteger.test(s);
}
function isSignedInteger (s) {
  if (isItEmpty(s)) 
    if (isSignedInteger.arguments.length == 1) return defaultEmptyOK;
    else return (isSignedInteger.arguments[1] == true);
  else {
    return reSignedInteger.test(s);
  }
}
function isPositiveInteger (s) {
  var secondArg = defaultEmptyOK;
  if (isPositiveInteger.arguments.length > 1) {
    secondArg = isPositiveInteger.arguments[1];
  }
  return (isSignedInteger(s, secondArg) && ( (isItEmpty(s) && secondArg) || (parseInt (s) > 0) ) );
}
function isNonnegativeInteger (s) {
  var secondArg = defaultEmptyOK;
  if (isNonnegativeInteger.arguments.length > 1) {
    secondArg = isNonnegativeInteger.arguments[1];
  }
  return (isSignedInteger(s, secondArg) && ( (isItEmpty(s) && secondArg)  || (parseInt (s) >= 0) ) );
}
function isNegativeInteger (s) {
  var secondArg = defaultEmptyOK;
  if (isNegativeInteger.arguments.length > 1) {
    secondArg = isNegativeInteger.arguments[1];
  }
  return (isSignedInteger(s, secondArg) && ( (isItEmpty(s) && secondArg)  || (parseInt (s) < 0) ) );
}
function isNonpositiveInteger (s) {
  var secondArg = defaultEmptyOK;
  if (isNonpositiveInteger.arguments.length > 1) {
    secondArg = isNonpositiveInteger.arguments[1];
  }
  return (isSignedInteger(s, secondArg) && ( (isItEmpty(s) && secondArg)  || (parseInt (s) <= 0) ) );
}
function isFloat (s) {
  if (isItEmpty(s)) 
    if (isFloat.arguments.length == 1) return defaultEmptyOK;
    else return (isFloat.arguments[1] == true);
  return reFloat.test(s);
}
function isSignedFloat (s) {
  if (isItEmpty(s)) 
    if (isSignedFloat.arguments.length == 1) return defaultEmptyOK;
    else return (isSignedFloat.arguments[1] == true);
  else {
    return reSignedFloat.test(s);
  }
}
function isAlphabetic (s) {
  var i;
  if (isItEmpty(s)) 
    if (isAlphabetic.arguments.length == 1) return defaultEmptyOK;
    else return (isAlphabetic.arguments[1] == true);
  else {
    return reAlphabetic.test(s);
  }
}
function isAlphanumeric (s) {
  if (isItEmpty(s)) 
     if (isAlphanumeric.arguments.length == 1) return defaultEmptyOK;
     else return (isAlphanumeric.arguments[1] == true);
  else {
    return reAlphanumeric.test(s);
  }
}
function isSSN (s) {
  if (isItEmpty(s)) 
    if (isSSN.arguments.length == 1) return defaultEmptyOK;
    else return (isSSN.arguments[1] == true);
  return (isInteger(s) && s.length == digitsInSocialSecurityNumber);
}
function isUSPhoneNumber (s) {
  if (isItEmpty(s)) 
    if (isUSPhoneNumber.arguments.length == 1) return defaultEmptyOK;
    else return (isUSPhoneNumber.arguments[1] == true);
  return (isInteger(s) && (s.length == digitsInUSPhoneNumber));
}
function isInternationalPhoneNumber (s) {
  if (isItEmpty(s)) 
    if (isInternationalPhoneNumber.arguments.length == 1) return defaultEmptyOK;
    else return (isInternationalPhoneNumber.arguments[1] == true);
  return (isPositiveInteger(s));
}
function isZIPCode (s) {
  if (isItEmpty(s)) 
    if (isZIPCode.arguments.length == 1) return defaultEmptyOK;
    else return (isZIPCode.arguments[1] == true);
  return (isInteger(s) && ((s.length == digitsInZIPCode1) || (s.length == digitsInZIPCode2)));
}
function isPostalCode (s) {
  if (isItEmpty(s)) 
    if (isPostalCode.arguments.length == 1) return defaultEmptyOK;
    else return (isPostalCode.arguments[1] == true);
  return rePostalCode.test(s);
}
function isStateCode(s) {
  if (isItEmpty(s)) 
    if (isStateCode.arguments.length == 1) return defaultEmptyOK;
    else return (isStateCode.arguments[1] == true);
  return ( (USStateCodes.indexOf(s) != -1) && (s.indexOf(USStateCodeDelimiter) == -1) );
}
function isEmail (s) {
  if (isItEmpty(s)) 
    if (isEmail.arguments.length == 1) return defaultEmptyOK;
    else return (isEmail.arguments[1] == true);
  else {
    return reEmail.test(s);
  }
}
function isYear (s) {
  if (isItEmpty(s)) {
    if (isYear.arguments.length == 1) return defaultEmptyOK;
    else return (isYear.arguments[1] == true);
  }
  if (!isNonnegativeInteger(s)) return false;
  return ((s.length == 2) || (s.length == 4));
}
function isIntegerInRange (s, a, b) {
  if (isItEmpty(s)) 
    if (isIntegerInRange.arguments.length == 1) return defaultEmptyOK;
    else return (isIntegerInRange.arguments[1] == true);
  if (!isInteger(s, false)) return false;
  var num = parseInt (s);
  return ((num >= a) && (num <= b));
}
function isMonth (s) {
  if (isItEmpty(s)) 
    if (isMonth.arguments.length == 1) return defaultEmptyOK;
    else return (isMonth.arguments[1] == true);
  return isIntegerInRange (s, 1, 12);
}
function isDay (s) {
  if (isItEmpty(s)) 
    if (isDay.arguments.length == 1) return defaultEmptyOK;
    else return (isDay.arguments[1] == true);   
  return isIntegerInRange (s, 1, 31);
}
function daysInFebruary (year) {
  return (  ((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0) ) ) ? 29 : 28 );
}
function isDate (year, month, day) {
  if (! (isYear(year, false) && isMonth(month, false) && isDay(day, false))) return false;
  var intYear = parseInt(year);
  var intMonth = parseInt(month);
  var intDay = parseInt(day);
  if (intDay > daysInMonth[intMonth]) return false; 
  if ((intMonth == 2) && (intDay > daysInFebruary(intYear))) return false;
  return true;
}

// Returns true if string s consists of only 'word' characters
function isWord (s) {
  if (isItEmpty(s)) 
    if (isWord.arguments.length == 1) return defaultEmptyOK;
    else return (isWord.arguments[1] == true);   
  return (reWord.test(s));
}

// Returns true if string s consists only of dashes
function isSeparator (s) {
  if (isItEmpty(s)) 
    if (isSeparator.arguments.length == 1) return defaultEmptyOK;
    else return (isSeparator.arguments[1] == true);   
  return (reSeparator.test(s));
}

// Returns true if string s is an integer value
function isNum (s) {
  if (isItEmpty(s)) 
    if (isNum.arguments.length == 1) return defaultEmptyOK;
    else return (isNum.arguments[1] == true);   
  return (reNum.test(s));
}


/* FUNCTIONS TO NOTIFY USER OF INPUT REQUIREMENTS OR MISTAKES. */
function statusBarMsg (s) {
  window.status = s;
}
function dispStatusBarMsg (s) {
  var reVowels = /[aeiou]/i;  
  if (reVowels.test(s.charAt(0)) ) { 
    window.status = pEntryPrompt + "an " + s;
  }
  else  window.status = pEntryPrompt + "a " + s;
}
function warnEmpty (theField, s) {
  theField.focus();
  alert(mPrefix + s + mSuffix);
  return false;
}
function warnInvalid (theField, s) {
  theField.focus();
  theField.select();
  alert(s);
  return false;
}
// should be invoked using onchange handler, and 
// use the special 'this' keyword in arguments.
// this.form.name, this.name, 'message string' 
function alertMsg (formName, elemName, msg) {
  alert(msg);
  document.forms[formName].elements[elemName].focus();
  if (document.forms[formName].elements[elemName].type==('text'||'text-area'))
    document.forms[formName].elements[elemName].select();
}


/*
FORMATTING FUNCTIONS (used in some of the check functions)
*/
// reformat is used by other functions to modify strings
// for example, it can turn 012345678 into 012-34-5678
// or 1235551000 into (123) 555-1000
function reformat (s) {
  var arg;
  var sPos = 0;
  var resultString = "";
  for (var i = 1; i < reformat.arguments.length; i++) {
    arg = reformat.arguments[i];
    if (i % 2 == 1) resultString += arg;
    else {
      resultString += s.substring(sPos, sPos + arg);
      sPos += arg;
    }
  }
  return resultString;
}

// prefix a string s with another string prefix
function prepend (s, prefix) {
 if (s.substr(0,prefix.length) == prefix)
   return s
 else
   return prefix + s;
}

// turn an integer into accounting formatted number
function formatCurrency(num) {
  num = num.toString().replace(/\$|\,/g,'');
  if(isNaN(num))
    {num = "0";}
  sign = (num == (num = Math.abs(num)));
  num = Math.floor(num*100+0.50000000001);
  cents = num%100;
  num = Math.floor(num/100).toString();
  if(cents<10)
  cents = "0" + cents;
  for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
    num = num.substring(0,num.length-(4*i+3))+','+
    num.substring(num.length-(4*i+3));
  return (((sign)?'':'-') + '$' + num + '.' + cents);
}
// turn an integer (possibly accepting $ and , characters) into thousands
function formatThousands(num) {
  num = num.toString().replace(/\$|\,/g,'');
  if(isNaN(num))
    {num = "0";}
  sign = (num == (Math.abs(num)));
  for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
    num = num.substring(0,num.length-(4*i+3))+','+
    num.substring(num.length-(4*i+3));
  return (((sign)?'':'-') + num);
}

// limit a text entry to a certain number of words
// usage: <textarea name="foobar" onchange="limitWords(this.form.foobar, 150);"></textarea>
function limitWords(theField, words) {
  tstr=theField.value;
  pos=0;
  for($i=0; $i<words; $i++) {
    if (pos < tstr.length) {
      pos = tstr.indexOf(' ',pos+1)
    }
    if (pos==-1) return;
  } 
//  alert(pos);
  if (tstr.length>pos) {
    tstr=tstr.substr(0,pos);
    if (confirm('You are over the limit of ' + words + ' words.  \n\n Click \'OK\' to shorten your text to: \n\n' + tstr + '\n\nClick \'Cancel\' to edit the text yourself.')) {
    theField.value=tstr;
    }
  }
}

// limit a text entry to a certain number of characters
// usage: <textarea name="foobar" onchange="limitChars(this.form.foobar, 150);"></textarea>
function limitChars(theField, chars) {
  tstr=theField.value;
  if (tstr.length<=chars) return;
  if (tstr.length>chars) {
    tstr=tstr.substr(0,chars);
    if (confirm('You are over the limit of ' + chars + ' characters.  \n\n Click \'OK\' to shorten your text to: \n\n' + tstr + '\n\nClick \'Cancel\' to edit the text yourself.')) {
    theField.value=tstr;
    }
  }
}



/* FUNCTIONS TO INTERACTIVELY CHECK VARIOUS FIELDS. */
function checkString (theField, s, emptyOK) {
  if (checkString.arguments.length == 2) emptyOK = defaultEmptyOK;
  if ((emptyOK == true) && (isItEmpty(theField.value))) return true;
  if (isWhitespace(theField.value)) 
    return warnEmpty (theField, s);
  else return true;
}
function checkAlphabetic (theField, s, emptyOK) {
  if (checkAlphabetic.arguments.length == 2) emptyOK = defaultEmptyOK;
  if ( (isAlphabetic(theField.value)) | (emptyOK == true) ) return true;
  if ( (!isAlphabetic(theField.value)) && (emptyOK == false) ) 
    return warnInvalid (theField, s);
  else return true;
}
function checkAlphanumeric (theField, s, emptyOK) {
  if (checkAlphanumeric.arguments.length == 2) emptyOK = defaultEmptyOK;
  if ( (isAlphanumeric(theField.value)) | (emptyOK == true) ) return true;
  if ( (!isAlphanumeric(theField.value)) && (emptyOK == false) ) 
    return warnInvalid (theField, s);
  else return true;
}
function checkStateCode (theField, emptyOK) {
  if (checkStateCode.arguments.length == 1) emptyOK = defaultEmptyOK;
  if ((emptyOK == true) && (isItEmpty(theField.value))) return true;
  else{
    theField.value = theField.value.toUpperCase();
    if (!isStateCode(theField.value, false)) return warnInvalid (theField, iStateCode);
    else return true;
  }
}
function reformatZIPCode (ZIPString) {
  if (ZIPString.length == 5) return ZIPString;
  else return (reformat (ZIPString, "", 5, "-", 4));
}
function checkZIPCode (theField, emptyOK) {
  if (checkZIPCode.arguments.length == 1) emptyOK = defaultEmptyOK;
  if ((emptyOK == true) && (isItEmpty(theField.value))) return true;
  else {
    var normalizedZIP = stripCharsInBag(theField.value, ZIPCodeDelimiters);
    if (!isZIPCode(normalizedZIP, false)) {
      warnInvalid (theField, iZIPCode);
	  return false;
	}
    else {
      theField.value = reformatZIPCode(normalizedZIP);
      return true;
    }
  }
}
function checkPostalCode (theField, emptyOK) {
  if (checkPostalCode.arguments.length == 1) emptyOK = defaultEmptyOK;
  if ((emptyOK == true) && (isItEmpty(theField.value))) return true;
  else {
    var normalizedCode = stripCharsInBag(theField.value, ZIPCodeDelimiters);
	if (!isPostalCode(normalizedCode, false))
	  return warnInvalid (theField, iPostalCode);
	else {
      return true;
	}
  }
}
function reformatUSPhone (USPhone) {
  return (reformat (USPhone, "(", 3, ") ", 3, "-", 4));
}
function checkUSPhone (theField, emptyOK) {
  if (checkUSPhone.arguments.length == 1) emptyOK = defaultEmptyOK;
  if ((emptyOK == true) && (isItEmpty(theField.value))) return true;
  else {
    var normalizedPhone = stripCharsInBag(theField.value, phoneNumberDelimiters);
    if (!isUSPhoneNumber(normalizedPhone, false)) 
      return warnInvalid (theField, iUSPhone);
    else {
      theField.value = reformatUSPhone(normalizedPhone);
      return true;
    }
  }
}
function checkInternationalPhone (theField, emptyOK) {
  if (checkInternationalPhone.arguments.length == 1) emptyOK = defaultEmptyOK;
  if ((emptyOK == true) && (isItEmpty(theField.value))) return true;
  else {
    var normalizedPhone = stripCharsInBag(theField.value, phoneNumberDelimiters);
    if (!isInternationalPhoneNumber(normalizedPhone, false)) 
      return warnInvalid (theField, iWorldPhone);
    else {
//      theField.value = normalizedPhone;
      return true;
    }
  }
}
function checkEmail (theField, emptyOK) {
  if (checkEmail.arguments.length == 1) emptyOK = defaultEmptyOK;
  if ((emptyOK == true) && (isItEmpty(theField.value))) return true;
  else if (!isEmail(theField.value, false)) 
     return warnInvalid (theField, iEmail);
  else return true;
}
function reformatSSN (SSN) {
  return (reformat (SSN, "", 3, "-", 2, "-", 4));
}
function checkSSN (theField, emptyOK) {
  if (checkSSN.arguments.length == 1) emptyOK = defaultEmptyOK;
  if ((emptyOK == true) && (isItEmpty(theField.value))) return true;
  else {
    var normalizedSSN = stripCharsInBag(theField.value, SSNDelimiters);
    if (!isSSN(normalizedSSN, false))
      return warnInvalid (theField, iSSN);
    else {
      theField.value = reformatSSN(normalizedSSN);
      return true;
    }
  }
}
function checkYear (theField, emptyOK) {
  if (checkYear.arguments.length == 1) emptyOK = defaultEmptyOK;
  if ((emptyOK == true) && (isItEmpty(theField.value))) return true;
  if (!isYear(theField.value, false)) 
    return warnInvalid (theField, iYear);
  else return true;
}
function checkMonth (theField, emptyOK) {
  if (checkMonth.arguments.length == 1) emptyOK = defaultEmptyOK;
  if ((emptyOK == true) && (isItEmpty(theField.value))) return true;
  if (!isMonth(theField.value, false)) 
    return warnInvalid (theField, iMonth);
  else return true;
}
function checkDay (theField, emptyOK) {
  if (checkDay.arguments.length == 1) emptyOK = defaultEmptyOK;
  if ((emptyOK == true) && (isItEmpty(theField.value))) return true;
  if (!isDay(theField.value, false)) 
    return warnInvalid (theField, iDay);
  else return true;
}
function checkDate (yearField, monthField, dayField, labelString, OKtoOmitDay) {
  if (checkDate.arguments.length == 4) OKtoOmitDay = false;
  if (!isYear(yearField.value)) return warnInvalid (yearField, iYear);
  if (!isMonth(monthField.value)) return warnInvalid (monthField, iMonth);
  if ( (OKtoOmitDay == true) && isItEmpty(dayField.value) ) return true;
  else if (!isDay(dayField.value)) 
    return warnInvalid (dayField, iDay);
  if (isDate (yearField.value, monthField.value, dayField.value))
    return true;
  alert (iDatePrefix + labelString + iDateSuffix)
  return false;
}
function getRadioButtonValue (radio) {
  for (var i = 0; i < radio.length; i++){
    if (radio[i].checked) { break }
  }
  return radio[i].value;
}



function checkCreditCard (radio, theField) {
  var cardType = getRadioButtonValue (radio);
  var normalizedCCN = stripCharsInBag(theField.value, creditCardDelimiters);
  if (!isCardMatch(cardType, normalizedCCN))
    return warnInvalid (theField, iCreditCardPrefix + cardType + iCreditCardSuffix);
  else {
    theField.value = normalizedCCN;
    return true
  }
}
/*  ================================================================
    Credit card verification functions
    Originally included as Starter Application 1.0.0 in LivePayment.
    20 Feb 1997 modified by egk:
           changed naming convention to initial lowercase
                  (isMasterCard instead of IsMasterCard, etc.)
           changed isCC to isCreditCard
           retained functions named with older conventions from
                  LivePayment as stub functions for backward 
                  compatibility only
           added "AMERICANEXPRESS" as equivalent of "AMEX" 
                  for naming consistency 
    ================================================================ */
/*  ================================================================
    FUNCTION:  isCreditCard(st)
 
    INPUT:     st - a string representing a credit card number
    RETURNS:  true, if the credit card number passes the Luhn Mod-10
		    test.
	      false, otherwise
    ================================================================ */
function isCreditCard(st) {
  if (st.length > 19)
    return (false);
  sum = 0; mul = 1; l = st.length;
  for (i = 0; i < l; i++) {
    digit = st.substring(l-i-1,l-i);
    tproduct = parseInt(digit ,10)*mul;
    if (tproduct >= 10)
      sum += (tproduct % 10) + 1;
    else
      sum += tproduct;
    if (mul == 1)
      mul++;
    else
      mul--;
  }
  if ((sum % 10) == 0)
    return (true);
  else
    return (false);
} 
/*  ================================================================
    FUNCTION:  isVisa()
 
    INPUT:     cc - a string representing a credit card number
    RETURNS:  true, if the credit card number is a valid VISA number.
		    
	      false, otherwise
    Sample number: 4111 1111 1111 1111 (16 digits)
    ================================================================ */
function isVisa(cc)
{
  if (((cc.length == 16) || (cc.length == 13)) &&
      (cc.substring(0,1) == 4))
    return isCreditCard(cc);
  return false;
}  
/*  ================================================================
    FUNCTION:  isMasterCard()
 
    INPUT:     cc - a string representing a credit card number
    RETURNS:  true, if the credit card number is a valid MasterCard
		    number.
		    
	      false, otherwise
    Sample number: 5500 0000 0000 0004 (16 digits)
    ================================================================ */
function isMasterCard(cc)
{
  firstdig = cc.substring(0,1);
  seconddig = cc.substring(1,2);
  if ((cc.length == 16) && (firstdig == 5) &&
      ((seconddig >= 1) && (seconddig <= 5)))
    return isCreditCard(cc);
  return false;
} 
/*  ================================================================
    FUNCTION:  isAmericanExpress()
 
    INPUT:     cc - a string representing a credit card number
    RETURNS:  true, if the credit card number is a valid American
		    Express number.
		    
	      false, otherwise
    Sample number: 340000000000009 (15 digits)
    ================================================================ */
function isAmericanExpress(cc)
{
  firstdig = cc.substring(0,1);
  seconddig = cc.substring(1,2);
  if ((cc.length == 15) && (firstdig == 3) &&
      ((seconddig == 4) || (seconddig == 7)))
    return isCreditCard(cc);
  return false;
} 
/*  ================================================================
    FUNCTION:  isDinersClub()
 
    INPUT:     cc - a string representing a credit card number
    RETURNS:  true, if the credit card number is a valid Diner's
		    Club number.
		    
	      false, otherwise
    Sample number: 30000000000004 (14 digits)
    ================================================================ */
function isDinersClub(cc)
{
  firstdig = cc.substring(0,1);
  seconddig = cc.substring(1,2);
  if ((cc.length == 14) && (firstdig == 3) &&
      ((seconddig == 0) || (seconddig == 6) || (seconddig == 8)))
    return isCreditCard(cc);
  return false;
}
/*  ================================================================
    FUNCTION:  isCarteBlanche()
 
    INPUT:     cc - a string representing a credit card number
    RETURNS:  true, if the credit card number is a valid Carte
		    Blanche number.
		    
	      false, otherwise
    ================================================================ */
function isCarteBlanche(cc)
{
  return isDinersClub(cc);
}
/*  ================================================================
    FUNCTION:  isDiscover()
 
    INPUT:     cc - a string representing a credit card number
    RETURNS:  true, if the credit card number is a valid Discover
		    card number.
		    
	      false, otherwise
    Sample number: 6011000000000004 (16 digits)
    ================================================================ */
function isDiscover(cc)
{
  first4digs = cc.substring(0,4);
  if ((cc.length == 16) && (first4digs == "6011"))
    return isCreditCard(cc);
  return false;
} 
/*  ================================================================
    FUNCTION:  isEnRoute()
 
    INPUT:     cc - a string representing a credit card number
    RETURNS:  true, if the credit card number is a valid enRoute
		    card number.
		    
	      false, otherwise
    Sample number: 201400000000009 (15 digits)
    ================================================================ */
function isEnRoute(cc)
{
  first4digs = cc.substring(0,4);
  if ((cc.length == 15) &&
      ((first4digs == "2014") ||
       (first4digs == "2149")))
    return isCreditCard(cc);
  return false;
}
/*  ================================================================
    FUNCTION:  isJCB()
 
    INPUT:     cc - a string representing a credit card number
    RETURNS:  true, if the credit card number is a valid JCB
		    card number.
		    
	      false, otherwise
    ================================================================ */
function isJCB(cc)
{
  first4digs = cc.substring(0,4);
  if ((cc.length == 16) &&
      ((first4digs == "3088") ||
       (first4digs == "3096") ||
       (first4digs == "3112") ||
       (first4digs == "3158") ||
       (first4digs == "3337") ||
       (first4digs == "3528")))
    return isCreditCard(cc);
  return false;
} 
/*  ================================================================
    FUNCTION:  isAnyCard()
 
    INPUT:     cc - a string representing a credit card number
    RETURNS:  true, if the credit card number is any valid credit
		    card number for any of the accepted card types.
		    
	      false, otherwise
    ================================================================ */
function isAnyCard(cc)
{
  if (!isCreditCard(cc))
    return false;
  if (!isMasterCard(cc) && !isVisa(cc) && !isAmericanExpress(cc) && !isDinersClub(cc) &&
      !isDiscover(cc) && !isEnRoute(cc) && !isJCB(cc)) {
    return false;
  }
  return true;
} 
/*  ================================================================
    FUNCTION:  isCardMatch()
 
    INPUT:    cardType - a string representing the credit card type
	      cardNumber - a string representing a credit card number
    RETURNS:  true, if the credit card number is valid for the particular
	      credit card type given in "cardType".
		    
	      false, otherwise
    ================================================================ */
function isCardMatch (cardType, cardNumber)
{
	cardType = cardType.toUpperCase();
	var doesMatch = true;
	if ((cardType == "VISA") && (!isVisa(cardNumber)))
		doesMatch = false;
	if ((cardType == "MASTERCARD") && (!isMasterCard(cardNumber)))
		doesMatch = false;
	if ( ( (cardType == "AMERICANEXPRESS") || (cardType == "AMEX") )
                && (!isAmericanExpress(cardNumber))) doesMatch = false;
	if ((cardType == "DISCOVER") && (!isDiscover(cardNumber)))
		doesMatch = false;
	if ((cardType == "JCB") && (!isJCB(cardNumber)))
		doesMatch = false;
	if ((cardType == "DINERS") && (!isDinersClub(cardNumber)))
		doesMatch = false;
	if ((cardType == "CARTEBLANCHE") && (!isCarteBlanche(cardNumber)))
		doesMatch = false;
	if ((cardType == "ENROUTE") && (!isEnRoute(cardNumber)))
		doesMatch = false;
	return doesMatch;
}  
 -->