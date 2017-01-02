<?php
	define("ORGANIZATION", "Ski Bradford");
	define("APP_ROOT", "/rental_tracking/");
	define("CATEGORY1", "Department");
	define("CATEGORY1_PLURAL", "Departments");
	define("CATEGORY2", "Rental");
	define("CATEGORY2_PLURAL", "Rental Equipment");
	define("CATEGORY3", "Class");
	define("CATEGORY3_PLURAL", "Classes");
	define("LECTURER", "Instructor");
	define("LECTURER_PLURAL", "Instructors");
	define("ABILITY", "Ability Level");
	define("ABILITY_PLURAL", "Ability Levels");
	define("LOCATION", "Location");
	define("LOCATION_PLURAL", "Locations");
	define("ROOM", "Classroom");
	define("ROOM_PLURAL", "Classrooms");
	define("ATTENDEE", "Customer");
	define("ATTENDEE_PLURAL", "Customers");
	
	global $user, $pass, $host, $db_name, $pear_db_path, $dsn;
	//Setup Overall Application Constants
		
	//DB Constants
	$user = 'rental_user';
	$pass = 'rental1234';
	$host = 'localhost';
	$db_name = 'rental_app';
	//$pear_db_path = "/usr/share/pear/DB.php";
	//$pear_db_path = "/usr/local/lib/php/DB.php";
    $pear_db_path = "/var/www/html/PEAR/MDB2.php";
	
	// Data Source Name: This is the universal connection string
	$dsn = "mysql://$user:$pass@$host/$db_name";
?>
