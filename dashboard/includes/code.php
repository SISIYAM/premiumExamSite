<?php
// Register New student
if(isset($_POST['registerBtn'])){
  $studentID = rand(10000,99999);
  $full_name = mysqli_real_escape_string($con, $_POST['full_name']) ;
  $username = mysqli_real_escape_string($con, $_POST['username']) ;
  $email = mysqli_real_escape_string($con, $_POST['email']) ;
  $password = mysqli_real_escape_string($con, $_POST['password']) ;
  $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']) ;

  $pass = password_hash($password,  PASSWORD_BCRYPT);
  $cpass = password_hash($confirm_password, PASSWORD_BCRYPT);

    $user_count = "select * from students where username= '$username' ";
    $userQuery = mysqli_query($con,$user_count);
    $userCount = mysqli_num_rows($userQuery);

    if($userCount > 0){
      ?>
<script>
Swal.fire({
  icon: "warning",
  title: "This username already exist, Please use another username",
}).then(() => {
  location.replace("login?register");
});
</script>
<?php 
    }else{
      $emailQuery = " select * from students where email= '$email'";
      $query = mysqli_query($con,$emailQuery);

      $emailCount = mysqli_num_rows($query);

    if($emailCount > 0){
      ?>
<script>
Swal.fire({
  icon: "warning",
  title: "This email already exist, Please use another email.",
}).then(() => {
  location.replace("login?register");
});
</script>
<?php 
    }else{
      if($password === $confirm_password){

          $insertQuery = "INSERT INTO `students` ( `student_id`,`full_name`, `username`, `email`, `password`, `confirm_password`)
          VALUES ('$studentID','$full_name', '$username', '$email', '$pass', '$cpass')";

            $iQuery = mysqli_query($con, $insertQuery);

          if($iQuery){
           // login
       $username_search = " select * from students where username='$username'";
       $query = mysqli_query($con,$username_search);
   
       $username_count = mysqli_num_rows($query);
   
       if($username_count){
           $username_pass = mysqli_fetch_assoc($query);
   
           $db_pass = $username_pass['password'];
         
           $_SESSION['student_id'] = $username_pass['student_id'];
           
           $pass_decode = password_verify($password, $db_pass);
   
           if($pass_decode){
             ?>
<script>
location.replace("index");
</script>
<?php
            }
   
        }
          }else{
            ?>
<script>
Swal.fire({
  icon: "error",
  title: "Registration Failed",
}).then(() => {
  location.replace("login?register");
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
  location.replace("login?register");
});
</script>
<?php 

          }
    }
  }
}

// student login
if(isset($_POST['LoginBtn'])){
  $username = $_POST['username'];
  $password = $_POST['password'];

    $username_search = " select * from students where username='$username'";
    $query = mysqli_query($con,$username_search);

    $username_count = mysqli_num_rows($query);

    if($username_count){
        $username_pass = mysqli_fetch_assoc($query);

        $db_pass = $username_pass['password'];
        
        $_SESSION['student_id'] = $username_pass['student_id'];
        
        $pass_decode = password_verify($password, $db_pass);

        if($pass_decode){
          ?>
<script>
location.replace("index");
</script>
<?php
         }else{
         
        ?>
<script>
Swal.fire({
  icon: "error",
  title: "Incorrect Password!",
}).then(() => {
  location.replace("login?login");
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
  location.replace("login?login");
});
</script>
<?php 
     }

}

// submit and calculate result
if(isset($_POST['submitExam'])){
  $exam_id = $_POST['exam_id'];
  $insertStudentID = $_SESSION['student_id'];
  $right = 0;
  $wrong = 0;
  $noAns = 0;
  
  #check exam custom or not
  $checkCustom = mysqli_query($con,"SELECT * FROM exam WHERE exam_id='$exam_id'");
  if(mysqli_num_rows($checkCustom) > 0){
    $fetch = mysqli_fetch_array($checkCustom);
    $custom_exam_type = $fetch['custom_exam_type'];
  }
   
  #if custom_exam_type == 0 then Not custom Exam
  if($custom_exam_type == 0){

  $searchExamType = mysqli_query($con,"SELECT * FROM exam WHERE exam_id='$exam_id' AND type=1");
  if(mysqli_num_rows($searchExamType) > 0){

  // check is student submit result before or not
  $checkStudent = mysqli_query($con, "SELECT * FROM result WHERE student_id='$insertStudentID' && exam_id='$exam_id'");
  if(mysqli_num_rows($checkStudent) > 0){

   ?>
<script>
Swal.fire({
  icon: "error",
  title: "Exam Already Taken!",
}).then(() => {
  location.replace("result?Exam-History=<?=$exam_id?>");
});
</script>
<?php
  }else{

    $select = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$exam_id'");
    if(mysqli_num_rows($select) > 0){
     while($res = mysqli_fetch_array($select)){
      $mark = $res['mark'];
      $negative_mark = $res['negative_mark'];
       if($_POST[$res['id']] == $res['answer']){
         $right++;
       }elseif ($_POST[$res['id']] == 5) {
         $noAns ++;
       }else{
         $wrong++;
       }
       $question_id = $res['id'];
       $answered = $_POST[$res['id']];
       
       $query = mysqli_query($con, "INSERT INTO record (student_id,exam_id,question_id,answered) VALUES ('$insertStudentID','$exam_id','$question_id', '$answered')");
     }
   
     $totalAnswered = $wrong + $right;
     $result = ($right * $mark)-($wrong * $negative_mark);
    
     $insertResult = mysqli_query($con, "INSERT INTO result (`student_id`, `exam_id`, `result`, `answered`, `wrong_answered`, `right_answered`, `not_answered`) 
     VALUES ('$insertStudentID','$exam_id','$result','$totalAnswered','$wrong','$right','$noAns')");

     $insertLeaderBoard = mysqli_query($con, "INSERT INTO leaderboard (`student_id`, `exam_id`, `result`) 
     VALUES ('$insertStudentID','$exam_id','$result')");

    if($insertResult){ 
     ?>
<script>
Swal.fire({
  icon: "success",
  title: "Submit Successfully!",
}).then(() => {
  location.replace("result?Exam-History=<?=$exam_id?>");
});
</script>
<?php
    }else{
     ?>
<script>
alert("Failed to insert Result");
</script>
<?php
    }
   
    }

  }
  
}else{

    $select = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$exam_id'");
    if(mysqli_num_rows($select) > 0){
     while($res = mysqli_fetch_array($select)){
      $mark = $res['mark'];
      $negative_mark = $res['negative_mark'];
       if($_POST[$res['id']] == $res['answer']){
         $right++;
       }elseif ($_POST[$res['id']] == 5) {
         $noAns ++;
       }else{
         $wrong++;
       }
       $question_id = $res['id'];
       $answered = $_POST[$res['id']];
       
       #check record
       $checkRecord = mysqli_query($con, "SELECT * FROM record WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND question_id='$question_id'");
       if(mysqli_num_rows($checkRecord) > 0){
        $query = mysqli_query($con, "UPDATE record SET answered='$answered' WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND question_id='$question_id'");
       }else{
        $query = mysqli_query($con, "INSERT INTO record (student_id,exam_id,question_id,answered) VALUES ('$insertStudentID','$exam_id','$question_id', '$answered')");
       }
      
     }
     
     $totalAnswered = $wrong + $right;
     $result = ($right * $mark)-($wrong * $negative_mark);
    
      # check result
      $checkResult = mysqli_query($con, "SELECT * FROM result WHERE student_id='$insertStudentID' AND exam_id='$exam_id'");
      if(mysqli_num_rows($checkResult) > 0){
       $insertResult = mysqli_query($con, "UPDATE result SET result='$result',answered='$totalAnswered',wrong_answered='$wrong',right_answered='$right',not_answered='$noAns' WHERE student_id='$insertStudentID' AND exam_id='$exam_id'");
      }else{
       $insertResult = mysqli_query($con, "INSERT INTO result (`student_id`, `exam_id`, `result`, `answered`, `wrong_answered`, `right_answered`, `not_answered`) 
      VALUES ('$insertStudentID','$exam_id','$result','$totalAnswered','$wrong','$right','$noAns')");
      }
      
     
    if($insertResult){ 
     ?>
<script>
Swal.fire({
  icon: "success",
  title: "Submit Successfully!",
}).then(() => {
  location.replace("result?Exam-History=<?=$exam_id?>");
});
</script>
<?php
    }else{
     ?>
<script>
alert("Failed to insert Result");
</script>
<?php
    }
   
    }

  
}
    
}elseif($custom_exam_type == 1){
  # condition for custom exam
  $getMark = mysqli_query($con,"SELECT * FROM exam WHERE exam_id='$exam_id'");
  if(mysqli_num_rows($getMark) > 0){
    $fetchMark = mysqli_fetch_array($getMark);
    $mark = $fetchMark['marks'];
    $negative_mark = $fetchMark['negative_mark'];
    $markPerOption = $fetchMark['marks_per_option'];
    $negative_markPerOption = $fetchMark['negative_marks_per_option'];
    $trueFalseResult = 0;
  }
  $searchExamType = mysqli_query($con,"SELECT * FROM exam WHERE exam_id='$exam_id' AND type=1");
  if(mysqli_num_rows($searchExamType) > 0){
    #live exam

  // check is student submit result before or not
  $checkStudent = mysqli_query($con, "SELECT * FROM result WHERE student_id='$insertStudentID' && exam_id='$exam_id'");
  if(mysqli_num_rows($checkStudent) > 0){

   ?>
<script>
Swal.fire({
  icon: "error",
  title: "Exam Already Taken!",
}).then(() => {
  location.replace("result?Exam-History=<?=$exam_id?>");
});
</script>
<?php
  }else{

    $select = mysqli_query($con, "SELECT * FROM questions");
    if(mysqli_num_rows($select) > 0){
     while($res = mysqli_fetch_array($select)){

       if(isset($_POST[$res['id']])){
        if($_POST[$res['id']] == $res['answer']){
          $right++;
        }elseif ($_POST[$res['id']] == 5) {
          $noAns ++;
        }else{
          $wrong++;
        }
        $question_id = $res['id'];
        $answered = $_POST[$res['id']];
        
        $query = mysqli_query($con, "INSERT INTO record (student_id,exam_id,question_id,answered) VALUES ('$insertStudentID','$exam_id','$question_id', '$answered')");
    
       }
      
       
    }
  
  $checkExamQuestion = mysqli_query($con,"SELECT * FROM exam_question WHERE exam_id='$exam_id' AND isTrue='1'");
      if(mysqli_num_rows($checkExamQuestion) > 0){
           # true false 
   $trueRight = 0;
   $trueWrong = 0;
   $trueNoAns = 0;
   
   $selectTrue = mysqli_query($con, "SELECT * FROM true_false_options");
   if(mysqli_num_rows($selectTrue) > 0){
    while($resTrue = mysqli_fetch_array($selectTrue)){
      if(isset($_POST[$resTrue['id']])){
       if($_POST[$resTrue['id']] == $resTrue['answer']){
         $trueRight++;
       }elseif ($_POST[$resTrue['id']] == 5) {
         $trueNoAns ++;
       }else{
         $trueWrong++;
       }
       $option_id = $resTrue['id'];
       $Question_id = $resTrue['question_id'];
       $answeredTrue = $_POST[$resTrue['id']];
       $query = mysqli_query($con, "INSERT INTO record (student_id,exam_id,question_id,option_id,answered) VALUES ('$insertStudentID','$exam_id','$Question_id','$option_id','$answeredTrue')");
            
      }
     
      
   }

  }

  $totalAnsweredTrue = $trueWrong + $trueRight;
  $resultTrue = ($trueRight * $markPerOption)-($trueWrong * $negative_markPerOption);
  $trueFalseResult = $resultTrue;

      }
     


     
     $totalAnswered = $wrong + $right;
     $result = ($right * $mark)-($wrong * $negative_mark);
     $result = $result + $trueFalseResult;
    
     $insertResult = mysqli_query($con, "INSERT INTO result (`student_id`, `exam_id`, `result`, `answered`, `wrong_answered`, `right_answered`, `not_answered`) 
     VALUES ('$insertStudentID','$exam_id','$result','$totalAnswered','$wrong','$right','$noAns')");

     $insertLeaderBoard = mysqli_query($con, "INSERT INTO leaderboard (`student_id`, `exam_id`, `result`) 
     VALUES ('$insertStudentID','$exam_id','$result')");

    if($insertResult){ 
     ?>
<script>
Swal.fire({
  icon: "success",
  title: "Submit Successfully!",
}).then(() => {
  location.replace("result?Exam-History=<?=$exam_id?>");
});
</script>
<?php
    }else{
     ?>
<script>
alert("Failed to insert Result");
</script>
<?php
    }
   
    }

  }
  
}else{
  #practice exam

    $select = mysqli_query($con, "SELECT * FROM questions");
    if(mysqli_num_rows($select) > 0){
     while($res = mysqli_fetch_array($select)){
        # delete old record first
        $deleteQuestion_id = $res['id'];
        $isRecordExist = mysqli_query($con, "SELECT * FROM record WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND question_id='$deleteQuestion_id'");
        if(mysqli_num_rows($isRecordExist) > 0){
          $deleteOldRecord = mysqli_query($con, "DELETE FROM record WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND question_id='$deleteQuestion_id'");
        }
        
      if(isset($_POST[$res['id']])){
        if($_POST[$res['id']] == $res['answer']){
          $right++;
        }elseif ($_POST[$res['id']] == 5) {
          $noAns ++;
        }else{
          $wrong++;
        }
        $question_id = $res['id'];
        $answered = $_POST[$res['id']];
       
        # check record
        $checkRecord = mysqli_query($con,"SELECT * FROM record WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND question_id='$question_id'");
        if(mysqli_num_rows($checkRecord) > 0){
          $query = mysqli_query($con, "UPDATE record SET answered='$answered' WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND question_id='$question_id'");
        }else{
          $query = mysqli_query($con, "INSERT INTO record (student_id,exam_id,question_id,answered) VALUES ('$insertStudentID','$exam_id','$question_id', '$answered')");
        }
       
       }
     }


     $checkExamQuestion = mysqli_query($con,"SELECT * FROM exam_question WHERE exam_id='$exam_id' AND isTrue='1'");
      if(mysqli_num_rows($checkExamQuestion) > 0){
           # true false 
   $trueRight = 0;
   $trueWrong = 0;
   $trueNoAns = 0;
   
   $selectTrue = mysqli_query($con, "SELECT * FROM true_false_options");
   if(mysqli_num_rows($selectTrue) > 0){
    while($resTrue = mysqli_fetch_array($selectTrue)){
            # delete old record first
        $deleteOption_id = $resTrue['id'];
        $isRecordExist = mysqli_query($con, "SELECT * FROM record WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND option_id='$deleteOption_id'");
        if(mysqli_num_rows($isRecordExist) > 0){
          $deleteOldRecord = mysqli_query($con, "DELETE FROM record WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND option_id='$deleteOption_id'");
        }
      if(isset($_POST[$resTrue['id']])){
       if($_POST[$resTrue['id']] == $resTrue['answer']){
         $trueRight++;
       }elseif ($_POST[$resTrue['id']] == 5) {
         $trueNoAns ++;
       }else{
         $trueWrong++;
       }
       $option_id = $resTrue['id'];
       $Question_id = $resTrue['question_id'];
       $answeredTrue = $_POST[$resTrue['id']];
       
       # check record
       $checkRecord = mysqli_query($con,"SELECT * FROM record WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND option_id='$option_id' AND question_id='$Question_id'");
       if(mysqli_num_rows($checkRecord) > 0){
         $query = mysqli_query($con, "UPDATE record SET answered='$answered' WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND option_id='$option_id' AND question_id='$Question_id'");
       }else{
        $query = mysqli_query($con, "INSERT INTO record (student_id,exam_id,question_id,option_id,answered) VALUES ('$insertStudentID','$exam_id','$Question_id','$option_id','$answeredTrue')");
   
       }
       
      
      }
     
      
   }

  }

  $totalAnsweredTrue = $trueWrong + $trueRight;
  $resultTrue = ($trueRight * $markPerOption)-($trueWrong * $negative_markPerOption);
  $trueFalseResult = $resultTrue;

      }
     


     
     $totalAnswered = $wrong + $right;
     $result = ($right * $mark)-($wrong * $negative_mark);
     $result = $result + $trueFalseResult;
     
    
     # check result
     $checkResult = mysqli_query($con, "SELECT * FROM result WHERE student_id='$insertStudentID' AND exam_id='$exam_id'");
     if(mysqli_num_rows($checkResult) > 0){
      $insertResult = mysqli_query($con, "UPDATE result SET result='$result',answered='$totalAnswered',wrong_answered='$wrong',right_answered='$right',not_answered='$noAns' WHERE student_id='$insertStudentID' AND exam_id='$exam_id'");
     }else{
      $insertResult = mysqli_query($con, "INSERT INTO result (`student_id`, `exam_id`, `result`, `answered`, `wrong_answered`, `right_answered`, `not_answered`) 
     VALUES ('$insertStudentID','$exam_id','$result','$totalAnswered','$wrong','$right','$noAns')");
     }

     # check leaderboard 
    //  $checkLeaderBoard = mysqli_query($con,"SELECT * FROM leaderboard WHERE student_id='$insertStudentID' AND exam_id='$exam_id'");
    //  if(mysqli_num_rows($checkLeaderBoard) == 0){
    //   $insertLeaderBoard = mysqli_query($con, "INSERT INTO leaderboard (`student_id`, `exam_id`, `result`) 
    //   VALUES ('$insertStudentID','$exam_id','$result')");
    //  }
     
    if($insertResult){ 
     ?>
<script>
Swal.fire({
  icon: "success",
  title: "Submit Successfully!",
}).then(() => {
  location.replace("result?Exam-History=<?=$exam_id?>");
});
</script>
<?php
    }else{
     ?>
<script>
alert("Failed to insert Result");
</script>
<?php
    }
   
    }

  
}
}else{
  # true false
  $getMark = mysqli_query($con,"SELECT * FROM exam WHERE exam_id='$exam_id'");
  if(mysqli_num_rows($getMark) > 0){
    $fetchMark = mysqli_fetch_array($getMark);
    $mark = $fetchMark['marks_per_option'];
    $negative_mark = $fetchMark['negative_marks_per_option'];
  }
  $searchExamType = mysqli_query($con,"SELECT * FROM exam WHERE exam_id='$exam_id' AND type=1");
  if(mysqli_num_rows($searchExamType) > 0){
    #live exam

  // check is student submit result before or not
  $checkStudent = mysqli_query($con, "SELECT * FROM result WHERE student_id='$insertStudentID' && exam_id='$exam_id'");
  if(mysqli_num_rows($checkStudent) > 0){

   ?>
<script>
Swal.fire({
  icon: "error",
  title: "Exam Already Taken!",
}).then(() => {
  location.replace("result?Exam-History=<?=$exam_id?>");
});
</script>
<?php
  }else{
   # true false live
    $select = mysqli_query($con, "SELECT * FROM true_false_options");
    if(mysqli_num_rows($select) > 0){
     while($res = mysqli_fetch_array($select)){
           
       if(isset($_POST[$res['id']])){
        if($_POST[$res['id']] == $res['answer']){
          $right++;
        }elseif ($_POST[$res['id']] == 5) {
          $noAns ++;
        }else{
          $wrong++;
        }
        $option_id = $res['id'];
        $Question_id = $res['question_id'];
        $answered = $_POST[$res['id']];
        
        $query = mysqli_query($con, "INSERT INTO true_false_record (student_id,exam_id,question_id,option_id,answered) VALUES ('$insertStudentID','$exam_id','$Question_id','$option_id','$answered')");
    
       }
      
       
    }
   
     $totalAnswered = $wrong + $right;
     $result = ($right * $mark)-($wrong * $negative_mark);
    
     $insertResult = mysqli_query($con, "INSERT INTO result (`student_id`, `exam_id`, `result`, `answered`, `wrong_answered`, `right_answered`, `not_answered`) 
     VALUES ('$insertStudentID','$exam_id','$result','$totalAnswered','$wrong','$right','$noAns')");

     $insertLeaderBoard = mysqli_query($con, "INSERT INTO leaderboard (`student_id`, `exam_id`, `result`) 
     VALUES ('$insertStudentID','$exam_id','$result')");

    if($insertResult){ 
     ?>
<script>
Swal.fire({
  icon: "success",
  title: "Submit Successfully!",
}).then(() => {
  location.replace("result?Exam-History=<?=$exam_id?>");
});
</script>
<?php
    }else{
     ?>
<script>
alert("Failed to insert Result");
</script>
<?php
    }
   
    }

  }
  
}else{
  #true false practice exam

    $select = mysqli_query($con, "SELECT * FROM true_false_options");
    if(mysqli_num_rows($select) > 0){
     while($res = mysqli_fetch_array($select)){
        # delete old record first
        $deleteOption_id = $res['id'];
        $isRecordExist = mysqli_query($con, "SELECT * FROM true_false_record WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND option_id='$deleteOption_id'");
        if(mysqli_num_rows($isRecordExist) > 0){
          $deleteOldRecord = mysqli_query($con, "DELETE FROM true_false_record WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND option_id='$deleteOption_id'");
        }
        
      if(isset($_POST[$res['id']])){
        if($_POST[$res['id']] == $res['answer']){
          $right++;
        }elseif ($_POST[$res['id']] == 5) {
          $noAns ++;
        }else{
          $wrong++;
        }
        $option_id = $res['id'];
        $Question_id = $res['question_id'];
        $answered = $_POST[$res['id']];
       
        # check record
        $checkRecord = mysqli_query($con,"SELECT * FROM true_false_record WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND option_id='$option_id' AND question_id='$Question_id'");
        if(mysqli_num_rows($checkRecord) > 0){
          $query = mysqli_query($con, "UPDATE true_false_record SET answered='$answered' WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND option_id='$option_id' AND question_id='$Question_id'");
        }else{
          $query = mysqli_query($con, "INSERT INTO true_false_record (student_id,exam_id,question_id,option_id,answered) VALUES ('$insertStudentID','$exam_id','$Question_id','$option_id','$answered')");
    
        }
       
       }
     }
     
     $totalAnswered = $wrong + $right;
     $result = ($right * $mark)-($wrong * $negative_mark);
    
     # check result
     $checkResult = mysqli_query($con, "SELECT * FROM result WHERE student_id='$insertStudentID' AND exam_id='$exam_id'");
     if(mysqli_num_rows($checkResult) > 0){
      $insertResult = mysqli_query($con, "UPDATE result SET result='$result',answered='$totalAnswered',wrong_answered='$wrong',right_answered='$right',not_answered='$noAns' WHERE student_id='$insertStudentID' AND exam_id='$exam_id'");
     }else{
      $insertResult = mysqli_query($con, "INSERT INTO result (`student_id`, `exam_id`, `result`, `answered`, `wrong_answered`, `right_answered`, `not_answered`) 
     VALUES ('$insertStudentID','$exam_id','$result','$totalAnswered','$wrong','$right','$noAns')");
     }

     # check leaderboard 
    //  $checkLeaderBoard = mysqli_query($con,"SELECT * FROM leaderboard WHERE student_id='$insertStudentID' AND exam_id='$exam_id'");
    //  if(mysqli_num_rows($checkLeaderBoard) == 0){
    //   $insertLeaderBoard = mysqli_query($con, "INSERT INTO leaderboard (`student_id`, `exam_id`, `result`) 
    //   VALUES ('$insertStudentID','$exam_id','$result')");
    //  }
     
    if($insertResult){ 
     ?>
<script>
Swal.fire({
  icon: "success",
  title: "Submit Successfully!",
}).then(() => {
  location.replace("result?Exam-History=<?=$exam_id?>");
});
</script>
<?php
    }else{
     ?>
<script>
alert("Failed to insert Result");
</script>
<?php
    }
   
    }

  
}
}

}

// calculate result for custom exam

if(isset($_POST['submitCustomExam'])){
  $exam_id = $_POST['exam_id'];
  $mark = $_POST['mark'];
  $negative_mark = $_POST['negative_mark'];
  $insertStudentID = $_SESSION['student_id'];
  $right = 0;
  $wrong = 0;
  $noAns = 0;


    $select = mysqli_query($con, "SELECT * FROM questions");
    if(mysqli_num_rows($select) > 0){
     while($res = mysqli_fetch_array($select)){

       if(isset($_POST[$res['id']])){
        if($_POST[$res['id']] == $res['answer']){
          $right++;
        }elseif ($_POST[$res['id']] == 5) {
          $noAns ++;
        }else{
          $wrong++;
        }
        $question_id = $res['id'];
        $answered = $_POST[$res['id']];
        
        $query = mysqli_query($con, "INSERT INTO record (student_id,exam_id,question_id,answered) VALUES ('$insertStudentID','$exam_id','$question_id', '$answered')");
    
       }
      
       
    }
     
     $totalAnswered = $wrong + $right;
     $result = ($right * $mark)-($wrong * $negative_mark);
    
     $insertResult = mysqli_query($con, "INSERT INTO result (`student_id`, `exam_id`, `result`, `answered`, `wrong_answered`, `right_answered`, `not_answered`) 
     VALUES ('$insertStudentID','$exam_id','$result','$totalAnswered','$wrong','$right','$noAns')"); 
    
    if($insertResult){ 
     ?>
<script>
Swal.fire({
  icon: "success",
  title: "Submit Successfully!",
}).then(() => {
  location.replace("result?Custom-Exam-History=<?=$exam_id?>");
});
</script>
<?php
    }else{
     ?>
<script>
alert("Failed to insert Result");
</script>
<?php
    }
   
    }

  
}




// update user information
if(isset($_POST['updateStudentsInformation'])){
  $full_name = mysqli_real_escape_string($con, $_POST['full_name']) ;
  $username = mysqli_real_escape_string($con, $_POST['username']) ;
  $email = mysqli_real_escape_string($con, $_POST['email']) ;
  $mobile = mysqli_real_escape_string($con, $_POST['mobile']) ;
  $institute = mysqli_real_escape_string($con, $_POST['college']) ;
  $hsc = mysqli_real_escape_string($con, $_POST['hsc']) ;

  $sql = mysqli_query($con,"UPDATE students SET full_name='$full_name',email='$email',username='$username',mobile='$mobile',
  college='$institute',hsc='$hsc' WHERE student_id='$student_id'");
  
  if($sql){
    ?>
<script>
Swal.fire({
  icon: "success",
  title: "Updated!",
}).then(() => {
  location.replace("details?Profile");
});
</script>
<?php
  }else{
    ?>
<script>
Swal.fire({
  icon: "error",
  title: "Failed!",
}).then(() => {
  location.replace("details?Profile");
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
    $password_search = "SELECT * FROM students WHERE student_id='$student_id' AND status='1'";
    $query = mysqli_query($con,$password_search);

    $password_count = mysqli_num_rows($query);

  if($new_password != $confirm_password){
    ?>
<script>
Swal.fire({
  icon: "error",
  title: "Password And Confirm Password didn't matched!",
}).then(() => {
  $("#passwordModal").modal("show");
});
</script>
<?php
  }else{
        $password_pass = mysqli_fetch_assoc($query);
        $db_pass = $password_pass['password'];
        $pass_decode = password_verify($old_password, $db_pass);
        if($pass_decode){
          $change =mysqli_query($con,"UPDATE students SET password = '{$new_pass}',confirm_password = '{$c_pass}' WHERE student_id = {$student_id}");

          if($change){
            ?>
<script>
Swal.fire({
  icon: "success",
  title: "Password changed Successfully!",
}).then(() => {
  location.replace("details?Profile");
});
</script>
<?php
          }else{
            ?>
<script>
Swal.fire({
  icon: "error",
  title: "Failed!",
}).then(() => {
  $("#passwordModal").modal("show");
});
</script>
<?php
          }
        }else{
          ?>
<script>
Swal.fire({
  icon: "warning",
  title: "Old Password didn't matched!",
}).then(() => {
  $("#passwordModal").modal("show");
});
</script>
<?php
        }
  }
  
 }

?>