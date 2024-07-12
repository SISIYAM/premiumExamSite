<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
  <?php include 'includes/head.php'; ?>
  <style>
  label {
    color: #000000;
    font-size: 16px;
  }
  </style>
</head>

<body class="h-100">
  <div class="authincation h-100">
    <div class="container-fluid h-100">
      <div class="row justify-content-center h-100 align-items-center">
        <div class="col-md-6">
          <div class="authincation-content">
            <div class="row no-gutters">
              <div class="col-xl-12">
                <div class="auth-form">
                  <h4 class="text-center mb-4">Reset Password</h4>
                  <div id="alertSuccessBox" class="alert alert-success text-center"
                    style="display:none;font-size:17px;color: #155724;background-color: #d4edda;border-color: #c3e6cb; padding: 0.4rem 0.4rem">

                  </div>
                  <div id="alertDangerBox" class="alert alert-danger text-center"
                    style="display:none;font-size:17px; color: #721c24;background-color: #f8d7da;border-color: #f5c6cb; padding: 0.4rem 0.4rem">

                  </div>
                  <div id="emailBox">
                    <div class="form-group">
                      <label>Enter your email address</label>
                      <input type="email" id="email" class="form-control" placeholder="Enter email" name="username">
                    </div>
                    <div class="form-row d-flex justify-content-between mt-4 mb-2">
                      <div class="form-group">
                        <a href="login?login">Log in?</a>
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="button" id="emailCheckBtn" class="btn btn-primary btn-block">Continue</button>
                    </div>
                  </div>

                  <div id="checkOtpBox" style="display:none;">
                    <div class="form-group">
                      <label>Code Verification</label>
                      <input type="number" id="otp" class="form-control" placeholder="Enter 6 digits code" name="">
                    </div>
                    <div class="form-row d-flex justify-content-between mt-4 mb-2">

                    </div>
                    <div class="text-center">
                      <button type="button" id="checkOtpBtn" class="btn btn-primary btn-block">Continue</button>
                    </div>
                  </div>

                  <div id="passWordBox" style="display:none">

                    <input type="hidden" name="" id="studentID">
                    <div class="form-group">
                      <label>New Password</label>
                      <input type="text" id="newPassword" class="form-control" placeholder="Enter new password" name="">
                    </div>

                    <div class="form-group">
                      <label>Confirm Password</label>
                      <input type="text" id="confirmPassword" class="form-control" placeholder="Enter  Confirm password"
                        name="">
                    </div>
                    <div class="form-row d-flex justify-content-between mt-4 mb-2">

                    </div>
                    <div class="text-center">
                      <button type="button" id="changePassBtn" class="btn btn-primary btn-block">Continue</button>
                    </div>
                  </div>
                  <div id="successBox" style="display:none">
                    <div class="form-row d-flex justify-content-between mt-4 mb-2">

                    </div>
                    <div class="text-center">
                      <a href="login?login"><button type="button" id="" class="btn btn-primary btn-block">Login
                          Now</button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./js/script.js"></script>

</body>

</html>