<?php
// Register New Admin
if(isset($_POST['registerAdminBtn'])){
  $full_name = mysqli_real_escape_string($con, $_POST['full_name']) ;
  $username = mysqli_real_escape_string($con, $_POST['username']) ;
  $email = mysqli_real_escape_string($con, $_POST['email']) ;
  $post = mysqli_real_escape_string($con, $_POST['post']) ;
  $password = mysqli_real_escape_string($con, $_POST['password']) ;
  $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']) ;

  $pass = password_hash($password,  PASSWORD_BCRYPT);
  $cpass = password_hash($confirm_password, PASSWORD_BCRYPT);

    $user_count = "select * from admin where username= '$username' ";
    $userQuery = mysqli_query($con,$user_count);
    $userCount = mysqli_num_rows($userQuery);

    if($userCount > 0){
      ?>
<script>
Swal.fire({
  icon: "warning",
  title: "This username already exist, Please use another username",
}).then(() => {
  location.replace("login.php?register");
});
</script>
<?php 
    }else{
      $emailQuery = " select * from admin where email= '$email'";
      $query = mysqli_query($con,$emailQuery);

      $emailCount = mysqli_num_rows($query);

    if($emailCount > 0){
      ?>
<script>
Swal.fire({
  icon: "warning",
  title: "This email already exist, Please use another email.",
}).then(() => {
  location.replace("login.php?register");
});
</script>
<?php 
    }else{
      if($password === $confirm_password){

          $insertQuery = "INSERT INTO `admin` ( `full_name`, `username`, `email`,`post`, `password`, `confirm_password`)
          VALUES ( '$full_name', '$username', '$email','$post', '$pass', '$cpass')";

            $iQuery = mysqli_query($con, $insertQuery);

          if($iQuery){
            ?>
<script>
Swal.fire({
  icon: "success",
  title: "Congratulations <?=$username?>! Your account created successfully. Now you can log in!",
}).then(() => {
  location.replace("login.php?login");
});
</script>
<?php
          }else{
            ?>
<script>
Swal.fire({
  icon: "error",
  title: "Registration Failed",
}).then(() => {
  location.replace("login.php?register");
});
</script>
<?php    
          }

      }else{

        ?>
<script>
Swal.fire({
  icon: "warning",
  title: "Password and confirm password doesn't matched!",
}).then(() => {
  location.replace("login.php?register");
});
</script>
<?php 

          }
    }
  }
}

// admin login
if(isset($_POST['adminLoginBtn'])){
  $username = mysqli_real_escape_string($con,$_POST['username']);
  $password = mysqli_real_escape_string($con,$_POST['password']);

    $username_search = " select * from admin where username='$username'";
    $query = mysqli_query($con,$username_search);

    $username_count = mysqli_num_rows($query);

    if($username_count){
        $username_pass = mysqli_fetch_assoc($query);

        $db_pass = $username_pass['password'];

        $_SESSION['username'] = $username_pass['username'];
        $_SESSION['email'] = $username_pass['email'];
        $_SESSION['id'] = $username_pass['id'];
        $_SESSION['post'] = $username_pass['post'];
        
        $pass_decode = password_verify($password, $db_pass);

        if($pass_decode){
          ?>
<script>
location.replace("index.php");
</script>
<?php
         }else{
          ?>
<script>
Swal.fire({
  icon: "error",
  title: "Incorrect Password!",
}).then(() => {
  location.replace("login.php?login");
});
</script>
<?php 
         }

     }else{
      ?>
<script>
Swal.fire({
  icon: "warning",
  title: "Invalid Username!",
}).then(() => {
  location.replace("login.php?login");
});
</script>
<?php 
     }

}

// change password
if(isset($_POST['changePassword'])){
  $old_password = mysqli_real_escape_string($con, $_POST['old_password']);
  $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
  $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

    $new_pass = password_hash($new_password,  PASSWORD_BCRYPT);
    $c_pass = password_hash($confirm_password, PASSWORD_BCRYPT);
    $password_search = "SELECT * FROM admin WHERE id='$admin_id' AND status='1'";
    $query = mysqli_query($con,$password_search);

    $password_count = mysqli_num_rows($query);

  if($new_password != $confirm_password){
$_SESSION['warning'] = "Password And Confirm Password didn't matched!";
$_SESSION['replace_url'] = "add.php?Change-Password";
?>
<script>
location.replace("list.php?Teachers");
</script>
<?php
  }else{
        $password_pass = mysqli_fetch_assoc($query);
        $db_pass = $password_pass['password'];
        $pass_decode = password_verify($old_password, $db_pass);
        if($pass_decode){
          $change =mysqli_query($con,"UPDATE admin SET password = '{$new_pass}',confirm_password = '{$c_pass}' WHERE id = {$admin_id}");

          if($change){
            $_SESSION['passwordMessage'] = "Password changed Successfully!";
            ?>
<script>
location.replace("list.php?Teachers");
</script>
<?php
          }else{
            $_SESSION['error'] = "Failed!";
            ?>
<script>
location.replace("list.php?Teachers");
</script>
<?php
          }
        }else{
          $_SESSION['warning'] = "Old Password didn't matched!";
          $_SESSION['replace_url'] = "add.php?Change-Password";
          ?>
<script>
location.replace("list.php?Teachers");
</script>
<?php
        }
  }
  
 }


