<?php
   include './includes/login_required.php';
   include 'includes/dbcon.php';
   include 'includes/code.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php'; ?>
</head>

<body>
  <?php include 'includes/nav.php'; ?>
  <div id="main">
    <header class="mb-3">
      <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
      </a>
    </header>

    <?php
    if (isset($_GET['Exam'])) {
      ?>
    <div class="page-heading">

      <!-- Basic Vertical form layout section start -->
      <section id="basic-vertical-layouts">
        <div class="row match-height">
          <div class="">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Add Exam</h4>
                <a href="add.php?Custom-Exam"><button class="btn btn-success">Add Custom Question</button></a>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data" class="form form-vertical">
                    <div class="form-body">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <label for="first-name-vertical">Exam Name <span>*</span></label>
                            <input type="text" id="first-name-vertical" class="form-control" name="exam_name"
                              placeholder="Exam Name" required>
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="first-name-vertical">Exam Type <span>*</span></label>
                            <select name="exam_type" id="" class="form-select">
                              <option value="1">Live Exam</option>
                              <option value="0">Practice Exam</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="first-name-vertical">Course Name<span>*</span></label>
                            <select name="course_name" id="" class="form-select">
                              <?php
                              $searchCourse = mysqli_query($con,"SELECT * FROM package WHERE status=1");
                              if(mysqli_num_rows($searchCourse) > 0){
                                while($courseRow = mysqli_fetch_array($searchCourse)){
                                  ?>
                              <option value="<?=$courseRow['package_id']?>"><?=$courseRow['name']?></option>
                              <?php
                                }
                              }else{
                                ?>
                              <option disabled selected>No courses found.</option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-12">
                          <label for="short-description-id-vertical">Duration*</label>
                          <div class="d-flex my-2">
                            <div class="col-1">
                              <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                name="duration_hour" required>
                                <option value="">Hours</option>
                                <?php
                              for ($i=0; $i <= 12; $i++) { 
                                ?>
                                <option value="<?=$i;?>"><?=$i;?></option>
                                <?php
                              }
                              ?>

                              </select> <br>
                            </div>
                            <div class="col-1 mx-2">
                              <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                name="duration_minute" required>
                                <option value="">Minutes</option>
                                <?php
                              for ($i=0; $i <= 59; $i++) { 
                                ?>
                                <option value="<?=$i;?>"><?=$i;?></option>
                                <?php
                              }
                              ?>

                              </select> <br>

                            </div>
                            <div class="col-1 mx-2">
                              <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                name="duration_seconds" required>
                                <option value="">Seconds</option>
                                <?php
                              for ($i=0; $i <= 59; $i++) { 
                                ?>
                                <option value="<?=$i;?>"><?=$i;?></option>
                                <?php
                              }
                              ?>

                              </select> <br>

                            </div>
                          </div>
                          <label for="first-name-vertical">Exam Start Date And Time <span>*</span></label>
                          <div style="display:flex" class="my-1">

                            <div class="col-2">
                              <div class="form-group">
                                <label for="first-name-vertical">Date <span>*</span></label>
                                <input type="date" id="first-name-vertical" class="form-control" name="start_date"
                                  placeholder="Exam Name" required>
                              </div>
                            </div>

                            <div class="mx-2 col-2">
                              <div class="form-group">
                                <label for="first-name-vertical">Time <span>*</span></label>
                                <input type="time" id="first-name-vertical" class="form-control" name="start_time"
                                  placeholder="Exam Name" required>
                              </div>
                            </div>



                          </div>

                          <label for="first-name-vertical">Exam End Date And Time <span>*</span></label>
                          <div style="display:flex" class="my-1">
                            <div class="col-2">
                              <div class="form-group">
                                <label for="first-name-vertical">Date <span>*</span></label>
                                <input type="date" id="first-name-vertical" class="form-control" name="end_date"
                                  placeholder="Exam Name" required>
                              </div>
                            </div>

                            <div class="mx-2 col-2">
                              <div class="form-group">
                                <label for="first-name-vertical">Time <span>*</span></label>
                                <input type="time" id="first-name-vertical" class="form-control" name="end_time"
                                  placeholder="Exam Name" required>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="first-name-vertical">MCQ Marks <span>*</span></label>
                            <input type="number" step="any" id="first-name-vertical" class="form-control"
                              name="mcq_marks" placeholder="MCQ Marks" required>
                          </div>

                          <div class="form-group">
                            <label for="first-name-vertical">Negative Marks <span>*</span></label>
                            <input type="number" step="any" id="first-name-vertical" class="form-control"
                              name="negative_mark" placeholder="Negative Marks" required>
                          </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                          <button type="submit" name="submitExamBtn" class="btn btn-primary me-1 mb-1">Submit</button>
                          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
    <?php
    }elseif (isset($_GET['Questions'])) {
      ?>
    <div class="page-heading">

      <!-- Basic Vertical form layout section start -->
      <section id="basic-vertical-layouts">
        <div class="row match-height">
          <div class="">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Add Questions</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form class="form form-vertical" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                      <div class="row">

                        <div class="form-group col-12">
                          <label for="">Exam (Optional)</label>
                          <select class="form-select" aria-label=".form-select-sm example" name="exam_id">
                            <option value="">Select Exam</option>
                            <?php
                              $select = mysqli_query($con, "SELECT * FROM exam");
                              if(mysqli_num_rows($select) > 0){
                                while($row = mysqli_fetch_array($select)){
                                  ?>
                            <option value="<?=$row['exam_id']?>"><?=$row['exam_name']?></option>
                            <?php
                                }
                              }
                              ?>

                          </select>

                        </div>

                        <div class="form-group col-12">
                          <label for="">Subject*</label>
                          <select class="form-select" aria-label=".form-select-sm example" id="filterSubject"
                            name="subject_id">
                            <option value="">Select Subject</option>
                            <?php
                              $selectSubject = mysqli_query($con, "SELECT * FROM subjects");
                              if(mysqli_num_rows($selectSubject) > 0){
                                while($SubjectRow = mysqli_fetch_array($selectSubject)){
                                  ?>
                            <option value="<?=$SubjectRow['id']?>"><?=$SubjectRow['subject']?></option>
                            <?php
                                }
                              }
                              ?>

                          </select>

                        </div>


                        <div class="form-group col-12">
                          <label for="">Chapter*</label>
                          <select class="form-select" id="chapterBox" aria-label=".form-select-sm example"
                            name="chapter_id">
                            <option value="">Select Chapter</option>

                          </select>

                        </div>


                        <div class="form-group">
                          <label for="first-name-vertical">Marks <span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="marks"
                            placeholder="Ex: 1" required>
                        </div>

                        <div class="form-group">
                          <label for="first-name-vertical">Negative Marks <span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="negative_marks"
                            placeholder="Ex: 0.25" required>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                            <label for="question">Question <span>*</span></label>
                            <!-- Cke question -->
                            <textarea name="question" id="editor"></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="option_1">Option A <span>*</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_1" id="option_1"></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option B <span>*</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_2" id="option_2"></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option C <span>(Optional)</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_3" id="option_3"></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option D <span>(Optional)</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_4" id="option_4"></textarea>

                          </div>
                        </div>
                        <div class="col-11 m-3">
                          <button type="button" class="btn btn-warning" id="option5Hide">Add Option E</button>
                        </div>
                        <div class="col-11 mx-5" id="option5">
                          <div class="form-group">
                            <label for="editor">Option E <span>(Optional)</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_5" id="option_5"></textarea>

                          </div>
                        </div>


                        <div class="form-group col-3">
                          <label for="">Correct Answer*</label>
                          <select class="form-select" aria-label=".form-select-sm example" name="answer" required>
                            <option Value="">Select Correct Answer</option>
                            <option value="1">Option A</option>
                            <option value="2">Option B</option>
                            <option value="3">Option C</option>
                            <option value="4">Option D</option>
                            <option value="6">Option E</option>

                          </select>

                        </div>

                        <div class="col-12">
                          <div class="form-group">
                            <label for="question">Solution <span>(Optional)</span></label>
                            <!-- Cke question -->
                            <textarea name="solution" id="solution"></textarea>

                          </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                          <button type="submit" name="addQuestion" class="btn btn-primary me-1 mb-1">Add
                            Question</button>
                          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
    <?php
    }elseif (isset($_GET['Subjects'])) {
      ?>
    <div class="page-heading">

      <!-- Basic Vertical form layout section start -->
      <section id="basic-vertical-layouts">
        <div class="row match-height">
          <div class="">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Add Subjects</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form class="form form-vertical" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                      <div class="row">

                        <div class="form-group">
                          <label for="first-name-vertical">Subject Name<span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="subject"
                            placeholder="Physics" required>
                        </div>



                        <div class="col-12 d-flex justify-content-end">
                          <button type="submit" name="addNewSubject" class="btn btn-primary me-1 mb-1">Add
                            Subject</button>
                          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
    <?php
    }elseif (isset($_GET['Chapters'])) {
      ?>
    <div class="page-heading">

      <!-- Basic Vertical form layout section start -->
      <section id="basic-vertical-layouts">
        <div class="row match-height">
          <div class="">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Add Chapters</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form class="form form-vertical" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                      <div class="row">

                        <div class="form-group col-12">
                          <label for="">Subject*</label>
                          <select class="form-select" aria-label=".form-select-sm example" name="subject_id">
                            <option value="">Select Subject</option>
                            <?php
                              $selectSubject = mysqli_query($con, "SELECT * FROM subjects");
                              if(mysqli_num_rows($selectSubject) > 0){
                                while($SubjectRow = mysqli_fetch_array($selectSubject)){
                                  ?>
                            <option value="<?=$SubjectRow['id']?>"><?=$SubjectRow['subject']?></option>
                            <?php
                                }
                              }
                              ?>

                          </select>

                        </div>
                        <div class="form-group">
                          <label for="first-name-vertical">Chapter Name<span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="name"
                            placeholder="Chapter 1" required>
                        </div>



                        <div class="col-12 d-flex justify-content-end">
                          <button type="submit" name="addChapter" class="btn btn-primary me-1 mb-1">Add
                          </button>
                          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
    <?php
    }elseif (isset($_GET['Courses'])) {
     ?>
    <div class="page-heading">

      <!-- Basic Vertical form layout section start -->
      <section id="basic-vertical-layouts">
        <div class="row match-height">
          <div class="">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Add Courses</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form class="form form-vertical" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                      <div class="row">

                        <div class="form-group">
                          <label for="first-name-vertical">Course Name<span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="courseName"
                            placeholder="Name" required>
                        </div>
                        <div class="form-group">
                          <label for="first-name-vertical">Course Thumbnail<span>*</span></label>
                          <input type="file" id="first-name-vertical" class="form-control" name="routine" required>
                        </div>
                        <div class="form-group">
                          <label for="first-name-vertical">Description<span>*</span></label>
                          <!-- <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea> -->
                          <textarea name="description" id="editor"></textarea>
                        </div>

                        <div class="form-group">
                          <label for="first-name-vertical">Course Price<span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="price"
                            placeholder="IN BDT" required>
                        </div>
                        <div class="form-group">
                          <label for="first-name-vertical">Course Duration<span>*</span></label>
                          <select name="duration" class="form-select" id="">
                            <option value="43200" selected>30 days</option>
                            <option value="86400">60 days</option>
                            <option value="129600">90 days</option>
                          </select>
                        </div>
                        <div class="form-group col-3">
                          <label for="first-name-vertical">Expiry Date<span>*</span></label>
                          <input type="date" id="first-name-vertical" class="form-control" name="expiry_date"
                            placeholder="" required>
                        </div>


                        <div class="col-12 d-flex justify-content-end">
                          <button type="submit" name="addCourse" class="btn btn-primary me-1 mb-1">Add</button>
                          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
    <?php
    }elseif(isset($_GET['Update-Questions'])){
      $question_id = $_GET['Update-Questions'];
      ?>
    <div class="page-heading">

      <!-- Basic Vertical form layout section start -->
      <section id="basic-vertical-layouts">
        <div class="row match-height">
          <div class="">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Update Questions</h4>
              </div>
              <?php  
              $search = mysqli_query($con,"SELECT * FROM questions WHERE id='$question_id'");
              if(mysqli_num_rows($search) > 0){
                $result=mysqli_fetch_array($search);
                $question_exam_id = $result['exam_id'];
                $subject_id = $result['subject_id'];
                $chapter_id = $result['chapter_id'];
                
                ?>
              <div class="card-content">
                <div class="card-body">
                  <form class="form form-vertical" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                      <div class="row">
                        <input type="hidden" value="<?=$question_id?>" name="questionID">
                        <div class="form-group col-12">
                          <label for="">Exam (Optional)</label>
                          <select class="form-select" aria-label=".form-select-sm example" name="exam_id">
                            <option value="">No Exam</option>
                            <?php 
                             $searchExamName = mysqli_query($con,"SELECT * FROM exam WHERE exam_id='$question_exam_id'");
                             if(mysqli_num_rows($searchExamName) > 0){
                              $examNameResult = mysqli_fetch_array($searchExamName);
                              ?>
                            <option value="<?=$examNameResult['exam_id'];?>" selected>
                              <?=$examNameResult['exam_name'];?></option>
                            <?php
                             }
                            ?>

                            <?php
                        $select = mysqli_query($con, "SELECT * FROM exam");
                        if(mysqli_num_rows($select) > 0){
                          while($row = mysqli_fetch_array($select)){
                            ?>
                            <option value="<?=$row['exam_id']?>"><?=$row['exam_name']?></option>
                            <?php
                          }
                        }
                        ?>

                          </select>

                        </div>



                        <div class="form-group col-12">
                          <label for="">Subject*</label>
                          <select class="form-select" aria-label=".form-select-sm example" id="filterSubject"
                            name="subject_id">
                            <?php 
                             $searchSubjectName = mysqli_query($con,"SELECT * FROM subjects WHERE id='$subject_id'");
                             if(mysqli_num_rows($searchSubjectName) > 0){
                              $subjectNameResult = mysqli_fetch_array($searchSubjectName);
                              ?>
                            <option value="<?=$subjectNameResult['id'];?>" selected>
                              <?=$subjectNameResult['subject'];?></option>
                            <?php
                             }else{
                              ?>
                            <option value="">Not selected Yet</option>
                            <?php
                             }
                            ?>

                            <?php
                        $subjectSelect = mysqli_query($con, "SELECT * FROM subjects");
                        if(mysqli_num_rows($subjectSelect) > 0){
                          while($subjectRow = mysqli_fetch_array($subjectSelect)){
                            ?>
                            <option value="<?=$subjectRow['id']?>"><?=$subjectRow['subject']?></option>
                            <?php
                          }
                        }
                        ?>

                          </select>

                        </div>

                        <div class="form-group col-12">
                          <label for="">Chapter*</label>
                          <select class="form-select" id="chapterBox" aria-label=".form-select-sm example"
                            name="chapter_id">
                            <?php 
                             $searchChapter = mysqli_query($con,"SELECT * FROM chapter WHERE id='$chapter_id'");
                             if(mysqli_num_rows($searchChapter) > 0){
                              $chapterNameRes = mysqli_fetch_array($searchChapter);
                              ?>
                            <option value="<?=$chapterNameRes['id'];?>" selected>
                              <?=$chapterNameRes['name'];?></option>
                            <?php
                             }else{
                              ?>
                            <option value="">Not selected Yet</option>
                            <?php
                             }
                            ?>

                          </select>

                        </div>


                        <div class="form-group">
                          <label for="first-name-vertical">Marks <span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="marks"
                            placeholder="Ex: 1" value="<?=$result['mark']?>" required>
                        </div>

                        <div class="form-group">
                          <label for="first-name-vertical">Negative Marks <span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="negative_marks"
                            placeholder="Ex: 0.25" value="<?=$result['negative_mark']?>" required>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                            <label for="question">Question <span>*</span></label>
                            <!-- Cke question -->
                            <textarea name="question" id="editor"><?=$result['question']?></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="option_1">Option A <span>*</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_1" id="option_1"><?=$result['option_1']?></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option B <span>*</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_2" id="option_2"><?=$result['option_2']?></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option C <span>(Optional)</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_3" id="option_3"><?=$result['option_3']?></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option D <span>(Optional)</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_4" id="option_4"><?=$result['option_4']?></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option E <span>(Optional)</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_5" id="option_5"><?=$result['option_5']?></textarea>

                          </div>
                        </div>


                        <div class="form-group col-3">
                          <label for="">Correct Answer*</label>
                          <select class="form-select" aria-label=".form-select-sm example" name="answer" required>
                            <option Value="" disabled>Select Correct Answer</option>
                            <?php
                            if($result['answer'] == 1){
                              ?>
                            <option value="1" selected>Option A</option>
                            <option value="2">Option B</option>
                            <option value="3">Option C</option>
                            <option value="4">Option D</option>
                            <option value="6">Option E</option>
                            <?php
                            }elseif($result['answer'] == 2){
                              ?>
                            <option value="1">Option A</option>
                            <option value="2" selected>Option B</option>
                            <option value="3">Option C</option>
                            <option value="4">Option D</option>
                            <option value="6">Option E</option>
                            <?php
                            }elseif($result['answer'] == 3){
                              ?>
                            <option value="1">Option A</option>
                            <option value="2">Option B</option>
                            <option value="3" selected>Option C</option>
                            <option value="4">Option D</option>
                            <option value="6">Option E</option>
                            <?php
                            }elseif($result['answer'] == 4){
                              ?>
                            <option value="1">Option A</option>
                            <option value="2">Option B</option>
                            <option value="3">Option C</option>
                            <option value="4" selected>Option D</option>
                            <option value="6">Option E</option>
                            <?php
                            }elseif($result['answer'] == 6){
                              ?>
                            <option value="1">Option A</option>
                            <option value="2">Option B</option>
                            <option value="3">Option C</option>
                            <option value="4">Option D</option>
                            <option value="6" selected>Option E</option>
                            <?php
                            }
                            ?>

                          </select>

                        </div>

                        <div class="col-12">
                          <div class="form-group">
                            <label for="question">Solution <span>(Optional)</span></label>
                            <!-- Cke question -->
                            <textarea name="solution" id="solution"><?=$result['solution']?></textarea>

                          </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                          <button type="submit" name="updateQuestion" class="btn btn-primary me-1 mb-1">Update
                            Question</button>
                          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <?php
              }
              ?>

            </div>
          </div>

        </div>
    </div>
    <?php
    }elseif (isset($_GET['Custom-Exam'])) {
      ?>
    <div class="page-heading">

      <!-- Basic Vertical form layout section start -->
      <section id="basic-vertical-layouts">
        <div class="row match-height">
          <div class="">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Add Custom Exam</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data" class="form form-vertical">
                    <div class="form-body">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <label for="first-name-vertical">Exam Name <span>*</span></label>
                            <input type="text" id="first-name-vertical" class="form-control" name="exam_name"
                              placeholder="Exam Name" required>
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="first-name-vertical">Exam Type <span>*</span></label>
                            <select name="exam_type" id="" class="form-select">
                              <option value="1">Live Exam</option>
                              <option value="0">Practice Exam</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="first-name-vertical">Course Name<span>*</span></label>
                            <select name="course_name" id="" class="form-select">
                              <?php
                              $searchCourse = mysqli_query($con,"SELECT * FROM package WHERE status=1");
                              if(mysqli_num_rows($searchCourse) > 0){
                                while($courseRow = mysqli_fetch_array($searchCourse)){
                                  ?>
                              <option value="<?=$courseRow['package_id']?>"><?=$courseRow['name']?></option>
                              <?php
                                }
                              }else{
                                ?>
                              <option disabled selected>No courses found.</option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-12">
                          <label for="short-description-id-vertical">Duration*</label>
                          <div class="d-flex my-2">
                            <div class="col-1">
                              <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                name="duration_hour" required>
                                <option value="">Hours</option>
                                <?php
                                for ($i=0; $i <= 12; $i++) { 
                                  ?>
                                <option value="<?=$i;?>"><?=$i;?></option>
                                <?php
                                }
                                ?>

                              </select> <br>
                            </div>
                            <div class="col-1 mx-2">
                              <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                name="duration_minute" required>
                                <option value="">Minutes</option>
                                <?php
                                for ($i=0; $i <= 59; $i++) { 
                                  ?>
                                <option value="<?=$i;?>"><?=$i;?></option>
                                <?php
                                }
                                ?>

                              </select> <br>

                            </div>
                            <div class="col-1 mx-2">
                              <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                name="duration_seconds" required>
                                <option value="">Seconds</option>
                                <?php
                                for ($i=0; $i <= 59; $i++) { 
                                  ?>
                                <option value="<?=$i;?>"><?=$i;?></option>
                                <?php
                                }
                                ?>

                              </select> <br>

                            </div>
                          </div>
                          <label for="first-name-vertical">Exam Start Date And Time <span>*</span></label>
                          <div style="display:flex" class="my-1">

                            <div class="col-2">
                              <div class="form-group">
                                <label for="first-name-vertical">Date <span>*</span></label>
                                <input type="date" id="first-name-vertical" class="form-control" name="start_date"
                                  placeholder="Exam Name" required>
                              </div>
                            </div>

                            <div class="mx-2 col-2">
                              <div class="form-group">
                                <label for="first-name-vertical">Time <span>*</span></label>
                                <input type="time" id="first-name-vertical" class="form-control" name="start_time"
                                  placeholder="Exam Name" required>
                              </div>
                            </div>



                          </div>

                          <label for="first-name-vertical">Exam End Date And Time <span>*</span></label>
                          <div style="display:flex" class="my-1">
                            <div class="col-2">
                              <div class="form-group">
                                <label for="first-name-vertical">Date <span>*</span></label>
                                <input type="date" id="first-name-vertical" class="form-control" name="end_date"
                                  placeholder="Exam Name" required>
                              </div>
                            </div>

                            <div class="mx-2 col-2">
                              <div class="form-group">
                                <label for="first-name-vertical">Time <span>*</span></label>
                                <input type="time" id="first-name-vertical" class="form-control" name="end_time"
                                  placeholder="Exam Name" required>
                              </div>
                            </div>
                          </div>

                          <label for="">Question Distribution*</label>
                          <div class="" style="display:flex; flex-wrap:wrap;">
                            <?php 
                              $searchSubject = mysqli_query($con, "SELECT * FROM subjects");
                              if(mysqli_num_rows($searchSubject) > 0){
                                while($subjectResult = mysqli_fetch_array($searchSubject)){
                                  ?>
                            <div class="mx-2 col-2">
                              <div class="form-group">
                                <label for="first-name-vertical"><?=$subjectResult['subject']?></label>
                                <input type="number" id="first-name-vertical" class="form-control"
                                  name="<?=$subjectResult['id']?>" placeholder="Ex- 25" value="0">
                                <br>
                                <input class="form-check-input showTrueFalseMark" type="checkbox"
                                  name="trueFalse<?=$subjectResult['id']?>" value="" id="flexCheckDefault">
                                <label for="">True False</label>

                                <input type="number" id="first-name-vertical" class="form-control mt-1"
                                  name="limTrue<?=$subjectResult['id']?>" placeholder="Ex- 25" value="0">


                                <?php
                                $chapterBox = mysqli_query($con,"SELECT * FROM chapter WHERE subject_id='".$subjectResult['id']."'");
                                if(mysqli_num_rows($chapterBox) > 0){
                                  while($chapterRow = mysqli_fetch_array($chapterBox)){
                                    ?>
                                <br>
                                <input class="form-check-input" type="checkbox"
                                  name="<?=$subjectResult['id']?>chapter[]" value="<?=$chapterRow['id']?>"
                                  id="flexCheckDefault">
                                <label class="mx-1" for=""><?=$chapterRow['name']?></label>

                                <?php
                                  }
                                }
                                
                                ?>




                              </div>
                            </div>
                            <?php
                                }
                              }
                              ?>


                          </div>

                          <div id="trueFalse" style="display:none;">
                            <div class="mx-2 col-6">
                              <div class="form-group">
                                <label for="">Marks per Option</label>
                                <input type="text" name="marksPerOption" type="any" class="form-control"
                                  placeholder="marks per option">
                              </div>
                            </div>
                            <div class="mx-2 col-6">
                              <div class="form-group">
                                <label for="">Negative Marks per Option</label>
                                <input type="text" name="negMarksPerOption" class="form-control"
                                  placeholder="marks per option">
                              </div>
                            </div>

                            <div class="mx-2 col-6">
                              <div class="form-group">
                                <span id="hideBtnTrue" class="btn btn-danger">Close</span>
                              </div>
                            </div>


                          </div>


                          <div class="mx-2 col-6">
                            <div class="form-group">
                              <label for="first-name-vertical">Marks per question <span>*</span></label>
                              <input type="number" step="any" id="first-name-vertical" class="form-control" name="marks"
                                placeholder="marks per question" required>
                            </div>
                          </div>
                        </div>
                        <div class="mx-2 col-6">
                          <div class="form-group">
                            <label for="first-name-vertical">Negative mark<span>*</span></label>
                            <input type="number" step="any" id="first-name-vertical" class="form-control"
                              name="negative_marks" placeholder="Negative marks per question" required>
                          </div>
                        </div>
                      </div>



                      <div class="col-12 d-flex justify-content-end">
                        <button type="submit" name="submitCustomExam" class="btn btn-primary me-1 mb-1">Submit</button>
                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                      </div>
                    </div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>

    </div>
  </div>
  <?php
    }elseif(isset($_GET['True-False'])){
      ?>
  <div class="page-heading">

    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts">
      <div class="row match-height">
        <div class="">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Add True False Exam</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data" class="form form-vertical">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Exam Name <span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="exam_name"
                            placeholder="Exam Name" required>
                        </div>
                      </div>


                      <div class="col-4">
                        <div class="form-group">
                          <label for="first-name-vertical">Course Name<span>*</span></label>
                          <select name="course_name" id="" class="form-select">
                            <?php
                              $searchCourse = mysqli_query($con,"SELECT * FROM package WHERE status=1");
                              if(mysqli_num_rows($searchCourse) > 0){
                                while($courseRow = mysqli_fetch_array($searchCourse)){
                                  ?>
                            <option value="<?=$courseRow['package_id']?>"><?=$courseRow['name']?></option>
                            <?php
                                }
                              }else{
                                ?>
                            <option disabled selected>No courses found.</option>
                            <?php
                              }
                              ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-12">
                        <label for="short-description-id-vertical">Duration*</label>
                        <div class="d-flex my-2">
                          <div class="col-1">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                              name="duration_hour" required>
                              <option value="">Hours</option>
                              <?php
                                for ($i=0; $i <= 12; $i++) { 
                                  ?>
                              <option value="<?=$i;?>"><?=$i;?></option>
                              <?php
                                }
                                ?>

                            </select> <br>
                          </div>
                          <div class="col-1 mx-2">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                              name="duration_minute" required>
                              <option value="">Minutes</option>
                              <?php
                                for ($i=0; $i <= 59; $i++) { 
                                  ?>
                              <option value="<?=$i;?>"><?=$i;?></option>
                              <?php
                                }
                                ?>

                            </select> <br>

                          </div>
                          <div class="col-1 mx-2">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                              name="duration_seconds" required>
                              <option value="">Seconds</option>
                              <?php
                                for ($i=0; $i <= 59; $i++) { 
                                  ?>
                              <option value="<?=$i;?>"><?=$i;?></option>
                              <?php
                                }
                                ?>

                            </select> <br>

                          </div>
                        </div>
                        <label for="first-name-vertical">Exam Start Date And Time <span>*</span></label>
                        <div style="display:flex" class="my-1">

                          <div class="col-2">
                            <div class="form-group">
                              <label for="first-name-vertical">Date <span>*</span></label>
                              <input type="date" id="first-name-vertical" class="form-control" name="start_date"
                                placeholder="Exam Name" required>
                            </div>
                          </div>

                          <div class="mx-2 col-2">
                            <div class="form-group">
                              <label for="first-name-vertical">Time <span>*</span></label>
                              <input type="time" id="first-name-vertical" class="form-control" name="start_time"
                                placeholder="Exam Name" required>
                            </div>
                          </div>



                        </div>

                        <label for="first-name-vertical">Exam End Date And Time <span>*</span></label>
                        <div style="display:flex" class="my-1">
                          <div class="col-2">
                            <div class="form-group">
                              <label for="first-name-vertical">Date <span>*</span></label>
                              <input type="date" id="first-name-vertical" class="form-control" name="end_date"
                                placeholder="Exam Name" required>
                            </div>
                          </div>

                          <div class="mx-2 col-2">
                            <div class="form-group">
                              <label for="first-name-vertical">Time <span>*</span></label>
                              <input type="time" id="first-name-vertical" class="form-control" name="end_time"
                                placeholder="Exam Name" required>
                            </div>
                          </div>
                        </div>

                        <label for="">Question Distribution*</label>
                        <div class="" style="display:flex; flex-wrap:wrap;">
                          <?php 
                              $searchSubject = mysqli_query($con, "SELECT * FROM subjects");
                              if(mysqli_num_rows($searchSubject) > 0){
                                while($subjectResult = mysqli_fetch_array($searchSubject)){
                                  ?>
                          <div class="mx-2 col-2">
                            <div class="form-group">
                              <label for="first-name-vertical"><?=$subjectResult['subject']?></label>
                              <input type="number" id="first-name-vertical" class="form-control"
                                name="<?=$subjectResult['id']?>" placeholder="Ex- 25" value="0">
                              <?php
                                $chapterBox = mysqli_query($con,"SELECT * FROM chapter WHERE subject_id='".$subjectResult['id']."'");
                                if(mysqli_num_rows($chapterBox) > 0){
                                  while($chapterRow = mysqli_fetch_array($chapterBox)){
                                    ?>
                              <br>
                              <input class="form-check-input" type="checkbox" name="chapter[]"
                                value="<?=$chapterRow['id']?>" id="flexCheckDefault">
                              <label class="mx-1" for=""><?=$chapterRow['name']?></label>

                              <?php
                                  }
                                }
                                
                                ?>




                            </div>
                          </div>
                          <?php
                                }
                              }
                              ?>


                        </div>

                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Marks per Option <span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="marks_per_option"
                            placeholder="Ex- 0.4" required>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Negative Marks per Option <span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control"
                            name="negative_marks_per_option" placeholder="Ex- 0" required>
                        </div>
                      </div>


                      <div class="col-12 d-flex justify-content-end">
                        <button type="submit" name="submitTrueFalse" class="btn btn-primary me-1 mb-1">Submit</button>
                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
  </div>
  <?php
    }elseif (isset($_GET['Change-Password'])) {
      ?>
  <div class="page-heading">

    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts">
      <div class="row match-height">
        <div class="">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Change Password</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data" class="form form-vertical">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Old Password<span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="old_password"
                            placeholder="" required>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">New Password<span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="new_password"
                            placeholder="" required>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Confirm Password<span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="confirm_password"
                            placeholder="" required>
                        </div>
                      </div>

                    </div>



                    <div class="col-12 d-flex justify-content-end">
                      <button type="submit" name="changePassword" class="btn btn-primary me-1 mb-1">Change</button>
                      <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                    </div>
                  </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>

  </div>
  </div>
  <?php
    }elseif(isset($_GET['Lectures'])){
      ?>
  <div class="page-heading">

    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts">
      <div class="row match-height">
        <div class="">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Add Lecture</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data" class="form form-vertical">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Title<span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="title"
                            placeholder="Type Title" required>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Src<span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="src"
                            placeholder="Src link" required>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Course<span>*</span></label>
                          <select name="course" class="form-select">
                            <option value="">Select Course</option>
                            <?php 
                            $searchCourse = mysqli_query($con, "SELECT * FROM package WHERE status=1");
                            if(mysqli_num_rows($searchCourse) > 0){
                              while($row = mysqli_fetch_array($searchCourse)){
                                ?>
                            <option value="<?=$row['package_id']?>"><?=$row['name']?></option>
                            <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Subject<span>*</span></label>
                          <select name="subject" class="form-select">
                            <option value="">Select Subject</option>
                            <?php 
                            $searchSubjects = mysqli_query($con, "SELECT * FROM subjects");
                            if(mysqli_num_rows($searchSubjects) > 0){
                              while($res = mysqli_fetch_array($searchSubjects)){
                                ?>
                            <option value="<?=$res['id']?>"><?=$res['subject']?></option>
                            <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Add Lecture Sheet<span></span></label>
                          <input type="file" id="first-name-vertical" class="form-control" name="lectureSheet">
                        </div>
                      </div>

                    </div>



                    <div class="col-12 d-flex justify-content-end">
                      <button type="submit" name="addLecture" class="btn btn-primary me-1 mb-1">Add</button>
                      <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                    </div>
                  </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>

  </div>
  </div>
  <?php
    }elseif (isset($_GET['Update-Lecture'])) {
      $id = $_GET['Update-Lecture'];
      $search = mysqli_query($con, "SELECT * FROM lectures WHERE id='$id'");
      if(mysqli_num_rows($search) > 0){
        $fetch = mysqli_fetch_array($search);
        $package_id=$fetch['course_id'];
        $subject_id=$fetch['subject_id'];
        $chapter_id=$fetch['chapter_id'];
        ?>
  <div class="page-heading">

    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts">
      <div class="row match-height">
        <div class="">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Update Lecture</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data" class="form form-vertical">
                  <input type="hidden" name="id" value="<?=$fetch['id']?>" id="">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Title<span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="title"
                            placeholder="Type Title" value="<?=$fetch['title']?>" required>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Src<span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="src"
                            placeholder="Src link" value="<?=$fetch['src']?>" required>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Course<span>*</span></label>
                          <select name="course" class="form-select">
                            <?php 
                            $fetchCourse = mysqli_query($con, "SELECT * FROM package WHERE package_id='$package_id'");
                            if(mysqli_num_rows($fetchCourse) > 0){
                              $courseRes = mysqli_fetch_array($fetchCourse);
                              ?>
                            <option value="<?=$package_id?>" selected><?=$courseRes['name']?></option>
                            <?php
                            }
                                $searchCourse = mysqli_query($con, "SELECT * FROM package WHERE status=1");
                                if(mysqli_num_rows($searchCourse) > 0){
                                  while($row = mysqli_fetch_array($searchCourse)){
                                    ?>
                            <option value="<?=$row['package_id']?>"><?=$row['name']?></option>
                            <?php
                                  }
                                }
                                ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Subject<span>*</span></label>
                          <select name="subject" class="form-select">
                            <option value="">Select Subject</option>
                            <?php 
                            $fetchSubject = mysqli_query($con, "SELECT * FROM subjects WHERE id='$subject_id'");
                            if(mysqli_num_rows($fetchSubject) > 0){
                              $subjectRes = mysqli_fetch_array($fetchSubject);
                              ?>
                            <option value="<?=$subject_id?>" selected><?=$subjectRes['subject']?></option>
                            <?php
                            }
                                $searchSubjects = mysqli_query($con, "SELECT * FROM subjects");
                                if(mysqli_num_rows($searchSubjects) > 0){
                                  while($res = mysqli_fetch_array($searchSubjects)){
                                    ?>
                            <option value="<?=$res['id']?>"><?=$res['subject']?></option>
                            <?php
                                  }
                                }
                                ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Chapter<span>*</span></label>
                          <select name="chapter" class="form-select">
                            <option value="">Select Chapter</option>
                            <?php 
                            $fetchChapter = mysqli_query($con, "SELECT * FROM chapter WHERE id='$chapter_id'");
                            if(mysqli_num_rows($fetchChapter) > 0){
                              $chapterRes = mysqli_fetch_array($fetchChapter);
                              ?>
                            <option value="<?=$chapter_id?>" selected><?=$chapterRes['name']?></option>
                            <?php
                            }
                                $searchChapter = mysqli_query($con, "SELECT * FROM chapter");
                                if(mysqli_num_rows($searchChapter) > 0){
                                  while($result = mysqli_fetch_array($searchChapter)){
                                    ?>
                            <option value="<?=$result['id']?>"><?=$result['name']?></option>
                            <?php
                                  }
                                }
                                ?>
                          </select>
                        </div>
                      </div>

                      <?php 
                      if($fetch['lectureSheet'] == NULL){
                        ?>
                      <label for="first-name-vertical" class="text-warning">Add Lecture Sheet<span></span></label>
                      <?php
                      }else{
                        ?>
                      <label for="first-name-vertical" class="text-success">Update Lecture
                        Sheet<span></span></label>
                      <?php
                      }
                      ?>
                      <div class="col-12">
                        <div class="form-group">

                          <input type="file" id="first-name-vertical" class="form-control" name="lectureSheet">
                        </div>
                      </div>

                    </div>



                    <div class="col-12 d-flex justify-content-end">
                      <button type="submit" name="updateLecture" class="btn btn-primary me-1 mb-1">Update</button>
                      <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                    </div>
                  </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>

  </div>
  <?php
  }
  ?>
  </div>
  <?php
    }elseif (isset($_GET['updateRoutine'])) {
      $id = $_GET['updateRoutine'];
      $search = mysqli_query($con, "SELECT * FROM package WHERE package_id='$id'");
      if(mysqli_num_rows($search) > 0){
        $fetch = mysqli_fetch_array($search);
        $course = $fetch['name'];
        ?>
  <div class="page-heading">

    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts">
      <div class="row match-height">
        <div class="">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Update Routine</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data" class="form form-vertical">
                  <input type="hidden" name="id" value="<?=$fetch['id']?>" id="">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical"><?=$course?></label>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="first-name-vertical">Routine</label>
                          <input type="file" class="form-control" name="routine" value="" id=""> <br>
                          <img src="<?=$fetch['routine']?>" height="180" width="180" alt="">
                        </div>
                      </div>

                    </div>



                    <div class="col-12 d-flex justify-content-end">
                      <button type="submit" name="updateRoutine" class="btn btn-primary me-1 mb-1">Update</button>
                      <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                    </div>
                  </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>

  </div>
  <?php
  }
  ?>
  </div>
  <?php
    }elseif (isset($_GET['True-False-Question'])) {
      ?>
  <div class="page-heading">

    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts">
      <div class="row match-height">
        <div class="">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Add True False Questions</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                <form class="form form-vertical" action="" method="POST" enctype="multipart/form-data">
                  <div class="form-body">
                    <div class="row">
                      <div class="form-group col-12">
                        <label for="">Subject*</label>
                        <select class="form-select" aria-label=".form-select-sm example" id="filterSubject"
                          name="subject_id">
                          <option value="">Select Subject</option>
                          <?php
                              $selectSubject = mysqli_query($con, "SELECT * FROM subjects");
                              if(mysqli_num_rows($selectSubject) > 0){
                                while($SubjectRow = mysqli_fetch_array($selectSubject)){
                                  ?>
                          <option value="<?=$SubjectRow['id']?>"><?=$SubjectRow['subject']?></option>
                          <?php
                                }
                              }
                              ?>

                        </select>

                      </div>


                      <div class="form-group col-12">
                        <label for="">Chapter*</label>
                        <select class="form-select" id="chapterBox" aria-label=".form-select-sm example"
                          name="chapter_id">
                          <option value="">Select Chapter</option>

                        </select>

                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="question">Question <span>*</span></label>
                          <!-- Cke question -->
                          <textarea name="question" id="editor"></textarea>

                        </div>
                      </div>

                      <div class="col-11 mx-5">
                        <div class="form-group">
                          <label for="option_1">Option A <span>*</span></label>
                          <!-- Cke Editor -->
                          <textarea name="option_1" id="option_1"></textarea>

                        </div>
                      </div>
                      <div class="form-group col-3 mx-5">
                        <label for="">True Or False*</label>
                        <select class="form-select" aria-label=".form-select-sm example" name="answer_1" required>
                          <option Value="">Select True Or False</option>
                          <option value="1">True</option>
                          <option value="0">False</option>

                        </select>

                      </div>

                      <div class="col-11 mx-5">
                        <div class="form-group">
                          <label for="editor">Option B <span>*</span></label>
                          <!-- Cke Editor -->
                          <textarea name="option_2" id="option_2"></textarea>

                        </div>
                      </div>
                      <div class="form-group col-3 mx-5">
                        <label for="">True Or False*</label>
                        <select class="form-select" aria-label=".form-select-sm example" name="answer_2" required>
                          <option Value="">Select True Or False</option>
                          <option value="1">True</option>
                          <option value="0">False</option>

                        </select>

                      </div>

                      <div class="col-11 mx-5">
                        <div class="form-group">
                          <label for="editor">Option C <span>*</span></label>
                          <!-- Cke Editor -->
                          <textarea name="option_3" id="option_3"></textarea>

                        </div>
                      </div>
                      <div class="form-group col-3 mx-5">
                        <label for="">True Or False*</label>
                        <select class="form-select" aria-label=".form-select-sm example" name="answer_3" required>
                          <option Value="">Select True Or False</option>
                          <option value="1">True</option>
                          <option value="0">False</option>

                        </select>

                      </div>

                      <div class="col-11 mx-5">
                        <div class="form-group">
                          <label for="editor">Option D <span>*</span></label>
                          <!-- Cke Editor -->
                          <textarea name="option_4" id="option_4"></textarea>

                        </div>
                      </div>
                      <div class="form-group col-3 mx-5">
                        <label for="">True Or False*</label>
                        <select class="form-select" aria-label=".form-select-sm example" name="answer_4" required>
                          <option Value="">Select True Or False</option>
                          <option value="1">True</option>
                          <option value="0">False</option>

                        </select>

                      </div>

                      <div class="col-11 mx-5">
                        <div class="form-group">
                          <label for="editor">Option E <span>*</span></label>
                          <!-- Cke Editor -->
                          <textarea name="option_5" id="option_5"></textarea>

                        </div>
                      </div>
                      <div class="form-group col-3 mx-5">
                        <label for="">True Or False*</label>
                        <select class="form-select" aria-label=".form-select-sm example" name="answer_5" required>
                          <option Value="">Select True Or False</option>
                          <option value="1">True</option>
                          <option value="0">False</option>

                        </select>

                      </div>

                      <div class="col-12 d-flex justify-content-end">
                        <button type="submit" name="addTrueFalse" class="btn btn-primary me-1 mb-1">Add
                          Question</button>
                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
  </div>
  <?php
    }elseif (isset($_GET['Update-True-False'])) {
      $question_id = $_GET['Update-True-False'];
      $select = mysqli_query($con, "SELECT * FROM true_false_question WHERE id='$question_id'");
      if(mysqli_num_rows($select) > 0){
        $result=mysqli_fetch_array($select);
        $subject_id = $result['subject_id'];
        $chapter_id = $result['chapter_id'];
        ?>
  <div class="page-heading">

    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts">
      <div class="row match-height">
        <div class="">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Add True False Questions</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                <form class="form form-vertical" action="" method="POST" enctype="multipart/form-data">
                  <input type="hidden" value="<?=$question_id?>" name="id">
                  <div class="form-body">
                    <div class="row">

                      <div class="form-group col-12">
                        <label for="">Subject*</label>
                        <select class="form-select" aria-label=".form-select-sm example" id="filterSubject"
                          name="subject_id">
                          <?php 
                             $searchSubjectName = mysqli_query($con,"SELECT * FROM subjects WHERE id='$subject_id'");
                             if(mysqli_num_rows($searchSubjectName) > 0){
                              $subjectNameResult = mysqli_fetch_array($searchSubjectName);
                              ?>
                          <option value="<?=$subjectNameResult['id'];?>" selected>
                            <?=$subjectNameResult['subject'];?></option>
                          <?php
                             }else{
                              ?>
                          <option value="">Not selected Yet</option>
                          <?php
                             }
                            ?>

                          <?php
                        $subjectSelect = mysqli_query($con, "SELECT * FROM subjects");
                        if(mysqli_num_rows($subjectSelect) > 0){
                          while($subjectRow = mysqli_fetch_array($subjectSelect)){
                            ?>
                          <option value="<?=$subjectRow['id']?>"><?=$subjectRow['subject']?></option>
                          <?php
                          }
                        }
                        ?>

                        </select>

                      </div>

                      <div class="form-group col-12">
                        <label for="">Chapter*</label>
                        <select class="form-select" id="chapterBox" aria-label=".form-select-sm example"
                          name="chapter_id">
                          <?php 
                             $searchChapter = mysqli_query($con,"SELECT * FROM chapter WHERE id='$chapter_id'");
                             if(mysqli_num_rows($searchChapter) > 0){
                              $chapterNameRes = mysqli_fetch_array($searchChapter);
                              ?>
                          <option value="<?=$chapterNameRes['id'];?>" selected>
                            <?=$chapterNameRes['name'];?></option>
                          <?php
                             }else{
                              ?>
                          <option value="">Not selected Yet</option>
                          <?php
                             }
                            ?>

                        </select>

                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="question">Question <span>*</span></label>
                          <!-- Cke question -->
                          <textarea name="question" id="editor"><?=$result['question']?></textarea>

                        </div>
                      </div>
                      <?php
                        $i=1;
                        $searchOption = mysqli_query($con,"SELECT * FROM true_false_options WHERE question_id='$question_id'");
                        if(mysqli_num_rows($searchOption) > 0){
                          while($optionRow = mysqli_fetch_array($searchOption)){
                            ?>
                      <div class="col-11 mx-5">
                        <div class="form-group">
                          <label for="option_<?=$i?>">Option <?=chr(64+$i)?> <span>*</span></label>
                          <!-- Cke Editor -->
                          <textarea name="<?=$optionRow['option_name_post']?>"
                            id="option_<?=$i?>"><?=$optionRow['option_1']?></textarea>

                        </div>
                      </div>
                      <div class="form-group col-3 mx-5">
                        <label for="">True Or False*</label>
                        <select class="form-select" aria-label=".form-select-sm example" name="<?=$optionRow['id']?>"
                          required>
                          <option Value="">Select True Or False</option>
                          <?php 
                          if($optionRow['answer'] == 1){
                            ?>
                          <option value="1" selected>True</option>
                          <option value="0">False</option>
                          <?php
                          }else{
                            ?>
                          <option value="1">True</option>
                          <option value="0" selected>False</option>
                          <?php
                          }
                          ?>

                        </select>

                      </div>
                      <?php
                      $i++;
                          }
                        }
                        ?>

                      <div class="col-12 d-flex justify-content-end">
                        <button type="submit" name="updateTrueFalse" class="btn btn-primary me-1 mb-1">Update
                          Question</button>
                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
  </div>
  <?php
      }
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
  <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/super-build/ckeditor.js"></script>
  <script src="js/ckeEditor.js"></script>
  <script src="js/ckeEditorOption_1.js"></script>
  <script src="js/ckeEditorOption_2.js"></script>
  <script src="js/ckeEditorOption_3.js"></script>
  <script src="js/ckeEditorOption_4.js"></script>
  <script src="js/ckeEditorOption_5.js"></script>
  <script src="js/ckeEditorSolution.js"></script>
  <script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="js/sweetalert.js"></script>
  <script src="js/script.js"></script>
  <script src="js/custom.js"></script>
  <script>
  $("#option5").hide();
  $('#option5Hide').on('click', function() {
    $("#option5").toggle();
  });

  $("#trueFalse").hide();
  $('.showTrueFalseMark').on('click', function() {
    $("#trueFalse").show(100);
  });
  $('#hideBtnTrue').on('click', () => {
    $("#trueFalse").hide(100);
  })
  </script>

</body>

</html>