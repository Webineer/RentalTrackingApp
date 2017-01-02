<?php

//This function takes a global DSN and table name and returns a single value from
//a database query
function get_one_data($table_name, $data_field, $id_field, $id_value, $id_data_type) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$sql_string = "select " . $data_field . " from " . $table_name;
	
	if ($id_data_type == "char") {
		$sql_string .= " where " . $id_field . "='" . $id_value . "'";
	} else {
		$sql_string .= " where " . $id_field . "=" . $id_value;
	}
	
	//$res = $db->query($sql);
	//print $sql_string . "<br>";
	
	//$res = $db->getOne($sql_string);
    $res = $mdb2->extended->getOne($sql_string);
	// Always check that $result is not an error
	//if (DB::isError($res)) {
	if (PEAR::isError($res)) {   
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	//$db->disconnect();
    $mdb2->disconnect();
}

//This function takes a global DSN and table name and returns a single value from
//a database query
function get_one_data_generic_sql($sql_string) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
     if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	//print $sql_string . "<br>";
	
	//$res = $db->getOne($sql_string);
    $res = $mdb2->extended->getOne($sql_string);
	// Always check that $result is not an error
	///if (DB::isError($res)) {
	//	die ("Cannot create result set: " . $res->getMessage() . "\n");
	//}
	if (PEAR::isError($res)) {   
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	//$db->disconnect();
    $mdb2->disconnect();
}

//This function takes a global DSN and table name and returns an array of values from
//a database query which returns a single row
function get_one_row_data_array($table_name, $data_fields, $id_field, $id_value, $id_data_type) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$i=0;
	foreach($data_fields as $item) {
		if ($i == 0) {
			$fields_string = $item;
			$i++;
		} else {
			$fields_string .= ", " . $item;
			$i++;
		}
	}
	
	$sql_string = "select " . $fields_string . " from " . $table_name;
	
	if ($id_data_type == "char") {
		$sql_string .= " where " . $id_field . "='" . $id_value . "'";
	} else {
		$sql_string .= " where " . $id_field . "=" . $id_value;
	}
	
	//$result = $db->query($sql);
	//print $sql_string . "<br>";
	
	//$res = $db->getRow($sql_string);
    $res = $mdb2->extended->getRow($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}	
	
	//return row array
	return $res;

	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}


//This function takes a global DSN and table name and returns an array of values from
//a database query which returns a single row
function get_one_row_data_array_generic_sql($sql_string) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }

	//$result = $db->query($sql);
	//print $sql_string . "<br>";
	
	//$res = $db->getRow($sql_string);
    $res = $mdb2->extended->getRow($sql_string);
    //$res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}	
	
	//return row array
	return $res;

	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}

//This function takes a global DSN and table name and returns an array of values from
//a database query which returns a single row
function get_one_row_data_array_join($table_names, $data_fields, $id_field, $id_value, $id_data_type, $join_field_1, $join_field_2) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$i=0;
	foreach($data_fields as $item) {
		if ($i == 0) {
			$fields_string = $item;
			$i++;
		} else {
			$fields_string .= ", " . $item;
			$i++;
		}
	}
	
	$sql_string = "select " . $fields_string . " from " . $table_names;
	
	if ($id_data_type == "char") {
		$sql_string .= " where " . $id_field . "='" . $id_value . "'";
	} else {
		$sql_string .= " where " . $id_field . "=" . $id_value;
	}
	
	$sql_string .= " and " . $join_field_1 . "=" . $join_field_2;
	
	//$result = $db->query($sql);
	//print $sql_string . "<br>";
	
	//$res = $db->getRow($sql_string);
    $res = $mdb2->extended->getRow($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}	
	
	//return row array
	return $res;

	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}


