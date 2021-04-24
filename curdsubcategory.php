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
        $searchQuery = " and (categoryname like '%".$searchValue."%' or
        subcategory_name like '%".$searchValue."%') ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from subcategory");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from subcategory WHERE 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select s.subcat_id,s.category_id,s.subcategory_name,s.status,c.cat_id,c.categoryname from subcategory AS s INNER JOIN category AS c ON s.category_id = c.cat_id  WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($conn, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {           

        // Update Button
        $updateButton = "<button class='btn btn-sm btn-info updateUser' data-id='".$row['subcat_id']."' data-toggle='modal' data-target='#updateModal' >Update</button>";

        // Delete Button
        $deleteButton = "<button class='btn btn-sm btn-danger deleteUser' data-id='".$row['subcat_id']."'>Delete</button>";

        $status = $row['status'];
        
        if($status==1)
        {
           
            $status=  "<button class='btn btn-sm btn-primary activedata' data-id='".$row['subcat_id']."' data-value='".$row['status']."'>Active</button>";

        }

        else{
           
            $status=  "<button class='btn btn-sm btn-warning deactivedata' data-id='".$row['subcat_id']."' data-value='".$row['status']."'>Deactive</button>";


        }
        
        $action = $updateButton." ".$deleteButton;

        $data[] = array(
            "categoryname" => $row['categoryname'],
            "subcategory_name" => $row['subcategory_name'],
    		"status" => $status,
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

// Insert
if($request == 2){
    $catname = mysqli_escape_string($conn,$_POST['categoryname']);
    $subcatname = mysqli_escape_string($conn,$_POST['subcatname']);
   
    if( $catname != ''){

        mysqli_query($conn,"INSERT INTO subcategory (category_id,subcategory_name) values('$catname','$subcatname')" );

        echo json_encode( array("status" => 1,"message" => "Record updated.") );
        exit;
    }else{
        echo json_encode( array("status" => 0,"message" => "Please fill all fields.") );
        exit;
    }
    

}


// Fetch user details
if($request == 3){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    $record = mysqli_query($conn,"SELECT * FROM subcategory INNER JOIN category WHERE subcat_id=".$id);

    $response = array();

    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
            "update_categoryname" => $row['category_id'],
            "update_subcatname" => $row['subcategory_name'],
        );

        echo json_encode( array("status" => 1,"data" => $response) );
        exit;
    }else{
        echo json_encode( array("status" => 0) );
        exit;
    }
}

// Update user
if($request == 4){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT subcat_id FROM subcategory WHERE subcat_id=".$id);
    if(mysqli_num_rows($record) > 0){

        $update_categoryname = mysqli_escape_string($conn,trim($_POST['update_categoryname']));
        $update_subcatname = mysqli_escape_string($conn,trim($_POST['update_subcatname']));

        if( $update_categoryname != ''&& $update_subcatname != '' ){

            mysqli_query($conn,"UPDATE subcategory SET category_id='".$update_categoryname."',subcategory_name='".$update_subcatname."'WHERE subcat_id=".$id);

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
if($request == 5){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM subcategory WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){

        mysqli_query($conn,"DELETE FROM subcategory WHERE id=".$id);

        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}



if($request == 6){
    $id = 0;
$update_status = 0;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT subcat_id FROM subcategory WHERE subcat_id=".$id);
    if(mysqli_num_rows($record) > 0){

        mysqli_query($conn,"UPDATE subcategory SET status ='".$update_status."'WHERE subcat_id=".$id);

        echo 1;
        exit;
    }else{
        
        echo 0;
        exit;
    }
}

if($request == 7){
    $id = 0;
$update_status = 1;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT subcat_id FROM subcategory WHERE subcat_id=".$id);
    if(mysqli_num_rows($record) > 0){

        mysqli_query($conn,"UPDATE subcategory SET status ='".$update_status."'WHERE subcat_id=".$id);

        echo 1;
        exit;
    }else{
        
        echo 0;
        exit;
    }
}