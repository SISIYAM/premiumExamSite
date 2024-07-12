<?php
include 'dbcon.php';

// delete teachers
if(isset($_POST['deleteTeacherBtn'])){
  $id = $_POST['id'];

  $delete = mysqli_query($con, "DELETE FROM admin WHERE id='$id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
}

// delete student
if(isset($_POST['deleteStudentBtn'])){
  $id = $_POST['id'];

  $delete = mysqli_query($con, "DELETE FROM students WHERE id='$id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
}

// delete exam
if(isset($_POST['deleteExamBtn'])){
  $id = $_POST['id'];

  $delete = mysqli_query($con, "DELETE FROM exam WHERE id='$id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
}

// delete question
if(isset($_POST['deleteQuestionBtn'])){
  $id = $_POST['id'];
  
  $delete = mysqli_query($con, "DELETE FROM questions WHERE id='$id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
}

// delete subject
if(isset($_POST['deleteSubjectBtn'])){
  $id = $_POST['id'];

  $oldSubject = mysqli_query($con, "SELECT * FROM subjects WHERE id='$id'");
  $oldName = mysqli_fetch_array($oldSubject)['subject'];
  
  
  $delete = mysqli_query($con, "DELETE FROM subjects WHERE id='$id'");
  if($delete){
    $updateColumn = mysqli_query($con, "ALTER TABLE exam DROP COLUMN $oldName;");
    if($updateColumn){
      $deleteChapter = mysqli_query($con,"DELETE FROM chapter WHERE subject_id='$id'");
      
      if($deleteChapter){
        echo 200;
      }
    }else{
      echo 900;
    }
  }else{
    echo 500;
  }
}

// delete chapter
if(isset($_POST['deleteChapterBtn'])){
  $id = $_POST['id'];
  
  $delete = mysqli_query($con, "DELETE FROM chapter WHERE id='$id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
}

// delete course
if(isset($_POST['deleteCourseBtn'])){
  $id = $_POST['id'];

  $delete = mysqli_query($con, "DELETE FROM package WHERE id='$id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
}

// delete lecture
if(isset($_POST['deleteLecture'])){
  $id = $_POST['id'];

  $delete = mysqli_query($con, "DELETE FROM lectures WHERE id='$id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
}

// delete true false
if(isset($_POST['deleteTrueFalse'])){
  $id = $_POST['id'];

  $delete = mysqli_query($con, "DELETE FROM true_false_question WHERE id='$id'");
  if($delete){
    $searchOptions = mysqli_query($con, "SELECT * FROM true_false_options WHERE question_id='$id'");
    if(mysqli_num_rows($searchOptions) > 0){
      while($res = mysqli_fetch_array($searchOptions)){
        $optionID = $res['id'];
        $deleteOption = mysqli_query($con, "DELETE FROM true_false_options WHERE id='$optionID'");
      }
    }
    echo 200; 
  }else{
    echo 500;
  }
}

?>