<?php
	require_once("includes/config.php");
	require_once("includes/session.php");
	require_once("includes/header.php");
	require_once("includes/top_nav.php");
	
	session_unregister("valid_user");
	session_unregister("pword");
	session_unregister("security_value");
?>
<h1><?php print ORGANIZATION; ?> Lesson Registration Application</h1>
<p>Thank you for using the <?php print ORGANIZATION; ?> Lesson Registration Application.  
You have logged-out.  Please click <a href="index.php">here</a> log back into this application.</p>

<?php
	require_once("includes/footer.php");
?>
