<?php
    require_once("../includes/config.php");
	//require_once("includes/session.php");
	//page-specific settings
	//global $page_security;
	//$page_security = 2;
	
	//require_once("../includes/security.php");
	//require_once("../includes/agent_header.php");
	//require_once("../includes/admin_top_nav.php");
	require_once("../lib/_lib_database.php");
	require_once("../lib/_lib_data_display.php");
    require_once($pear_db_path);

	if ($_POST["uname"] && $_POST["pword"]) {
	   //print "we are here<br>";
       //print $_POST['uname'] . "<br>";
		session_start();
		
		$result = get_one_data("users", "password", "username", $_POST["uname"], "char");
		//print $result . "<br>";
		
		if ($result == $_POST["pword"]) {
		  //print "we are here2<br>";
			$valid_user = $_POST["uname"];
			$pword = $_POST["pword"];
			//$security_value = get_security_data($_POST["uname"]);
			//print "the security value is " . $security_value . "<br>";
			$_SESSION["valid_user"] = $_POST["uname"];
			$_SESSION["pword"] = $_POST["pword"];
			//$_SESSION["security_value"] = $security_value;
			//session_register("valid_user", "pword", "security_value");
			//$dest = "http://192.168.1.87/reservation/admin/index.php";
			header("Location: index.php");
			exit;
		}
	}

	//session_unregister("valid_user");
	//session_unregister("pword");
	//session_unregister("security_value");
	if ($_SESSION['valid_user']) {
		session_destroy();
	}
	
	require_once("../includes/agent_header.php");

	if ($_POST["uname"]) {
		echo "<p>You entered an incorrect username or password.  Please try again.</p>";
	} else {
		echo "<p>Welcome to the Ski Bradford Reservation Application.  Please enter your username and password.</p>";
	}
	
	require("../lib/forms/login_form.php");

	require_once("../includes/admin_footer.php");
?>