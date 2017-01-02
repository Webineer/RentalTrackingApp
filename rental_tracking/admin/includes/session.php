<?php
	session_start();

	$redirectURL = "/instructors/admin/login.php";

	if ($_SESSION["valid_user"]) {
		$valid_user = $_SESSION["valid_user"];
		$pword = $_SESSION["pword"];
		# Show the page; nothing doing...
	} else {
		//print "We are here<br>";
		header("Location:  $redirectURL");
	}
?>