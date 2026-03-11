<?php
$method="POST";
$cache="no-cache";
include "../head.php";

if(isset($_POST['id'])){



$id=cleanme(trim($_POST['id']));

$check=$connect->prepare("SELECT * FROM sub_plan WHERE id=?");
$check->bind_param("i",$id);
$check->execute();

$result=$check->get_result();

if($result->num_rows==0){
respondBadRequest("Plan not found.");
exit;
}

$data=$result->fetch_assoc();

respondOK($data,"Plan fetched successfully");

}else{
respondBadRequest("Plan ID required.");
}
?>