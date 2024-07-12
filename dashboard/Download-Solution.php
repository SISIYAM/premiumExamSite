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
  p {
    color: #000000;
    font-size: 25px;
  }
  </style>
</head>

<body onload="autoDownload()">

  <?php
if(isset($_GET['ExamID'])){
  $ExamID = $_GET['ExamID'];
  $selectExam = mysqli_query($con, "SELECT * FROM exam WHERE exam_id='$ExamID'");
  if(mysqli_num_rows($selectExam) > 0){
    $fetch = mysqli_fetch_array($selectExam);
    $examName= $fetch['exam_name'];
  }
  ?>
  <br>
  <button class="d-none" id="generate">Download</button>
  <div class="row" id="pdfContent" style="margin-top:0;">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header justify-content-center" style="">
          <h2 id="examName"><?=$examName?></h2>
        </div>
        <?php
        $i = 1;
        $select = mysqli_query($con, "SELECT * FROM record WHERE student_id='$student_id' AND exam_id='$ExamID'");
        if(mysqli_num_rows($select) > 0){
          while($row=mysqli_fetch_array($select)){
            $i++;
            $question_id = $row['question_id'];  
            $option_id = $row['option_id'];
            if($option_id == NULL){
              $question = mysqli_query($con,"SELECT * FROM questions WHERE id='$question_id'");
            $fetch = mysqli_fetch_array($question);
            ?>
        <div class=" card-body">
          <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?></h6>
          <div class="radio-list col-xl-12">
            <p for="" class="font-weight-bold text-dark my-3 h3" style="color:#000000;">
              <?=$fetch['question']?>
            </p>
            <b class="text-dark">Answer: </b>
            <?php
            if($fetch['answer'] == 1){
              ?>
            <p class="text-dark my-3 h5"><?=$fetch['option_1']?></p>
            <?php
            }elseif($fetch['answer'] == 2){
              ?>
            <p class="text-dark my-3 h5"><?=$fetch['option_2']?></p>
            <?php
            }elseif($fetch['answer'] == 3){
              ?>
            <p class="text-dark my-3 h5"><?=$fetch['option_3']?></p>
            <?php
            }elseif($fetch['answer'] == 4){
              ?>
            <p class="text-dark my-3 h5"><?=$fetch['option_4']?></p>
            <?php
            }elseif($fetch['answer'] == 6){
              ?>
            <p class="text-dark my-3 h5"><?=$fetch['option_5']?></p>
            <?php
            }
            ?>
          </div>

        </div>
        <?php
            if($fetch['solution'] != NULL){
              ?>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 mb-4">
              <div class="card bg-light text-dark">
                <div class="card-body rounded" style="border:2px solid #2EAD1E">
                  <span class="font-weight-bold text-dark">Solution:</span>
                  <div class="solution">
                    <?=$fetch['solution']?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
            }
            }else{
              $select = mysqli_query($con, "SELECT * FROM true_false_question WHERE id='$question_id'");
              if(mysqli_num_rows($select) > 0)
              {
                
                    ?>
        <div class="card-body">
          <h6 class="badge bg-primary text-light" style="font-size:13px">Question : <?=$i?> </h6>
          <div class="radio-list col-xl-12">
            <p for="" class="font-weight-bold text-dark my-3 h4">
              <?=mysqli_fetch_array($select)['question']?>
            </p>

            <?php 
                  $j = 1;
                  $optionSearch = mysqli_query($con,"SELECT * FROM true_false_options WHERE question_id='$question_id'");
                  if(mysqli_num_rows($optionSearch) > 0){
                  while($optionRow = mysqli_fetch_array($optionSearch)){
                    $optionID = $optionRow['id'];
                       ?>
            <span class="btn btn-dark btn-sm my-2">Option <?=$j?></span>

            <div class="true-false">
              <b class="text-dark">Answer: </b>
              <?php 
              if($optionRow['answer'] == 1){
                echo "<p>True</p>";
              }else{
                echo "<p>False</p>";
              }
              ?>
            </div>

            <?php 

             $j++;
              }
              ?>

            <?php
               
                 }
                   
                     ?>

          </div>

        </div>
        <?php
                 
           
                }
              }

            }
            
            ?>
        <?php
       
          }
        
        ?>

      </div>
    </div>
  </div>
  <?php
}
?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>


  <script>
  document.querySelector("#generate").addEventListener("click", () => {
    const element = document.getElementById('pdfContent');
    const fileName = document.querySelector("#examName").textContent;
    var opt = {
      margin: 0.3,
      filename: fileName + '.pdf',
      image: {
        type: 'jpeg',
        quality: 0.98
      },
      html2canvas: {
        scale: 2
      },
      jsPDF: {
        unit: 'in',
        format: 'letter',
        orientation: 'portrait'
      }
    };

    // New Promise-based usage:
    html2pdf().set(opt).from(element).save();
  });

  function autoDownload() {
    document.querySelector("#generate").click();
  }
  </script>

</body>

</html>