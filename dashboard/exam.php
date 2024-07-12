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

  .radio-list p {
    color: #000000;
  }

  .radio-item label {
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
  }

  .radio-item label:after,
  .radio-item label:before {
    content: "";
    position: absolute;
    border-radius: 50%;
  }

  .radio-item label:after {
    height: 20px;
    width: 20px;
    border: 2px solid #524eee;
    left: 20px;
    top: calc(50% - 12px);
  }

  .radio-item label:before {
    background: #585855;
    height: 17px;
    width: 17px;
    left: 21.5px;
    top: calc(50% - 10px);
    transform: scale(5);
    transition: .4s ease-in-out 0s;
    opacity: 0;
    visibility: hidden;
  }

  .radio-item [type="radio"]:checked~label {
    border-color: #59D933;
    background: #C1F0DB;
  }

  .radio-item [type="radio"]:checked~label:before {
    opacity: 1;
    visibility: visible;
    transform: scale(1);
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

  .radio-list p {
    font-size: 25px;
  }
  </style>
</head>

<body>

  <!-- Nav bar -->
  <?php include 'includes/nav.php'; ?>

  <?php
    $courseCount = mysqli_query($con, "SELECT * FROM package_record WHERE student_id='$student_id'");
    if(mysqli_num_rows($courseCount) > 0){
      ?>

  <?php 
    if(isset($_GET['Exam-ID'])){
      $examId= $_GET['Exam-ID'];
      $selectExam = mysqli_query($con,"SELECT * FROM exam WHERE exam_id = '$examId'");
      if(mysqli_num_rows($selectExam) > 0){
        $resultRow = mysqli_fetch_array($selectExam);
        $examNme = $resultRow['exam_name'];
        $duration = $resultRow['duration'];
        $mcqMarks = $resultRow['mcq_marks'];
        if($resultRow['marks'] == NULL){
          $marks = 0;
        }else{
          $marks = $resultRow['marks'];
        }
        $examType = $resultRow['type'];
        $custom_exam_type = $resultRow['custom_exam_type'];
        $exam_start_date = strtotime($resultRow['exam_start']);
        $new_start_date = date('d M Y', $exam_start_date);
        $exam_start_time = strtotime($resultRow['exam_start_time']);
        $new_start_time = date('h:i A',$exam_start_time);
        $exam_end_date = strtotime($resultRow['exam_end']);
        $new_end_date = date('d M Y', $exam_end_date);
        $exam_end_time = strtotime($resultRow['exam_end_time']);
        $new_end_time = date('h:i A',$exam_end_time);
        // current time
        date_default_timezone_set("Asia/Dhaka");
        $date = date('Y-m-d H:i');
        $current_time = strtotime($date);

        // convert into timestamp
        $examStartDate = $resultRow['exam_start']." ".$resultRow['exam_start_time'];
        $examEndDate = $resultRow['exam_end']." ".$resultRow['exam_end_time'];
  
        $examStartTimestamp = strtotime($examStartDate);
        $examEndTimestamp = strtotime($examEndDate);
      }
      ?>
  <div class="content-body">
    <div class="container-fluid">
      <?php
      if($examType == 1){
        if($current_time >= $examStartTimestamp && $current_time < $examEndTimestamp){
          ?>
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <b style="position:fixed; z-index:999; right:1%; top:10%;opacity: 0.8;"
          class="alert alert-danger solid alert-rounded ">
          <div id="time-status">
            <span class="hidden" id="hours-left"></span>
            <span id="min-left"></span>
            <span id="sec-left"></span>
            left
          </div>

          <span id="session-time" style="display: none;"></span>

          <span id="break-time" style="display: none;"></span>
        </b>
      </div>
      <?php
        }
      }else{
        if($current_time >= $examStartTimestamp && $current_time < $examEndTimestamp){
          ?>
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <b style="position:fixed; z-index:999; right:1%; top:10%;opacity: 0.8;"
          class="alert alert-danger solid alert-rounded ">
          <div id="time-status">
            <span class="hidden" id="hours-left"></span>
            <span id="min-left"></span>
            <span id="sec-left"></span>
            left
          </div>

          <span id="session-time" style="display: none;"></span>

          <span id="break-time" style="display: none;"></span>
        </b>
      </div>
      <?php
        }elseif($current_time > $examEndTimestamp){
          ?>
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <b style="position:fixed; z-index:999; right:1%; top:10%;opacity: 0.8;"
          class="alert alert-danger solid alert-rounded ">
          <div id="time-status">
            <span class="hidden" id="hours-left"></span>
            <span id="min-left"></span>
            <span id="sec-left"></span>
            left
          </div>

          <span id="session-time" style="display: none;"></span>

          <span id="break-time" style="display: none;"></span>
        </b>
      </div>
      <?php
        }
      }
      ?>
      <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
          <div class="welcome-text">
            <h4><?=$examNme?></h4>

          </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Exam</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)"><?=$examNme?></a></li>
          </ol>
        </div>
      </div>

      <?php
      if($current_time < $examStartTimestamp){
        ?>
      <div class="row">
        <div class="col-xl-12 col-xxl-12">
          <div class="card">
            <div class="card-body">
              <div class="card-header text-dark font-weight-bold">
                <h3> <?=$examNme?></h3>
              </div>


              <span class="badge bg-warning" style="color:#000000;width:100%;">Exam Will Started at
                <?=$new_start_date." ".$new_start_time?></span>

              <div class="text-dark">
                <p>Total marks: <?=$mcqMarks?></p>
                <p>Time: <?php
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
                      ?></p>
                <p>Number of Questions: <?php 
                    $countQuestion = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$examId'");
                    $countNumbers = mysqli_num_rows($countQuestion);
                    echo $countNumbers;
                    ?></p>
              </div>
              <a href="all-exam?Exams" class="btn btn-primary">Go Back</a>
            </div>




          </div>
        </div>
      </div>
      <?php
      }elseif($current_time >= $examStartTimestamp && $current_time < $examEndTimestamp){
        ?>
      <div class="row">
        <div class="col-xl-12 col-xxl-12">
          <form action="" method="post">
            <input type="hidden" value="<?=$examId?>" name="exam_id">
            <input type="hidden" value="<?=$duration?>" id="timeLeft">
            <div class="card">

              <?php 
              if($custom_exam_type == 0){
                $i = 0;
          $select = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$examId'");
          if(mysqli_num_rows($select) > 0){
            while($row = mysqli_fetch_array($select)){
              $i++;
              ?>
              <div class="card-body">
                <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
                <span class="badge bg-light text-dark"
                  style="float: right; margin-right:20px; color:#000000; font-weight:bold">Mark
                  :
                  <?=$row['mark']?></span>
                <div class="radio-list col-xl-12">
                  <p for="" class="font-weight-bold text-dark my-3 h4" style="color:#000000;">
                    <?=$row['question']?>
                  </p>
                  <?php
                 if(isset($row['option_1'])){
                  ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="1 " id="radio1<?=$i?>">
                    <label for="radio1<?=$i?>"><?=$row['option_1']?></label>
                  </div>
                  <?php
                 }
                 ?>
                  <?php
                 if(isset($row['option_2'])){
                  ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="2" id="radio2<?=$i?>">
                    <label for="radio2<?=$i?>"><?=$row['option_2']?></label>
                  </div>
                  <?php
                 }
                 ?>
                  <?php
                  if($row['option_3'] != NULL){
                    if(isset($row['option_3'])){
                      ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="3" id="radio3<?=$i?>">
                    <label for="radio3<?=$i?>"><?=$row['option_3']?></label>
                  </div>
                  <?php
                     }
                  }
                 ?>
                  <?php
                 if($row['option_4'] != NULL){
                  if(isset($row['option_4'])){
                    ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="4" id="radio4<?=$i?>">
                    <label for="radio4<?=$i?>"><?=$row['option_4']?></label>
                  </div>
                  <?php
                   }
                 }
                 ?>

                  <?php
                  if($row['option_5'] != NULL){
                    if(isset($row['option_5'])){
                      ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="6" id="radio5<?=$i?>">
                    <label for="radio5<?=$i?>"><?=$row['option_5']?></label>
                  </div>
                  <?php
                     }
                  }
                 ?>

                  <input type="radio" checked value="5" name="<?=$row['id']?>" style="display:none;">
                </div>

              </div>
              <?php
            }
          }
              }elseif($custom_exam_type == 1){
              $i=0;
              
              $selectQuestion = mysqli_query($con,"SELECT * FROM exam_question WHERE exam_id='$examId' AND isTrue='0'");
              if(mysqli_num_rows($selectQuestion) > 0){
                while($examQuestion = mysqli_fetch_array($selectQuestion)){
                  $select = mysqli_query($con, "SELECT * FROM questions WHERE id=".$examQuestion['question_id']);
              if(mysqli_num_rows($select) > 0){
                while($row = mysqli_fetch_array($select)){
                  $i++;
                  ?>
              <div class="card-body">
                <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
                <span class="badge bg-light text-dark"
                  style="float: right; margin-right:20px; color:#000000; font-weight:bold">Mark
                  :
                  <?=$marks?></span>
                <div class="radio-list col-xl-12">
                  <p for="" class="font-weight-bold text-dark my-3 h4" style="color:#000000;">
                    <?=$row['question']?>
                  </p>
                  <?php
                     if(isset($row['option_1'])){
                      ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="1 " id="radio1<?=$i?>">
                    <label for="radio1<?=$i?>"><?=$row['option_1']?></label>
                  </div>
                  <?php
                     }
                     ?>
                  <?php
                     if(isset($row['option_2'])){
                      ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="2" id="radio2<?=$i?>">
                    <label for="radio2<?=$i?>"><?=$row['option_2']?></label>
                  </div>
                  <?php
                     }
                     ?>
                  <?php
                     if($row['option_3'] != NULL){
                      if(isset($row['option_3'])){
                        ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="3" id="radio3<?=$i?>">
                    <label for="radio3<?=$i?>"><?=$row['option_3']?></label>
                  </div>
                  <?php
                       }
                     }
                     ?>
                  <?php
                    if($row['option_4'] != NULL){
                      if(isset($row['option_4'])){
                        ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="4" id="radio4<?=$i?>">
                    <label for="radio4<?=$i?>"><?=$row['option_4']?></label>
                  </div>
                  <?php
                       }
                    }
                     ?>
                  <?php
                  if($row['option_5'] != NULL){
                    if(isset($row['option_5'])){
                      ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="6" id="radio5<?=$i?>">
                    <label for="radio5<?=$i?>"><?=$row['option_5']?></label>
                  </div>
                  <?php
                     }
                  }
                 ?>

                  <input type="radio" checked value="5" name="<?=$row['id']?>" style="display:none;">
                </div>

              </div>
              <?php
                }
              }
                }
              }
               // true false
               $selectQuestionTrue = mysqli_query($con,"SELECT * FROM exam_question WHERE exam_id='$examId' AND isTrue='1'");
 
               if(mysqli_num_rows($selectQuestionTrue) > 0){
                 while($examQuestionRow = mysqli_fetch_array($selectQuestionTrue)){
                 $trueFalseId= $examQuestionRow['question_id'];
                   $selectTrue = mysqli_query($con, "SELECT * FROM true_false_question WHERE id='$trueFalseId'");
                   if(mysqli_num_rows($selectTrue) > 0){
                     while($rowTrueFalse = mysqli_fetch_array($selectTrue)){
                       $QuestionID = $rowTrueFalse['id'];
                       $i++;
                       ?>
              <div class="card-body">
                <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
                <div class="radio-list col-xl-12">
                  <p for="" class="font-weight-bold text-dark my-3 h4">
                    <?=$rowTrueFalse['question']?>
                  </p>

                  <?php 
                       $j = 1;
                       $optionSearch = mysqli_query($con,"SELECT * FROM true_false_options WHERE question_id='$QuestionID'");
                       if(mysqli_num_rows($optionSearch) > 0){
                         while($optionRow = mysqli_fetch_array($optionSearch)){
                           ?>
                  <span class="btn btn-dark btn-sm my-2">Option <?=$j?></span>
                  <div class="true-false">
                    <label for="radio1<?=$i.$j?>"><?=$optionRow['option_1']?></label>
                  </div>


                  <div class="radio-item" style="width:80%">
                    <input type="radio" name="<?=$optionRow['id']?>" value="1" id="radio4<?=$i.$j?>">
                    <label for="radio4<?=$i.$j?>">True</label>
                  </div>

                  <div class="radio-item" style="width:80%">
                    <input type="radio" name="<?=$optionRow['id']?>" value="0" id="radio5<?=$i.$j?>">
                    <label for="radio5<?=$i.$j?>">False</label>
                  </div>

                  <input type="radio" value="5" checked name="<?=$optionRow['id']?>" style="display:none;">

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

                 }
               }
                               
              }else{
                # true false exam
                $i=0;
                $selectQuestion = mysqli_query($con,"SELECT * FROM exam_question WHERE exam_id='$examId' AND isTrue='1'");

                if(mysqli_num_rows($selectQuestion) > 0){
                  while($examQuestion = mysqli_fetch_array($selectQuestion)){
                  $trueFalseId= $examQuestion['question_id'];
                    $select = mysqli_query($con, "SELECT * FROM true_false_question WHERE id='$trueFalseId'");
                    if(mysqli_num_rows($select) > 0){
                      while($row = mysqli_fetch_array($select)){
                        $QuestionID = $row['id'];
                        $i++;
                        ?>
              <div class="card-body">
                <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
                <div class="radio-list col-xl-12">
                  <p for="" class="font-weight-bold text-dark my-3 h4">
                    <?=$row['question']?>
                  </p>

                  <?php 
                        $j = 1;
                        $optionSearch = mysqli_query($con,"SELECT * FROM true_false_options WHERE question_id='$QuestionID'");
                        if(mysqli_num_rows($optionSearch) > 0){
                          while($optionRow = mysqli_fetch_array($optionSearch)){
                            ?>
                  <span class="btn btn-dark btn-sm my-2">Option <?=$j?></span>
                  <div class="true-false">
                    <label for="radio1<?=$i.$j?>"><?=$optionRow['option_1']?></label>
                  </div>


                  <div class="radio-item" style="width:80%">
                    <input type="radio" name="<?=$optionRow['id']?>" value="1" id="radio4<?=$i.$j?>">
                    <label for="radio4<?=$i.$j?>">True</label>
                  </div>

                  <div class="radio-item" style="width:80%">
                    <input type="radio" name="<?=$optionRow['id']?>" value="0" id="radio5<?=$i.$j?>">
                    <label for="radio5<?=$i.$j?>">False</label>
                  </div>

                  <input type="radio" value="5" checked name="<?=$optionRow['id']?>" style="display:none;">

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

                  }
                }
                
              }
          ?>
              <button type="submit" id="submitBtn" name="submitExam"
                class="btn btn-primary btn-lg col-xl-12 text-light">Final
                Submission</button>
            </div>

          </form>
        </div>
      </div>
      <?php
      }elseif($current_time >= $examEndTimestamp){  
        if($examType == 1){
          ?>
      <div class="card text-center col-lg-12">
        <div class="card-header text-dark font-weight-bold">
          <h3> <?=$examNme?></h3>
        </div>
        <div class="card-body">
          <h6 class="card-title mb-4"><span class="alert alert-light">Opps! The exam was finished.</span></h6>

          <a href="leaderboard?Leader-Board=<?=$examId?>" class="btn btn-info">Leader Board</a>
        </div>
      </div>
      <?php
        }else{
          ?>
      <div class="row">
        <div class="col-xl-12 col-xxl-12">
          <form action="" method="post">
            <input type="hidden" value="<?=$examId?>" name="exam_id">
            <input type="hidden" value="<?=$duration?>" id="timeLeft">
            <div class="card">

              <?php 
                  if($custom_exam_type == 0){
                    $i = 0;
              $select = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$examId'");
              if(mysqli_num_rows($select) > 0){
                while($row = mysqli_fetch_array($select)){
                  $i++;
                  ?>
              <div class="card-body">
                <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
                <span class="badge bg-light text-dark"
                  style="float: right; margin-right:20px; color:#000000; font-weight:bold">Mark
                  :
                  <?=$row['mark']?></span>
                <div class="radio-list col-xl-12">
                  <p for="" class="font-weight-bold text-dark my-3 h4" style="color:#000000;">
                    <?=$row['question']?>
                  </p>
                  <?php
                     if(isset($row['option_1'])){
                      ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="1 " id="radio1<?=$i?>">
                    <label for="radio1<?=$i?>"><?=$row['option_1']?></label>
                  </div>
                  <?php
                     }
                     ?>
                  <?php
                     if(isset($row['option_2'])){
                      ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="2" id="radio2<?=$i?>">
                    <label for="radio2<?=$i?>"><?=$row['option_2']?></label>
                  </div>
                  <?php
                     }
                     ?>
                  <?php
                    if($row['option_3'] != NULL){
                      if(isset($row['option_3'])){
                        ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="3" id="radio3<?=$i?>">
                    <label for="radio3<?=$i?>"><?=$row['option_3']?></label>
                  </div>
                  <?php
                       }
                    }
                     ?>
                  <?php
                     if($row['option_4'] != NULL){
                      if(isset($row['option_4'])){
                        ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="4" id="radio4<?=$i?>">
                    <label for="radio4<?=$i?>"><?=$row['option_4']?></label>
                  </div>
                  <?php
                       }
                     }
                     ?>

                  <?php
                  if($row['option_5'] != NULL){
                    if(isset($row['option_5'])){
                      ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="6" id="radio5<?=$i?>">
                    <label for="radio5<?=$i?>"><?=$row['option_5']?></label>
                  </div>
                  <?php
                     }
                  }
                 ?>

                  <input type="radio" checked value="5" name="<?=$row['id']?>" style="display:none;">
                </div>

              </div>
              <?php
                }
              }
                  }elseif($custom_exam_type == 1){
                    $i=0;
              
                    $selectQuestion = mysqli_query($con,"SELECT * FROM exam_question WHERE exam_id='$examId' AND isTrue='0'");
                    if(mysqli_num_rows($selectQuestion) > 0){
                      while($examQuestion = mysqli_fetch_array($selectQuestion)){
                        $select = mysqli_query($con, "SELECT * FROM questions WHERE id=".$examQuestion['question_id']);
                    if(mysqli_num_rows($select) > 0){
                      while($row = mysqli_fetch_array($select)){
                        $i++;
                        ?>
              <div class="card-body">
                <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
                <span class="badge bg-light text-dark"
                  style="float: right; margin-right:20px; color:#000000; font-weight:bold">Mark
                  :
                  <?=$marks?></span>
                <div class="radio-list col-xl-12">

                  <p for="" class="font-weight-bold text-dark my-3 h4" style="color:#000000;">
                    <?=$row['question']?>
                  </p>
                  <?php
                           if(isset($row['option_1'])){
                            ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="1 " id="radio1<?=$i?>">
                    <label for="radio1<?=$i?>"><?=$row['option_1']?></label>
                  </div>
                  <?php
                           }
                           ?>
                  <?php
                           if(isset($row['option_2'])){
                            ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="2" id="radio2<?=$i?>">
                    <label for="radio2<?=$i?>"><?=$row['option_2']?></label>
                  </div>
                  <?php
                           }
                           ?>
                  <?php
                           if($row['option_3'] != NULL){
                            if(isset($row['option_3'])){
                              ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="3" id="radio3<?=$i?>">
                    <label for="radio3<?=$i?>"><?=$row['option_3']?></label>
                  </div>
                  <?php
                             }
                           }
                           ?>
                  <?php
                          if($row['option_4'] != NULL){
                            if(isset($row['option_4'])){
                              ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="4" id="radio4<?=$i?>">
                    <label for="radio4<?=$i?>"><?=$row['option_4']?></label>
                  </div>
                  <?php
                             }
                          }
                           ?>
                  <?php
                        if($row['option_5'] != NULL){
                          if(isset($row['option_5'])){
                            ?>
                  <div class="radio-item">
                    <input type="radio" name="<?=$row['id']?>" value="6" id="radio5<?=$i?>">
                    <label for="radio5<?=$i?>"><?=$row['option_5']?></label>
                  </div>
                  <?php
                           }
                        }
                       ?>

                  <input type="radio" checked value="5" name="<?=$row['id']?>" style="display:none;">
                </div>

              </div>
              <?php
                      }
                    }
                      }
                    }
               // true false
                    $selectQuestionTrue = mysqli_query($con,"SELECT * FROM exam_question WHERE exam_id='$examId' AND isTrue='1'");
 
                 if(mysqli_num_rows($selectQuestionTrue) > 0){
                   while($examQuestionRow = mysqli_fetch_array($selectQuestionTrue)){
                   $trueFalseId= $examQuestionRow['question_id'];
                     $selectTrue = mysqli_query($con, "SELECT * FROM true_false_question WHERE id='$trueFalseId'");
                     if(mysqli_num_rows($selectTrue) > 0){
                       while($rowTrueFalse = mysqli_fetch_array($selectTrue)){
                         $QuestionID = $rowTrueFalse['id'];
                         $i++;
                         ?>
              <div class="card-body">
                <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
                <div class="radio-list col-xl-12">
                  <p for="" class="font-weight-bold text-dark my-3 h4">
                    <?=$rowTrueFalse['question']?>
                  </p>

                  <?php 
                         $j = 1;
                         $optionSearch = mysqli_query($con,"SELECT * FROM true_false_options WHERE question_id='$QuestionID'");
                         if(mysqli_num_rows($optionSearch) > 0){
                           while($optionRow = mysqli_fetch_array($optionSearch)){
                             ?>
                  <span class="btn btn-dark btn-sm my-2">Option <?=$j?></span>
                  <div class="true-false">
                    <label for="radio1<?=$i.$j?>"><?=$optionRow['option_1']?></label>
                  </div>


                  <div class="radio-item" style="width:80%">
                    <input type="radio" name="<?=$optionRow['id']?>" value="1" id="radio4<?=$i.$j?>">
                    <label for="radio4<?=$i.$j?>">True</label>
                  </div>

                  <div class="radio-item" style="width:80%">
                    <input type="radio" name="<?=$optionRow['id']?>" value="0" id="radio5<?=$i.$j?>">
                    <label for="radio5<?=$i.$j?>">False</label>
                  </div>

                  <input type="radio" value="5" checked name="<?=$optionRow['id']?>" style="display:none;">

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
 
                   }
                 }


                  }else{
                 # true false exam
                 $i=0;
                 $selectQuestion = mysqli_query($con,"SELECT * FROM exam_question WHERE exam_id='$examId' AND isTrue='1'");
 
                 if(mysqli_num_rows($selectQuestion) > 0){
                   while($examQuestion = mysqli_fetch_array($selectQuestion)){
                   $trueFalseId= $examQuestion['question_id'];
                     $select = mysqli_query($con, "SELECT * FROM true_false_question WHERE id='$trueFalseId'");
                     if(mysqli_num_rows($select) > 0){
                       while($row = mysqli_fetch_array($select)){
                         $QuestionID = $row['id'];
                         $i++;
                         ?>
              <div class="card-body">
                <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
                <div class="radio-list col-xl-12">
                  <p for="" class="font-weight-bold text-dark my-3 h4">
                    <?=$row['question']?>
                  </p>

                  <?php 
                         $j = 1;
                         $optionSearch = mysqli_query($con,"SELECT * FROM true_false_options WHERE question_id='$QuestionID'");
                         if(mysqli_num_rows($optionSearch) > 0){
                           while($optionRow = mysqli_fetch_array($optionSearch)){
                             ?>
                  <span class="btn btn-dark btn-sm my-2">Option <?=$j?></span>
                  <div class="true-false">
                    <label for="radio1<?=$i.$j?>"><?=$optionRow['option_1']?></label>
                  </div>


                  <div class="radio-item" style="width:80%">
                    <input type="radio" name="<?=$optionRow['id']?>" value="1" id="radio4<?=$i.$j?>">
                    <label for="radio4<?=$i.$j?>">True</label>
                  </div>

                  <div class="radio-item" style="width:80%">
                    <input type="radio" name="<?=$optionRow['id']?>" value="0" id="radio5<?=$i.$j?>">
                    <label for="radio5<?=$i.$j?>">False</label>
                  </div>

                  <input type="radio" value="5" checked name="<?=$optionRow['id']?>" style="display:none;">

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
 
                   }
                 }
                  }
              ?>
              <button type="submit" id="submitBtn" name="submitExam"
                class="btn btn-primary btn-lg col-xl-12 text-light">Final
                Submission</button>
            </div>

          </form>
        </div>
      </div>
      <?php
        }
      }
      ?>

      <?php
    }elseif (isset($_GET['CustomExam'])) {
      # code...
      ?>
      <div class="content-body">
        <div class="container-fluid">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <b style="position:fixed; z-index:999; right:1%; top:10%;opacity: 0.8;"
              class="alert alert-danger solid alert-rounded ">
              <div id="time-status">
                <span class="hidden" id="hours-left"></span>
                <span id="min-left"></span>
                <span id="sec-left"></span>
                left
              </div>

              <span id="session-time" style="display: none;"></span>

              <span id="break-time" style="display: none;"></span>
            </b>
          </div>
          <!-- row -->
          <?php
               if(isset($_POST['create_exam'])){
                $exam_name = $_POST['exam_name'];
                $marks = $_POST['custom_mark'];
                $negative_marks = $_POST['negative_mark'];
                $duration = $_POST['duration'] * 60;
                $customExam_id = "cu".uniqid();
                $examStart = time();
                date_default_timezone_set('Asia/dhaka');
                $exam_date= date('d M Y h:i A', $examStart);
                
                
                $i = 0;
          ?>
          <div class="row">
            <div class="col-xl-12 col-xxl-12">
              <form action="" method="post">
                <input type="hidden" id="timeLeft" value="<?=$duration?>">
                <input type="hidden" id="" name="negative_mark" value="<?=$negative_marks?>">
                <input type="hidden" id="" name="mark" value="<?=$marks?>">
                <input type="hidden" id="" name="exam_id" value="<?=$customExam_id?>">
                <div class="card">

                  <!-- code for auto fetch questions -->
                  <?php
                  $sumLimit = 0;
                $search_subject = mysqli_query($con, "SELECT * FROM subjects");
                if(mysqli_num_rows($search_subject) > 0){
                  while ($subject_row = mysqli_fetch_array($search_subject)) {
                    if($_POST[$subject_row['id']] != 0 && $_POST[$subject_row['id']] != NULL){
                      $limit = $_POST[$subject_row['id']];
                      $subject_id = $subject_row['id'];
                      $sumLimit = $sumLimit + $limit; 

                      // code for chapter checkbox
                      $checkedChapter = [];
                      if(isset($_POST[$subject_id.'chapter'])){
                      $checkedChapter = $_POST[$subject_id.'chapter'];  
                    }else{
                      $checkedChapter = NULL;  
                    }
                  
                      if($limit !=0){
                        if($checkedChapter == NULL){
                              if($limit != NULL){
                                $select = mysqli_query($con, "SELECT * FROM questions WHERE subject_id='$subject_id' ORDER BY RAND() LIMIT $limit");
                                if(mysqli_num_rows($select) > 0){
                                  while($row = mysqli_fetch_array($select)){
                                    $qsId = $row['id'];
                                    $matchQues = mysqli_query($con,"SELECT * FROM custom_exam_question WHERE question_id='$qsId' AND  exam_id='$customExam_id'");
                                    if(mysqli_num_rows($matchQues) > 0){
                                      continue;
                                    }
                                    $ins = mysqli_query($con,"INSERT INTO custom_exam_question (`exam_id`, `question_id`,`subject_id`) VALUES ('$customExam_id','$qsId','$subject_id')");
                                  }
                              }
                              }
                            
                        }else{
                          
                        for($c=1;$c<=$limit;$c++){
                          foreach($checkedChapter as $chapterId){
                      
                            if($limit != NULL){
                              $select = mysqli_query($con, "SELECT * FROM questions WHERE subject_id='$subject_id' AND chapter_id='$chapterId' ORDER BY RAND() LIMIT 1");
                              if(mysqli_num_rows($select) > 0){
                                while($row = mysqli_fetch_array($select)){
                                  $qsId = $row['id'];
                                  $matchQues = mysqli_query($con,"SELECT * FROM custom_exam_question WHERE question_id='$qsId' AND exam_id='$customExam_id'");
                                  if(mysqli_num_rows($matchQues) > 0){
                                    continue;
                                  }
                                  $ins = mysqli_query($con,"INSERT INTO custom_exam_question (`exam_id`,`question_id`,`subject_id`) VALUES ('$customExam_id','$qsId','$subject_id')");
                                }
                            }
                            }
                            $countAddedQuestion = mysqli_query($con,"SELECT * FROM custom_exam_question WHERE exam_id='$customExam_id' AND subject_id='$subject_id'");
                            $countNum = mysqli_num_rows($countAddedQuestion);
                          
                          if($countNum >= $limit){
                            break;
                          }
                          }
                          if($countNum >= $limit){
                            break;
                          }
                          
                        }
                        
                      }
                     }  
                    }
                  }
                }
                
                $select = mysqli_query($con, "SELECT * FROM custom_exam_question WHERE exam_id='$customExam_id'");
                if(mysqli_num_rows($select) > 0){
                  while($row = mysqli_fetch_array($select)){
                    $question_id = $row['question_id'];
                    $i++;
                    $getQuestion = mysqli_query($con,"SELECT * FROM questions WHERE id='$question_id'");
                    if(mysqli_num_rows($getQuestion) > 0){
                      $quesRow = mysqli_fetch_array($getQuestion);
                      ?>
                  <div class="card-body">
                    <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
                    <span class="badge bg-light text-dark"
                      style="float: right; margin-right:20px; color:#000000; font-weight:bold">Mark
                      :
                      <?=$marks?></span>
                    <div class="radio-list col-xl-12">
                      <p for="" class="font-weight-bold text-dark my-3 h4" style="color:#000000;">
                        <?=$quesRow['question']?>
                      </p>
                      <?php
                       if(isset($quesRow['option_1'])){
                        ?>
                      <div class="radio-item">
                        <input type="radio" name="<?=$quesRow['id']?>" value="1 " id="radio1<?=$i?>">
                        <label for="radio1<?=$i?>"><?=$quesRow['option_1']?></label>
                      </div>
                      <?php
                       }
                       ?>
                      <?php
                       if(isset($quesRow['option_2'])){
                        ?>
                      <div class="radio-item">
                        <input type="radio" name="<?=$quesRow['id']?>" value="2" id="radio2<?=$i?>">
                        <label for="radio2<?=$i?>"><?=$quesRow['option_2']?></label>
                      </div>
                      <?php
                       }
                       ?>
                      <?php
                        if($quesRow['option_3'] != NULL){
                          if(isset($quesRow['option_3'])){
                            ?>
                      <div class="radio-item">
                        <input type="radio" name="<?=$quesRow['id']?>" value="3" id="radio3<?=$i?>">
                        <label for="radio3<?=$i?>"><?=$quesRow['option_3']?></label>
                      </div>
                      <?php
                           }
                        }
                       ?>
                      <?php
                        if($quesRow['option_4'] != NULL){
                          if(isset($quesRow['option_4'])){
                            ?>
                      <div class="radio-item">
                        <input type="radio" name="<?=$quesRow['id']?>" value="4" id="radio4<?=$i?>">
                        <label for="radio4<?=$i?>"><?=$quesRow['option_4']?></label>
                      </div>
                      <?php
                           }
                        }
                       ?>

                      <?php
                        if($quesRow['option_5'] != NULL){
                          if(isset($quesRow['option_5'])){
                            ?>
                      <div class="radio-item">
                        <input type="radio" name="<?=$quesRow['id']?>" value="6" id="radio5<?=$i?>">
                        <label for="radio5<?=$i?>"><?=$quesRow['option_5']?></label>
                      </div>
                      <?php
                           }
                        }
                       ?>
                      <input type="radio" checked value="5" name="<?=$quesRow['id']?>" style="display:none;">
                    </div>

                  </div>
                  <?php
                    }
                  }
                }
                ?>
                  <?php
                  //insert new custom exam
                  $insertCustomExam = mysqli_query($con,"INSERT INTO custom_exam (`exam_name`, `exam_id`, `duration`,
                  `exam_start`, `mcq_marks`,`negative_mark`,`total_questions`, `student_id`)
                  VALUES
                  ('$exam_name','$customExam_id','$duration','$exam_date','$marks','$negative_marks','$sumLimit','$student_id')");
                  ?>

                  <button type="submit" id="submitBtn" name="submitCustomExam"
                    class="btn btn-primary btn-lg col-xl-12 text-light">Final
                    Submission</button>
                </div>

              </form>
            </div>
          </div>
          <?php
          }
          ?>
        </div>
      </div>
      <?php
    
    }else{
        echo '<div class="alert alert-danger text-light">Page not found</div>';
    }
    ?>

    </div>
  </div>


  <?php
    }else{
      ?>
  <div class="content-body">
    <div class="container-fluid">
      <p class="alert alert-danger text-white">No courses Purchased Yet!</p>
    </div>
  </div>
  <?php
    }
    ?>

  <!--  Footer ---->
  <?php include "includes/footer.php"; ?>
  <?php include './includes/code.php';?>

</body>

</html>