// add exam
if (isset($_POST['submitExamBtn'])) {
  $ChangeExam_name = $_POST['exam_name'];
  $exam_name = str_replace("'","\'", $ChangeExam_name);
  $exam_id = uniqid();
  $duration = (($_POST['duration_hour'] * 3600) + ($_POST['duration_minute'] * 60) + ($_POST['duration_seconds']));
  $exam_start = $_POST['start_date'];
  $exam_start_time = $_POST['start_time'];
  $exam_end = $_POST['end_date'];
  $exam_end_time = $_POST['end_time'];
  $mcq_marks = $_POST['mcq_marks'];
  $negative_mark = $_POST['negative_mark'];
  $exam_type = $_POST['exam_type'];
  $course_id=$_POST['course_name'];
  $added_by = $_SESSION['username'];
  
    $sql = "INSERT INTO `exam`(`exam_name`, `exam_id`,`course_id`, `duration`, `exam_start`, `exam_start_time`, `exam_end`,`exam_end_time`,`mcq_marks`,`negative_mark`,`type`,`added_by`) 
    VALUES ('$exam_name','$exam_id','$course_id','$duration','$exam_start','$exam_start_time','$exam_end','$exam_end_time','$mcq_marks','$negative_mark','$exam_type','$added_by')";
    $query = mysqli_query($con, $sql);
  
    if ($query) {
      $_SESSION['message'] = "Success";
      ?>
<script>
location.replace("list.php?Exam");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      ?>
<script>
location.replace("list.php?Exam");
</script>
<?php
  
    }
}

