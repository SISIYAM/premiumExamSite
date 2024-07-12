<?php 
include './Admin/includes/dbcon.php';
include './includes/login_required.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
include 'includes/head.php';
?>
</head>

<body>

  <!-- Nav bar -->
  <?php include 'includes/nav.php'; ?>

  <!--**********************************
            Content body start
        ***********************************-->

  <!--**********************************
            Content body start
        ***********************************-->
  <div class="content-body">

    <div class="container-fluid">

      <div class="row">

        <?php 
      $courseCount = mysqli_query($con, "SELECT * FROM package_record WHERE student_id='$student_id' AND status='1'");
      if(mysqli_num_rows($courseCount) > 0){
        if(isset($_GET['Routine'])){
          while($packageRow = mysqli_fetch_array($courseCount)){
            $package_id = $packageRow['package_id'];
            $searchPackage = mysqli_query($con, "SELECT * FROM package WHERE package_id='$package_id' AND status='1'");
            if(mysqli_num_rows($searchPackage) > 0){
              $courseRow = mysqli_fetch_array($searchPackage);
              ?>
        <div class="col-lg-3 col-sm-6">
          <div class="card">
            <div class="stat-widget-two card-body">
              <div class="stat-content">

                <div class="text-dark"
                  style="color:#000000; font-size:18px; text-align:justify; height:130px;font-weight:bold;">
                  <?=$courseRow['name']?> </div>
                <a href="routine?CourseID=<?=$courseRow['package_id']?>"> <button class="btn btn-primary my-3">View
                    Routine</button></a>
              </div>

            </div>
          </div>
        </div>
        <?php
            }
          }
        }elseif (isset($_GET['CourseID'])) {
          $courseID = $_GET['CourseID'];

          $checkDuration = mysqli_query($con, "SELECT * FROM package_record WHERE student_id='$student_id' AND package_id='$courseID'");
          if(mysqli_num_rows($checkDuration) > 0){
            $timeStamp = mysqli_fetch_array($checkDuration)['timestamp'];
          }
          $checkCourse = mysqli_query($con, "SELECT * FROM package WHERE package_id='$courseID' AND status='1'");
          if(mysqli_num_rows($checkCourse) > 0){
            $durationCourse = mysqli_fetch_array($checkCourse)['duration'];
          }

          if((time() - $timeStamp) < $durationCourse){
            $search = mysqli_query($con, "SELECT * FROM package WHERE package_id='$courseID'");
            if(mysqli_num_rows($search) > 0){
            while($row = mysqli_fetch_array($search)){
            ?>

        <div class="mx-3">
          <a style="color:#fff" href="Admin /<?=$row['routine']?>" Download="routine-<?=$row['name']?>">
            <button class="btn btn-primary btn-lg">Download Routine
          </a>
          </button>
        </div>
      </div><br>
      <img src="Admin/<?=$row['routine']?>" class="img-fluid" alt="">
      <?php
            }
           }else{
            ?>
      <p class="alert alert-warning text-dark">Coming Soon!</p>
      <?php
           }
          }else{
            ?>
      <p class="alert alert-danger text-light">Course Expired!</p>
      <?php
          }

        }
      }else{
        ?>
      <P class="alert alert-danger text-white">No Courses Purchased Yet!</P>
      <?php
      }
      ?>


    </div>
  </div>
  <!--**********************************
Content body end
***********************************-->

  <?php include("includes/footer.php"); ?>

</body>

</html>