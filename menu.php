<?php
include "config.php";
session_start();
if($_SESSION["username"]) {
   ?>
<body>
    <aside id="left-panel" class="left-panel">
         <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
               <ul class="nav navbar-nav">
                  <li class="menu-title">Dashboard</li>
                  <li class="menu-item-has-children dropdown">
                     <a href="#" >Category Master</a>
                  </li>
                  <li class="menu-item-has-children dropdown">
                     <a href="#" >Sub Category Master</a>
                  </li>
                  <li class="menu-item-has-children dropdown">
                     <a href="#" > Product Master</a>
                  </li>
                  <li class="menu-item-has-children dropdown">
                     <a href="#" > Order Master</a>
                  </li>
				  <li class="menu-item-has-children dropdown">
                     <a href="usermaster.php" > User Master</a>
                  </li>
               </ul>
            </div>
         </nav>
      </aside>
      <div id="right-panel" class="right-panel">
         <header id="header" class="header">
            <div class="top-left">
               <div class="navbar-header">
                  <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="Logo"></a>
                  <a class="navbar-brand hidden" href="index.html"><img src="images/logo2.png" alt="Logo"></a>
                  <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
               </div>
            </div>
            <div class="top-right">
               <div class="header-menu">
                  <div class="user-area dropdown float-right">
                     <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome <?php echo $_SESSION["username"]; ?></a>
                     <div class="user-menu dropdown-menu">
                        <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i>Logout</a>
                     </div>
                  </div>
               </div>
            </div>
         </header>
         <?php
         }else echo "<h1>Please login first .</h1>";
                 ?>