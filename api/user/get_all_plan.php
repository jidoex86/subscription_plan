<?php
$method="POST";
$cache="no-cache";
include "../head.php";

$datasentin=ValidateAPITokenSentIN();
$user_id=$datasentin->usertoken;

$get=$connect->prepare("SELECT * FROM sub_plan ORDER BY id DESC");
$get->execute();

$result=$get->get_result();

$plans=[];

while($row=$result->fetch_assoc()){
$plans[]=$row;
}

respondOK($plans,"Plans fetched successfully");
?>