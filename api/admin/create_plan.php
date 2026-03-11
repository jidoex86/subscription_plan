<?php
$method="POST";
$cache="no-cache";
include "../head.php";

if(isset($_POST['plan_name'],$_POST['price'],$_POST['duration_days'])){



$plan_name = cleanme(trim($_POST['plan_name']));
$price = cleanme(trim($_POST['price']));
$duration_days = cleanme(trim($_POST['duration_days']));
$description = isset($_POST['description']) ? cleanme(trim($_POST['description'])) : "";

if(input_is_invalid($plan_name) || input_is_invalid($price) || input_is_invalid($duration_days)){
respondBadRequest("All required fields must be filled.");
exit;
}

$checkPlan = $connect->prepare("SELECT id FROM sub_plan WHERE plan_name=?");
$checkPlan->bind_param("s",$plan_name);
$checkPlan->execute();
$result=$checkPlan->get_result();

if($result->num_rows>0){
respondBadRequest("Plan already exists.");
exit;
}

$insert=$connect->prepare("
INSERT INTO sub_plan(plan_name,price,duration_days,description,status,created_at)
VALUES(?,?,?,?,1,NOW())
");

$insert->bind_param("sdss",$plan_name,$price,$duration_days,$description);
$insert->execute();

if($insert->affected_rows>0){

$plan_id=$connect->insert_id;

$get=$connect->prepare("SELECT * FROM sub_plan WHERE id=?");
$get->bind_param("i",$plan_id);
$get->execute();
$data=$get->get_result()->fetch_assoc();

respondOK($data,"Plan created successfully");

}else{
respondBadRequest("Plan creation failed.");
}

}else{
respondBadRequest("Invalid request.");
}
?>