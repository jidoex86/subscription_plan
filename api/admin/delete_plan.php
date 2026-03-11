<?php
$method="POST";
$cache="no-cache";
include "../head.php";

if(isset($_POST['sub_plan_id'])){



$id=cleanme(trim($_POST['sub_plan_id']));

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

$plan=$res->fetch_assoc();

$delete=$connect->prepare("DELETE FROM sub_plan WHERE id=?");
$delete->bind_param("i",$id);
$delete->execute();

respondOK($plan,"Plan deleted successfully");

}else{
respondBadRequest("Invalid request.");
}
?>