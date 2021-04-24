<?php
include "config.php";
include "header.php";
include "menu.php";
$catstatus=1;
$catquery ="SELECT * FROM category WHERE status= $catstatus";
$result = mysqli_query($conn,$catquery);

   ?>


<div class="data-field col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">

    <div class="card menu-titles">
        <div class="card-body"> Sub Category Master</div>
    </div>
    <div class="card menu-data">
        <div class="card-header"><button type="button" class="btn btn-primary" data-toggle="modal"
                data-target="#myModal">
                Add Sub Category
            </button></div>
        <div class="card-body">

            <table id='subcategoryTable' class='display dataTable' width='100%'>
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Sub Category Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

            </table>


        </div>
    </div>




</div>



</div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">New Sub Category</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form id="form1" method="post">
                
                    <div class="form-group">
                        <label for="sel1">Category Name</label>
                      
                        <select class="form-control" id="categoryname" name="categoryname">
                        <option value="">Select Category </option>
                        <?php  while ($row = mysqli_fetch_assoc($result)) { ?>
                            <option value="<?php echo $row['cat_id'];?>"> <?php echo $row['categoryname']; ?></option>
                            <?php }
                            mysqli_free_result($result);

                           ?>
                        </select>
                    </div>
                   
                    <div class="form-group">
                        <label for="subcatname">Sub Category Name:</label>
                        <input type="text" class="form-control" id="subcatname" placeholder="Enter Sub Category Name"
                            name="subcatname" required>
                    </div>

                    <button type="submit" id="add_category" class="btn btn-primary">Save</button>
                </form>
            </div>



        </div>
    </div>
</div>

<!-- Update Modal -->
<div id="updateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

            <div class="form-group">
                        <label for="sel1">Category Name</label>
                      
                        <select class="form-control" id="update_categoryname" name="update_categoryname">
                        <option value="">Select Category </option>
                        <?php
                        $updatequery=mysqli_query($conn,"select * FROM category");
                        while($row=mysqli_fetch_assoc($updatequery)){ 
                        ?>
                         <option value="<?php echo $row['cat_id'];?>"> <?php echo $row['categoryname']; ?></option>
                            <?php } ?>
                        </select>
                    </div>


                <div class="form-group">
                    <label for="name">Sub Category Name</label>
                    <input type="text" class="form-control" id="update_subcatname" name="update_subcatname"
                        placeholder="Enter Sub Category Name" required>
                </div>

            </div>
            <div class="modal-footer">
                <input type="hidden" id="txt_userid" value="0">
                <button type="button" class="btn btn-success btn-sm" id="btn_save">Save</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<script>
$(document).ready(function() {

    // DataTable
    var categoryDataTable = $('#subcategoryTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'curdsubcategory.php'
        },
        'columns': [{
                data: 'categoryname'
            },
            {
                data: 'subcategory_name'
            },
            {
                data: 'status'
            },
            {
                data: 'action'
            },
        ]
    });
    // Save user 
    $('#add_category').on('click', function() {
        debugger;
        var categoryname = $('#categoryname').val();
        var subcatname = $('#subcatname').val();

        if (categoryname != '' && subcatname != '') {

            // AJAX request
            $.ajax({
                url: 'curdsubcategory.php',
                type: 'post',
                data: {
                    request: 2,
                    categoryname: categoryname,
                    subcatname:subcatname,

                },
                dataType: 'json',
                success: function(response) {


                    if (response.status == 1) {
                        alert(response.message);

                        // Empty the fields
                        $('#categoryname').val('');
                        $('#subcatname').val('');

                        // Reload DataTable
                        categoryDataTable.ajax.reload();
                        // Close modal
                        $('#myModal').modal('toggle');
                    } else {
                        alert(response.message);
                    }
                }
            });

        } else {
            alert('Please fill all fields.');
        }
    });



    // Update record
    $('#subcategoryTable').on('click', '.updateUser', function() {
        debugger
        var id = $(this).data('id');

        $('#txt_userid').val(id);

        // AJAX request
        $.ajax({
            url: 'curdsubcategory.php',
            type: 'post',
            data: {
                request: 3,
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {

                    $('#update_categoryname').val(response.data.update_categoryname);
                    $('#update_subcatname').val(response.data.update_subcatname);

                } else {
                    alert("Invalid ID.");
                }
            }
        });

    });


    // Save user 
    $('#btn_save').click(function() {
        debugger
        var id = $('#txt_userid').val();

        var update_categoryname = $('#update_categoryname').val().trim();
        var update_subcatname = $('#update_subcatname').val().trim();

        if (update_categoryname != ''&& update_subcatname != '') {

            // AJAX request
            $.ajax({
                url: 'curdsubcategory.php',
                type: 'post',
                data: {
                    request: 4,
                    id: id,
                    update_categoryname: update_categoryname,
                    update_subcatname: update_subcatname

                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 1) {
                        alert(response.message);

                        // Empty the fields
                        $('#update_categoryname').val('');
                        $('#update_subcatname').val('');
                        $('#txt_userid').val(0);
                        // Reload DataTable
                        categoryDataTable.ajax.reload();
                        // Close modal
                        $('#updateModal').modal('toggle');
                    } else {
                        alert(response.message);
                    }
                }
            });

        } else {
            alert('Please fill all fields.');
        }
    });


    // Delete record
    $('#subcategoryTable').on('click', '.deleteUser', function() {
        var id = $(this).data('id');

        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // AJAX request
            $.ajax({
                url: 'curdsubcategory.php',
                type: 'post',
                data: {
                    request: 5,
                    id: id
                },
                success: function(response) {

                    if (response == 1) {
                        alert("Record deleted.");

                        // Reload DataTable
                        categoryDataTable.ajax.reload();
                    } else {
                        alert("Invalid ID.");
                    }

                }
            });
        }

    });


    // Status record
    $('#subcategoryTable').on('click', '.activedata', function() {
        debugger
        var id = $(this).data('id');
        var currentstatus = $(this).data('value');

        var DeactiveConfirm = confirm("Are you sure?");
        if (DeactiveConfirm == true) {
            // AJAX request
            $.ajax({
                url: 'curdsubcategory.php',
                type: 'post',
                data: {
                    request: 6,
                    id: id
                },
                success: function(response) {

                    if (response == 1) {
                        alert("Deactive record.");

                        // Reload DataTable
                        categoryDataTable.ajax.reload();
                    } else {
                        alert("Invalid ID.");
                    }

                }
            });
        }

    });

    $('#subcategoryTable').on('click', '.deactivedata', function() {
        debugger
        var id = $(this).data('id');
        var currentstatus = $(this).data('value');

        var ActiveConfirm = confirm("Are you sure?");
        if (ActiveConfirm == true) {
            // AJAX request
            $.ajax({
                url: 'curdsubcategory.php',
                type: 'post',
                data: {
                    request: 7,
                    id: id
                },
                success: function(response) {

                    if (response == 1) {
                        alert("Active record.");

                        // Reload DataTable
                        categoryDataTable.ajax.reload();
                    } else {
                        alert("Invalid ID.");
                    }

                }
            });
        }

    });




});
</script>



</body>

</html>