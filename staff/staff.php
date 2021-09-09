<?php
header("Access-Control-Allow-Origin: *");

$staffs = array(
	array("id" => 1, "name" => "Lukman", "lname" => "chehdo"),
	array("id" => 2, "name" => "hayatee", "lname" => "hamasa")
);

echo json_encode($staffs);
?>