<?php
include "config.php";
include "header.php";
include "menu.php";
   ?>
     <div class='container'>

<!-- Modal -->
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
                    <input type="text" class="form-control" id="firstname" placeholder="Enter Firstname" required>            
                </div>
                <div class="form-group">
                    <label for="email" >Email</label>    
                    <input type="email" class="form-control" id="email"  placeholder="Enter email">                          
                </div>      
               
                <div class="form-group">
                    <label for="Mobile" >Mobile</label>    
                    <input type="text" class="form-control" id="mobile"  placeholder="Enter Mobile">                          
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

<!-- Table -->
<table id='userTable' class='display dataTable' width='100%'>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>User ID</th>
            <th>Action</th>
        </tr>
    </thead>
    
</table>

</div>
       

        <script>
        $(document).ready(function(){

            // DataTable
            var userDataTable = $('#userTable').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'curduser.php'
                },
                'columns': [
                    { data: 'firstname' },
                    { data: 'email' },
                    { data: 'mobile' },
                    { data: 'user_id' },
                    { data: 'action' },
                ]
            });


            // Update record
            $('#userTable').on('click','.updateUser',function(){
                var id = $(this).data('id');

                $('#txt_userid').val(id);

                // AJAX request
                $.ajax({
                    url: 'curduser.php',
                    type: 'post',
                    data: {request: 2, id: id},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){

                            $('#firstname').val(response.data.firstname);
                            $('#email').val(response.data.email);
                            $('#mobile').val(response.data.mobile);
                         
                        }else{
                            alert("Invalid ID.");
                        }
                    }
                });

            });


            // Save user 
            $('#btn_save').click(function(){
                var id = $('#txt_userid').val();

                var firstname = $('#firstname').val().trim();
                var email = $('#email').val().trim();
                var mobile = $('#mobile').val().trim();

                if(firstname !='' && email != '' && mobile != ''){

                    // AJAX request
                    $.ajax({
                        url: 'curduser.php',
                        type: 'post',
                        data: {request: 3, id: id,firstname: firstname, email: email, mobile: mobile},
                        dataType: 'json',
                        success: function(response){
                            if(response.status == 1){
                                alert(response.message);

                                // Empty the fields
                                $('#firstname','#email','#mobile').val('');
                                $('#txt_userid').val(0);
                                // Reload DataTable
                                userDataTable.ajax.reload();
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
            $('#userTable').on('click','.deleteUser',function(){
                var id = $(this).data('id');

                var deleteConfirm = confirm("Are you sure?");
                if (deleteConfirm == true) {
                    // AJAX request
                    $.ajax({
                        url: 'curduser.php',
                        type: 'post',
                        data: {request: 4, id: id},
                        success: function(response){

                            if(response == 1){
                                alert("Record deleted.");

                                // Reload DataTable
                                userDataTable.ajax.reload();
                            }else{
                                alert("Invalid ID.");
                            }
                            
                        }
                    });
                } 
                
            });
        });
        </script>

         <?php
         include "footer.php";
         ?>