// add custom exam
if (isset($_POST['submitCustomExam'])) {
  $ChangeExam_name = $_POST['exam_name'];
  $exam_name = str_replace("'","\'", $ChangeExam_name);
  $exam_id = uniqid();
  
  $duration = (($_POST['duration_hour'] * 3600) + ($_POST['duration_minute'] * 60) + ($_POST['duration_seconds']));
  $exam_start = $_POST['start_date'];
  $exam_start_time = $_POST['start_time'];
  $exam_end = $_POST['end_date'];
  $exam_end_time = $_POST['end_time'];
  $marks = $_POST['marks'];
  $negative_mark = $_POST['negative_marks'];
  $exam_type = $_POST['exam_type'];
  $custom_exam_type = 1;
  $course_id=$_POST['course_name'];
  $marksPerOption=$_POST['marksPerOption'];
  $negMarksPerOption=$_POST['negMarksPerOption'];
  $added_by = $_SESSION['username'];
 
    $sql = "INSERT INTO `exam`(`exam_name`, `exam_id`,`course_id`, `duration`, `exam_start`, `exam_start_time`, `exam_end`,`exam_end_time`,`type`,`added_by`,`custom_exam_type`,`negative_mark`,`marks`,`marks_per_option`,`negative_marks_per_option`) 
    VALUES ('$exam_name','$exam_id','$course_id','$duration','$exam_start','$exam_start_time','$exam_end','$exam_end_time','$exam_type','$added_by','$custom_exam_type','$negative_mark','$marks','$marksPerOption','$negMarksPerOption')";
    $query = mysqli_query($con, $sql);
  
    if ($query) {
      $sumMarks=0;
      $sumMarksTrue = 0;
      $searchSubjectColumn= mysqli_query($con, "SELECT * FROM subjects");
      if(mysqli_num_rows($searchSubjectColumn) > 0){
        while ($subjectRow = mysqli_fetch_array($searchSubjectColumn)) {
          if($_POST[$subjectRow['id']] != 0 && $_POST[$subjectRow['id']] != NULL){
            $subject = $subjectRow['subject'];
            $limit = $_POST[$subjectRow['id']];
            $sumMarks = ($sumMarks + $limit);
            $updateExamSql = mysqli_query($con, "UPDATE exam SET $subject='$limit' WHERE exam_id='$exam_id'");
          }
          if(isset($_POST['trueFalse'.$subjectRow['id']])){
            if(isset($_POST['limTrue'.$subjectRow['id']])){
              $trueLimitSum = $_POST['limTrue'.$subjectRow['id']];
              $sumMarksTrue = ($sumMarksTrue + $trueLimitSum);
            }
          }
        }
      }
      $number_of_questions = $sumMarks+$sumMarksTrue;

      if($marksPerOption != NULL){
        $TotalMarks = ($sumMarks * $marks)+($sumMarksTrue*$marksPerOption*5);
      }else{
        $TotalMarks = ($sumMarks * $marks);
      }

      mysqli_query($con, "UPDATE exam SET mcq_marks='$TotalMarks',number_of_questions='$number_of_questions' WHERE exam_id='$exam_id'");

      $_SESSION['message'] = "Success";
      $search_subject = mysqli_query($con, "SELECT * FROM subjects");
  if(mysqli_num_rows($search_subject) > 0){
  while($subject_row = mysqli_fetch_array($search_subject)){
    $subject_id = $subject_row['id'];
    $search_limit = mysqli_query($con,"SELECT * FROM exam WHERE exam_id = '$exam_id'");
    if(mysqli_num_rows($search_limit) > 0){
      $result = mysqli_fetch_array($search_limit);
      $limit = $result[$subject_row['subject']];

    }else{
      $limit = 0;
    }

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
                  $matchQues = mysqli_query($con,"SELECT * FROM exam_question WHERE question_id='$qsId' AND  exam_id='$exam_id' AND isTrue='0'");
                  if(mysqli_num_rows($matchQues) > 0){
                    continue;
                  }
                  $ins = mysqli_query($con,"INSERT INTO exam_question (`exam_id`, `question_id`,`subject_id`) VALUES ('$exam_id','$qsId','$subject_id')");
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
                $matchQues = mysqli_query($con,"SELECT * FROM exam_question WHERE question_id='$qsId' AND exam_id='$exam_id' AND isTrue='0'");
                if(mysqli_num_rows($matchQues) > 0){
                  continue;
                }
                $ins = mysqli_query($con,"INSERT INTO exam_question (`exam_id`, `question_id`,`subject_id`) VALUES ('$exam_id','$qsId','$subject_id')");
              }
          }
          }
          $countAddedQuestion = mysqli_query($con,"SELECT * FROM exam_question WHERE exam_id='$exam_id' AND subject_id='$subject_id' AND isTrue='0'");
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

    // true false
    if(isset($_POST['trueFalse'.$subject_id])){
      
    $trueLimit = $_POST['limTrue'.$subject_id];
    if($trueLimit !=0 AND $trueLimit != NULL){
     
      if($checkedChapter == NULL){
        if($trueLimit != NULL){
          $selectTrue = mysqli_query($con, "SELECT * FROM true_false_question WHERE subject_id='$subject_id' ORDER BY RAND() LIMIT $trueLimit");
          if(mysqli_num_rows($selectTrue) > 0){
            while($trueRow = mysqli_fetch_array($selectTrue)){
              $qsIdTrue = $trueRow['id'];
              $matchQuesTrue = mysqli_query($con,"SELECT * FROM exam_question WHERE question_id='$qsIdTrue' AND exam_id='$exam_id' AND isTrue='1'");
              if(mysqli_num_rows($matchQuesTrue) > 0){
                continue;
              }
              $insertTrue = mysqli_query($con,"INSERT INTO exam_question (`exam_id`, `question_id`,`subject_id`,`isTrue`) VALUES ('$exam_id','$qsIdTrue','$subject_id','1')");
            }
        }
        }
      }else{
        
      for($a=1;$a<=$trueLimit;$a++){
        foreach($checkedChapter as $trueChapterId){
    
          if($trueLimit != NULL){
            $selectTrue = mysqli_query($con, "SELECT * FROM true_false_question WHERE subject_id='$subject_id' AND chapter_id='$trueChapterId' ORDER BY RAND() LIMIT 1");
            if(mysqli_num_rows($selectTrue) > 0){
              $trueRow = mysqli_fetch_array($selectTrue);
              $qsIdTrue = $trueRow['id'];
              $matchQuesTrue = mysqli_query($con,"SELECT * FROM exam_question WHERE question_id='$qsIdTrue' AND exam_id='$exam_id' AND isTrue='1'");
              if(mysqli_num_rows($matchQuesTrue) > 0){
                continue;
              }
              $insertTrue = mysqli_query($con,"INSERT INTO exam_question (`exam_id`, `question_id`,`subject_id`,`isTrue`) VALUES ('$exam_id','$qsIdTrue','$subject_id','1')");
          }
          }
          $countAddedQuestionTrue = mysqli_query($con,"SELECT * FROM exam_question WHERE exam_id='$exam_id' AND subject_id='$subject_id' AND isTrue='1'");
          $countNumTrue = mysqli_num_rows($countAddedQuestionTrue);
        
        if($countNumTrue >= $trueLimit){
          break;
        }
        }
        if($countNumTrue >= $trueLimit){
          break;
        }
        
      }
      }

    }
    
  }

  }
}
      ?>
<script>
location.replace("list.php?Exam");
</script>
<?php


    } else {
      $_SESSION['error'] = "Failed";
      ?>
<script>
location.replace("list.php?Exam");
</script>
<?php
  
    }
}

