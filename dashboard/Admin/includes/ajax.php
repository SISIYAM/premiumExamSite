<?php
include 'dbcon.php';

// search student information
if(isset($_POST['searchStudentInformation'])){
  $id = $_POST['id'];
  $output = "";
  $search = mysqli_query($con,"SELECT * FROM students WHERE id ='$id'");
  if(mysqli_num_rows($search) > 0){
     $row = mysqli_fetch_array($search);
     $output = ' 
   <label for="email">Student ID: </label>
     <div class="form-group">
       <input type="text" value="'.$row['student_id'].'" class="form-control" readonly>
     </div>
     <label for="name">Name: </label>
     <div class="form-group">
       <input type="text" value="'.$row['full_name'].'" class="form-control" readonly>
     </div>
     <label for="email">Username: </label>
     <div class="form-group">
       <input type="text" value="'.$row['username'].'" class="form-control" readonly>
     </div>
   <label for="email">Email: </label>
     <div class="form-group">
       <input type="text" value="'.$row['email'].'" class="form-control" readonly>
     </div>
     <label for="email">Mobile: </label>
     <div class="form-group">
       <input type="text" value="'.$row['mobile'].'" class="form-control" readonly>
     </div>
     <label for="email">Medical College: </label>
     <div class="form-group">
       <input type="text" value="'.$row['college'].'" class="form-control" readonly>
     </div>
     <label for="email">Passing Year: </label>
     <div class="form-group">
       <input type="text" value="'.$row['hsc'].'" class="form-control" readonly>
     </div>
     ';
     echo $output;
  }
  else{
     $output = '<div class="alert alert-danger">No data found.</div>';
     echo $output;
  }
}

// search chapter information
if(isset($_POST['searchChapterInformation'])){
  $id = $_POST['id'];
  $output = "";
  $search = mysqli_query($con,"SELECT * FROM chapter WHERE id ='$id'");
  if(mysqli_num_rows($search) > 0){
     $row = mysqli_fetch_array($search);
     $output = ' 
     <input value="'.$row['id'].'" type="hidden" id="chapterId">
     <label for="email">Chapter Name: </label>
     <div class="form-group">
       <input type="text" id="chapterName" value="'.$row['name'].'" class="form-control">
     </div>
     ';
     echo $output;
  }
  else{
     $output = '<div class="alert alert-danger">No data found.</div>';
     echo $output;
  }
}


if(isset($_POST['searchSubjectInformation'])){
  $id = $_POST['id'];
  $output = "";
  $search = mysqli_query($con,"SELECT * FROM subjects WHERE id ='$id'");
  if(mysqli_num_rows($search) > 0){
     $row = mysqli_fetch_array($search);
     $output = ' 
     <input value="'.$row['id'].'" type="hidden" id="subjectID">
     <label for="email">Subject Name: </label>
     <div class="form-group">
       <input type="text" id="subjectName" value="'.$row['subject'].'" class="form-control">
     </div>
     ';
     echo $output;
  }
  else{
     $output = '<div class="alert alert-danger">No data found.</div>';
     echo $output;
  }
}


