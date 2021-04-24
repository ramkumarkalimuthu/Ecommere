<?php
include "config.php";
session_start();
if($_SESSION["username"]) {
   ?>

<body class="bg-gray">
  
<div class="container-fluid header-sec">
  <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-12 mt-1">
    <div class="row">
      
    

    <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-12">

      <div class="left-panel">

        <a class="nav-brand" href="index.html"><img src="images/logo.png"  class="img-fluid logo-admin"alt="Logo"></a>
        <button type="button" class="btn" data-toggle="collapse" data-target="#demo"><i class="fa fa-bars" style="font-size:20px;color:gray;margin-top: 10px;
          padding-top: 7px;"></i></button>
  
      </div>
  
    </div>
    <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div class="right-panel">

        <nav class="navbar navbar-expand-sm justify-content-end">
                  
          <!-- Links -->
          <ul class="navbar-nav">
                     
        
            <!-- Dropdown -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Welcome <?php echo $_SESSION["username"]; }?>
              </a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="logout.php">Logout</a>
               
              </div>
            </li>
          </ul>
        </nav>
  
  
       </div>
    </div>
  </div>

  </div>
  
</div>
<?php $pg = basename(substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'.'))); // get file name from url and strip extension ?>
<div class="container-fluid">
  <div class="row">
    <div class="aside-menu collapse show col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12" id="demo" >
      <nav class="navbar navbar-light bg-faded">
          
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item <?php if($pg=='dashboard'){?>active<?php }?>">
                  <a class="nav-link " href="dashboard.php">DashBoard <?php if($pg=='dashboard'){?><span class="sr-only">(current)</span><?php }?></a>
              </li>
              <li class="nav-item <?php if($pg=='categorymaster'){?>active<?php }?>">
                  <a class="nav-link" href="categorymaster.php">Category Master<?php if($pg=='categorymaster'){?><span class="sr-only">(current)</span><?php }?> </a>
              </li>
              <li class="nav-item <?php if($pg=='subcategorymaster'){?>active<?php }?>">
                <a class="nav-link" href="subcategorymaster.php">Sub Category Master <?php if($pg=='subcategorymaster'){?><span class="sr-only">(current)</span><?php }?></a>
            </li>
            <li class="nav-item <?php if($pg=='productmaster'){?>active<?php }?>">
              <a class="nav-link" href="productmaster.php">Product Master <?php if($pg=='productmaster'){?><span class="sr-only">(current)</span><?php }?></a>
          </li>
          <li class="nav-item <?php if($pg=='ordermaster'){?>active<?php }?>">
            <a class="nav-link" href="ordermaster.php">Order Master <?php if($pg=='ordermaster'){?>echo '<span class="sr-only">(current)</span>';<?php }?></a>
        </li>
        <li class="nav-item <?php if($pg=='usermaster'){?>active<?php }?>">
          <a class="nav-link" href="usermaster.php">User Master <?php if($pg=='usermaster'){?><span class="sr-only">(current)</span><?php }?></a>
      </li>       

             
          </ul>
         
      </nav>



    </div>