//Same as above - returns 2-dimensional array of values in the returned row
function get_row_data($table_name, $data_fields) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$i=0;
	foreach($data_fields as $item) {
		if ($i == 0) {
			$fields_string = $item;
			$i++;
		} else {
			$fields_string .= ", " . $item;
			$i++;
		}
	}
	
	$sql_string = "select " . $fields_string . " from " . $table_name;
	//print $sql_string . "<br>";
	
	//$res = $db->getRow($sql_string);
    $res = $mdb2->extended->getRow($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}	
	return $res;
	
	//free the result set
	//$res->free();	
	
	// close conection
	$mdb2->disconnect();
}


//Same as above - returns a 2-dimensional result array of values in the returned row
function get_row_data_array($table_name, $data_fields) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$i=0;
	foreach($data_fields as $item) {
		if ($i == 0) {
			$fields_string = $item;
			$i++;
		} else {
			$fields_string .= ", " . $item;
			$i++;
		}
	}
	
	$sql_string = "select " . $fields_string . " from " . $table_name;
	
	//$result = $db->query($sql);
	//print $sql_string . "<br>";
	
	//$res = $db->getRow($sql_string);
    $res = $mdb2->extended->getRow($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}	

	//return row array
	return $res;
	
	//free the result set
	//$res->free();	
	
	// close conection
	$mdb2->disconnect();
}


//Same as above - returns a 2-dimensional result array of values in the returned row
function get_row_data_array_generic_sql($sql_string) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	//print $sql_string . "<br>";
	
	//$res = $db->getRow($sql_string);
    $res = $mdb2->extended->getRow($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}	

	//return row array
	return $res;
	
	//free the result set
	//$res->free();	
	
	// close conection
	$mdb2->disconnect();
}

//Same as above - returns an array of values in the returned row
function view_data($table_name, $data_fields) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$i=0;
	foreach ($data_fields as $item) {
		if ($i == 0) {
			$fields_string = $item;
			$i++;
		} else {
			$fields_string .= ", " . $item;
			$i++;
		}
	}
	
	$sql_string = "select " . $fields_string . " from " . $table_name . " order by " . $data_fields[1];
	//$sql_string = "select * from " . $table_name;
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";
	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}

//Same as above - returns an array of values in the returned row
function view_data_generic_sql($sql_string) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	//$sql_string = "select " . $fields_string . " from " . $table_name;
	//$sql_string = "select * from " . $table_name;
	//
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";
	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}

//Same as above - returns an array of values in the returned row
function view_data_distinct($table_name, $data_fields) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$i=0;
	foreach ($data_fields as $item) {
		if ($i == 0) {
			$fields_string = $item;
			$i++;
		} else {
			$fields_string .= ", " . $item;
			$i++;
		}
	}
	
	$sql_string = "select distinct " . $fields_string . " from " . $table_name . " order by " . $data_fields[1];
	//$sql_string = "select * from " . $table_name;
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";
	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}

//Same as above - returns an array of values in the returned row
function view_data_where($table_name, $data_fields, $id_field, $id_value, $id_data_type) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$i=0;
	foreach ($data_fields as $item) {
		if ($i == 0) {
			$fields_string = $item;
			$i++;
		} else {
			$fields_string .= ", " . $item;
			$i++;
		}
	}
	
	$sql_string = "select " . $fields_string . " from " . $table_name;
	//$sql_string = "select * from " . $table_name;
	
	if ($id_data_type == "char") {
		$sql_string .= " where " . $id_field . "='" . $id_value . "'";
	} else {
		$sql_string .= " where " . $id_field . "=" . $id_value;
	}
	$sql_string .= " order by " . $data_fields[1];
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";
	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}

//Same as above - returns an array of values in the returned row
function view_data_where_distinct($table_name, $data_fields, $id_field, $id_value, $id_data_type) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$i=0;
	foreach ($data_fields as $item) {
		if ($i == 0) {
			$fields_string = $item;
			$i++;
		} else {
			$fields_string .= ", " . $item;
			$i++;
		}
	}
	
	$sql_string = "select distinct " . $fields_string . " from " . $table_name . " order by " . $data_fields[1];
	//$sql_string = "select * from " . $table_name;
	
	if ($id_data_type == "char") {
		$sql_string .= " where " . $id_field . "='" . $id_value . "'";
	} else {
		$sql_string .= " where " . $id_field . "=" . $id_value;
	}
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";
	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}