// update chapter 
if(isset($_POST['saveChapterEdit'])){
  $chapter_id = $_POST['id'];
  $chapter_name =  str_replace("'","\'", $_POST['name']);
  
  $sql = mysqli_query($con, "UPDATE chapter SET name='$chapter_name' WHERE id='$chapter_id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}

// update subject 
if(isset($_POST['saveSubjectEdit'])){
  $subject_id = $_POST['id'];
  $subject_name = str_replace(' ', '_', str_replace("'","\'", $_POST['name']));;
  

  $oldSubject = mysqli_query($con, "SELECT * FROM subjects WHERE id='$subject_id'");
  $oldName = mysqli_fetch_array($oldSubject)['subject'];
  
  $sql = mysqli_query($con, "UPDATE subjects SET subject='$subject_name' WHERE id='$subject_id'");
  if($sql){
    $updateColumn = mysqli_query($con, "ALTER TABLE `exam` CHANGE $oldName $subject_name VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL");
    if($updateColumn){
      echo 200;
    }else{
      echo 900;
    }
  }else{
    echo 500;
  }
}


// search exam information
if(isset($_POST['searchExamInformation'])){
  $id = $_POST['id'];
  $output = "";
  $search = mysqli_query($con,"SELECT * FROM exam WHERE id ='$id'");
  if(mysqli_num_rows($search) > 0){
     $row = mysqli_fetch_array($search);
     $course_id = $row['course_id'];
     $courseName = '';
     $searchCourse = mysqli_query($con,"SELECT * FROM package");
     if(mysqli_num_rows($searchCourse) > 0){
      while($resCourse = mysqli_fetch_array($searchCourse)){
        $courseName .= '<option value="'.$resCourse['package_id'].'">'.$resCourse['name'].'</option>';
      }
     }
     $course = "No courses Selected Yet!";
     $addedCourse = mysqli_query($con,"SELECT * FROM package WHERE package_id='$course_id'");
     if(mysqli_num_rows($addedCourse) > 0){
      $selectedCourse = mysqli_fetch_array($addedCourse)['name'];
      if($selectedCourse != NULL){
        $course = $selectedCourse;
        }
     }
   
    

     if($row['type'] == 1){ 
      $examType = '<option selected value="1">Live Exam</option>
      <option  value="0">Practice Exam</option>';
     }else{
      $examType = '<option selected value="0">Practice Exam</option>
      <option  value="1">Live Exam</option>';
     }
     
     $output = ' 
     <input type="hidden" value="'.$row['id'].'" id="exam_edit_id">
   <label for="email">Exam Name: </label>
     <div class="form-group">
       <input type="text" value="'.$row['exam_name'].'" id="examName" class="form-control">
     </div>
     <label for="email">Exam Type: </label>
     <div class="form-group">
       <select name="type" id="examType" class="form-select">
       '.$examType.'
       </select>
     </div>
     <label for="email">Course Name: </label>
     <div class="form-group">
       <select name="course" id="courseName" class="form-select">
       <option selected value="'.$course_id.'">'.$course.'</option>
       '.$courseName.'
       </select>
     </div>
     <label for="name">Exam Start Date: </label>
     <div class="form-group">
       <input type="date" value="'.$row['exam_start'].'" id="examDate" class="form-control">
     </div>
     <label for="name">Exam Start Time: </label>
     <div class="form-group">
       <input type="time" value="'.$row['exam_start_time'].'" id="examStartTime" class="form-control">
     </div>
     <label for="email">Exam End Date: </label>
     <div class="form-group">
       <input type="date" value="'.$row['exam_end'].'" id="examEnd" class="form-control">
     </div>
     <label for="email">Exam End Time: </label>
     <div class="form-group">
       <input type="time" value="'.$row['exam_end_time'].'" id="examEndTime" class="form-control">
     </div>
   <label for="email">MCQ Marks: </label>
     <div class="form-group">
       <input type="text" value="'.$row['mcq_marks'].'" id="mcq_marks" class="form-control">
     </div>
     <label for="email">Exam Duration(In Second): </label>
     <div class="form-group">
       <input type="text" value="'.$row['duration'].'" id="exam_duration" class="form-control">
     </div>
     ';
     echo $output;
  }
  else{
     $output = '<div class="alert alert-danger">No data found.</div>';
     echo $output;
  }
}

// show course information and update
if(isset($_POST['searchCourseInformation'])){
  $id = $_POST['id'];
  $output = "";
  $search = mysqli_query($con,"SELECT * FROM package WHERE id ='$id'");
  if(mysqli_num_rows($search) > 0){
     $row = mysqli_fetch_array($search);
     if($row['status'] == 1){
      $courseStatus = '<option value="1" selected>Active</option>
     <option value="0">Inactive</option>';
     }else{
      $courseStatus = '<option value="1">Active</option>
     <option value="0" selected>Inactive</option>';
     }
     if($row['custom_exam'] == 1){
     $customExam = '<option value="1" selected>On</option>
     <option value="0">Off</option>'; 
    }else{
      $customExam = '<option value="1">On</option>
      <option value="0" selected>Off</option>'; 
    }
     $output = ' 
     <input value="'.$row['id'].'" type="hidden" id="courseID">
     <label for="email">Course Name: </label>
     <div class="form-group">
       <input type="text" id="courseName" value="'.$row['name'].'" class="form-control">
     </div>
     <label for="email">Status: </label>
     <div class="form-group">
       <select name="status" id="courseStatus" class="form-select">
       '.$courseStatus.'
       </select>
     </div>
     <label for="email">Custom Exam: </label>
     <div class="form-group">
       <select name="customExam" id="customExam" class="form-select">
       '.$customExam.'
       </select>
     </div>
     <label for="email">Description: </label>
     <div class="form-group">
       <textarea id="courseDescription" class="form-control">'.$row['description'].'</textarea>
     </div>
     <label for="email">Course Price (BDT): </label>
     <div class="form-group">
       <input type="text" id="coursePrice" value="'.$row['price'].'" class="form-control">
     </div>
     <label for="email">Course Duration (Seconds): </label>
     <div class="form-group">
       <select id="courseDuration" class="form-select">
       <option value="'.$row['duration'].'">'.$row['duration'].'</option>
       <option value="43200">30 days</option>
       <option value="86400">60 days</option>
       <option value="129600">90 days</option>
       </select>
     </div>
     <label for="email">Expiry Date: </label>
     <div class="form-group">
       <input type="date" id="expiryDate" value="'.$row['expiry_date'].'" class="form-control">
     </div>
     ';
     echo $output;
  }
  else{
     $output = '<div class="alert alert-danger">No data found.</div>';
     echo $output;
  }
}


// update course 
if(isset($_POST['saveCourseEdit'])){
  $course_id = $_POST['id'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $status = $_POST['status'];
  $custom_exam = $_POST['custom_exam'];
  $duration = $_POST['duration'];
  $expiry_date = $_POST['expiry_date'];
  
  $sql = mysqli_query($con, "UPDATE package SET name='$name',description='$description',price='$price',custom_exam='$custom_exam',status='$status',duration='$duration',expiry_date='$expiry_date' WHERE id='$course_id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}


// active and inactive teachers account code
if(isset($_POST['deactivateTeacherBtn'])){
  $id = $_POST['id'];
  $sql = mysqli_query($con, "UPDATE admin SET status = 0 WHERE id='$id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}

if(isset($_POST['activateTeacherBtn'])){
  $id = $_POST['id'];
  $sql = mysqli_query($con, "UPDATE admin SET status = 1 WHERE id='$id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}

// unpublish  and publish exam

if(isset($_POST['UnpublishExamBtn'])){
  $id= $_POST['id'];
  $sql = mysqli_query($con,"UPDATE exam SET status = 0 WHERE id= '$id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}

if(isset($_POST['publishExamBtn'])){
  $id = $_POST['id'];
  $sql = mysqli_query($con, "UPDATE exam SET status = 1 WHERE id='$id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}

// update exam 
if(isset($_POST['updateExam'])){
  $exam_id = $_POST['id'];
  $exam_name = $_POST['exam_name'];
  $exam_date = $_POST['exam_date'];
  $exam_start_time = $_POST['exam_start_time'];
  $exam_end = $_POST['exam_end'];
  $exam_end_time = $_POST['exam_end_time'];
  $mcq_marks = $_POST['mcq_marks'];
  $duration = $_POST['duration'];
  $exam_type = $_POST['exam_type'];
  $course_id = $_POST['course_id'];
  
  $sql = mysqli_query($con, "UPDATE exam SET exam_name='$exam_name',course_id='$course_id', duration='$duration', exam_start='$exam_date',
   exam_start_time='$exam_start_time', exam_end='$exam_end', exam_end_time='$exam_end_time', mcq_marks='$mcq_marks',type='$exam_type' WHERE id='$exam_id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}


 // auto update exam type
 if(isset($_POST['examType'])){
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

        if($ExamTypeCurrent_time >= $examTypeEndTimestamp){
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
 }

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

 // filter exam leader board
 if(isset($_POST['filterBtn'])){
  $id = $_POST['id'];

  $no = 1;
  $output = "";
  $select = mysqli_query($con, "SELECT * FROM leaderboard WHERE exam_id='$id' ORDER BY result DESC");
  if(mysqli_num_rows($select) > 0){
    while($row = mysqli_fetch_array($select)){
      $student_id = $row['student_id'];
      $searchStudent = mysqli_query($con,"SELECT * FROM students WHERE student_id='$student_id'");
      if(mysqli_num_rows($searchStudent) > 0){
        $fetch = mysqli_fetch_array($searchStudent);
        $viewStudentId = $fetch['id'];
        $studentName = $fetch['full_name'];
        $college = $fetch['college'];
      }else{
        $studentName = "N/A";
        $college = "N/A";
      }
      $output .= ' <tr>
      <td>'.$no.'</td>
      <td>'.$student_id.'</td>
      <td>'.$studentName.'</td>
      <td>'.$college.'</td>
      <td>'.$row['result'].'</td>
    </tr>';
    $no++;
    }
  }else{
    $output = '<p class="alert alert-danger">No data Found</p>';
  }

  echo $output;
 }


 // search chapter subject wise

 if(isset($_POST['searchChapter'])){
  $subject_id = $_POST['subject_id'];

  $output = "";
  $searchChapter = mysqli_query($con,"SELECT * FROM chapter WHERE subject_id='$subject_id'");
  if(mysqli_num_rows($searchChapter) > 0){
    while($row = mysqli_fetch_array($searchChapter)){
      $output .= "<option value='{$row['id']}'>{$row['name']}</option>";
    }
  }

  echo $output;
 }

?>