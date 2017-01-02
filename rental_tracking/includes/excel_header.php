<?php
	header("Cache-control: private");
	header("Content-Type: application/vnd.ms-excel");
    //header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	#header("Expires: -1441");
	header("Expires: Mon, 26 Jul 2001 05:00:00 GMT");
	header("Pragma: no-cache");
	header("Content-Disposition: attachment; filename=data.xls");
?>

