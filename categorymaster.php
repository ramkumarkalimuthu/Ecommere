<?php
include "config.php";
include "header.php";
include "menu.php";
   ?>


<div class="data-field col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
  
    <div class="card menu-titles">
    <div class="card-body">Category Master</div>
  </div>
  <div class="card menu-data">
    <div class="card-header"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
      Add Category
    </button></div>
    <div class="card-body">
      
    <table id='categoryTable' class='display dataTable' width='100%'>
    <thead>
        <tr>
            <th>Category Name</th>
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
        <h4 class="modal-title">New Category</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
      <form id="form1" method="post">
                 <div class="form-group">
            <label for="catname">Category Name:</label>
            <input type="text" class="form-control" id="catname" placeholder="Enter Category" name="catname" required>
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
                    <label for="name" >Name</label>
                    <input type="text" class="form-control" id="update_catname" name="update_catname" placeholder="Enter Category" required>            
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
        $(document).ready(function(){

                   


            // DataTable
           var categoryDataTable = $('#categoryTable').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'curdcategory.php'
                },
                'columns': [
                    { data: 'categoryname' },
                    { data: 'status' },
                    { data: 'action' },
                ]
            });
 // Save user 
 $('#add_category').on('click', function() {
                debugger;
                var catname = $('#catname').val();
               
                if(catname !=''){

                    // AJAX request
                    $.ajax({
                        url: 'curdcategory.php',
                        type: 'post',
                        data: {request: 2, catname: catname,},
                        dataType: 'json',
                       success: function(response){       
                                                     
                            
                    if(response.status == 1){
                                alert(response.message);

                                // Empty the fields
                                $('#catname').val('');
                               
                                // Reload DataTable
                                categoryDataTable.ajax.reload();
                                // Close modal
                                $('#myModal').modal('toggle');
                            }else{
                                alert(response.message);
                            }
                        }
                    });

                }else{
                    alert('Please fill all fields.');
                }
            });



            // Update record
            $('#categoryTable').on('click','.updateUser',function(){
                debugger
                var id = $(this).data('id');

                $('#txt_userid').val(id);

                // AJAX request
                $.ajax({
                    url: 'curdcategory.php',
                    type: 'post',
                    data: {request: 3, id: id},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){

                            $('#update_catname').val(response.data.update_catname);
                                                   
                        }else{
                            alert("Invalid ID.");
                        }
                    }
                });

            });


            // Save user 
            $('#btn_save').click(function(){
                debugger
                var id = $('#txt_userid').val();

                var update_catname = $('#update_catname').val().trim();
               
                if(update_catname !=''){

                    // AJAX request
                    $.ajax({
                        url: 'curdcategory.php',
                        type: 'post',
                        data: {request: 4, id: id,update_catname: update_catname},
                        dataType: 'json',
                        success: function(response){
                            if(response.status == 1){
                                alert(response.message);

                                // Empty the fields
                                $('#update_catname').val('');
                                $('#txt_userid').val(0);
                                // Reload DataTable
                                categoryDataTable.ajax.reload();
                                // Close modal
                                $('#updateModal').modal('toggle');
                            }else{
                                alert(response.message);
                            }
                        }
                    });

                }else{
                    alert('Please fill all fields.');
                }
            });


            // Delete record
           $('#categoryTable').on('click','.deleteUser',function(){
                var id = $(this).data('id');

                var deleteConfirm = confirm("Are you sure?");
                if (deleteConfirm == true) {
                    // AJAX request
                    $.ajax({
                        url: 'curdcategory.php',
                        type: 'post',
                        data: {request: 5, id: id},
                        success: function(response){

                            if(response == 1){
                                alert("Record deleted.");

                                // Reload DataTable
                                categoryDataTable.ajax.reload();
                            }else{
                                alert("Invalid ID.");
                            }
                            
                        }
                    });
                } 
                
            });


              // Status record
           $('#categoryTable').on('click','.activedata',function(){
               debugger
                var id = $(this).data('id');
                var currentstatus = $(this).data('value');

                var ActiveConfirm = confirm("Are you sure?");
                if (ActiveConfirm == true) {
                    // AJAX request
                    $.ajax({
                        url: 'curdcategory.php',
                        type: 'post',
                        data: {request: 6, id: id, currentstatus: status},
                        success: function(response){

                            if(response == 1){
                                alert("Deactive record.");

                                // Reload DataTable
                                categoryDataTable.ajax.reload();
                            }else{
                                alert("Invalid ID.");
                            }
                            
                        }
                    });
                } 
                
            });

            $('#categoryTable').on('click','.deactivedata',function(){
               debugger
                var id = $(this).data('id');
                var currentstatus = $(this).data('value');

                var ActiveConfirm = confirm("Are you sure?");
                if (ActiveConfirm == true) {
                    // AJAX request
                    $.ajax({
                        url: 'curdcategory.php',
                        type: 'post',
                        data: {request: 7, id: id, currentstatus: status},
                        success: function(response){

                            if(response == 1){
                                alert("Active record.");

                                // Reload DataTable
                                categoryDataTable.ajax.reload();
                            }else{
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
