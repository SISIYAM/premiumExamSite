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

  <style>
  .radio-item [type="radio"] {
    display: none;
  }

  .radio-item+.radio-item {
    margin-top: 15px;
  }

  .radio-item label {
    width: 100%;
    color: #000000;
    display: block;
    padding: 20px 20px;
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    cursor: pointer;
    font-size: 18px;
    font-weight: 400;
    position: relative;
    border: 2px solid #CACACA;

  }

  .radio-list p {
    color: #000000;
  }

  .true-false label {
    width: 100%;
    color: #000000;
    display: block;
    padding: 20px 10px 20px 60px;
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    cursor: pointer;
    font-size: 18px;
    font-weight: 400;
    position: relative;
    border: 2px solid #CACACA;
    background-color: #f7f7f7;
  }


  .correct {
    border-color: #59D933;
    background: #C1F0DB;
  }

  .wrong {
    border-color: #59D933;
    background: #F8D7DA;
  }

  /* responsive cke-editor uploaded image */
  .radio-list img {
    max-width: 100%;
    height: auto !important;
  }

  .radio-item {
    max-width: 100%;
    height: auto !important;
  }

  .solution img {
    max-width: 100%;
    height: auto !important;
  }
  </style>
</head>

<body>

  <!-- Nav bar -->
  <?php include 'includes/nav.php'; ?>
  <!--**********************************
            Content body start
        ***********************************-->
  <div class="content-body">
    <input type="hidden" value="<?=$student_id?>" id="studentID">
    <!-- row -->
    <?php 
    if(isset($_GET['Exam-History'])){ 
      $exam_id = $_GET['Exam-History'];
      $select = mysqli_query($con, "SELECT * FROM exam WHERE exam_id='$exam_id'");
      if(mysqli_num_rows($select) > 0){
        $ExamRow = mysqli_fetch_array($select);

        $examName = $ExamRow['exam_name'];
        $totalMarks = $ExamRow['mcq_marks'];
        $mcq_marks = $ExamRow['mcq_marks'];
        $examStart = $ExamRow['exam_start'];
        $examEnd = $ExamRow['exam_end']; 
        $duration = $ExamRow['duration'];
        $singleMark = $ExamRow['marks'];
        $negativeMarks = $ExamRow['negative_mark'];


         // current time
         date_default_timezone_set("Asia/Dhaka");
         $date = date('Y-m-d H:i');
         $current_time = strtotime($date);
 
         // convert into timestamp
         $examStartDate = $ExamRow['exam_start']." ".$ExamRow['exam_start_time'];
         $examEndDate = $ExamRow['exam_end']." ".$ExamRow['exam_end_time'];
   
         $examStartTimestamp = strtotime($examStartDate);
         $examEndTimestamp = strtotime($examEndDate);

      }else{
        $examName = "N/A";
        $totalMarks = "N/A";
        $mcq_marks = "N/A";
        $written_marks = "N/A";
        $examStart = "N/A";
        $examEnd = "N/A";
        $duration = "N/A";
        $numberOfQuestion = "N/A";
       
      }
    
    ?>
    <div class="container-fluid">
      <div class="row">
        <?php
                  $showResult = mysqli_query($con, "SELECT * FROM result WHERE student_id='$student_id' AND exam_id='$exam_id'");
                  if(mysqli_num_rows($showResult) > 0){
                    $showResultRow = mysqli_fetch_array($showResult);
                    ?>

        <!-- Pie chart section value -->
        <input type="hidden" id="total_answered" value="<?=$showResultRow['answered']?>">
        <input type="hidden" id="right_answer" value="<?=$showResultRow['right_answered']?>">
        <input type="hidden" id="wrong_answer" value="<?=$showResultRow['wrong_answered']?>">
        <input type="hidden" id="not_answer" value="<?=$showResultRow['not_answered']?>">

        <div class="col-lg-3 col-sm-6">
          <div class="card">
            <div class="stat-widget-two card-body">
              <div class="stat-content">
                <div class="stat-text">Obtained Marks </div>
                <div class="stat-digit"><?=$showResultRow['result']?></div>
              </div>
              <div class="progress">
                <div class="progress-bar progress-bar-info w-100" role="progressbar" aria-valuenow="100"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card">
            <div class="stat-widget-two card-body">
              <div class="stat-content">
                <div class="stat-text">Correct Answer</div>
                <div class="stat-digit"><?=$showResultRow['right_answered']?></div>
              </div>
              <div class="progress">
                <div class="progress-bar progress-bar-success w-100" role="progressbar" aria-valuenow="100"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card">
            <div class="stat-widget-two card-body">
              <div class="stat-content">
                <div class="stat-text">Wrong Answer</div>
                <div class="stat-digit"><?=$showResultRow['wrong_answered']?></div>
              </div>
              <div class="progress">
                <div class="progress-bar progress-bar-danger w-100" role="progressbar" aria-valuenow="100"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card">
            <div class="stat-widget-two card-body">
              <div class="stat-content">
                <div class="stat-text">Not Answered</div>
                <div class="stat-digit"><?=$showResultRow['not_answered']?></div>
              </div>
              <div class="progress">
                <div class="progress-bar progress-bar-primary w-100" role="progressbar" aria-valuenow="100"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
          <!-- /# card -->
        </div>
        <!-- /# column -->
      </div>


      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-lg-4 col-sm-6">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Exam Marks</h4>
                </div>
                <div class="card-body">
                  <canvas id="resultChart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-7 col-sm-6">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title"><?=$examName?></h4>
                </div>
                <div class="card-body">

                  <p class="badge badge-rounded badge-outline-dark">Exam Date: <?=$examStart?></p> <br>
                  <p class="badge badge-rounded badge-outline-dark">Exam End: <?=$examEnd?></p> <br>
                  <p class="badge badge-rounded badge-outline-dark">Exam Duration: <?php
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
                      ?></p> <br>
                  <?php
                  if($current_time >= $examEndTimestamp){
                    ?>
                  <div class="my-2">
                    <a href="result?Solution=<?=$exam_id?>"><button class="btn btn-primary mr-2">View
                        Solution</button></a>
                    <a href="leaderboard?Leader-Board=<?=$exam_id?>"> <button class="btn btn-dark my-2">Leader
                        Board</button></a>
                    <?php
                    if($ExamRow['custom_exam_type'] != 2){
                        ?>
                    <a href="Download-Solution?ExamID=<?=$exam_id?>" target="_blank"><button
                        class="btn btn-danger text-light ml-2">Download
                        Solution</button></a>
                    <?php
                    }
                    ?>
                  </div>
                  <?php
                  }else{
                    ?>
                  <p class="alert alert-light">
                    After finishing the exam, you are able to see the solution, leader Board, and
                    download solution.</p>
                  <?php
                  }
                  ?>
                </div>
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
    }elseif (isset($_GET['Custom-Exam-History'])) {
      $exam_id = $_GET['Custom-Exam-History'];
      $select = mysqli_query($con, "SELECT * FROM custom_exam WHERE exam_id='$exam_id'");
      if(mysqli_num_rows($select) > 0){
        $ExamRow = mysqli_fetch_array($select);

        $examName = $ExamRow['exam_name'];
        $mcq_marks = $ExamRow['mcq_marks'];
        $examStart = $ExamRow['exam_start'];
        $duration = $ExamRow['duration'];
        $total_questions = $ExamRow['total_questions'];
      }else{
        $examName = "N/A";
        $mcq_marks = "N/A";
        $examStart = "N/A";
        $duration = "N/A";
        $total_questions = 0;
      }
    
    ?>
    <div class="container-fluid">
      <div class="row">
        <?php
                  $showResult = mysqli_query($con, "SELECT * FROM result WHERE student_id='$student_id' AND exam_id='$exam_id'");
                  if(mysqli_num_rows($showResult) > 0){
                    $showResultRow = mysqli_fetch_array($showResult);
                    ?>
        <!-- Pie chart section value -->
        <input type="hidden" id="total_answered" value="<?=$showResultRow['answered']?>">
        <input type="hidden" id="right_answer" value="<?=$showResultRow['right_answered']?>">
        <input type="hidden" id="wrong_answer" value="<?=$showResultRow['wrong_answered']?>">
        <input type="hidden" id="not_answer" value="<?=$showResultRow['not_answered']?>">

        <div class="col-lg-3 col-sm-6">
          <div class="card">
            <div class="stat-widget-two card-body">
              <div class="stat-content">
                <div class="stat-text">Obtained Marks </div>
                <div class="stat-digit"><?=$showResultRow['result']?></div>
              </div>
              <div class="progress">
                <div class="progress-bar progress-bar-info w-100" role="progressbar" aria-valuenow="100"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card">
            <div class="stat-widget-two card-body">
              <div class="stat-content">
                <div class="stat-text">Correct Answer</div>
                <div class="stat-digit"><?=$showResultRow['right_answered']?></div>
              </div>
              <div class="progress">
                <div class="progress-bar progress-bar-success w-100" role="progressbar" aria-valuenow="100"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card">
            <div class="stat-widget-two card-body">
              <div class="stat-content">
                <div class="stat-text">Wrong Answer</div>
                <div class="stat-digit"><?=$showResultRow['wrong_answered']?></div>
              </div>
              <div class="progress">
                <div class="progress-bar progress-bar-danger w-100" role="progressbar" aria-valuenow="100"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card">
            <div class="stat-widget-two card-body">
              <div class="stat-content">
                <div class="stat-text">Not Answered</div>
                <div class="stat-digit"><?=$showResultRow['not_answered']?></div>
              </div>
              <div class="progress">
                <div class="progress-bar progress-bar-primary w-100" role="progressbar" aria-valuenow="100"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
          <!-- /# card -->
        </div>
        <!-- /# column -->
      </div>


      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-lg-6 col-sm-6">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Exam Marks</h4>
                </div>
                <div class="card-body">
                  <canvas id="resultChart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-sm-6">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title"><?=$examName?></h4>
                </div>
                <div class="card-body">
                  <p class="badge badge-rounded badge-outline-dark">Number of Question: <?=$total_questions?></p> <br>
                  <p class="badge badge-rounded badge-outline-dark">Marks Per Question: <?=$mcq_marks?></p> <br>
                  <p class="badge badge-rounded badge-outline-dark">Exam Date: <?=$examStart?></p> <br>
                  <p class="badge badge-rounded badge-outline-dark">Exam Duration: <?php
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
                      ?></p> <br>
                  <p class="badge badge-rounded badge-outline-dark">Biology</p>
                  <div class="my-2">
                    <a href="result?Custom-Solution=<?=$exam_id?>"><button class="btn btn-primary mr-2">View
                        Solution</button></a>
                  </div>
                </div>
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
    }elseif(isset($_GET['Solution'])){
      $examId = $_GET['Solution'];
      $selectExam = mysqli_query($con, "SELECT * FROM exam WHERE exam_id='$examId'");
      if(mysqli_num_rows($selectExam) > 0){
        $fetchExam = mysqli_fetch_array($selectExam);
        $custom_exam_type = $fetchExam['custom_exam_type'];
        $examName = $fetchExam['exam_name'];
      }else{
        $examName = "N/A";
      }
      ?>
    <div class="row">
      <div class="col-xl-12 col-xxl-12">

        <?php
      if($custom_exam_type == 0){
        ?>
        <div class="card">

          <?php 
              $i = 1;
              $select = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$examId'");
              if(mysqli_num_rows($select) > 0)
              {
                while($row = mysqli_fetch_array($select)){
                  $questionID = $row['id'];
                  $correctAnswer = $row['answer'];
                  $matchQuestion = mysqli_query($con, "SELECT * FROM record WHERE exam_id='$examId' AND student_id='$student_id' AND question_id='$questionID'");
                  if(mysqli_num_rows($matchQuestion) > 0){
                    $answeredOption = mysqli_fetch_array($matchQuestion)['answered'];
                  }else{
                    $answeredOption = 5;
                  }
                  ?>

          <div class="card-body">
            <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
            <button class="btn btn-danger btn-sm mx-3 bookmarkBtn" value="<?=$row['id']?>">Add to bookmark</button>
            <input type="hidden" class="questionType" value="0">
            <span class="badge bg-light text-dark"
              style="float: right; margin-right:20px; color:#000000; font-weight:bold">Mark
              :
              <?=$row['mark']?></span>
            <div class="radio-list col-xl-12">
              <p for="" class="font-weight-bold text-dark my-3 h4" style="color:#000000;">
                <?=$row['question']?>
              </p>
              <!-- if user answered correct answer then -->
              <?php
                  if($answeredOption == $correctAnswer){
                  ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 1){
                      ?> class="correct" <?php
                    } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
              </div>

              <div class="radio-item">
                <label <?php if($answeredOption == 2){
                      ?> class="correct" <?php
                    } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
              </div>

              <?php
              if($row['option_3'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 3){
                      ?> class="correct" <?php
                    } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
              </div>
              <?php
              }
              ?>

              <?php
              if($row['option_4'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 4){
                      ?> class="correct" <?php
                    } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
              </div>
              <?php
              }
              ?>
              <?php
              if($row['option_5'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 6){
                      ?> class="correct" <?php
                    } ?> for="radio5<?=$i?>"><?=$row['option_5']?></label>
              </div>
              <?php
              }
              ?>
              <?php  
            }elseif($answeredOption == 5){
              ?>
              <span class="btn btn-dark mb-4">Not Answered</span>
              <div class="radio-item">
                <label <?php if($correctAnswer == 1){
                      ?> class="correct" <?php
                    } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
              </div>

              <div class="radio-item">
                <label <?php if($correctAnswer == 2){
                      ?> class="correct" <?php
                    } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
              </div>

              <?php
              if($row['option_3'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($correctAnswer == 3){
                      ?> class="correct" <?php
                    } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
              </div>
              <?php
              }
              ?>

              <?php
              if($row['option_4'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($correctAnswer == 4){
                      ?> class="correct" <?php
                    } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
              </div>
              <?php
              }
              ?>

              <?php
              if($row['option_5'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($correctAnswer == 6){
                      ?> class="correct" <?php
                    } ?> for="radio5<?=$i?>"><?=$row['option_5']?></label>
              </div>
              <?php
              }
              ?>
              <?php
            }else{
              ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 1){
                        ?> class="wrong" <?php
                      } if($correctAnswer == 1){
                        ?> class="correct" <?php
                      } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
              </div>

              <div class="radio-item">
                <label <?php if($answeredOption == 2){
                        ?> class="wrong" <?php
                      } if($correctAnswer == 2){
                        ?> class="correct" <?php
                      } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
              </div>

              <?php
              if($row['option_3'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 3){
                        ?> class="wrong" <?php
                      } if($correctAnswer == 3){
                        ?> class="correct" <?php
                      } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
              </div>
              <?php
              }
              ?>

              <?php
              if($row['option_4'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 4){
                        ?> class="wrong" <?php
                      } if($correctAnswer == 4){
                        ?> class="correct" <?php
                      } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
              </div>
              <?php
              }
              ?>

              <?php
              if($row['option_5'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 6){
                        ?> class="wrong" <?php
                      } if($correctAnswer == 6){
                        ?> class="correct" <?php
                      } ?> for="radio5<?=$i?>"><?=$row['option_5']?></label>
              </div>
              <?php
              }
              ?>
              <?php
            }
              ?>
            </div>

          </div>
          <?php
                  if($row['solution'] > 0){
                    ?>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12 mb-4">
                <div class="card bg-light text-dark">
                  <div class="card-body rounded" style="border:2px solid #2EAD1E">
                    <span class="font-weight-bold text-dark">Solution:</span>
                    <div class="solution">
                      <?=$row['solution']?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
                  }
                  ?>
          <?php
          $i++;
            }
          }
          ?>
        </div>
        <?php
      }elseif($custom_exam_type == 1){
       // admin custom exam solution code
       ?>
        <div class="card">

          <?php 
              
              $select = mysqli_query($con, "SELECT * FROM questions");
              if(mysqli_num_rows($select) > 0)
              {
                while($row = mysqli_fetch_array($select)){
                  $questionID = $row['id'];
                  $correctAnswer = $row['answer'];
                  $record_questions = mysqli_query($con, "SELECT * FROM record WHERE exam_id='$examId' AND student_id='$student_id' AND option_id IS NULL");
                  if(mysqli_num_rows($record_questions) > 0){
                    $i = 0;
                    while($record_question_id = mysqli_fetch_array($record_questions)){
                    $i++;
                      if($questionID == $record_question_id['question_id']){
                        $matchQuestion = mysqli_query($con, "SELECT * FROM record WHERE exam_id='$examId' AND student_id='$student_id' AND question_id='$questionID'");
                        if(mysqli_num_rows($matchQuestion) > 0){
                          $answeredOption = mysqli_fetch_array($matchQuestion)['answered'];
                        }else{
                          $answeredOption = 5;
                        }
                        ?>

          <div class="card-body">
            <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
            <button class="btn btn-danger btn-sm mx-3 bookmarkBtn" value="<?=$row['id']?>">Add to bookmark</button>
            <input type="hidden" class="questionType" value="0">
            <span class="badge bg-light text-dark"
              style="float: right; margin-right:20px; color:#000000; font-weight:bold">Mark
              :
              <?=$row['mark']?></span>
            <div class="radio-list col-xl-12">
              <p for="" class="font-weight-bold text-dark my-3 h4" style="color:#000000;">
                <?=$row['question']?>
              </p>
              <!-- if user answered correct answer then -->
              <?php
                        if($answeredOption == $correctAnswer){
                        ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 1){
                            ?> class="correct" <?php
                          } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
              </div>

              <div class="radio-item">
                <label <?php if($answeredOption == 2){
                            ?> class="correct" <?php
                          } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
              </div>

              <?php
             if($row['option_3'] != NULL){
              ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 3){
                            ?> class="correct" <?php
                          } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
              </div>
              <?php
             }
             ?>

              <?php
              if($row['option_4'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 4){
                            ?> class="correct" <?php
                          } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
              </div>
              <?php
              }
              ?>
              <?php
              if($row['option_5'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 6){
                            ?> class="correct" <?php
                          } ?> for="radio5<?=$i?>"><?=$row['option_5']?></label>
              </div>
              <?php
              }
              ?>

              <?php  
                  }elseif($answeredOption == 5){
                    ?>
              <span class="btn btn-dark mb-4">Not Answered</span>
              <div class="radio-item">
                <label <?php if($correctAnswer == 1){
                            ?> class="correct" <?php
                          } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
              </div>

              <div class="radio-item">
                <label <?php if($correctAnswer == 2){
                            ?> class="correct" <?php
                          } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
              </div>

              <?php
            if($row['option_3'] != NULL){
              ?>
              <div class="radio-item">
                <label <?php if($correctAnswer == 3){
                            ?> class="correct" <?php
                          } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
              </div>
              <?php
            }
            ?>

              <?php
              if($row['option_4'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($correctAnswer == 4){
                            ?> class="correct" <?php
                          } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
              </div>
              <?php
              }
              ?>

              <?php
              if($row['option_5'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($correctAnswer == 6){
                            ?> class="correct" <?php
                          } ?> for="radio5<?=$i?>"><?=$row['option_5']?></label>
              </div>
              <?php
              }
              ?>


              <?php
                  }else{
                    ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 1){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 1){
                              ?> class="correct" <?php
                            } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
              </div>

              <div class="radio-item">
                <label <?php if($answeredOption == 2){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 2){
                              ?> class="correct" <?php
                            } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
              </div>

              <?php
            if($row['option_3'] != NULL){
              ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 3){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 3){
                              ?> class="correct" <?php
                            } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
              </div>
              <?php
            }
            ?>

              <?php
              if($row['option_4'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 4){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 4){
                              ?> class="correct" <?php
                            } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
              </div>
              <?php
              }
              ?>

              <?php
              if($row['option_5'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 6){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 6){
                              ?> class="correct" <?php
                            } ?> for="radio5<?=$i?>"><?=$row['option_5']?></label>
              </div>
              <?php
              }
              ?>

              <?php
                  }
                    ?>
            </div>

          </div>
          <?php
                        if($row['solution'] > 0){
                          ?>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12 mb-4">
                <div class="card bg-light text-dark">
                  <div class="card-body rounded" style="border:2px solid #2EAD1E">
                    <span class="font-weight-bold text-dark">Solution:</span>
                    <div class="solution">
                      <?=$row['solution']?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
                        }
                      }
                      
          }
        }


         
            }
          }
          ?>

          <?php 
           $k = $i+1;
              $select = mysqli_query($con, "SELECT * FROM true_false_question");
              if(mysqli_num_rows($select) > 0)
              {
                while($row = mysqli_fetch_array($select)){
                  $questionID = $row['id'];
                  $searchRecord = mysqli_query($con, "SELECT * FROM record WHERE exam_id='$examId' AND student_id='$student_id' AND question_id='$questionID'");
                  if(mysqli_num_rows($searchRecord) > 0){
                    $matchedQuestionID = $questionID;

                    ?>
          <div class="card-body">
            <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$k?> </h6>
            <button class="btn btn-danger btn-sm mx-3 bookmarkBtnTrue" value="<?=$row['id']?>">Add to bookmark</button>
            <input type="hidden" class="questionTypeTrue" value="1">
            <div class="radio-list col-xl-12">
              <p for="" class="font-weight-bold text-dark my-3 h4">
                <?=$row['question']?>
              </p>

              <?php 
                  $j = 1;
                  $optionSearch = mysqli_query($con,"SELECT * FROM true_false_options WHERE question_id='$matchedQuestionID'");
                  if(mysqli_num_rows($optionSearch) > 0){
                  while($optionRow = mysqli_fetch_array($optionSearch)){
                    $optionID = $optionRow['id'];
                    $correctAnswer = $optionRow['answer'];
                    $answeredOption = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM record WHERE exam_id='$examId' AND student_id='$student_id' AND option_id='$optionID'"))['answered'];
                  ?>
              <span class="btn btn-dark btn-sm my-2">Option <?=$j?></span>
              <div class="true-false">
                <label for="radio1<?=$j?>"><?=$optionRow['option_1']?></label>
              </div>

              <?php 
              if($answeredOption == $correctAnswer){
                ?>
              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio4<?=$j?>">
                <label <?php if($answeredOption == 1){
                            ?> class="correct" <?php
                          } ?> for="radio4<?=$j?>">True</label>
              </div>

              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio5<?=$j?>">
                <label <?php if($answeredOption == 0){
                            ?> class="correct" <?php
                          } ?> for="radio5<?=$j?>">False</label>
              </div>
              <?php
              }elseif($answeredOption == 5){
                ?>
              <button class="btn btn-warning my-1">Not Answered</button>
              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio4<?=$j?>">
                <label <?php if($correctAnswer == 1){
                              ?> class="correct" <?php
                            } ?> for="radio4<?=$j?>">True</label>
              </div>

              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio5<?=$j?>">
                <label <?php if($correctAnswer == 0){
                              ?> class="correct" <?php
                            } ?> for="radio5<?=$j?>">False</label>
              </div>
              <?php
              }else{
                ?>
              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio4<?=$j?>">
                <label <?php if($answeredOption == 1){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 1){
                              ?> class="correct" <?php
                            } ?> for="radio4<?=$j?>">True</label>
              </div>

              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio5<?=$j?>">
                <label <?php if($answeredOption == 0){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 0){
                              ?> class="correct" <?php
                            } ?> for="radio5<?=$j?>">False</label>
              </div>
              <?php
              }
              ?>

              <?php
                $j++;
                 }
                   }
                     ?>

            </div>

          </div>
          <?php
                   
                    
                  }
                  $k++;
           
                }
              }
          ?>

        </div>
        <?php
      }else{
       // true false solution
        ?>
        <div class="card">

          <?php 
              $i=1;
              $select = mysqli_query($con, "SELECT * FROM true_false_question");
              if(mysqli_num_rows($select) > 0)
              {
                while($row = mysqli_fetch_array($select)){
                  $questionID = $row['id'];
                  $searchRecord = mysqli_query($con, "SELECT * FROM true_false_record WHERE exam_id='$examId' AND student_id='$student_id' AND question_id='$questionID'");
                  if(mysqli_num_rows($searchRecord) > 0){
                    $matchedQuestionID = $questionID;

                    ?>
          <div class="card-body">
            <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
            <button class="btn btn-danger btn-sm mx-3 bookmarkBtn" value="<?=$row['id']?>">Add to bookmark</button>
            <input type="hidden" class="questionType" value="1">
            <div class="radio-list col-xl-12">
              <p for="" class="font-weight-bold text-dark my-3 h4">
                <?=$row['question']?>
              </p>

              <?php 
                  $j = 1;
                  $optionSearch = mysqli_query($con,"SELECT * FROM true_false_options WHERE question_id='$matchedQuestionID'");
                  if(mysqli_num_rows($optionSearch) > 0){
                  while($optionRow = mysqli_fetch_array($optionSearch)){
                    $optionID = $optionRow['id'];
                    $correctAnswer = $optionRow['answer'];
                    $answeredOption = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM true_false_record WHERE exam_id='$examId' AND student_id='$student_id' AND option_id='$optionID'"))['answered'];
                  ?>
              <span class="btn btn-dark btn-sm my-2">Option <?=$j?></span>
              <div class="true-false">
                <label for="radio1<?=$j?>"><?=$optionRow['option_1']?></label>
              </div>

              <?php 
              if($answeredOption == $correctAnswer){
                ?>
              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio4<?=$j?>">
                <label <?php if($answeredOption == 1){
                            ?> class="correct" <?php
                          } ?> for="radio4<?=$j?>">True</label>
              </div>

              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio5<?=$j?>">
                <label <?php if($answeredOption == 0){
                            ?> class="correct" <?php
                          } ?> for="radio5<?=$j?>">False</label>
              </div>
              <?php
              }elseif($answeredOption == 5){
                ?>
              <button class="btn btn-warning my-1">Not Answered</button>
              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio4<?=$j?>">
                <label <?php if($correctAnswer == 1){
                              ?> class="correct" <?php
                            } ?> for="radio4<?=$j?>">True</label>
              </div>

              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio5<?=$j?>">
                <label <?php if($correctAnswer == 0){
                              ?> class="correct" <?php
                            } ?> for="radio5<?=$j?>">False</label>
              </div>
              <?php
              }else{
                ?>
              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio4<?=$j?>">
                <label <?php if($answeredOption == 1){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 1){
                              ?> class="correct" <?php
                            } ?> for="radio4<?=$j?>">True</label>
              </div>

              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio5<?=$j?>">
                <label <?php if($answeredOption == 0){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 0){
                              ?> class="correct" <?php
                            } ?> for="radio5<?=$j?>">False</label>
              </div>
              <?php
              }
              ?>

              <?php
                $j++;
                 }
                   }
                     ?>

            </div>

          </div>
          <?php
                    $i++;
                    
                  }
           
                }
              }
          ?>
        </div>
        <?php
      }
      ?>

        </form>
      </div>
    </div>
    <?php
    }elseif (isset($_GET['Custom-Solution'])) {
      $examId = $_GET['Custom-Solution'];
      $select = mysqli_query($con, "SELECT * FROM custom_exam WHERE exam_id='$examId'");
      if(mysqli_num_rows($select) > 0){
        $fetchCustom = mysqli_fetch_array($select);
        $examName = $fetchCustom['exam_name'];
        $customMark = $fetchCustom['mcq_marks'];
      }else{
        $examName = "N/A";
        $customMark = "N/A";
      }
      ?>
    <div class="row">
      <div class="col-xl-12 col-xxl-12">
        <div class="card">

          <?php 
              
              $select = mysqli_query($con, "SELECT * FROM questions");
              if(mysqli_num_rows($select) > 0)
              {
                while($row = mysqli_fetch_array($select)){
                  $questionID = $row['id'];
                  $correctAnswer = $row['answer'];
                  $record_questions = mysqli_query($con, "SELECT * FROM record WHERE exam_id='$examId' AND student_id='$student_id'");
                  if(mysqli_num_rows($record_questions) > 0){
                    $i = 0;
                    while($record_question_id = mysqli_fetch_array($record_questions)){
                    $i++;
                      if($questionID == $record_question_id['question_id']){
                        $matchQuestion = mysqli_query($con, "SELECT * FROM record WHERE exam_id='$examId' AND student_id='$student_id' AND question_id='$questionID'");
                        if(mysqli_num_rows($matchQuestion) > 0){
                          $answeredOption = mysqli_fetch_array($matchQuestion)['answered'];
                        }else{
                          $answeredOption = 5;
                        }
                        ?>

          <div class="card-body">
            <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
            <button class="btn btn-danger btn-sm mx-3 bookmarkBtn" value="<?=$row['id']?>">Add to bookmark</button>
            <input type="hidden" class="questionType" value="0">
            <span class="badge bg-light text-dark"
              style="float: right; margin-right:20px; color:#000000; font-weight:bold">Mark
              :
              <?=$customMark?></span>
            <div class="radio-list col-xl-12">
              <p for="" class="font-weight-bold text-dark my-3 h4" style="color:#000000;">
                <?=$row['question']?>
              </p>
              <!-- if user answered correct answer then -->
              <?php
                        if($answeredOption == $correctAnswer){
                        ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 1){
                            ?> class="correct" <?php
                          } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
              </div>

              <div class="radio-item">
                <label <?php if($answeredOption == 2){
                            ?> class="correct" <?php
                          } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
              </div>

              <?php
             if($row['option_3'] != NULL){
              ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 3){
                            ?> class="correct" <?php
                          } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
              </div>
              <?php
             }
             ?>

              <?php 
              if($row['option_4'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 4){
                            ?> class="correct" <?php
                          } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
              </div>
              <?php
              }
              ?>

              <?php 
              if($row['option_5'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 6){
                            ?> class="correct" <?php
                          } ?> for="radio5<?=$i?>"><?=$row['option_5']?></label>
              </div>
              <?php
              }
              ?>


              <?php  
                  }elseif($answeredOption == 5){
                    ?>
              <span class="btn btn-dark mb-4">Not Answered</span>
              <div class="radio-item">
                <label <?php if($correctAnswer == 1){
                            ?> class="correct" <?php
                          } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
              </div>

              <div class="radio-item">
                <label <?php if($correctAnswer == 2){
                            ?> class="correct" <?php
                          } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
              </div>

              <?php
              if($row['option_3'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($correctAnswer == 3){
                            ?> class="correct" <?php
                          } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
              </div>
              <?php
              }
              ?>

              <?php
              if($row['option_4'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($correctAnswer == 4){
                            ?> class="correct" <?php
                          } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
              </div>
              <?php
              }
              ?>
              <?php
              if($row['option_5'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($correctAnswer == 6){
                            ?> class="correct" <?php
                          } ?> for="radio5<?=$i?>"><?=$row['option_5']?></label>
              </div>
              <?php
              }
              ?>

              <?php
                  }else{
                    ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 1){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 1){
                              ?> class="correct" <?php
                            } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
              </div>

              <div class="radio-item">
                <label <?php if($answeredOption == 2){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 2){
                              ?> class="correct" <?php
                            } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
              </div>

              <?php
             if($row['option_3'] != NULL){
              ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 3){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 3){
                              ?> class="correct" <?php
                            } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
              </div>
              <?php
             }
             ?>

              <?php 
             if($row['option_4'] != NULL){
              ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 4){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 4){
                              ?> class="correct" <?php
                            } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
              </div>
              <?php
             }
             ?>

              <?php
             if($row['option_5'] != NULL){
              ?>
              <div class="radio-item">
                <label <?php if($answeredOption == 6){
                              ?> class="wrong" <?php
                            } if($correctAnswer == 6){
                              ?> class="correct" <?php
                            } ?> for="radio5<?=$i?>"><?=$row['option_5']?></label>
              </div>
              <?php
             }
             ?>
              <?php
                  }
                    ?>
            </div>

          </div>
          <?php
                        if($row['solution'] > 0){
                          ?>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12 mb-4">
                <div class="card bg-light text-dark">
                  <div class="card-body rounded" style="border:2px solid #2EAD1E">
                    <span class="font-weight-bold text-dark">Solution:</span>
                    <div class="solution">
                      <?=$row['solution']?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
                        }
                      }
                      
          }
        }


         
            }
          }
          ?>
        </div>

        </form>
      </div>
    </div>
    <?php
    }elseif (isset($_GET['Bookmark'])) {
      ?>
    <div class="row">
      <div class="col-xl-12 col-xxl-12">
        <div class="card">

          <?php 
             
              $i = 1;
              $bookmarkSearch = mysqli_query($con,"SELECT * FROM bookmark WHERE student_id='$student_id' ORDER BY id DESC");
              if(mysqli_num_rows($bookmarkSearch) > 0){
                while($result = mysqli_fetch_array($bookmarkSearch)){
                  $questionID = $result['question_id'];
                  $question_type = $result['question_type'];
                 if($question_type == 0){
                  $select = mysqli_query($con, "SELECT * FROM questions WHERE id='$questionID'");
                  if(mysqli_num_rows($select) > 0)
                  {
                    $row = mysqli_fetch_array($select);
                    $correctAnswer = $row['answer']; 

                    ?>
          <div class="card-body">
            <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
            <button class="badge bg-danger text-light border-0 deleteBookmarkBtn"
              style="float: right; margin-right:20px; color:#000000; font-weight:bold;cursor:pointer;" id=""
              value="<?=$questionID?>">Remove</button>
            <div class="radio-list col-xl-12">
              <p for="" class="font-weight-bold text-dark my-3 h4" style="color:#000000;">
                <?=$row['question']?>
              </p>


              <div class="radio-item">
                <label <?php if($correctAnswer == 1){
                            ?> class="correct" <?php
                          } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
              </div>

              <div class="radio-item">
                <label <?php if($correctAnswer == 2){
                            ?> class="correct" <?php
                          } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
              </div>

              <?php
              if($row['option_3'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($correctAnswer == 3){
                            ?> class="correct" <?php
                          } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
              </div>
              <?php
              }
              ?>

              <?php
              if($row['option_4'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($correctAnswer == 4){
                            ?> class="correct" <?php
                          } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
              </div>
              <?php
              }
              ?>
              <?php
              if($row['option_5'] != NULL){
                ?>
              <div class="radio-item">
                <label <?php if($correctAnswer == 6){
                            ?> class="correct" <?php
                          } ?> for="radio5<?=$i?>"><?=$row['option_5']?></label>
              </div>
              <?php
              }
              ?>
            </div>

          </div>

          <?php
            if($row['solution'] > 0){
              ?>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12 mb-4">
                <div class="card bg-light text-dark">
                  <div class="card-body rounded" style="border:2px solid #2EAD1E">
                    <span class="font-weight-bold text-dark">Solution:</span>
                    <div class="solution">
                      <?=$row['solution']?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
            }
                  }
                 }elseif($question_type == 1){
                  $select = mysqli_query($con,"SELECT * FROM true_false_question WHERE id='$questionID'");
                  if(mysqli_num_rows($select) > 0){
                    $row = mysqli_fetch_array($select);
                   ?>
          <div class="card-body">
            <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
            <button class="badge bg-danger text-light border-0 deleteBookmarkBtn"
              style="float: right; margin-right:20px; color:#000000; font-weight:bold;cursor:pointer;" id=""
              value="<?=$questionID?>">Remove</button>
            <div class="radio-list col-xl-12">
              <p for="" class="font-weight-bold text-dark my-3 h4">
                <?=$row['question']?>
              </p>

              <?php 
                  $j = 1;
                  $optionSearch = mysqli_query($con,"SELECT * FROM true_false_options WHERE question_id='$questionID'");
                  if(mysqli_num_rows($optionSearch) > 0){
                  while($optionRow = mysqli_fetch_array($optionSearch)){
                    $optionID = $optionRow['id'];
                    $correctAnswer = $optionRow['answer'];
                     ?>
              <span class="btn btn-dark btn-sm my-2">Option <?=$j?></span>
              <div class="true-false">
                <label for="radio1<?=$j?>"><?=$optionRow['option_1']?></label>
              </div>


              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio4<?=$j?>">
                <label <?php if($correctAnswer == 1){
                              ?> class="correct" <?php
                            } ?> for="radio4<?=$j?>">True</label>
              </div>

              <div class="radio-item" style="width:80%">
                <input type="radio" id="radio5<?=$j?>">
                <label <?php if($correctAnswer == 0){
                              ?> class="correct" <?php
                            } ?> for="radio5<?=$j?>">False</label>
              </div>
              <?php
           

            
                $j++;
                 }
                   }
                     ?>
            </div>

          </div>

          <?php
                  }
                 }
                  $i++;
                }
              }else{
                ?>
          <p class="alert alert-danger text-light">No Data Found!</p>
          <?php
              }
              
                 
          ?>
        </div>

        </form>
      </div>
    </div>
    <?php
    }else{
      echo "<p class='alert alert-danger'>Page Not Found!</p>";
    }
    ?>
  </div>
  <!--**********************************
            Content body end
        ***********************************-->







  <?php include("includes/footer.php"); ?>
  <!-- Chartjs -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
  let total_answered = $('#total_answered').val();
  let right_answer = $('#right_answer').val();
  let wrong_answer = $('#wrong_answer').val();
  let not_answer = $('#not_answer').val();

  const ctx = document.getElementById('resultChart');

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Total Answered', 'Correct Answered', 'Wrong Answered', 'Not Answered'],
      datasets: [{
        label: '',
        data: [total_answered, right_answer, wrong_answer, not_answer],
        backgroundColor: [
          '#FFC300',
          '#0EE134',
          'rgb(255, 99, 132)',
          'rgb(54, 162, 235)'

        ],
        hoverOffset: 4
      }]
    },
  });
  </script>
  <script src="js/script.js"></script>

</body>

</html>