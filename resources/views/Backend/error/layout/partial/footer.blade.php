  <footer class="blog-footer">
    <p>© Copyright 2018, All Rights reserved by ACEPLUS Solutions Co.,Ltd.</p>
  </footer>



    <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="/assets/f_js/ie10-viewport-bug-workaround.js"></script>
      <script type="text/javascript" src="/assets/f_js/bootstrap-datepicker.js"></script>
      <link rel="stylesheet" href="/assets/f_css/bootstrap-datepicker.css"/>

      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script> -->
      <script src="/assets/f_js/bootstrap.min.js"></script>
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="/assets/f_js/slick.min.js"></script>
      <script src="/assets/f_js/custom.js"></script>
      <script src="/assets/f_js/jquery.easing.min.js"></script>
      <script src="/assets/js/validation/jquery.validate.js"></script>
      <script src="/assets/js/validation/validation.js"></script>
      <script src="/assets/l_js/validate_additional.js"></script>


      <script src="/test/multiple-select.js"></script>
      <script src="/test/file-validate.js"></script>
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script> -->
      <script src="/assets/f_js/bootstrap.min.js"></script>
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->


    </body>
    <script>
      $(document).ready(function(){
        var date_input=$('#date'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
          format: 'mm/dd/yyyy',
          container: container,
          todayHighlight: true,
          autoclose: true,
        });
      })
      // $(function () {
      //   function addNotification(title, text){
      //     $.gritter.add({
      //       title: title,
      //       text: text,
      //       time: 3000
      //     });
      //     return false;
      //   };
      // });
    </script>

    </html>