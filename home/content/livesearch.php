<?php
require_once("../db/Select.php");
$select = new Select();

//get the q parameter from URL
$q = $_GET["q"];
$bla = $select->getSearchTicker($q);

//lookup all links from the xml file if length of q>0
if (strlen($q) > 0) {
    $hint = "";
    if ($hint == "") {
        $hint = "Test";
    } else {
        $hint = hint . "<br>blub";
    }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint == "") {
    $response = "no suggestion";
} else {
    $response = $hint;
}

//output the response
echo json_encode($bla);
//echo $response;

?>