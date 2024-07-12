<?php
include './includes/login_required.php';
include 'includes/dbcon.php';
include 'includes/code.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php
include 'includes/head.php';
?>
<style>
.table tbody tr td span {
  cursor: pointer;

}
</style>


<body>
  <?php include 'includes/nav.php'; ?>
  <div id="main">
    <header class="mb-3">
      <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
      </a>
    </header>

    <?php if (isset($_GET['Exam'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Exams List
            </h5>
            <a href="add.php?Exam"><button class="btn btn-primary">Add Exam</button></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="float-end">
                <input type="text" class="search-box form-control" id="myInput" onkeyup="myFunction()"
                  placeholder="Search for names.." title="Type in a name">
              </div>
              <?php
                  $no = 0;
                  $select = mysqli_query($con, "SELECT * FROM exam ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                    ?>

              <table class="table" id="myTable" style="font-size:14px">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Exam ID</th>
                    <th>Exam Name</th>
                    <th>Exam Date</th>
                    <th>Questions</th>
                    <th>MCQ Marks</th>
                    <th>Duration</th>
                    <th>Author</th>
                    <td>Status</td>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row = mysqli_fetch_array($select)){
                  $no ++;
                  $duration = $row['duration'];
                  $examID = $row['exam_id'];
                  $exam_start_date = strtotime($row['exam_start']);
                  $new_start_date = date('d M Y', $exam_start_date);
                  $exam_start_time = strtotime($row['exam_start_time']);
                  $new_start_time = date('h:i A',$exam_start_time);
                  $exam_end_date = strtotime($row['exam_end']);
                  $new_end_date = date('d M Y', $exam_end_date);
                  $exam_end_time = strtotime($row['exam_end_time']);
                  $new_end_time = date('h:i A',$exam_end_time);

                  // current time
                  date_default_timezone_set("Asia/Dhaka");
                  $date = date('Y-m-d H:i');
                  $current_time = strtotime($date);
                 
                  ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$row['exam_id'];?></td>
                    <td><?=$row['exam_name'];?></td>
                    <td>
                      <?=$new_start_date." ".$new_start_time." to ".$new_end_date." ".$new_end_time?>
                    </td>
                    <td><?php 
                    if($row['custom_exam_type'] == 0){
                    $countQuestion = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$examID'");
                    $countNumbers = mysqli_num_rows($countQuestion);
                    echo $countNumbers;
                    }else{
                      echo $row['number_of_questions'];
                    }
                    ?></td>
                    <td><?=$row['mcq_marks'];?></td>

                    <td>
                      <?php
                      if(((int)($duration/3600)) == 0 && ((int)($duration%3600)/60) != 0 && (($duration%3600)%60) != 0){
                        echo ((int)(($duration%3600)/60)." min ".(($duration%3600)%60)." Sec");
                      }elseif (((int)($duration/3600)) != 0 && ((int)($duration%3600)/60) != 0 && (($duration%3600)%60) == 0) {
                        echo ((int)($duration/3600)." hour ".(int)(($duration%3600)/60)." min " );
                      }elseif (((int)($duration/3600)) == 0 && (($duration%3600)%60) == 0 && ((int)($duration%3600)/60) != 0) {
                        echo ((int)(($duration%3600)/60)." min " );
                      }elseif (((int)($duration/3600)) != 0 && ((int)($duration%3600)/60) == 0 && (($duration%3600)%60)==0) {
                        echo ((int)($duration/3600)." hour ");
                      } else{
                        echo ((int)($duration/3600)." hour ".(int)(($duration%3600)/60)." min ".(($duration%3600)%60)." Sec");
                      }
                      ?>

                    </td>
                    <td><?=$row['added_by'];?></td>
                    <td><?php
                    if($row['status'] == 1){
                      ?>
                      <button value="<?=$row['id'] ?>"
                        class="badge bg-success border-0 unPublishExamBtn">Published</button>
                      <?php
                    }else{
                      ?>
                      <button value="<?=$row['id'] ?>"
                        class="badge bg-danger border-0 publishExamBtn">Unpublished</button>
                      <?php
                    }
                    ?>
                    </td>
                    <td>
                      <?php 
                      $examStartDate = $row['exam_start']." ".$row['exam_start_time'];
                      $examEndDate = $row['exam_end']." ".$row['exam_end_time'];

                      $examStartTimestamp = strtotime($examStartDate);
                      $examEndTimestamp = strtotime($examEndDate);
                      
                      if($current_time < $examStartTimestamp){
                        ?>
                      <span class="badge bg-warning">Not Start</span>
                      <?php
                      }elseif($current_time >= $examStartTimestamp && $current_time < $examEndTimestamp){
                        ?>
                      <span class="badge bg-danger">Live</span>
                      <?php
                      }elseif($current_time >= $examEndTimestamp){
                        ?>
                      <span class="badge bg-light">Finished</span>
                      <?php
                      }
                      
                    ?>
                    </td>
                    <td><button value="<?=$row['id']?>" class="badge bg-primary border-0 editExamBtn"
                        data-bs-toggle="modal" data-bs-target="#examEditModal">Edit</button></td>
                    <td><button value="<?=$row['id']?>" class="badge bg-danger border-0 deleteExamBtn">Delete</button>
                    </td>
                  </tr>
                  <?php
                    }
                  }else{
                    ?>
                  <tr>

                    <p class="alert alert-danger"> No Result Found!</p>

                  </tr>
                  <?php
                  }
                  ?>
              </table>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>
    <!--scrolling content Modal -->
    <div class="modal fade" id="examEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="" method="post">
            <div class="modal-body" id="examModalContent">
            </div>
          </form>

          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="button" id="saveExamBtn" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <?php
    }elseif (isset($_GET['Questions'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Question List
            </h5>
            <a href="add.php?Questions"><button class="btn btn-primary">Add Question</button></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="float-end">
                <input type="text" class="search-box form-control" id="myInput" onkeyup="myFunction()"
                  placeholder="Search for names.." title="Type in a name">
              </div>
              <?php
                  $no = 0;
                  $select = mysqli_query($con, "SELECT * FROM questions ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                    ?>
              <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Exam ID</th>
                    <th>Questions</th>
                    <th>Mark</th>
                    <th>Negative Mark</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                while($row = mysqli_fetch_array($select)){
                  $no ++;
                  ?>
                  <tr>
                    <td><?=$no;?></td>
                    <td>
                      <?php 
                    if($row['exam_id'] != NULL){
                      echo $row['exam_id'];
                    }else{
                      echo "No Exam";
                    }
                    ?> </td>
                    <td class="questionColor"><?=$row['question']?></td>
                    <td><?=$row['mark']?></td>
                    <td><?=$row['negative_mark']?></td>
                    <td><a href="add.php?Update-Questions=<?=$row['id']?>"><span
                          class="badge bg-primary">Edit</span></a></td>
                    <td><button class="badge bg-danger border-0 deleteQuestionBtn"
                        value="<?=$row['id']?>">Delete</button></td>
                  </tr>
                  <?php
                    }
                  }else{
                    ?>
                  <tr>

                    <p class="alert alert-danger"> No Result Found!</p>

                  </tr>
                  <?php
                  }
                  ?>
              </table>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>
    <?php
    } elseif (isset($_GET['Students'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Students List
            </h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="float-end">
                <input type="text" class="search-box form-control" id="myInput" onkeyup="myFunction()"
                  placeholder="Search for names.." title="Type in a name">
              </div>
              <?php
                  $no = 1;
                  $select = mysqli_query($con, "SELECT * FROM students ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                    ?>
              <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th></th>
                    <?php
                    if($_SESSION['post'] == 1){
                      echo "<th></th>";
                    }
                    ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row=mysqli_fetch_array($select)){
                    ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$row['student_id']?></td>
                    <td><?=$row['username']?></td>
                    <td><?=$row['full_name']?></td>
                    <td>
                      <button type="button" value="<?=$row['id']?>"
                        class="badge bg-primary border-0 viewStudentInformationBtn" data-bs-toggle="modal"
                        data-bs-target="#studentInformationModal">
                        View
                      </button>
                    </td>
                    <?php
                   if($_SESSION['post'] == 1){
                    ?>
                    <td>
                      <button value="<?=$row['id']?>" class="badge bg-danger border-0 deleteStudentBtn">Delete</button>
                    </td>
                    <?php
                   }
                   ?>
                  </tr>
                  <?php
                  $no++;
                  }
                  ?>


              </table>
              <?php
                }else{
                ?>
              <tr>

                <p class="alert alert-danger"> No Result Found!</p>

              </tr>
              <?php
                }
                ?>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>

    <!--scrolling content Modal -->
    <div class="modal fade" id="studentInformationModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body" id="studentModalContent">


          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <?php
    }elseif (isset($_GET['Leader-Board'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Leader Board
            </h5>
          </div>
          <div class="col-6 mx-4">
            <select name="" class="form-select" id="filterExam">
              <option value="">Select Exam</option>
              <?php
               $selectExam = mysqli_query($con,"SELECT * FROM exam WHERE status=1");
               if(mysqli_num_rows($selectExam) > 0){
                while($result = mysqli_fetch_array($selectExam)){
                  ?>
              <option value="<?=$result['exam_id']?>"><?=$result['exam_name']?></option>
              <?php
                }
               }
              ?>
            </select>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="float-end">
                <input type="text" class="search-box form-control" id="myInput" onkeyup="myFunction()"
                  placeholder="Search for names.." title="Type in a name">
              </div>

              <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th>Merit</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Institution</th>
                    <th>Mark</th>
                    <th></th>

                </thead>
                <tbody id="outputLeaderBoard">

              </table>


            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>

    <!--scrolling content Modal -->
    <div class="modal fade" id="studentInformationModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body" id="studentModalContent">


          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <?php
    }elseif (isset($_GET['Teachers'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Teachers List
            </h5>
            <?php if($_SESSION['post'] == 1){
            ?>
            <a href="login.php?register"><button class="btn btn-primary btn-lg">Add Teachers</button></a>
            <?php
           } ?>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="float-end">
                <input type="text" class="search-box form-control" id="myInput" onkeyup="myFunction()"
                  placeholder="Search for names.." title="Type in a name">
              </div>
              <?php
                  $no = 1;
                  $select = mysqli_query($con, "SELECT * FROM admin WHERE post='0' ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                    ?>
              <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <?php
                    if($_SESSION['post'] == 1){
                      ?>
                    <th></th>
                    <th></th>
                    <?php
                    }
                    ?>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row = mysqli_fetch_array($select)){
                    ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$row['id']?></td>
                    <td><?=$row['full_name']?></td>
                    <td><?=$row['username']?></td>
                    <td><?=$row['email']?></td>
                    <td><?=$row['mobile']?></td>
                    <?php
                    if($_SESSION['post'] == 1){
                      ?>


                    <td>
                      <?php
                      if($row['status'] == 0){
                        ?>
                      <button value="<?=$row['id']?>"
                        class="badge bg-warning border-0 teacherActivateBtn">Deactivate</button>
                      <?php
                      }else{
                        ?>
                      <button value="<?=$row['id']?>"
                        class="badge bg-success border-0 teacherDeactivateBtn">Active</button>
                      <?php
                      }
                      ?>
                    </td>

                    <td>

                      <button value="<?=$row['id']?>" class="badge bg-danger border-0 deleteTeacher">Delete</button>
                    </td>

                    <?php
                    }
                    ?>
                  </tr>
                  <?php
                   $no++;
                  }
                  ?>
              </table>
              <?php
                  }else{
                   ?>
              <tr>

                <p class="alert alert-danger"> No Result Found!</p>

              </tr>
              <?php 
                  }
                  ?>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>
    <?php
    }elseif (isset($_GET['Admins'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Admins List
            </h5>
            <?php if($_SESSION['post'] == 1){
            ?>
            <a href="login.php?register"><button class="btn btn-primary btn-lg">Add Admin</button></a>
            <?php
           } ?>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="float-end">
                <input type="text" class="search-box form-control" id="myInput" onkeyup="myFunction()"
                  placeholder="Search for names.." title="Type in a name">
              </div>
              <?php
                  $no = 1;
                  $select = mysqli_query($con, "SELECT * FROM admin WHERE post='1' ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                    ?>
              <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row = mysqli_fetch_array($select)){
                    ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$row['id']?></td>
                    <td><?=$row['full_name']?></td>
                    <td><?=$row['username']?></td>
                    <td><?=$row['email']?></td>
                    <td><?=$row['mobile']?></td>
                    <td><button class="badge bg-danger border-0 deleteAdminBtn" value="<?=$row['id']?>">Delete</button>
                    </td>
                  </tr>
                  <?php
                   $no++;
                  }
                  ?>
              </table>
              <?php
                  }else{
                   ?>
              <tr>

                <p class="alert alert-danger"> No Result Found!</p>

              </tr>
              <?php 
                  }
                  ?>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>


    <?php
    }elseif (isset($_GET['Subjects'])) {
     ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Subjects List
            </h5>
            <!-- <a href="list.php?Chapters"><button class="btn btn-success">View Chapters</button></a> -->
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="float-end">
                <input type="text" class="search-box form-control" id="myInput" onkeyup="myFunction()"
                  placeholder="Search for names.." title="Type in a name">
              </div>
              <?php
                  $no = 0;
                  $select = mysqli_query($con, "SELECT * FROM subjects");
                  if(mysqli_num_rows($select) > 0){
                    ?>

              <table class="table" id="myTable" style="font-size:14px">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Subject ID</th>
                    <th>Subject Name</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row = mysqli_fetch_array($select)){
                  $no ++;
                 
                  ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$row['id'];?></td>
                    <td><?=$row['subject'];?></td>

                    <td><button value="<?=$row['id']?>" class="badge bg-primary border-0 editSubjectBtn"
                        data-bs-toggle="modal" data-bs-target="#subjectEditModal">Edit</button></td>
                    <td><button value="<?=$row['id']?>"
                        class="badge bg-danger border-0 deleteSubjectBtn">Delete</button>
                    </td>
                  </tr>
                  <?php
                    }
                  }else{
                    ?>
                  <tr>

                    <p class="alert alert-danger"> No Result Found!</p>

                  </tr>
                  <?php
                  }
                  ?>
              </table>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>

    <!--scrolling content Modal -->
    <div class="modal fade" id="subjectEditModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="" method="post">
            <div class="modal-body" id="subjectEditContent">
            </div>
          </form>

          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="button" id="saveSubjectBtn" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <?php
    }elseif (isset($_GET['Chapters'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Chapters List
            </h5>
            <a href="add.php?Chapters"><button type="button" class="btn btn-primary">Add
                Chapters</button></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <?php
                  $no = 0;
                  $select = mysqli_query($con, "SELECT * FROM chapter");
                  if(mysqli_num_rows($select) > 0){
                    ?>

              <table class="table" id="table1" style="font-size:14px">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Subject Name</th>
                    <th>Chapter Name</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row = mysqli_fetch_array($select)){
                  $no ++;
                  $subject_id = $row['subject_id'];
                  ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?php
                     echo mysqli_fetch_array(mysqli_query($con, "SELECT * FROM subjects WHERE id='$subject_id'"))['subject'];
                    ?></td>
                    <td><?=$row['name'];?></td>

                    <td><button value="<?=$row['id']?>" class="badge bg-primary border-0 editChapterBtn"
                        data-bs-toggle="modal" data-bs-target="#chapterEditModal">Edit</button></td>
                    <td><button value="<?=$row['id']?>"
                        class="badge bg-danger border-0 deleteChapterBtn">Delete</button>
                    </td>
                  </tr>
                  <?php
                    }
                  }else{
                    ?>
                  <tr>

                    <p class="alert alert-danger"> No Result Found!</p>

                  </tr>
                  <?php
                  }
                  ?>
              </table>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>

    <!--scrolling content Modal -->
    <div class="modal fade" id="chapterEditModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="" method="post">
            <div class="modal-body" id="chapterEdit">
            </div>
          </form>

          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="button" id="saveChapterBtn" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <?php
    }elseif (isset($_GET['Courses'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Courses List
            </h5>
            <a href="add.php?Courses"><button type="button" class="btn btn-primary">Add
                Courses</button></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="float-end">
                <input type="text" class="search-box form-control" id="myInput" onkeyup="myFunction()"
                  placeholder="Search for names.." title="Type in a name">
              </div>
              <?php
                  $no = 0;
                  $select = mysqli_query($con, "SELECT * FROM package");
                  if(mysqli_num_rows($select) > 0){
                    ?>

              <table class="table" id="myTable" style="font-size:14px">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Custom Exam</th>
                    <th>Routine</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Expiry date</th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row = mysqli_fetch_array($select)){
                  $no ++;
                  ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$row['package_id'];?></td>
                    <td><?=$row['name'];?></td>
                    <td><?php 
                    if($row['custom_exam'] == 1){
                      ?>
                      <span class='badge bg-success'>On</span>
                      <?php
                    }else{
                      ?>
                      <span class='badge bg-danger'>Off</span>
                      <?php
                    }
                    ?>
                    </td>
                    <td><a href="add.php?updateRoutine=<?=$row['package_id']?>"><span
                          class="badge bg-info text-dark">Change</span></a></td>
                    <td><?=$row['price'];?></td>
                    <td><?=$row['duration'];?></td>
                    <td><?=$row['expiry_date'];?></td>
                    <td><?php
                    if($row['status'] == 1){
                      echo "<span class='badge bg-success'>Active</span>";
                    }else{
                      echo "<span class='badge bg-danger'>Inactive</span>";
                    }
                    ?></td>
                    <td><button value="<?=$row['id']?>" class="badge bg-primary border-0 editCourseBtn"
                        data-bs-toggle="modal" data-bs-target="#courseEditModal">Edit</button></td>
                    <td><button value="<?=$row['id']?>" class="badge bg-danger border-0 deleteCourseBtn">Delete</button>
                    </td>
                  </tr>
                  <?php
                    }
                  }else{
                    ?>
                  <tr>

                    <p class="alert alert-danger"> No Result Found!</p>

                  </tr>
                  <?php
                  }
                  ?>
              </table>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>

    <!--scrolling content Modal -->
    <div class="modal fade" id="courseEditModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="" method="post">
            <div class="modal-body" id="courseEdit">
            </div>
          </form>

          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="button" id="saveCourseBtn" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <?php
    }elseif (isset($_GET['Courses-Record'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Students List
            </h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="float-end">
                <input type="text" class="search-box form-control" id="myInput" onkeyup="myFunction()"
                  placeholder="Search for names.." title="Type in a name">
              </div>
              <?php
                  $no = 1;
                  $select = mysqli_query($con, "SELECT * FROM package_record ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                    ?>
              <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Enrolled</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row=mysqli_fetch_array($select)){
                    $student_id = $row['student_id'];
                    $package_id = $row['package_id'];
                    $studentInfo = mysqli_query($con, "SELECT * FROM students WHERE student_id='$student_id'");
                    $studentResult = mysqli_fetch_array($studentInfo);

                    $courseInfo = mysqli_query($con, "SELECT * FROM package WHERE package_id='$package_id'");
                    $packageRow = mysqli_fetch_array($courseInfo);
                    $enrolled = date('d M Y h:i A',$row['timestamp']);
                   
                    ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$row['student_id']?></td>
                    <td><?=$studentResult['full_name']?></td>
                    <td><?=$package_id?></td>
                    <td><?=$packageRow['name']?></td>
                    <td><?=$enrolled?></td>
                    <td>
                      <button type="button" value="<?=$studentResult['id']?>"
                        class="badge bg-primary border-0 viewStudentInformationBtn" data-bs-toggle="modal"
                        data-bs-target="#studentInformationModal">
                        View
                      </button>
                    </td>
                  </tr>
                  <?php
                  $no++;
                  }
                  ?>


              </table>
              <?php
                }else{
                ?>
              <tr>

                <p class="alert alert-danger"> No Result Found!</p>

              </tr>
              <?php
                }
                ?>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>

    <!--scrolling content Modal -->
    <div class="modal fade" id="studentInformationModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body" id="studentModalContent">


          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <?php
    }elseif (isset($_GET['Lectures'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Lectures List
            </h5>
            <a href="add.php?Lectures"><button class="btn btn-primary">Add Lecture</button></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="float-end">
                <input type="text" class="search-box form-control" id="myInput" onkeyup="myFunction()"
                  placeholder="Search for names.." title="Type in a name">
              </div>
              <?php
                    $no = 1;
                    $select = mysqli_query($con, "SELECT * FROM lectures ORDER BY id DESC");
                    if(mysqli_num_rows($select) > 0){
                      ?>
              <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Watch ID</th>
                    <th>Title</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    while($row = mysqli_fetch_array($select)){
                      ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$row['watch_id']?></td>
                    <td><?=$row['title']?></td>
                    <td><a href="add.php?Update-Lecture=<?=$row['id']?>"><button class="badge bg-primary border-0"
                          value="<?=$row['id']?>">Edit</button></a>
                    </td>
                    <td><button class="badge bg-danger border-0 deleteLectureBtn"
                        value="<?=$row['id']?>">Delete</button>
                    </td>
                  </tr>
                  <?php
                     $no++;
                    }
                    ?>
              </table>
              <?php
                    }else{
                     ?>
              <tr>

                <p class="alert alert-danger"> No Result Found!</p>

              </tr>
              <?php 
                    }
                    ?>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>


    <?php
    }elseif (isset($_GET['True-False'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              True False Question List
            </h5>
            <a href="add.php?True-False-Question"><button class="btn btn-primary">Add True False</button></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="float-end">
                <input type="text" class="search-box form-control" id="myInput" onkeyup="myFunction()"
                  placeholder="Search for names.." title="Type in a name">
              </div>
              <?php
                  $no = 0;
                  $select = mysqli_query($con, "SELECT * FROM true_false_question ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                    ?>
              <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Questions</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                while($row = mysqli_fetch_array($select)){
                  $no ++;
                  ?>
                  <tr>
                    <td><?=$no;?></td>
                    <td><?=$row['question']?></td>
                    <td><a href="add.php?Update-True-False=<?=$row['id']?>"><span
                          class="badge bg-primary">Edit</span></a></td>
                    <td><button class="badge bg-danger border-0 deleteTrueFalseQuestionBtn"
                        value="<?=$row['id']?>">Delete</button></td>
                  </tr>
                  <?php
                    }
                  }else{
                    ?>
                  <tr>

                    <p class="alert alert-danger"> No Result Found!</p>

                  </tr>
                  <?php
                  }
                  ?>
              </table>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>
    <?php
    }else {
      ?>
    <div id="error">
      <div class="error-page container">
        <div class="col-md-6 col-12 offset-md-2">
          <div class="text-center">
            <img class="img-error" src="./assets/compiled/svg/error-404.svg" alt="Not Found">
            <h1 class="error-title">NOT FOUND</h1>
            <p class='fs-5 text-gray-600'>The page you are looking not found.</p>
            <button onclick="history.back()" class="btn btn-lg btn-outline-primary mt-3">Go Home</button>
          </div>
        </div>
      </div>
    </div>
    <?php
    } ?>

    <?php include 'includes/footer.php'; ?>
  </div>
  </div>
  <script src="assets/static/js/components/dark.js"></script>
  <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="assets/compiled/js/app.js"></script>
  <script src="assets/extensions/jquery/jquery.min.js"></script>
  <script src="assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/static/js/pages/datatables.js"></script>
  <script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>
  <script src="js/sweetalert.js"></script>
  <?php
  if (isset($_SESSION['message'])) {
    ?>
  <script>
  callSuccess();
  </script>
  <?php
  unset($_SESSION['message']);
  }

  if (isset($_SESSION['error'])) {
    ?>
  <script>
  Swal2.fire({
    icon: "error",
    title: "Failed",
  }).then(() => {
    location.replace("<?=$_SESSION['replace_url']?>");
  });
  </script>
  <?php
  unset($_SESSION['error']);
  }

  if (isset($_SESSION['warning'])) {
    ?>
  <script>
  Swal2.fire({
    icon: "warning",
    title: "<?=$_SESSION['warning'];?>",
  }).then(() => {
    location.replace("<?=$_SESSION['replace_url']?>");
  });
  </script>
  <?php
  unset($_SESSION['warning']);
  unset($_SESSION['replace_url']);
  }
  
  // mcq question 
  if (isset($_SESSION['mcq_message'])) {
    ?>
  <script>
  Swal2.fire({
    icon: "success",
    title: "Added Successfully!",
  }).then(() => {
    location.replace("add.php?Questions");
  });
  </script>
  <?php
  unset($_SESSION['mcq_message']);
  }

  // password Change Modal
  if(isset($_SESSION['passwordMessage'])){
    ?>
  <script>
  Swal2.fire({
    icon: "success",
    title: "Password changed Successfully!",
  }).then(() => {
    location.replace("add.php?Change-Password");
  });
  </script>
  <?php
    unset($_SESSION['passwordMessage']);
  }

  ?>
  <script src="js/script.js"></script>
  <script>
  function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[2];
      td1 = tr[i].getElementsByTagName("td")[1];
      if (td) {
        txtValue = td.textContent || td.innerText;
        txtValue1 = td1.textContent || td1.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1 || txtValue1.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
  </script>
</body>

</html>