//Same as above - returns an array of values in the returned row
function view_data_join($table_names, $data_fields, $join_field_1, $join_field_2) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$i=0;
	foreach ($data_fields as $item) {
		if ($i == 0) {
			$fields_string = $item;
			$i++;
		} else {
			$fields_string .= ", " . $item;
			$i++;
		}
	}
	
	$sql_string = "select " . $fields_string . " from " . $table_names . " where " . $join_field_1 . "=" . $join_field_2 . " order by " . $data_fields[1];
	//$sql_string = "select * from " . $table_name;
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";
	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}


//Same as above - returns an array of values in the returned row
function view_data_join_where($table_names, $data_fields, $join_field_1, $join_field_2, $id_field, $id_value, $id_data_type) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$i=0;
	foreach ($data_fields as $item) {
		if ($i == 0) {
			$fields_string = $item;
			$i++;
		} else {
			$fields_string .= ", " . $item;
			$i++;
		}
	}
	
	$sql_string = "select " . $fields_string . " from " . $table_names . " where " . $join_field_1 . "=" . $join_field_2;
	
	if ($id_data_type == "char") {
		$sql_string .= " and " . $id_field . "='" . $id_value . "'";
	} else {
		$sql_string .= " and " . $id_field . "=" . $id_value;
	}
	$sql_string .= " order by " . $data_fields[1];
	//$sql_string = "select * from " . $table_name;
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";
	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}



//Same as above - returns an array of values in the returned row
function view_data_join_double_where($table_names, $data_fields, $join_field_1, $join_field_2, $join_field_3, $join_field_4, $id_field, $id_value, $id_data_type) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$i=0;
	foreach ($data_fields as $item) {
		if ($i == 0) {
			$fields_string = $item;
			$i++;
		} else {
			$fields_string .= ", " . $item;
			$i++;
		}
	}
	
	$sql_string = "select " . $fields_string . " from " . $table_names . " where " . $join_field_1 . "=" . $join_field_2 . " AND " . $join_field_3 . "=" . $join_field_4;
	
	if ($id_data_type == "char") {
		$sql_string .= " and " . $id_field . "='" . $id_value . "'";
	} else {
		$sql_string .= " and " . $id_field . "=" . $id_value;
	}
	
	$sql_string .= " order by " . $data_fields[1];
	//$sql_string = "select * from " . $table_name;
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";
	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}


//Same as above - returns an array of values in the returned row
function view_data_where_double_distinct($table_names, $data_fields, $id_field_1, $id_value_1, $id_data_type_1, $id_field_2, $id_value_2, $id_data_type_2) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$i=0;
	foreach ($data_fields as $item) {
		if ($i == 0) {
			$fields_string = $item;
			$i++;
		} else {
			$fields_string .= ", " . $item;
			$i++;
		}
	}
	
	$sql_string = "select distinct " . $fields_string . " from " . $table_names;
	
	if ($id_data_type_1 == "char") {
		$sql_string .= " where " . $id_field_1 . "='" . $id_value_1 . "'";
	} else {
		$sql_string .= " where " . $id_field_1 . "=" . $id_value_1;
	}
	
	if ($id_data_type_2 == "char") {
		$sql_string .= " and " . $id_field_2 . "='" . $id_value_2 . "'";
	} else {
		$sql_string .= " and " . $id_field_2 . "=" . $id_value_2;
	}
	
	$sql_string .= " order by " . $data_fields[1];
	//$sql_string = "select * from " . $table_name;
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";
	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}




function get_security_data($id_value) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "<br>");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$sql_string = "select security.level_value from users,security where users.security_id=security.id and username = '" . $id_value . "'";
	//print $sql_string . "<br>";
	
	//$res = $db->getOne($sql_string);
    $res = $mdb2->extended->getOne($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "<br>");
	}	
	return $res;	
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}

