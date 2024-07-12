<footer>
  <div class="footer clearfix mb-0 text-muted">


  </div>
</footer>

<script>
setInterval(() => {
  $.ajax({
    type: "post",
    url: "includes/ajax.php",
    data: {
      examType: "examType",
      expiryDate: "expiryDate",
    },
    success: function(ExamTypeResponse) {
      console.log(ExamTypeResponse);
    }
  });
}, 1000);
</script>