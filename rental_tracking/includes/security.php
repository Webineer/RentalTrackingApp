<?php
	//print $_SESSION["security_value"] . "<br>";
	if ($_SESSION["security_value"] >= $page_security) {
		//do nothing
	} else {
		$redirectURL = APP_ROOT . "noaccess.php";
		header("Location:  $redirectURL");
	}
?>