function get_products_ids() {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "<br>");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	//$sql_string = "select id from products";
    $sql_string = "select distinct product_id, level_id, from sections where section_date='" . date('Y-m-d') . "'";
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";	
	return $res;	
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}

function get_products_ids_time($the_time) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "<br>");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	//$sql_string = "select id from products";
    $sql_string = "select distinct product_id, level_id from sections where section_date='" . date('Y-m-d') . "' and section_time_id=" . $the_time;
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";	
	return $res;	
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}

function get_level_ids() {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "<br>");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$sql_string = "select id from levels order by level_name asc";
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";	
	return $res;	
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}



function get_levels_ids($my_time, $my_prod_id) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "<br>");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$sql_string = "select distinct level_id from sections where section_time_id=" . $my_time . " and product_id=" . $my_prod_id;
	//print $sql_string . "<br>";
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}
	//print "the value of res is " . $res . "<br>";	
	return $res;	
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}


//Same as above - returns an array of values in the returned row
function delete_row_data($table_name, $id_field_name, $id_field_value, $id_field_type) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	if ($id_field_type == "char") {
		$sql_string = "delete from " . $table_name . " where " . $id_field_name . " = '" . $id_field_value . "'";
	} else {
		$sql_string = "delete from " . $table_name . " where " . $id_field_name . " = " . $id_field_value;
	}
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	//print $sql_string . "<br>";
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot delete record: " . $res->getMessage() . "\n");
	}
	
	// close conection
	$mdb2->disconnect();
}


//This function takes a result object and does multiple inserts of that result data
//into a table
function delete_multiple_data_rows($result_object, $table_name, $id_field_name, $id_field_type) {
	while ($row = $result_object->fetchRow()) {    
		foreach($row as $item) {
			delete_row_data($table_name, $id_field_name, $item, $id_field_type);
		}
	}
}

//This function takes a result object and does multiple inserts of that result data
//into a table
function delete_multiple_data_array($result_array, $table_name, $id_field_name, $id_field_type) {
	foreach($result_array as $item) {
		delete_row_data($table_name, $id_field_name, $item, $id_field_type);
	}
}

//Same as above - returns an array of values in the returned row
function delete_data_generic_sql($sql_string) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	//print $sql_string . "<br>";
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot delete record: " . $res->getMessage() . "\n");
	}
	
	// close conection
	$mdb2->disconnect();
}




//This is a function that takes need an associative array (key => value) where keys are fields names and 
//values are corresponding values of these fields and inserts them into a database table.
function insert_data($table_name, $table_fields, $table_values) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "<br>");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	for ($i = 0; $i < count($table_valus); $i++) {
        $types[$i] = gettype($table_values[$i]);
    }
    
    for($l=0; $l<count($table_values); $l++) {
        if ($l == count($table_values)-1) {
            $field_string .= $table_fields[$l];
            
            //if ($types[$l] == "integer") {
            if(is_numeric($table_values[$l])) {
               $value_string .= $table_values[$l];
            } else {
               $value_string .= "'" . $table_values[$l] . "'"; 
            }
           
        } else {
            $field_string .= $table_fields[$l] . ", ";
            
            //if ($types[$l] == "integer") {
            if(is_numeric($table_values[$l])) {
              $value_string .= $table_values[$l] . ", ";  
            } else {
               $value_string .= "'" . $table_values[$l] . "', "; 
            }
        }
    }
 
    $sql_string = "insert into " . $table_name . " (" . $field_string . ") values (" . $value_string . ")" ;
    //print $sql_string . "<br>";
    
    $res = $mdb2->query($sql_string);
    
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot execute insert: " . $res->getMessage() . "\n");
	}
	
	// close conection
	$mdb2->disconnect();
}

