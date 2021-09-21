<header class="main-header">

<?php
require 'Mobile_Detect.php';
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

if ($detect->isMobile() or $detect->isTablet()) {
  $contentmargin = 0;
  $sidebarmargin = 0;
}else{
  $contentmargin = 40;
  $sidebarmargin = 100;
  ?>
   <img src="images/header.jpg" id="header_image" width="100%" height="90px">
  <?php
}
  ?>


  <?php
     
    ?>
   
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>MC</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>MetroCure</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      
    </nav>
  </header>
