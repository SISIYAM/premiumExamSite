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
  location.replace("login.php?register");
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
  location.replace("login.php?register");
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
location.replace("home.php");
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
location.replace("home.php");
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

if(isset($_POST['purchaseBtn'])){
  $id = $_POST['id'];
  $package_id = $_POST['package_id'];
  $time = time();

  #check is user already purchased or not

  $checkRecord = mysqli_query($con,"SELECT * FROM package_record WHERE student_id='$id' AND package_id='$package_id'");

  if(mysqli_num_rows($checkRecord) > 0){
    ?>
<script>
location.replace("dashboard/index.php");
</script>
<?php
  }else{
    $sql = mysqli_query($con, "INSERT INTO package_record (student_id,package_id,timestamp) VALUES ('$id','$package_id','$time')");
    if($sql){
      ?>
<script>
location.replace("dashboard/index.php");
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

}

if(isset($_POST['renewBtn'])){
  $id = $_POST['id'];
  $package_id = $_POST['package_id'];
  $time = time();
  
    $sql = mysqli_query($con, "UPDATE package_record SET timestamp='$time',status='1' WHERE student_id='$id' AND package_id='$package_id'");
    if($sql){
      ?>
<script>
location.replace("dashboard/index.php");
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

?>