// add true false exam
if (isset($_POST['submitTrueFalse'])) {
  $ChangeExam_name = $_POST['exam_name'];
  $exam_name = str_replace("'","\'", $ChangeExam_name);
  $exam_id = uniqid();
  $duration = (($_POST['duration_hour'] * 3600) + ($_POST['duration_minute'] * 60) + ($_POST['duration_seconds']));
  $exam_start = $_POST['start_date'];
  $exam_start_time = $_POST['start_time'];
  $exam_end = $_POST['end_date'];
  $exam_end_time = $_POST['end_time'];
  $custom_exam_type = 2;
  $course_id=$_POST['course_name'];
  $marks_per_option = $_POST['marks_per_option'];
  $negative_marks_per_option = $_POST['negative_marks_per_option'];
  $added_by = $_SESSION['username'];
 
    $sql = "INSERT INTO `exam`(`exam_name`, `exam_id`,`course_id`, `duration`, `exam_start`, `exam_start_time`, `exam_end`,`exam_end_time`,`added_by`,`custom_exam_type`,`marks_per_option`,`negative_marks_per_option`) 
    VALUES ('$exam_name','$exam_id','$course_id','$duration','$exam_start','$exam_start_time','$exam_end','$exam_end_time','$added_by','$custom_exam_type','$marks_per_option','$negative_marks_per_option')";
    $query = mysqli_query($con, $sql);
  
    if ($query) {
      $sumMarks=0;
      $searchSubjectColumn= mysqli_query($con, "SELECT * FROM subjects");
      if(mysqli_num_rows($searchSubjectColumn) > 0){
        while ($subjectRow = mysqli_fetch_array($searchSubjectColumn)) {
          if($_POST[$subjectRow['id']] != 0 && $_POST[$subjectRow['id']] != NULL){
            $subject = $subjectRow['subject'];
            $limit = $_POST[$subjectRow['id']];
            $sumMarks = ($sumMarks + $limit);
            $updateExamSql = mysqli_query($con, "UPDATE exam SET $subject='$limit' WHERE exam_id='$exam_id'");
          }
        }
      }
      $TotalMarks = $sumMarks * $marks_per_option * 5;
      mysqli_query($con, "UPDATE exam SET mcq_marks='$TotalMarks',number_of_questions='$sumMarks' WHERE exam_id='$exam_id'");

      $_SESSION['message'] = "Success";

      $search_subject = mysqli_query($con, "SELECT * FROM subjects");
      if(mysqli_num_rows($search_subject) > 0){
        while($subject_row = mysqli_fetch_array($search_subject)){
          $subject_id = $subject_row['id'];
          $search_limit = mysqli_query($con,"SELECT * FROM exam WHERE exam_id = '$exam_id'");
          if(mysqli_num_rows($search_limit) > 0){
            $result = mysqli_fetch_array($search_limit);
            $limit = $result[$subject_row['subject']];

          }else{
            $limit = 0;
          }
      
          $checkedChapter = [];
          if(isset($_POST['chapter'])){
          $checkedChapter = $_POST['chapter'];
        }else{
          $checkedChapter = NULL;
        }  
      
          if($checkedChapter != NULL){
            for($a=1;$a<=$limit;$a++){
              foreach($checkedChapter as $trueChapterId){
          
                if($limit != NULL){
                  $selectTrue = mysqli_query($con, "SELECT * FROM true_false_question WHERE subject_id='$subject_id' AND chapter_id='$trueChapterId' ORDER BY RAND() LIMIT 1");
                  if(mysqli_num_rows($selectTrue) > 0){
                    $trueRow = mysqli_fetch_array($selectTrue);
                    $qsIdTrue = $trueRow['id'];
                    $matchQuesTrue = mysqli_query($con,"SELECT * FROM exam_question WHERE question_id='$qsIdTrue' AND exam_id='$exam_id' AND isTrue='1'");
                    if(mysqli_num_rows($matchQuesTrue) > 0){
                      continue;
                    }
                    $insertTrue = mysqli_query($con,"INSERT INTO exam_question (`exam_id`, `question_id`,`subject_id`,`isTrue`) VALUES ('$exam_id','$qsIdTrue','$subject_id','1')");
                }
                }
                $countAddedQuestionTrue = mysqli_query($con,"SELECT * FROM exam_question WHERE exam_id='$exam_id' AND subject_id='$subject_id' AND isTrue='1'");
                $countNumTrue = mysqli_num_rows($countAddedQuestionTrue);
              
              if($countNumTrue >= $limit){
                break;
              }
              }
              if($countNumTrue >= $limit){
                break;
              }
              
            }
          }else{
           if($limit !=0){
            $selectTrue = mysqli_query($con, "SELECT * FROM true_false_question WHERE subject_id='$subject_id' ORDER BY RAND() LIMIT $limit");
            if(mysqli_num_rows($selectTrue) > 0){
              while($trueRow = mysqli_fetch_array($selectTrue)){
                $qsIdTrue = $trueRow['id'];
                $matchQuesTrue = mysqli_query($con,"SELECT * FROM exam_question WHERE question_id='$qsIdTrue' AND exam_id='$exam_id' AND isTrue='1'");
                if(mysqli_num_rows($matchQuesTrue) > 0){
                  continue;
                }
                $insertTrue = mysqli_query($con,"INSERT INTO exam_question (`exam_id`, `question_id`,`subject_id`,`isTrue`) VALUES ('$exam_id','$qsIdTrue','$subject_id','1')");
              }
          }
           }
          }
      
        }
      }


      ?>
<script>
location.replace("list.php?Exam");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      ?>
<script>
location.replace("list.php?Exam");
</script>
<?php
  
    }
}

