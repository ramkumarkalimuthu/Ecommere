<?php
include "config.php";

session_start();

header('Access-Control-Allow-Origin: *');  
$pwd = $_GET['pwd'];
$pwd = urldecode($pwd);
//echo $pwd;
//echo '<br>';
$pwd = $pwd;
$email = urldecode($_GET['email']);
//echo $email;
$myArray = array();
$result = mysqli_query($conn,"SELECT * FROM admin where email = '" . $email . "' and password= '" . $pwd . "'");
//echo "SELECT * FROM users where mobile = '" . $mobile . "' and password= '" . $pwd_md5 . "' and account_status = 1  and record_status = 1";
$count = 0;
if ($result) 
{        
   $count = mysqli_num_rows($result);       
}else{
$myArray[] = array('result' => 'failed' , 'error' => mysqli_error($conn));
   echo json_encode($myArray);
}
if($count > 0){
    $row = mysqli_fetch_assoc($result);
    $_SESSION['login_id'] = $row['id'];
    $_SESSION['username'] = $row['email'];
    $myArray[] = array('result' => 'success');   
    echo json_encode($myArray);
 }else{
 $myArray[] = array('result' => 'failed');
    echo json_encode($myArray);
 }
?>