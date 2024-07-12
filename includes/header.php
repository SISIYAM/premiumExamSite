<header class="header" data-header>
  <div class="container">

    <div class="overlay" data-overlay></div>

    <a href="#" class="logo">
      <p style="font-size:25px; color:hsl(39, 100%, 50%); font-weight:bold;">SEI <sub>Innovations</sub></p>
    </a>

    <button class="menu-open-btn" data-menu-open-btn>
      <ion-icon name="menu-outline"></ion-icon>
    </button>

    <nav class="navbar" data-navbar>

      <button class="menu-close-btn" data-menu-close-btn>
        <ion-icon name="close-outline"></ion-icon>
      </button>

      <a href="#" class="logo">
        <img src="./assets/images/logo.svg" alt="Eduland logo">
      </a>

      <ul class="navbar-list">
        <!--
        <li>
          <a href="index.php" class="navbar-link">Home</a>
        </li>

        <li>
          <a href="#" class="navbar-link">Contact</a>
        </li>

       
      

            -->
      </ul>

      <?php 
       if(isset($_SESSION['student_id'])){
        ?>
      <a href="dashboard/index.php"> <button class="btn btn-primary">GO Exam Site</button></a>
      <?php
       } else{  ?>
      <a href="login.php?login"> <button class="btn btn-primary">Login </button></a>

      <?php 
       }
       ?>

    </nav>

  </div>
</header>