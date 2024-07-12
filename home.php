<?php
session_start();
session_regenerate_id();
if(!isset($_SESSION['student_id'])){
?>
<script>
location.replace("login.php?login");
</script>
<?php
}

include './dashboard/Admin/includes/dbcon.php';
$id = $_SESSION['student_id'];
include './includes/code.php';
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
                $course_id = $res['package_id'];
                $checkRecord = mysqli_query($con, "SELECT * FROM package_record WHERE student_id='$id' AND package_id='$course_id'");
      
                ?>
            <li>
              <div class="departments-card">

                <h3 class="h3 card-title"><?=$res['name']?></h3>


                <p class="card-text">
                  <?=$res['description']?>
                </p>

                <div class="pay">
                  <div class="price"> <span class="badge badge-pill badge-success">BDT <?=$res['price']?>TK</span>
                  </div>
                  <div class="enroll">
                    <form action="" method="post">
                      <input type="hidden" name="id" value="<?=$id?>">
                      <input type="hidden" name="package_id" value="<?=$res['package_id']?>">
                      <?php 
                      if(mysqli_num_rows($checkRecord) > 0){
                        if(mysqli_fetch_array($checkRecord)['status'] == 1){
                          ?>
                      <a href="dashboard/index.php" class="btn btn-primary">Stat Course</a>
                      <?php
                        }else{
                          ?>
                      <button type="submit" name="renewBtn" class="btn btn-primary">Renew Course</button>
                      <?php
                        }                      
                      }else{
                        ?>
                      <button type="submit" name="purchaseBtn" class="btn btn-primary">Enroll Now</button>
                      <?php
                      }
                      ?>
                    </form>
                  </div>

                </div>
              </div>
            </li>
            <?php
              }
            }
            ?>
          </ul>
        </div>
      </section>


    </article>
  </main>





  <?php include "includes/footer.php"; ?>