<?php
	require_once("includes/config.php");
	require_once("includes/header.php");
	require_once("lib/_lib_database.php");
	require_once("lib/_lib_data_display.php");
	require_once($pear_db_path);
	
?>
		
			<h1>Transaction Failed</h1>
            
            <!-- p>The value of $_POST['course'] is < ?php print $_POST['course']; ?>.</p>
            
            <p>The value of $_POST['bname'] is < ?php print $_POST['bname']; ?>.</p>
            
            <p>The value of $_POST['chargetotal'] is < ?php print $_POST['chargetotal']; ?>.</p -->
			
			<p>Unfortunately, the processing of this transaction could not be completed.  If you believe that you've received this message in error, 
            please contact your credit card issuer and try this transaction <a href="/remote_registration/index.php">again</a>.</p>
            
            <img src="images/spacer.gif" height="200" width="20" border="0" />
            
<?php require_once("includes/footer.php"); ?>