// Add MCQ Question
if (isset($_POST['addQuestion'])) {
  $exam_id = $_POST['exam_id'];
  $subject_id = $_POST['subject_id'];
  $chapter_id = $_POST['chapter_id'];
  $marks = $_POST['marks'];
  $negative_marks = $_POST['negative_marks'];
  $changeQuestion = $_POST['question'];
  $question = str_replace("'","\'", $changeQuestion);
  $changeOption_1 = $_POST['option_1'];
  $option_1 = str_replace("'","\'", $changeOption_1);
  $changeOption_2 = $_POST['option_2'];
  $option_2 = str_replace("'","\'", $changeOption_2);
  $changeOption_3 = $_POST['option_3'];
  $option_3 = str_replace("'","\'", $changeOption_3);
  $changeOption_4 = $_POST['option_4'];
  $option_4 = str_replace("'","\'", $changeOption_4);
  $changeOption_5 = $_POST['option_5'];
  $option_5 = str_replace("'","\'", $changeOption_5);
  $changeSolution = $_POST['solution'];
  $solution = str_replace("'","\'", $changeSolution);
  $answer = $_POST['answer'];
  $added_by = $_SESSION['username'];
  
    $sql = "INSERT INTO `questions`(`exam_id`,`subject_id`,`chapter_id`,`question`, `option_1`, `option_2`, `option_3`, `option_4`,`option_5`, `answer`, `mark`, `negative_mark`,`solution`,`added_by`)
    VALUES ('$exam_id','$subject_id','$chapter_id','$question','$option_1','$option_2','$option_3','$option_4','$option_5','$answer','$marks','$negative_marks','$solution','$added_by')";
    $query = mysqli_query($con, $sql);
  
    if ($query) {
      $_SESSION['mcq_message'] = "Success";
      ?>
<script>
location.replace("list.php?Questions");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      $_SESSION['replace_url'] = "add.php?Questions";
      ?>
<script>
location.replace("list.php?Questions");
</script>
<?php
  
    }
}

// add subjects
if(isset($_POST['addNewSubject'])){
  $changeSubject = $_POST['subject'];
  $subject = str_replace(' ', '_', str_replace("'","\'", $changeSubject));

    $query = mysqli_query($con, "INSERT INTO subjects (subject) VALUES ('$subject')");
  
    if ($query) {
      $addColumn = mysqli_query($con, "ALTER TABLE `exam` ADD $subject VARCHAR(255) NULL");
      if($addColumn){
        $_SESSION['message'] = "Success";
        ?>
<script>
location.replace("list.php?Subjects");
</script>
<?php
      }else{
        ?>
<script>
alert("Column Add Failed");
</script>
<?php
      }
    } else {
      $_SESSION['error'] = "Failed";
      $_SESSION['replace_url'] = "add.php?Subjects";
      ?>
<script>
location.replace("list.php?Subjects");
</script>
<?php
  
    }
}


// add chapters
if(isset($_POST['addChapter'])){
  $subject_id = $_POST['subject_id'];
  $changeChapter = $_POST['name'];
  $Chapter = str_replace("'","\'", $changeChapter);

    $sql = "INSERT INTO `chapter`(`subject_id`,`name`)
    VALUES ('$subject_id','$Chapter')";
    $query = mysqli_query($con, $sql);
  
    if ($query) {
      $_SESSION['message'] = "Success";
      ?>
<script>
location.replace("list.php?Chapters");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      $_SESSION['replace_url'] = "add.php?Chapters";
      ?>
<script>
location.replace("list.php?Chapters");
</script>
<?php
  
    }
}

// deactivate teachers
if(isset($_POST['teacherDeactivateBtn'])){
  $id = $_POST['id'];

  $query = mysqli_query($con, "UPDATE admin SET status='1' WHERE id='$id'");
  if($query){
    ?>
<script>
location.replace("list.php?Teachers");
</script>
<?php
  }else{
    ?>
<script>
alert("Failed");
</script>
<?php
  }
}

