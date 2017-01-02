<?php
	require_once("includes/config.php");
	require_once("lib/_lib_database.php");
	require_once($pear_db_path);

	if ($_POST["uname"] && $_POST["pword"]) {
		session_start();
		
		$result = get_one_data("users", "password", "username", $_POST["uname"], "char");
		//print $result . "<br>";
		
		if ($result == $_POST["pword"]) {	
			$valid_user = $_POST["uname"];
			$pword = $_POST["pword"];
			//$security_value = get_security_data($_POST["uname"]);
			//print "the security value is " . $security_value . "<br>";
			$_SESSION["valid_user"] = $_POST["uname"];
			$_SESSION["pword"] = $_POST["pword"];
			$_SESSION["security_value"] = $security_value;
			//session_register("valid_user", "pword", "security_value");
			$dest = APP_ROOT . "welcome.php";
            //print "the destination is " . $dest . "<br>";
			header("Location:  $dest");
			exit;
		}
	}

	//session_unregister("valid_user");
	//session_unregister("pword");
	//session_unregister("security_value");
	if ($_SESSION['valid_user']) {
		session_destroy();
	}
	
	require_once("includes/index_header.php");

	if ($_POST["uname"]) {
		echo "<p>You entered an incorrect username or password.  Please try again.</p><br><br><br>";
	} else {
		echo "<p>Welcome to the " . ORGANIZATION . " Equipment Rental Tracking Management Application.  Please enter your username and password.</p><br><br><br>";
	}
	
	require("lib/forms/login_form.php");

	require_once("includes/index_footer.php");
?>