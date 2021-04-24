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
      



    </div>
  </div>




</div>



  </div>
</div>

<!-- The Modal -->
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
        <form action="/action_page.php">
          <div class="form-group">
            <label for="uname">Category Name:</label>
            <input type="text" class="form-control" id="catname" placeholder="Enter Category" name="catname" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
          </div>
          
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      
      
      
    </div>
  </div>
</div>

  
</body>
</html>
