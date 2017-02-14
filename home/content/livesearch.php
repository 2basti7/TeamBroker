<?php
/* 
	Include 'db/select.php' for getting connection to the db.
	call 'getSearchTicker()' - method to get the data from the db
*/
require_once("../db/Select.php");
$select = new Select();

//get the q parameter from URL
$q = $_GET["q"];
$bla = $select->getSearchTicker($q);

//output the response
echo json_encode($bla);
?>