//This function takes a result object and does multiple inserts of that result data
//into a table
function insert_multiple_data_rows($result_object, $table_name, $table_fields) {
	while ($row = $result_object->fetchRow()) {    
		//foreach($row as $item) {
			
		//}
		insert_data($table_name, $table_fields, $row);
	}
}


function insert_form_data($table_name, $table_fields) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
    
    //create temp array of values from POST buffer
	reset ($_POST);
	$k=0;
	while (list ($key, $val) = each($_POST)) {
	    //echo "$key => $val<br />\n";
		//$temp_array[$k] = addslashes($val);
		$temp_array[$k] = $val;
		//print $temp_array[$k] . "<br>";
        $types[$k] = gettype($val);
		$k++;
	}
    
    for($l=0; $l<count($temp_array); $l++) {
        if ($l == count($temp_array)-1) {
            $field_string .= $table_fields[$l];
            
            //if ($types[$l] == "integer") {
            if(is_numeric($temp_array[$l])) {
               $value_string .= $temp_array[$l];
            } else {
               $value_string .= "'" . $temp_array[$l] . "'"; 
            }
           
        } else {
            $field_string .= $table_fields[$l] . ", ";
            
            //if ($types[$l] == "integer") {
            if(is_numeric($temp_array[$l])) {
              $value_string .= $temp_array[$l] . ", ";  
            } else {
               $value_string .= "'" . $temp_array[$l] . "', "; 
            }
        }
    }
    
    $sql_string = "insert into " . $table_name . " (" . $field_string . ") values (" . $value_string . ")" ;
    //print $sql_string . "<br>";
    
    $res = $mdb2->query($sql_string);
    
	if (PEAR::isError($res)) {
		die ("Cannot execute insert: " . $res->getMessage() . "<br>");
	}
	
	// close conection
	$mdb2->disconnect();
}

function insert_data_generic_sql($sql_string) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	//print $sql_string . "<br>";
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot insert record: " . $res->getMessage() . "\n");
	}
	
	// close conection
	$mdb2->disconnect();
 }

function update_data($table_name, $table_fields, $table_values, $id_field_name, $id_field_value) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "<br>");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	for ($k = 0; $k < count($table_values); $k++) {
        $types[$k] = gettype($val);
	}
    
    //generate sql
    $set_string = "";
    
    //this loop assumes that the last entity in the POST array is the id field value
    for($l=0; $l<count($table_values); $l++) {
        if ($l == count($table_values)-1) {
                        
            //if ($types[$l] == "integer") {
            if(is_numeric($table_values[$l])) {
               $set_string .= $table_fields[$l] . " = " . $table_values[$l];
            } else {
               $set_string .= $table_fields[$l] . " = '" . $table_values[$l] . "'"; 
            }
           
        } else {
            
            //if ($types[$l] == "integer") {
            if(is_numeric($table_values[$l])) {
              $set_string .= $table_fields[$l] . " = " . $table_values[$l] . ", ";  
            } else {
               $set_string .= $table_fields[$l] . " = '" . $table_values[$l] . "', "; 
            }
        }
    }
    
    //if (gettype($id_field_value) == "integer") {
    if(is_numeric($id_field_value)) {
        $sql_string = "update " . $table_name . " set " . $set_string . " where " . $id_field_name . " = " . $id_field_value;
    } else {
        $sql_string = "update " . $table_name . " set " . $set_string . " where " . $id_field_name . " = '" . $id_field_value . "'";
    }
    //print $sql_string . "<br>";
    
    $res = $mdb2->query($sql_string);
    
	if (PEAR::isError($res)) {
		//die ("Cannot execute update: " . $res->getMessage() . "<br>");
	}	
	
	
	// close conection
	$mdb2->disconnect();
}


