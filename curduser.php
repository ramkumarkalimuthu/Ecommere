<?php
include 'config.php';

$request = 1;
if(isset($_POST['request'])){
    $request = $_POST['request'];
}

// DataTable data
if($request == 1){
    ## Read value
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc

    $searchValue = mysqli_escape_string($conn,$_POST['search']['value']); // Search value

    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
        $searchQuery = " and (firstname like '%".$searchValue."%' or 
            email like '%".$searchValue."%' or 
            mobile like'%".$searchValue."%' ) ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from user");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from user WHERE 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from user WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($conn, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button
        $updateButton = "<button class='btn btn-sm btn-info updateUser' data-id='".$row['id']."' data-toggle='modal' data-target='#updateModal' >Update</button>";

        // Delete Button
        $deleteButton = "<button class='btn btn-sm btn-danger deleteUser' data-id='".$row['id']."'>Delete</button>";
        
        $action = $updateButton." ".$deleteButton;

        $data[] = array(
            "firstname"=>$row['firstname'],
    		"email"=>$row['email'],
    		"mobile"=>$row['mobile'],
    		"user_id"=>$row['user_id'],
                "action" => $action
            );
    }

    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
    exit;
}

// Fetch user details
if($request == 2){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    $record = mysqli_query($conn,"SELECT * FROM user WHERE id=".$id);

    $response = array();

    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
            "firstname" => $row['firstname'],
            "email" => $row['email'],
            "mobile" => $row['mobile'],
        );

        echo json_encode( array("status" => 1,"data" => $response) );
        exit;
    }else{
        echo json_encode( array("status" => 0) );
        exit;
    }
}

// Update user
if($request == 3){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM user WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){

        $firstname = mysqli_escape_string($conn,trim($_POST['firstname']));
        $email = mysqli_escape_string($conn,trim($_POST['email']));
        $mobile = mysqli_escape_string($conn,trim($_POST['mobile']));

        if( $firstname != '' && $email != '' && $mobile != '' ){

            mysqli_query($conn,"UPDATE user SET firstname='".$firstname."',email='".$email."',mobile='".$mobile."' WHERE id=".$id);

            echo json_encode( array("status" => 1,"message" => "Record updated.") );
            exit;
        }else{
            echo json_encode( array("status" => 0,"message" => "Please fill all fields.") );
            exit;
        }
        
    }else{
        echo json_encode( array("status" => 0,"message" => "Invalid ID.") );
        exit;
    }
}

// Delete User
if($request == 4){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM user WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){

        mysqli_query($conn,"DELETE FROM user WHERE id=".$id);

        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}