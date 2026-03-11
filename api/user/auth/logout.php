<?php
$method="POST";
$cache="no-cache";
include "../../head.php";


if(isset($_POST['user_id'])){
$datasentin=ValidateAPITokenSentIN();
$user_id=$datasentin->usertoken;
    //$user_id = $_POST['user_id'];

    // validation
    if(input_is_invalid($user_id)){
        respondBadRequest("User ID is required");
    }else if(!is_numeric($user_id)){ 
        respondBadRequest("User ID must be numeric");
    }else{

        // check if user exists
        $checkUser = $connect->prepare("SELECT * FROM user WHERE id=?");
        $checkUser->bind_param("i", $user_id);
        $checkUser->execute();
        $result = $checkUser->get_result();

        if($result->num_rows > 0){

           
            respondOK([], "Logout successful");

        }else{
            respondBadRequest("User not found");
        }
    }

}else{
    respondBadRequest("Invalid request. User ID is required.");
}


?>