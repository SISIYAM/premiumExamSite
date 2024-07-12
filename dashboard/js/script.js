$(document).ready(function () {
  // send otp
  $("#emailCheckBtn").on("click", function () {
    const email = $("#email").val();

    $.ajax({
      type: "post",
      url: "./includes/resetCode.php",
      data: {
        email: email,
        checkEmail: "checkEmail",
      },
      success: function (response) {
        let data = jQuery.parseJSON(response);
        if (data.is_error == "no") {
          $("#alertDangerBox").hide();
          $("#emailBox").hide();
          $("#alertSuccessBox").html(data.result);
          $("#alertSuccessBox").show();
          $("#checkOtpBox").show();
        }
        if (data.is_error == "yes") {
          $("#alertSuccessBox").hide();
          $("#alertDangerBox").html(data.result);
          $("#alertDangerBox").show();
        }
      },
    });
  });

  $("#checkOtpBtn").on("click", function () {
    const otp = $("#otp").val();
    $.ajax({
      type: "post",
      url: "./includes/resetCode.php",
      data: {
        otp: otp,
        checkOtp: "checkOtp",
      },
      success: function (response) {
        let data = jQuery.parseJSON(response);
        if (data.is_error == "no") {
          $("#alertDangerBox").hide();
          $("#checkOtpBox").hide();
          $("#alertSuccessBox").html(data.result);
          $("#alertSuccessBox").show();
          $("#studentID").val(data.student_id);
          $("#passWordBox").show();
        }
        if (data.is_error == "yes") {
          $("#alertDangerBox").html(data.result);
          $("#alertSuccessBox").hide();
          $("#alertDangerBox").show();
        }
      },
    });
  });
  // change password
  $("#changePassBtn").on("click", function () {
    const studentID = $("#studentID").val();
    const newPassword = $("#newPassword").val();
    const confirmPassword = $("#confirmPassword").val();

    $.ajax({
      type: "post",
      url: "./includes/resetCode.php",
      data: {
        id: studentID,
        newPassword: newPassword,
        confirmPassword: confirmPassword,
        changePassword: "changePassword",
      },
      success: function (response) {
        let data = jQuery.parseJSON(response);
        if (data.is_error == "no") {
          $("#passWordBox").hide();
          $("#alertDangerBox").hide();
          $("#checkOtpBox").hide();
          $("#alertSuccessBox").html(data.result);
          $("#alertSuccessBox").show();
          $("#successBox").show();
        }
        if (data.is_error == "yes") {
          $("#alertDangerBox").html(data.result);
          $("#alertSuccessBox").hide();
          $("#alertDangerBox").show();
        }
      },
    });
  });

  // add bookmark

  $(".bookmarkBtn").on("click", function () {
    const studentID = $("#studentID").val();
    const questionID = $(this).val();
    const questionType = $(".questionType").val();

    $.ajax({
      type: "post",
      url: "includes/ajax.php",
      data: {
        student_id: studentID,
        question_id: questionID,
        question_type: questionType,
        bookmarkBtn: "bookmarkBtn",
      },
      success: function (response) {
        if (response == 200) {
          Swal.fire({
            icon: "success",
            title: "Added to bookmark!",
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Failed!",
          });
        }
      },
    });
  });

  $(".bookmarkBtnTrue").on("click", function () {
    const studentID = $("#studentID").val();
    const questionID = $(this).val();
    const questionType = $(".questionTypeTrue").val();

    $.ajax({
      type: "post",
      url: "includes/ajax.php",
      data: {
        student_id: studentID,
        question_id: questionID,
        question_type: questionType,
        bookmarkBtn: "bookmarkBtn",
      },
      success: function (response) {
        if (response == 200) {
          Swal.fire({
            icon: "success",
            title: "Added to bookmark!",
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Failed!",
          });
        }
      },
    });
  });

  // delete bookmark

  $(".deleteBookmarkBtn").on("click", function () {
    const questionID = $(this).val();
    const studentID = $("#studentID").val();

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "includes/ajax.php",
          data: {
            id: questionID,
            student_id: studentID,
            deleteBookmark: "deleteBookmark",
          },
          success: function (response) {
            if (response == 200) {
              Swal.fire({
                icon: "error",
                title: "Deleted!",
              }).then(() => {
                location.replace("result?Bookmark");
              });
            } else {
              Swal.fire({
                icon: "warning",
                title: "Failed!",
              });
            }
          },
        });
      }
    });
  });
});
