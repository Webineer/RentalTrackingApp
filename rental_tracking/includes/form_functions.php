<?php
	global $thank_you_msg, $msg;
	
function view_form_info() {
	foreach ($_POST as $key => $value) {
    echo "Key: $key; Value: $value<br>\n";
	}
}

//Send confirmation to submitter
function send_response($info_array) {
	$text_body = "";
	$body = "";
	$my_date = date(M) . " " . date(d) . ", " . date(Y);
	#Send notification to webmaster
	//$to = "greg@webineering.com";
	if ($_POST['email']) {
		$to = $_POST['email'];
		$subject = "Ski Bradford Registration";
		if ($_POST['lastname']) {
			$text_body .= "Good Day " . $_POST['firstname'] . " " . $_POST['lastname'] . ",\n\n";
			$body .= "<p>Good Day " . $_POST['firstname'] . " " . $_POST['lastname'] . ",</p>";
		}
		$text_body .= "SKI BRADFORD PROGRAM CONFIRMATION\n\nThank you for your lesson registration for " . $info_array[0] . " on " . convert_date_display($info_array[1]) . ".\n\n";
		$text_body .= "On the first day, please come early to check-in.  We suggest 40 minutes.  You must come to the registration area to pick up your package that includes your class card and sign the program waiver if you have not done so.\n\n";
		$text_body .= "Please bring  your confirmation with you on the first day of your program.\n\n";
		$text_body .= "If you are renting, the first day we suggest 60 minutes to check-in and go through the rental shop.\n\n";
		$text_body .= "In order to save time the first day, you may come to Bradford to pick up your program package and fit rentals, from 9am-3pm, Mon-Fri the week prior to start of your program.  Pleae do not reply via email.  For any questions or changes, call 978-373-0071.\n\n";
		//$text_body .= "Thank you for your lesson registration for " . $info_array[0] . " on " . convert_date_display($info_array[1]) . ".  If you do not receive a written confirmation within a week, please call us at Ski Bradford at 978-373-0071.\n\n";
		//$text_body .= "If you do not receive an email confirmation within 10 business days, please call SkiBradford at 978-373-0071 regarding the status of your request.  If you have general questions regarding SkiBradford, please call us at 866-644-SNOW.\n\n";
		$text_body .= "Thank you for your interest in SkiBradford.  Have a good day.\n\n";
		$text_body .= "Regards,\nSki Bradford";
		
		$body .= "<p>SKI BRADFORD PROGRAM CONFIRMATION</p><p>Thank you for your lesson registration for " . $info_array[0] . " on " . convert_date_display($info_array[1]) . ".</p>";
		$body .= "<p>On the first day, please come early to check-in.  We suggest 40 minutes.  You must come to the registration area to pick up your package that includes your class card and sign the program waiver if you have not done so.</p>";
		$body .= "<p>Please bring your confirmation with you on the first day of our program.<p>";
		$body .= "<p>If you are renting, the first day we suggest 60 minutes to check-in and go through the rental shop.<p>";
		$body .= "<p>In order to save time the first day, you may come to Bradford to pick up your program package and fit rentals, from 9am-3pm, Mon-Fri the week prior to start of your program.  Please do not reply via email.  For any questions or changes, call 978-373-0071.</p>";
		//$body .= "<p>Thank you for your lesson registration for " . $info_array[0] . " on " . convert_date_display($info_array[1]) . ".  If you do not receive a written confirmation within a week, please call us at Ski Bradford at 978-373-0071.</p>";
		//$body .= "<p>If you do not receive an email confirmation within 10 business days, please call SkiBradford at 978-373-0071 regarding the status of your request.  If you have general questions regarding SkiBradford, please call us at 866-644-SNOW.</p>";
		$body .= "<p>Thank you for your interest in SkiBradford.  Have a good day.</p>";
		$body .= "<p>Regards,<br>Ski Bradford</p>";
		
		$mail = new phpmailer();
		$mail->From     = "sales@skibradford.com";
		$mail->FromName = "Ski Bradford";
		$mail->Host     = "smtp.comcast.net";
		$mail->Mailer   = "smtp";
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = $text_body;
		$mail->AddAddress($to, $_POST['lastname']);

		if(!$mail->Send()) {
			echo "There has been a mail error sending to " . $to . "<br>";
		}
		// Clear all addresses and attachments for next loop
		$mail->ClearAddresses();
		
		//Log the email
		append_email_log($info_array[0]);
	}
}

