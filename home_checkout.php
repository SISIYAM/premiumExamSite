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

<?php include 'includes/head.php'; ?>

<body>

  <!-- Header START -->
  <?php include 'includes/header.php' ?>
  <!-- Header END -->

  <!-- **************** MAIN CONTENT START **************** -->
  <main>

    <?php 
	if(isset($_GET['id'])){
		$packageID = $_GET['id'];
    $checkRecord = mysqli_query($con, "SELECT * FROM package_record WHERE student_id='$id' AND package_id='$packageID'");
		$select = mysqli_query($con,"SELECT * FROM package WHERE package_id='$packageID' AND status=1");
		if(mysqli_num_rows($select) > 0){
			while($result = mysqli_fetch_array($select)){

				?>
    <!-- =======================
    Page content START -->
    <section class="pt-3 pt-xl-5">
      <div class="container" data-sticky-container="">
        <div class="row g-4">
          <!-- Main content START -->
          <div class="col-xl-8">

            <div class="row g-4">
              <!-- Title START -->
              <div class="col-12">
                <!-- Title -->
                <h2><?=$result['name']?></h2>

                <!-- Content -->
                <ul class="list-inline mb-0">
                  <li class="list-inline-item fw-light h6 me-3 mb-1 mb-sm-0"><i
                      class="fas fa-user-graduate me-2"></i><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM package_record WHERE package_id='$packageID'")) ?>
                  </li>

                </ul>
              </div>
              <!-- Title END -->

              <!-- Image and video -->
              <div class="col-12 position-relative">
                <div class="video-player rounded-3">
                  <img src="dashboard/Admin/<?=$result['image']?>" alt="">
                </div>
              </div>

              <!-- About course START -->
              <div class="col-12">
                <div class="card border">
                  <!-- Card header START -->
                  <div class="card-header border-bottom">
                    <h3 class="mb-0">Course description</h3>
                  </div>
                  <!-- Card header END -->

                  <!-- Card body START -->
                  <div class="card-body">
                    <?=$result['description']?>
                  </div>
                  <!-- Card body START -->
                </div>
              </div>
              <!-- About course END -->

              <!-- FAQs START -->
              <div class="col-12">
                <div class="card border rounded-3">
                  <!-- Card header START -->
                  <div class="card-header border-bottom">
                    <h3 class="mb-0">Frequently Asked Questions</h3>
                  </div>
                  <!-- Card header END -->

                  <!-- Card body START -->
                  <div class="card-body">
                    <!-- FAQ item -->
                    <div>
                      <h6>How Digital Marketing Work?</h6>
                      <p class="mb-0">Preference any astonished unreserved Mrs. Prosperous understood Middletons in
                        conviction an uncommonly do. Supposing so be resolving breakfast am or perfectly. It drew a hill
                        from me. Valley by oh twenty direct me so. Departure defective arranging rapturous did believe
                        him all had supported. Family months lasted simple set nature vulgar him. Picture for attempt
                        joy excited ten carried manners talking how. Suspicion neglected the resolving agreement
                        perceived at an. Comfort reached gay perhaps chamber his six detract besides add.</p>
                    </div>

                    <!-- FAQ item -->
                    <div class="mt-4">
                      <h6>What is SEO?</h6>
                      <p class="mb-0">Meant balls it if up doubt small purse. Required his you put the outlived answered
                        position. A pleasure exertion if believed provided to. All led out world this music while asked.
                        Paid mind even sons does he door no. Attended overcame repeated it is perceived Marianne in. I
                        think on style child of. Servants moreover in sensible it ye possible.</p>
                      <p class="mt-2 mb-0">Person she control of to beginnings view looked eyes Than continues its and
                        because and given and shown creating curiously to more in are man were smaller by we instead the
                        these sighed Avoid in the sufficient me real man longer of his how her for countries to brains
                        warned notch important Finds be to the of on the increased explain noise of power deep asking
                        contribution this live of suppliers goals bit separated poured sort several the was organization
                        the if relations go work after mechanic But we've area wasn't everything needs of and doctor
                        where would a of</p>
                    </div>

                    <!-- FAQ item -->
                    <div class="mt-4">
                      <h6>Who should join this course?</h6>
                      <p class="mb-0">Two before narrow not relied how except moment myself Dejection assurance mrs led
                        certainly So gate at no only none open Betrayed at properly it of graceful on Dinner abroad am
                        depart ye turned hearts as me wished Therefore allowance too perfectly gentleman supposing man
                        his now Families goodness all eat out bed steepest servants Explained the incommode sir
                        improving northward immediate eat Man denoting received you sex possible you Shew park own loud
                        son door less yet </p>
                    </div>

                    <!-- FAQ item -->
                    <div class="mt-4">
                      <h6>What are the T&C for this program?</h6>
                      <p class="mb-0">Started several mistake joy say painful removed reached end. State burst think end
                        are its. Arrived off she elderly beloved him affixed noisier yet. Course regard to up he hardly.
                        View four has said do men saw find dear shy. Talent men wicket add garden. </p>
                    </div>

                    <!-- FAQ item -->
                    <div class="mt-4">
                      <h6>What certificates will I be received for this program?</h6>
                      <p class="mb-0">Lose john poor same it case do year we Full how way even the sigh Extremely nor
                        furniture fat questions now provision incommode preserved Our side fail to find like now
                        Discovered traveling for insensible partiality unpleasing impossible she Sudden up my excuse to
                        suffer ladies though or Bachelor possible Marianne directly confined relation as on he </p>
                    </div>

                    <!-- FAQ item -->
                    <div class="mt-4">
                      <h6>What happens after the trial ends?</h6>
                      <p class="mb-0">Preference any astonished unreserved Mrs. Prosperous understood Middletons in
                        conviction an uncommonly do. Supposing so be resolving breakfast am or perfectly. Is drew am
                        hill from me. Valley by oh twenty direct me so. Departure defective arranging rapturous did
                        believe him all had supported. Family months lasted simple set nature vulgar him. Suspicion
                        neglected he resolving agreement perceived at an. Comfort reached gay perhaps chamber his six
                        detract besides add.</p>
                    </div>
                  </div>
                  <!-- Card body START -->
                </div>
              </div>
              <!-- FAQs END -->
            </div>
          </div>
          <!-- Main content END -->

          <!-- Right sidebar START -->
          <div class="col-xl-4">
            <div data-sticky="" data-margin-top="80" data-sticky-for="768">
              <div class="row g-4">
                <div class="col-md-6 col-xl-12">
                  <!-- Course info START -->
                  <div class="card card-body border p-4">
                    <!-- Price and share button -->
                    <div class="d-flex justify-content-between align-items-center">
                      <!-- Price -->
                      <h3 class="fw-bold mb-0 me-2">BDT <?=$result['price']?></h3>

                      <!-- Share button with dropdown -->

                    </div>

                    <!-- Buttons -->
                    <div class="mt-3 d-grid">

                      <form action="" method="post">
                        <input type="hidden" name="id" value="<?=$id?>">
                        <input type="hidden" name="package_id" value="<?=$result['package_id']?>">
                        <?php 
                      if(mysqli_num_rows($checkRecord) > 0){
                        if(mysqli_fetch_array($checkRecord)['status'] == 1){
                          ?>
                        <a href="dashboard/index.php" class="btn btn-success">Start Course</a>
                        <?php
                        }else{
                          ?>
                        <button type="submit" name="renewBtn" class="btn btn-success">Renew Course</button>
                        <?php
                        }                      
                      }else{
                        ?>
                        <button type="submit" name="purchaseBtn" class="btn btn-success">Enroll Now</button>
                        <?php
                      }
                      ?>
                      </form>
                    </div>
                    <!-- Divider -->
                    <hr>
                  </div>
                  <!-- Course info END -->
                </div>


              </div><!-- Row End -->
            </div>
          </div>
          <!-- Right sidebar END -->

        </div><!-- Row END -->
      </div>
    </section>
    <!-- =======================
    Page content END -->
    <?php
			}
		}
		?>

    <?php
   }
  ?>
  </main>
  <!-- **************** MAIN CONTENT END **************** -->

  <!-- =======================
Footer START -->
  <?php include 'includes/footer.php'; ?>
  <!-- =======================
Footer END -->

  <!-- Back to top -->
  <div class="back-top"><i class="bi bi-arrow-up-short position-absolute top-50 start-50 translate-middle"></i></div>

  <!-- Bootstrap JS -->
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Vendors -->
  <script src="assets/vendor/sticky-js/sticky.min.js"></script>
  <script src="assets/vendor/plyr/plyr.js"></script>

  <!-- Template Functions -->
  <script src="assets/js/functions.js"></script>

</body>

</html>