// activate teacher
if(isset($_POST['teacherActivateBtn'])){
  $id = $_POST['id'];

  $query = mysqli_query($con, "UPDATE admin SET status='0' WHERE id='$id'");
  if($query){
    ?>
<script>
location.replace("list.php?Teachers");
</script>
<?php
  }else{
    ?>
<script>
alert("Failed");
</script>
<?php
  }
}


// update question
if (isset($_POST['updateQuestion'])) {
  $questionID = $_POST['questionID'];
  $exam_id = $_POST['exam_id'];
  $subject_id = $_POST['subject_id'];
  $chapter_id = $_POST['chapter_id'];
  $marks = $_POST['marks'];
  $negative_marks = $_POST['negative_marks'];
  $changeQuestion = $_POST['question'];
  $question = str_replace("'","\'", $changeQuestion);
  $changeOption_1 = $_POST['option_1'];
  $option_1 = str_replace("'","\'", $changeOption_1);
  $changeOption_2 = $_POST['option_2'];
  $option_2 = str_replace("'","\'", $changeOption_2);
  $changeOption_3 = $_POST['option_3'];
  $option_3 = str_replace("'","\'", $changeOption_3);
  $changeOption_4 = $_POST['option_4'];
  $option_4 = str_replace("'","\'", $changeOption_4);
  $changeOption_5 = $_POST['option_5'];
  $option_5 = str_replace("'","\'", $changeOption_5);
  $changeSolution = $_POST['solution'];
  $solution = str_replace("'","\'", $changeSolution);
  $answer = $_POST['answer'];
  
    $sql = "UPDATE questions SET `exam_id`='$exam_id',`subject_id`='$subject_id',`chapter_id`='$chapter_id', `question`='$question', `option_1`='$option_1', `option_2`='$option_2', `option_3`='$option_3', `option_4`='$option_4',`option_5`='$option_5', `answer`='$answer', `mark`='$marks', `negative_mark`='$negative_marks',`solution`='$solution' WHERE id='$questionID'";
    $query = mysqli_query($con, $sql);
  
    if ($query) {
      $_SESSION['message'] = "Success";
      ?>
<script>
location.replace("list.php?Questions");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      ?>
<script>
location.replace("list.php?Questions");
</script>
<?php
  
    }
}