//Send info to Scott
function send_form_info() {
	
	#Send information request to Scott
	$text_body = "The following information was submitted via the web site contact form:\n\n";
	$body = "<p>The following information was submitted via the web site contact form:</p>";
	$my_date = date(M) . " " . date(d) . ", " . date(Y);
	#Send notification to webmaster
	#$to = "scott@echolsfineart.com";
	$to = "greg@webineering.com";
	
	$body .= "<p>";
	foreach ($_POST as $key => $value) {
    	//print "$key: $value<br>\n";
		$text_body .= "$key: $value<br>\n";
		$body .= "$key: $value<br>";
	}
	
	$text_body .= "Please process this information accordingly.\n\n";
	$body .= "</p><p>Please process this information accordingly.</p>";

	$mail = new phpmailer();
	$mail->From     = "greg@webineering.com";
	$mail->FromName = "Your Web Site";
	$mail->Host     = "smtp.comcast.net";
	$mail->Mailer   = "smtp";
	$mail->Subject = $_POST['subject'];
	$mail->Body    = $body;
	$mail->AltBody = $text_body;
	$mail->AddAddress($to, "M. Scott Echols");

	if(!$mail->Send()) {
		echo "There has been a mail error sending to " . $to . "<br>";
	}
	// Clear all addresses and attachments for next loop
	$mail->ClearAddresses();
}

function notify_admin() {
	$my_date = date(M) . " " . date(d) . ", " . date(Y);
	#Send notification to webmaster
	$to = "greg@webineering.com";
	$subject = $_POST['subject'] . " Form Submitted";
	$text_body = "$my_date: The Echols " . $_POST['subject'] . " form was submitted";
	$body = "<p>$my_date: The Echols " . $_POST['subject'] . " form was submitted</p>";
	$mail = new phpmailer();
	$mail->From     = "greg@webineering.com";
	$mail->FromName = "Your Web Site";
	$mail->Host     = "mail.netway.com";
	$mail->Mailer   = "smtp";
	$mail->Subject = $_POST['subject'];
	$mail->Body    = $body;
	$mail->AltBody = $text_body;
	$mail->AddAddress($to, "Webmaster");

	if(!$mail->Send()) {
		echo "There has been a mail error sending to " . $to . "<br>";
	}
	// Clear all addresses and attachments for next loop
	$mail->ClearAddresses();
}

function post_thank_you() {
	global $thank_you_msg;
	
	#echo "<p>Thank you for your inquiry.  Your inquiry is being processed and you will be contacted shortly.</p>";
	#echo "<p> Thank you, again, for your interest in Mr. Echols and this site.</p>";
	print $thank_you_msg;
}

function check_required() {
	#initialize variables
	$err = 0;
	$err_msg = "The following fields are required:\\n";
	
	$required_fields = explode(",", $_POST['required']);
	#echo "the required fields are " . $_POST['required'] . "<br>";
	
	#if ($required_fields == "all") {
	#	foreach ($_POST as $key => $value) {
	#		if ($value == "") {
	#			$err_msg .= $key . "\\n";
	#			$err = 1;
	#			#echo "$err_msg<br>";
	#		}
	#	}
	#} 
	
	if (count($required_fields) > 0) {
		foreach ($required_fields as $value) {
			if ($_POST[$value] == "") {
				$err_msg .= $value . "\\n";
				$err = 1;
				#echo "the key is $value<br>";
				#echo "the values pass are " . $_POST[$value] . "<br>";
			}
		}
	}
	$err_msg .= "Please enter inputs into these fields.";
		
	if ($err == 1) {
		echo "<script language=\"Javascript\">alert('" . $err_msg . "');history.back()</script>";
	}
	
}

function append_email_log($the_class) {
	$entry_string = date('Y') . "-" . date('m') . "-" . date('d') . ": Email sent to " . $_POST['lastname'] . " at " . $_POST['email'] . " for program " . $the_class . ".\n";
	//$entry_string = "You are a loser\n\n";
	//print $entry_string . "<br>";
	$log_path = "/var/www/html/remote_registration/email_log.txt";
	#echo "$entry_string<br>";
	$logfile = @fopen($log_path, "a+") or die("Could not open email list!");
	@fwrite($logfile, $entry_string) or die("Could not write to email list!");
	fclose($logfile);
}

function process_form() {
	check_required();
	send_form_info();
	notify_admin();
	send_response();
	post_thank_you();
	append_log();
}

?>
