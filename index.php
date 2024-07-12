<?php
session_start();
session_regenerate_id();
include './dashboard/Admin/includes/dbcon.php';
if(isset($_SESSION['student_id'])){
  ?>
<script>
location.replace("home.php");
</script>
<?php
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include "includes/head.php"; ?>

<body id="top">

  <!-- 
    - #HEADER
  -->

  <?php include "includes/header.php" ; ?>





  <main>
    <article>

      <!-- 
        - #HERO
      -->

      <section class="hero">
        <div class="container">

          <figure class="hero-banner">
            <img src="./assets/images/hero-banner.png" alt="A young lady sits, holding a pen and a notebook.">
          </figure>

          <div class="hero-content">

            <h1 class="h1 hero-title">Start Your Future Education</h1>

            <p class="section-text">
              Credibly redefine distinctive total linkage vis-a-vis multifunction data. Phosphorescently impact
              goal-oriented
              strategic
            </p>

            <button class="btn btn-primary">Discover More</button>

          </div>

        </div>
      </section>







      <style>
      .pay {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
      }

      .pay .price {
        font-size: 20px;
      }

      .pay .btn-enroll {
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        background-color: #fcda6a;
        color: #444;
      }
      </style>



      <!-- 
        - #DEPARTMENTS
      -->

      <section class="departments">
        <div class="container">

          <img src="./assets/images/departmets-vector.svg" alt="Vector line art" class="vector-line">

          <h2 class="h2 departments-title">We Have Most of Popular Courses</h2>

          <ul class="departments-list">
            <?php
            $select = mysqli_query($con, "SELECT * FROM package WHERE status = 1");
            if(mysqli_num_rows($select) > 0){
              while($res=mysqli_fetch_array($select)){
                ?>
            <li>
              <div class="departments-card">

                <h3 class="h3 card-title"><?=$res['name']?></h3>


                <p class="card-text">
                  <?=$res['description']?>
                </p>
                <div class="pay">
                  <div class="price"> <span class="badge badge-pill badge-success">BDT <?=$res['price']?>TK</span></div>
                  <div class="enroll">
                    <a href="login.php?login"><button type="submit" name="purchaseBtn" class="btn btn-primary">Enroll
                        Now</button></a>
                  </div>

                </div>


                <!-- <div class="card">

                <div class="card-body">
                  <h5 class="card-title"><?=$res['name']?></h5>
                  <p class="card-text"><?=$res['description']?></p>
                  <div class="pay">
                    <div class="price"> <span class="badge badge-pill badge-success">BDT <?=$res['price']?>TK</span>
                    </div>
                    <div class="enroll">
                      <a href="login.php?login"><button type="submit" name="purchaseBtn" class="btn btn-primary">Enroll
                          Now</button></a>
                    </div>

                  </div>
                </div>
              </div> -->
            </li>
            <?php
              }
            }
            ?>


          </ul>

        </div>
      </section>






      <!-- 
        - #CTA
      -->

      <section class="cta">
        <div class="container">

          <div class="title-wrapper">

            <h2 class="h2 cta-title">
              <span>Create Free Account & Get Register</span>

              <img src="./assets/images/cta-vector.svg" alt="Vector arrow art" class="vector-line">
            </h2>

            <a href="login.php?register"><button class="btn btn-primary">Register Now</button></a>

          </div>

          <div class="cta-banner"></div>

        </div>
      </section>

    </article>
  </main>





  <?php include "includes/footer.php"; ?>