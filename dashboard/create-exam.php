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
  <div class="content-body">
    <div class="container-fluid">
      <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
          <div class="welcome-text">
            <h4>Hi, welcome back!</h4>
            <span class="ml-1">Create Exam</span>
          </div>
        </div>

      </div>
      <!-- row -->
      <div class="row">
        <?php
      $courseCount = mysqli_query($con, "SELECT * FROM package_record WHERE student_id='$student_id' AND status='1'");
      if(mysqli_num_rows($courseCount) > 0){
        if(isset($_GET['CourseID'])){
          $courseID = $_GET['CourseID'];
          $checkDuration = mysqli_query($con, "SELECT * FROM package_record WHERE student_id='$student_id' AND package_id='$courseID'");
          if(mysqli_num_rows($checkDuration) > 0){
            $timeStamp = mysqli_fetch_array($checkDuration)['timestamp'];
          }
          $checkCourse = mysqli_query($con, "SELECT * FROM package WHERE package_id='$courseID' AND status='1'");
          if(mysqli_num_rows($checkCourse) > 0){
            $durationCourse = mysqli_fetch_array($checkCourse)['duration'];
          }

          if((time() - $timeStamp) > $durationCourse){
            ?>
        <p class="alert alert-danger text-light">Course Expired!</p>
        <?php
          }else{
          ?>

        <div class="col-xl-12 col-xxl-12">

          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Create Your Exam</h4>
            </div>
            <div class="card-body">
              <div class="basic-form">
                <form action="exam?CustomExam" method="post">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label text-dark">Exam Name</label>
                    <div class="col-sm-10">
                      <input type="name" name="exam_name" class="form-control" placeholder="Exam Name" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-2 text-dark">Question Distribution</div>
                    <div class="col-sm-10">
                      <div class="row">
                        <?php
              $search_subject = mysqli_query($con, "SELECT * FROM subjects");
              if(mysqli_num_rows($search_subject) > 0){
                while($row = mysqli_fetch_array($search_subject)){
                  ?>
                        <div class="col-sm-3">
                          <label for="" class="text-dark"><?=$row['subject']?></label>
                          <input type="number" name="<?=$row['id']?>" class="form-control"
                            placeholder="<?=$row['subject']?>" value="0">


                          <?php 
                                      $chapterBox = mysqli_query($con,"SELECT * FROM chapter WHERE subject_id='".$row['id']."'");
                                      if(mysqli_num_rows($chapterBox) > 0){
                                      while($chapterRow = mysqli_fetch_array($chapterBox)){
                                      ?>
                          <br>
                          <input class="form-check-input ml-1" type="checkbox" name="<?=$row['id']?>chapter[]"
                            value="<?=$chapterRow['id']?>" id="flexCheckDefault">
                          <label class="mx-4 text-dark" for=""><?=$chapterRow['name']?></label>

                          <?php
                                       }
                                       }
                            ?>

                        </div>
                        <?php                          
                }
              }
              ?>


                      </div>

                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-2 text-dark">Marks Per Qustion</div>
                    <div class="col-sm-10">
                      <input type="number" step="any" name="custom_mark" class="form-control"
                        placeholder="Marks Per Question" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-2 text-dark">Negative Marking</div>
                    <div class="col-sm-10">
                      <input type="number" step="any" name="negative_mark" class="form-control" value="0"
                        placeholder="Negative Marking" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-2 text-dark">Exam Duration(Minutes)</div>
                    <div class="col-sm-10">
                      <input type="number" name="duration" class="form-control" placeholder="Exam Duration in minutes"
                        required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-10">
                      <button type="submit" name="create_exam" class="btn btn-primary btn-lg">Create Exam</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>
        <?php
          }
        }else{
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
                <a href="create-exam?CourseID=<?=$courseRow['package_id']?>"> <button
                    class="btn btn-primary my-3">Create
                  </button></a>
              </div>

            </div>
          </div>
        </div>
        <?php
            }
          }
        }

      }else{
        ?>
        <p class="alert alert-danger text-white">No courses Purchased Yet!</p>
        <?php
      }
      ?>
      </div>
    </div>


    <?php include("includes/footer.php"); ?>


</body>

</html>