<?php 
include "../Admin/includes/dbcon.php";
include './credential.php';
$email = "";
$MessageArray = array();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


    //if user click continue button in forgot password form
    if(isset($_POST['checkEmail'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);  
        $check_email = "SELECT * FROM students WHERE email='$email'";
        $run_sql = mysqli_query($con, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
            $code = rand(999999, 111111);
            $insert_code = "UPDATE students SET code = $code WHERE email = '$email'";
            $run_query =  mysqli_query($con, $insert_code);
            if($run_query){
                $msg='<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
                <div style="margin:50px auto;width:70%;padding:20px 0">
                  <div style="border-bottom:1px solid #eee">
                    <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">SEI Innovations</a>
                  </div>
                  <p style="font-size:1.1em">Hi,</p>
                  <p>Thank you for choosing SEI Innovations. Use the following OTP to reset your password. OTP is valid for 5 minutes</p>
                  <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">'.$code.'</h2>
                  <p style="font-size:0.9em;">Regards,<br />SEI Innovations</p>
                  <hr style="border:none;border-top:1px solid #eee" />
                  <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
                    <p>SEI Innovations</p>
                  </div>
                </div>
              </div>';
                
                //Load Composer's autoloader
                require '../phpmailer/vendor/autoload.php';
                
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);
                
                
                    //Server settings
                                        
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'siyam.ahmmedimtiaz.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = EMAIL;                     //SMTP username
                    $mail->Password   = PASS;                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
                    //Recipients
                    $mail->setFrom(EMAIL,NAME);     //Add a recipient
                    $mail->addAddress($email);               //Name is optional
                    $mail->addReplyTo('no-replay@gmail.com', 'No-replay');
                
                   
                
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Reset Password';
                    $mail->Body    = $msg;
                
                    
                
                
                                    //Email
                if($mail->send()){
                  $MessageArray = array("is_error"=>"no","result"=> "We've sent a password reset otp to your email - $email, If you do not find the mail in your inbox, please check the spam folder.");
                }else{
                    $MessageArray = array('is_error'=>'yes','result'=>'Failed while sending code!');
                }
            }else{
                $MessageArray = array('is_error'=>'yes','result'=>'Something went wrong!');
            }
        }else{
          $MessageArray = array('is_error'=>'yes','result'=>'This email address does not exist!');
        }

        echo json_encode($MessageArray);
    }

    //if user click check reset otp button
    if(isset($_POST['checkOtp'])){
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM students WHERE code = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $email = $fetch_data['email'];
            $student_id = $fetch_data['student_id'];
            $MessageArray = array('is_error'=>'no','result'=>"Please create a new password that you don't use on any other site.",'student_id'=>$student_id);
        }else{
          $MessageArray = array('is_error'=>'yes','result'=>"You've entered incorrect code!");
        }
        echo json_encode($MessageArray);
    }

    //if user click change password button
    if(isset($_POST['changePassword'])){
        $id = $_POST['id'];
        $password = mysqli_real_escape_string($con, $_POST['newPassword']);
        $cpassword = mysqli_real_escape_string($con, $_POST['confirmPassword']);
        if($password !== $cpassword){
          $MessageArray = array('is_error'=>'yes','result'=>"Confirm password not matched!");
        }else{
            $code = 0;
            $encpass = password_hash($password, PASSWORD_BCRYPT);

            $concpass = password_hash($cpassword, PASSWORD_BCRYPT);
            $update_pass = "UPDATE students SET code = $code, password = '$encpass',confirm_password = '$concpass' WHERE student_id = '$id'";
            $run_query = mysqli_query($con, $update_pass);
            if($run_query){
              $MessageArray = array('is_error'=>'no','result'=>"Congratulations Your password has been changed successfully!");
            }else{
            $MessageArray = array('is_error'=>'yes','result'=>"Failed to change your password!");
            }
        }
        echo json_encode($MessageArray);
    }
    
?>