// add courses
if(isset($_POST['addCourse'])){
  $package_id = uniqid();
  $name = $_POST['courseName'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $duration = $_POST['duration'] * 60;
  $expiry_date = $_POST['expiry_date'];

  $routine = $_FILES['routine']['name'];
  
  if($routine != NULL){
    $extension = pathinfo($routine, PATHINFO_EXTENSION);

    $new_name = rand().".".$extension; 
    $routine_path = "images/" .$new_name;
    $supported_extension = array("jpg","png","jpeg","webp");
    
    if(in_array($extension, $supported_extension)){

      $sql = mysqli_query($con, "INSERT INTO package (package_id,name,description,price,duration,image,expiry_date) VALUES ('$package_id','$name','$description','$price','$duration','$routine_path','$expiry_date')");
      if($sql){
        move_uploaded_file($_FILES['routine']['tmp_name'],$routine_path);
        $_SESSION['message'] = "Success";
    
        ?>
<script>
location.replace("list.php?Courses");
</script>
<?php
      }else{
        $_SESSION['error'] = "Failed";
        ?>
<script>
location.replace("list.php?Courses");
</script>
<?php
      }
      
    }else{
      $_SESSION['warning'] = "Invalid Extension!";
      $_SESSION['replace_url'] = "add.php?Courses";
      ?>
<script>
location.replace("list.php?Lectures");
</script>
<?php
    }
  }else{
    
    $sql = mysqli_query($con, "INSERT INTO package (package_id,name,description,price,duration,expiry_date) VALUES ('$package_id','$name','$description','$price','$duration','$expiry_date')");
    if($sql){
      $_SESSION['message'] = "Success";
  
      ?>
<script>
location.replace("list.php?Courses");
</script>
<?php
    }else{
      $_SESSION['error'] = "Failed";
      ?>
<script>
location.replace("list.php?Courses");
</script>
<?php
    }
    
  }
}

// update routine
if(isset($_POST['updateRoutine'])){
  $id = $_POST['id'];
  $routine = $_FILES['routine']['name'];
  $oldImagePath = "";
  $oldImg = mysqli_query($con,"SELECT * FROM package WHERE id='$id'");
  if(mysqli_num_rows($oldImg) > 0){
    $oldImagePath = mysqli_fetch_array($oldImg)['routine'];
  }

  if($routine != NULL){
    $extension = pathinfo($routine, PATHINFO_EXTENSION);
  
      $new_name = rand().".".$extension; 
      $routine_path = "images/" .$new_name;
      $supported_extension = array("jpg","png","jpeg","webp");
      
      if(in_array($extension, $supported_extension)){
  
        $sql = mysqli_query($con, "UPDATE package SET routine='$routine_path' WHERE id='$id'");
        if($sql){
          move_uploaded_file($_FILES['routine']['tmp_name'],$routine_path);
          if($oldImagePath != NULL){
            unlink($oldImagePath);
          }
          $_SESSION['message'] = "Success";
      
          ?>
<script>
location.replace("list.php?Courses");
</script>
<?php
        }else{
          $_SESSION['error'] = "Failed";
          ?>
<script>
location.replace("list.php?Courses");
</script>
<?php
        }
        
      }else{
        $_SESSION['warning'] = "Invalid Extension!";
        $_SESSION['replace_url'] = "add.php?Courses";
        ?>
<script>
location.replace("list.php?Lectures");
</script>
<?php
      }
  }
}

// add lectures
if(isset($_POST['addLecture'])){
  $title = $_POST['title'];
  $src = $_POST['src'];
  $course = $_POST['course'];
  $subject = $_POST['subject'];
  $watch_id = uniqid(rand(11,999).uniqid(rand(1,99)),false);

  $lectureSheet = $_FILES['lectureSheet']['name'];
  if($lectureSheet != NULL){
    $extension = pathinfo($lectureSheet, PATHINFO_EXTENSION);

    $new_name = rand().".".$extension; 
    $lectureSheet_path = "lecture/" .$new_name;
    $supported_extension = array("pdf");
    
    if(in_array($extension, $supported_extension)){

      $sql = mysqli_query($con,"INSERT INTO lectures (`watch_id`, `course_id`, `subject_id`, `title`, `src`,`lectureSheet`) VALUES 
      ('$watch_id','$course','$subject','$title','$src','$lectureSheet_path')");
    
    if($sql){
      move_uploaded_file($_FILES['lectureSheet']['tmp_name'],$lectureSheet_path);
      $_SESSION['message'] = "Success";
    
      ?>
<script>
location.replace("list.php?Lectures");
</script>
<?php
    }else{
      $_SESSION['error'] = "Failed";
      ?>
<script>
location.replace("list.php?Lectures");
</script>
<?php
    }

    }else{
      $_SESSION['warning'] = "Pdf only!";
      $_SESSION['replace_url'] = "add.php?Lectures";
      ?>
<script>
location.replace("list.php?Lectures");
</script>
<?php
    }
  }else{
    $sql = mysqli_query($con,"INSERT INTO lectures (`watch_id`, `course_id`, `subject_id`, `title`, `src`) VALUES 
      ('$watch_id','$course','$subject','$title','$src')");
    
    if($sql){
      $_SESSION['message'] = "Success";   
      ?>
<script>
location.replace("list.php?Lectures");
</script>
<?php
    }else{
      $_SESSION['error'] = "Failed";
      ?>
<script>
location.replace("list.php?Lectures");
</script>
<?php
    }
  }
 
}

// update lecture
if(isset($_POST['updateLecture'])){
  $id = $_POST['id'];
  $title = $_POST['title'];
  $src = $_POST['src'];
  $course = $_POST['course'];
  $subject = $_POST['subject'];
  $chapter = $_POST['chapter'];
  $lectureSheet = $_FILES['lectureSheet']['name'];

  $oldImagePath = "";
  $oldImg = mysqli_query($con,"SELECT * FROM lectures WHERE id='$id'");
  if(mysqli_num_rows($oldImg) > 0){
    $oldImagePath = mysqli_fetch_array($oldImg)['lectureSheet'];
  }
  
  if($lectureSheet != NULL){

  $extension = pathinfo($lectureSheet, PATHINFO_EXTENSION);

    $new_name = rand().".".$extension; 
    $lectureSheet_path = "lecture/" .$new_name;
    $supported_extension = array("pdf");
    
    if(in_array($extension, $supported_extension)){
      $sql = mysqli_query($con, "UPDATE lectures SET `course_id`='$course', `subject_id`='$subject', `chapter_id`='$chapter', `title`='$title', `src`='$src',`lectureSheet`='$lectureSheet_path' WHERE id='$id'");
      if($sql){
        move_uploaded_file($_FILES['lectureSheet']['tmp_name'],$lectureSheet_path);
        if($oldImagePath != NULL){
          unlink($oldImagePath);
        }
        $_SESSION['message'] = "Success";
      
        ?>
<script>
location.replace("list.php?Lectures");
</script>
<?php
      }else{
        $_SESSION['error'] = "Failed";
        ?>
<script>
location.replace("list.php?Lectures");
</script>
<?php
      }
    }else{
      $_SESSION['warning'] = "Pdf only!";
      $_SESSION['replace_url'] = "add.php?Lectures";
      ?>
<script>
location.replace("list.php?Lectures");
</script>
<?php
    }
  }else{
    $sql = mysqli_query($con, "UPDATE lectures SET `course_id`='$course', `subject_id`='$subject', `chapter_id`='$chapter', `title`='$title', `src`='$src' WHERE id='$id'");
    if($sql){
      $_SESSION['message'] = "Success";
    
      ?>
<script>
location.replace("list.php?Lectures");
</script>
<?php
    }else{
      $_SESSION['error'] = "Failed";
      ?>
<script>
location.replace("list.php?Lectures");
</script>
<?php
    }
  }

}

// Add True False Question
if (isset($_POST['addTrueFalse'])) {
  $subject_id = $_POST['subject_id'];
  $chapter_id = $_POST['chapter_id'];
  $changeQuestion = $_POST['question'];
  $question = str_replace("'","\'", $changeQuestion);
  $changeOption_1 = $_POST['option_1'];
  $option_1 = str_replace("'","\'", $changeOption_1);
  $changeOption_2 = $_POST['option_2'];
  $option_2 = str_replace("'","\'", $changeOption_2);
  $changeOption_3 = $_POST['option_3'];
  $option_3 = str_replace("'","\'", $changeOption_3);
  $changeOption_4 = $_POST['option_4'];
  $option_4 = str_replace("'","\'", $changeOption_4);
  $changeOption_5 = $_POST['option_5'];
  $option_5 = str_replace("'","\'", $changeOption_5);
  $answer_1 = $_POST['answer_1'];
  $answer_2 = $_POST['answer_2'];
  $answer_3 = $_POST['answer_3'];
  $answer_4 = $_POST['answer_4'];
  $answer_5 = $_POST['answer_5'];
  
    $sql = "INSERT INTO `true_false_question`(`subject_id`,`chapter_id`, `question`)
    VALUES ('$subject_id','$chapter_id','$question')";
    $query = mysqli_query($con, $sql);
   
    if ($query) {
      $QuestionId = mysqli_insert_id($con);
      $option_name_post_1 = rand(1,99999);
      $option_name_post_2 = rand(22,99999); 
      $option_name_post_3 = rand(333,99999);  
      $option_name_post_4 = rand(4444,99999); 
      $option_name_post_5 = rand(55555,99999); 
      
      $optionSql1 = mysqli_query($con, "INSERT INTO `true_false_options` (`option_name_post`,`question_id`, `option_1`, `answer`) 
      VALUES ('$option_name_post_1','$QuestionId','$option_1','$answer_1')");
      
      $optionSql2 = mysqli_query($con, "INSERT INTO `true_false_options` (`option_name_post`,`question_id`, `option_1`, `answer`) 
      VALUES ('$option_name_post_2','$QuestionId','$option_2','$answer_2')");

      $optionSql3 = mysqli_query($con, "INSERT INTO `true_false_options` (`option_name_post`,`question_id`, `option_1`, `answer`) 
            VALUES ('$option_name_post_3','$QuestionId','$option_3','$answer_3')");

      $optionSql4 = mysqli_query($con, "INSERT INTO `true_false_options` (`option_name_post`,`question_id`, `option_1`, `answer`) 
      VALUES ('$option_name_post_4','$QuestionId','$option_4','$answer_4')");

      $optionSql5 = mysqli_query($con, "INSERT INTO `true_false_options` (`option_name_post`,`question_id`, `option_1`, `answer`) 
            VALUES ('$option_name_post_5','$QuestionId','$option_5','$answer_5')");
     

      $_SESSION['message'] = "Success";
      ?>
<script>
location.replace("list.php?True-False");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      $_SESSION['replace_url'] = "add.php?True-False-Question";
      ?>
<script>
location.replace("list.php?True-False");
</script>
<?php
  
    }
}

if(isset($_POST['updateTrueFalse'])){
  $id = $_POST['id'];
  $subject_id = $_POST['subject_id'];
  $changeQuestion = $_POST['question'];
  $question = str_replace("'","\'", $changeQuestion);
 

  $sql = "UPDATE true_false_question SET subject_id='$subject_id',question='$question' WHERE id='$id'";
    $query = mysqli_query($con, $sql);

    if ($query) {
      
      $updateOption = mysqli_query($con, "SELECT * FROM true_false_options WHERE question_id='$id'");
      if(mysqli_num_rows($updateOption) > 0){
        while($optionRes = mysqli_fetch_array($updateOption)){
          $updateOptionID = $optionRes['id'];
          $changeOption_1 = $_POST[$optionRes['option_name_post']];
          $option_1 = str_replace("'","\'", $changeOption_1);
          $answer = $_POST[$optionRes['id']];

          $update = mysqli_query($con,"UPDATE true_false_options SET option_1='$option_1',answer='$answer' WHERE id='$updateOptionID'");
        }
      }
      $_SESSION['message'] = "Success";
      ?>
<script>
location.replace("list.php?True-False");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      $_SESSION['replace_url'] = "add.php?True-False-Question";
      ?>
<script>
location.replace("list.php?True-False-Question");
</script>
<?php   

  
    }
  
}

?>