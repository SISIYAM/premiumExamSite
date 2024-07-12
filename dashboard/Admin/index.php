<?php
include './includes/dbcon.php';
include './includes/login_required.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'includes/head.php'; ?>

<body>
  <?php include 'includes/nav.php'; ?>
  <div id="main">
    <header class="mb-3">
      <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
      </a>
    </header>

    <div class="page-heading">
      <h3>Profile Statistics
      </h3>
    </div>
    <div class="page-content">
      <section class="row">
        <div class="col-12 col-lg-9">
          <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
              <div class="card">
                <div class="card-body px-4 py-4-5">
                  <a href="list.php?Exam">
                    <div class="row">
                      <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                        <div class="stats-icon purple mb-2">
                          <i class="iconly-boldShow"></i>
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Total Exams</h6>
                        <h6 class="font-extrabold mb-0"><?php 
                      echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM exam"));
                      ?></h6>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
              <div class="card">
                <div class="card-body px-4 py-4-5">
                  <a href="list.php?Questions">
                    <div class="row">
                      <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                        <div class="stats-icon red mb-2">
                          <i class="iconly-boldBookmark"></i>
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Questions</h6>
                        <h6 class="font-extrabold mb-0"><?php 
                      echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM questions"));
                      ?></h6>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
              <div class="card">
                <div class="card-body px-4 py-4-5">
                  <a href="list.php?Teachers">
                    <div class="row">
                      <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                        <div class="stats-icon blue mb-2">
                          <i class="iconly-boldProfile"></i>
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Teachers</h6>
                        <h6 class="font-extrabold mb-0"><?php 
                      echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM admin WHERE post=0"));
                      ?></h6>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
              <div class="card">
                <div class="card-body px-4 py-4-5">
                  <a href="list.php?Students">
                    <div class="row">
                      <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                        <div class="stats-icon green mb-2">
                          <i class="iconly-boldAdd-User"></i>
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Students</h6>
                        <h6 class="font-extrabold mb-0"><?php 
                      echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM students"));
                      ?></h6>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>

            <div class="col-6 col-lg-3 col-md-6">
              <div class="card">
                <div class="card-body px-4 py-4-5">
                  <a href="list.php?Courses">
                    <div class="row">
                      <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                        <div class="stats-icon green mb-2">
                          <i class="iconly-boldBookmark"></i>
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Courses</h6>
                        <h6 class="font-extrabold mb-0"><?php 
                      echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM package"));
                      ?></h6>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>

            <div class="col-6 col-lg-3 col-md-6">
              <div class="card">
                <div class="card-body px-4 py-4-5">
                  <a href="list.php?Courses-Record">
                    <div class="row">
                      <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                        <div class="stats-icon green mb-2">
                          <i class="iconly-boldUser"></i>
                        </div>
                      </div>
                      <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Enrolled</h6>
                        <h6 class="font-extrabold mb-0"><?php 
                      echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM package_record"));
                      ?></h6>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>

          </div>

        </div>
        <div class="col-12 col-lg-3">
          <div class="card">
            <div class="card-body py-4 px-4">
              <div class="d-flex align-items-center">
                <div class="avatar avatar-xl">
                  <img src="./assets/compiled/jpg/1.jpg" alt="Face 1">
                </div>
                <div class="ms-3 name">
                  <h5 class="font-bold"><?=$_SESSION['username']?></h5>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include 'includes/footer.php'; ?>

  </div>
  </div>
  <script src="assets/static/js/components/dark.js"></script>
  <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>


  <script src="assets/compiled/js/app.js"></script>



  <!-- Need: Apexcharts -->
  <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
  <script src="assets/static/js/pages/dashboard.js"></script>

</body>

</html>