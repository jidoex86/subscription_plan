<?php
$method="POST";
$cache="no-cache";
include "../head.php";

if(isset($_POST['id'],$_POST['plan_name'],$_POST['price'],$_POST['duration_days'])){


$id=cleanme(trim($_POST['id']));
$plan_name=cleanme(trim($_POST['plan_name']));
$price=cleanme(trim($_POST['price']));
$duration_days=cleanme(trim($_POST['duration_days']));
$description=isset($_POST['description']) ? cleanme(trim($_POST['description'])) : "";

if(input_is_invalid($id)){
respondBadRequest("Plan ID required.");
exit;
}

$check=$connect->prepare("SELECT * FROM sub_plan WHERE id=?");
$check->bind_param("i",$id);
$check->execute();
$res=$check->get_result();

if($res->num_rows==0){
respondBadRequest("Plan not found.");
exit;
}

$update=$connect->prepare("
UPDATE sub_plan
SET plan_name=?,price=?,duration_days=?,description=?
WHERE id=?
");

$update->bind_param("sdssi",$plan_name,$price,$duration_days,$description,$id);
$update->execute();

$get=$connect->prepare("SELECT * FROM sub_plan WHERE id=?");
$get->bind_param("i",$id);
$get->execute();
$data=$get->get_result()->fetch_assoc();

respondOK($data,"Plan updated successfully");

}else{
respondBadRequest("Invalid request.");
}
?>