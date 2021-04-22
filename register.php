<?php

define('IGNORE_SESSION',true);
header('Access-Control-Allow-Origin: *');

function generateRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function otpgenerateRandomString($length = 4) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomStringotp = '';
    for ($i = 0; $i < $length; $i++) {
        $randomStringotp .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomStringotp;
}

function useridgenerateRandomString($length = 8) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomStringuserid = '';
    for ($i = 0; $i < $length; $i++) {
        $randomStringuserid .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomStringuserid;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include 'config.php';
    $myArray = array();

    $result = mysqli_query($conn, "SELECT ID FROM user WHERE mobilenumber = '" .  $_POST['mobile'] . "'");
	$num_rows = mysqli_num_rows($result);
	if($num_rows > 0){
			$mobile_errmsg = "Sorry, but this mobile number is already registered to a user.";
	         $myArray[] = array('result' => 'Failed: ' . $mobile_errmsg);
	         echo json_encode($myArray);
	         die();
	}
	
	
    
    $password_reset_key = generateRandomString();
    $otp = otpgenerateRandomString();
    $userid= useridgenerateRandomString();
    $created_date = date('Y-m-d h:i:s');
    $pwd = md5($_POST['password']);
    $statement = $conn->prepare("INSERT INTO user(firstname,lastname,emailid,password,mobilenumber,user_id,password_reset,otp,created) values(?,?,?,?,?,?,?,?,?)");
    if(!$statement){
       // die(mysqli_error($db));
       $myArray[] = array('result' => 'failed: ' . mysqli_error($conn));
       echo json_encode($myArray);
       exit;
    }
    $statement->bind_param("sssssisis", $_POST['firstname'],$_POST['lastname'],$_POST['email'],$pwd,$_POST['mobile'],$userid,$password_reset_key,$otp,$created_date);
    if(!$statement){
      //  die(mysqli_error($db));
       $myArray[] = array('result' => 'failed: ' . mysqli_error($conn));
       echo json_encode($myArray);
       exit;
    }

    if($statement->execute()){        
         
    $myArray[] = array('result' => 'Success: Your registration comlpeted successfully. Click <a href="javascript:void(0)" id="login-b">here</a> to login.');
}else{
       $myArray[] = array('result' => 'failed: ' . mysqli_error($conn));
     //  die(mysqli_error($db));
}
$conn->close();
    
    echo json_encode($myArray);

}
?>