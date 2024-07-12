<!-- Header START -->
<header class="navbar-light navbar-sticky header-static">
  <!-- Logo Nav START -->
  <nav class="navbar navbar-expand-xl">
    <div class="container">
      <!-- Logo START -->
      <a class="navbar-brand" href="<?php if(isset($_SESSION['student_id'])){
        echo "home";
      }else{
        echo "index";
      } ?>">
        <b class="">SEI INNOVATIONS</b>
      </a>
      <!-- Logo END -->



      <!-- Main navbar START -->
      <div class="navbar-collapse w-100 collapse" id="navbarCollapse">

      </div>
      <!-- Main navbar END -->

      <!-- Profile START -->
      <div class="dropdown ms-1 ms-lg-0">
        <?php 
       if(isset($_SESSION['student_id'])){
        ?>
        <a href="dashboard/"> <button class="btn btn-primary">GO Exam Site</button></a>
        <?php
       } else{  ?>
        <a href="login.php?login"> <button class="btn btn-primary">Login </button></a>

        <?php 
       }
       ?>
      </div>
      <!-- Profile START -->
    </div>
  </nav>
  <!-- Logo Nav END -->
</header>
<!-- Header END -->