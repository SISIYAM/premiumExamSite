<?php
include '../Admin/includes/dbcon.php';
 // auto update exam type
 if(isset($_POST['examType'])){
  $student_id = $_POST['studentID'];
  $searchExamTime = mysqli_query($con,"SELECT * FROM exam WHERE type=1");
  if(mysqli_num_rows($searchExamTime) > 0){
    while($typeResult = mysqli_fetch_array($searchExamTime)){
      $examTypeId = $typeResult['id'];
        // current time
        date_default_timezone_set("Asia/Dhaka");
        $ExamTypeDate = date('Y-m-d H:i');
        $ExamTypeCurrent_time = strtotime($ExamTypeDate);

        // convert into timestamp
        $examTypeStartDate = $typeResult['exam_start']." ".$typeResult['exam_start_time'];
        $examTypeEndDate = $typeResult['exam_end']." ".$typeResult['exam_end_time'];
  
        $examTypeStartTimestamp = strtotime($examTypeStartDate);
        $examTypeEndTimestamp = strtotime($examTypeEndDate);

        if($ExamTypeCurrent_time > $examTypeEndTimestamp){
          $typeSQL = mysqli_query($con, "UPDATE exam SET type=0 WHERE id='$examTypeId'");
          if($typeSQL){
            echo "Success";
          }else{
            echo "Failed";
          }
        }else{
          echo "Time not expired";
        }
    }
  }

  // course 
  $checkCourse = mysqli_query($con, "SELECT * FROM package_record WHERE student_id='$student_id' AND status='1'");
  if(mysqli_num_rows($checkCourse) > 0){
    while($courseRes = mysqli_fetch_array($checkCourse)){
      $course_id = $courseRes['package_id'];
      $timeStamp = $courseRes['timestamp'];
      
      $checkCourse = mysqli_query($con, "SELECT * FROM package WHERE package_id='$course_id' AND status='1'");
      if(mysqli_num_rows($checkCourse) > 0){
        $durationCourse = mysqli_fetch_array($checkCourse)['duration'];
      }

      if((time() - $timeStamp) > $durationCourse){
        $updateCourse = mysqli_query($con,"UPDATE package_record SET status='0' WHERE student_id='$student_id' AND package_id='$course_id'");
      }
    }
  }
 }

 // auto expire course
 if(isset($_POST['expiryDate'])){
  $searchExpiryDate = mysqli_query($con,"SELECT * FROM package WHERE status=1");
  if(mysqli_num_rows($searchExpiryDate) > 0){
    while($expiryDateResult = mysqli_fetch_array($searchExpiryDate)){
        $packageId = $expiryDateResult['package_id'];
        // current time
        date_default_timezone_set("Asia/Dhaka");
        $expiry_dateDate = date('Y-m-d H:i');
        $expiry_dateCurrent_time = strtotime($expiry_dateDate);

        // convert into timestamp
        $expiry_date = $expiryDateResult['expiry_date'];
        
  
        $expiry_dateStartTimestamp = strtotime($expiry_date);

        if($expiry_dateCurrent_time >= $expiry_dateStartTimestamp){
          $updatePackage = mysqli_query($con, "UPDATE package SET status=0 WHERE package_id='$packageId'");
          if($updatePackage){
            echo "Success";
          }else{
            echo "Failed";
          }
        }else{
          echo "Time not expired";
        }
    }
  }
 }

 // add to bookmark
 if(isset($_POST['bookmarkBtn'])){
  $student_id = $_POST['student_id'];
  $question_id = $_POST['question_id'];
  $question_type = $_POST['question_type'];

  $sql = mysqli_query($con, "INSERT INTO bookmark (student_id,question_id,question_type) VALUES ('$student_id','$question_id','$question_type')");
  
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
 }

 // delete bookmark
 if(isset($_POST['deleteBookmark'])){
  $id = $_POST['id'];
  $student_id = $_POST['student_id'];
  
  $delete = mysqli_query($con, "DELETE FROM bookmark WHERE question_id='$id' AND student_id='$student_id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
 }
?>