function update_form_data($table_name, $table_fields, $id_field_name, $id_field_value) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "<br>");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	reset ($_POST);
	$k=0;
	while (list ($key, $val) = each($_POST)) {
	    //echo "$key => $val<br />\n";
		//$temp_array[$k] = addslashes($val);
		$temp_array[$k] = $val;
		//print $temp_array[$k] . "<br>";
        $types[$k] = gettype($val);
		$k++;
	}
    
    //generate sql
    $set_string = "";
    
    //this loop assumes that the last entity in the POST array is the id field value
    for($l=0; $l<count($temp_array)-1; $l++) {
        if ($l == count($temp_array)-2) {
                        
            //if ($types[$l] == "integer") {
            if(is_numeric($temp_array[$l])) {
               $set_string .= $table_fields[$l] . " = " . $temp_array[$l];
            } else {
               $set_string .= $table_fields[$l] . " = '" . $temp_array[$l] . "'"; 
            }
           
        } else {
            
            //if ($types[$l] == "integer") {
            if(is_numeric($temp_array[$l])) {
              $set_string .= $table_fields[$l] . " = " . $temp_array[$l] . ", ";  
            } else {
               $set_string .= $table_fields[$l] . " = '" . $temp_array[$l] . "', "; 
            }
        }
    }
    
    //if (gettype($id_field_value) == "integer") {
    if(is_numeric($id_field_value)) {
        $sql_string = "update " . $table_name . " set " . $set_string . " where " . $id_field_name . " = " . $id_field_value;
    } else {
        $sql_string = "update " . $table_name . " set " . $set_string . " where " . $id_field_name . " = '" . $id_field_value . "'";
    }
    print $sql_string . "<br>";
    
    $res = $mdb2->query($sql_string);
    
	if (PEAR::isError($res)) {
		die ("Cannot execute update: " . $res->getMessage() . "<br>");
	}	
		
	// close conection
	$mdb2->disconnect();
}

function update_data_generic_sql($sql_string) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	//$res = $db->query($sql_string);
    $res = $mdb2->query($sql_string);
	//print $sql_string . "<br>";
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot update record: " . $res->getMessage() . "\n");
	}
	
	// close conection
	$mdb2->disconnect();
 }

//This function takes a global DSN and table name and returns an array of values from
//a single field in a database query
function get_data_2_array($table_name, $data_field, $id_field, $id_value, $id_data_type) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }
	
	$sql_string = "select " . $data_field . " from " . $table_name;
	
	if ($id_data_type == "char") {
		$sql_string .= " where " . $id_field . "='" . $id_value . "'";
	} else {
		$sql_string .= " where " . $id_field . "=" . $id_value;
	}
	
	//$result = $db->query($sql);
	//print $sql_string . "<br>";
	
	//$res = $db->getOne($sql_string);
	//$res = $db->getCol($sql_string);
    $res = $mdb2->extended->getCol($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}

//This function takes a global DSN and table name and returns an array of values from
//a single field in a database query
function get_data_2_array_generic_sql($sql_string) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }

	//print $sql_string . "<br>";
	
	//$res = $db->getCol($sql_string);
    $res = $mdb2->extended->getCol($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}


//This function takes a global DSN and table name and returns an array of values from
//a single row in a database query
function get_row_data_2_array_generic_sql($sql_string) {
	global $dsn;
	// DB::connect will return a PEAR DB object on success
	// or an PEAR DB Error object on error
	//$db = DB::connect($dsn);
    $mdb2 = MDB2::connect($dsn);
    $mdb2->loadModule('Extended');
	
	// With DB::isError you can differentiate between an error or
	// a valid connection.
	//if (DB::isError($db)) {	
	//	die ("Cannot connect: " . $db->getMessage() . "\n");
	//}
    if (PEAR::isError($mdb2)) {
        die("Cannot connect: " . $mdb2->getMessage());
    }

	//print $sql_string . "<br>";
	
	//$res = $db->getRow($sql_string);
    $res = $mdb2->extended->getRow($sql_string);
	// Always check that $result is not an error
	if (PEAR::isError($res)) {
		die ("Cannot create result set: " . $res->getMessage() . "\n");
	}	
	return $res;
	
	//free the result set
	//$res->free();
	
	// close conection
	$mdb2->disconnect();
}

?>