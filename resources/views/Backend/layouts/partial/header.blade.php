<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>RMS - @yield('title')</title>{{--// yield(title) is for only title--}}
    <link rel="stylesheet" href="/assets/backend_css/bootstrap.min.css">
      <link rel="stylesheet" href="/assets/backend_css/AdminLTE.min.css">
  <link rel="stylesheet" href="/assets/backend_css/AdminLTE.css">
  <link rel="stylesheet" href="/assets/backend_fonts/font-awesome/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="/assets/backend_css/jquery-jvectormap.css"> -->
  <link rel="stylesheet" href="/assets/backend_plugins/bootstrap-datepicker/css/datepicker3.css">

  <link rel="stylesheet" href="/assets/backend_css/_all-skins.min.css">
  <link rel="stylesheet" href="/assets/js/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="/assets/js/datatables/jquery.dataTables.min.css">
  <link rel="stylesheet" href="/assets/backend_css/style.css">
  <link rel="stylesheet" href="/assets/backend_css/import.css">
  <link rel="stylesheet" href="/assets/backend_css/font-awesome.min.css">
  <link rel="stylesheet" href="/assets/backend_css/formValidation.css">
  <link rel="stylesheet" href="/assets/backend_css/jquery.gritter.css">
  <link rel="stylesheet" href="/assets/backend_css/sweetalert.css">
  <link rel="stylesheet" href="/assets/backend_fonts/ionic.css">
  <link rel="stylesheet" href="/assets/backend_css/bootstrap-timepicker.css">
  <link rel="stylesheet" href="/assets/backend_css/datepicker3.css">
  <link href="/assets/css/multiple-select.css" rel="stylesheet">

  <script src="/assets/backend_js/jquery.min.js"></script>
  <script src="/assets/js/jquery-2.1.4.js"></script>
<script src="/assets/backend_js/jquery-ui/jquery-ui.min.js"></script>
  <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

  
 
  <script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script> 
  <script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
  <script src="/assets/backend_plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script src="/assets/backend_js/booking_validation.js"></script>
  <script src="/assets/js/multiple-select.js"></script>
 <script src="/assets/backend_js/moment.min.js"></script>

  
  
  <script src="/assets/backend_js/custom-datepicker.js"></script>
  <script src="/assets/backend_js/date.js"></script>
  <script src="/assets/js/czMore/js/jquery.czMore-1.5.3.2.js"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <script src="/assets/js/checkall.js"></script>
  <script src="/assets/backend_js/Chart.js"></script>
 
  <script src="/assets/backend_js/validation/jquery.validate.js"></script>
  
  
  <script src="/assets/backend_js/raphael.min.js"></script>
  <script src="/assets/backend_js/morris.min.js"></script>
  <script src="/assets/backend_js/jquery.sparkline.min.js"></script>
  <script src="/assets/backend_plugins/gritter/js/jquery.gritter.min.js"></script>
  <script src="/assets/backend_js/jquery.knob.min.js"></script>
  <script src="/assets/backend_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <script src="/assets/backend_plugins/bootstrap-datepicker/js/moment.js"></script>
  <script src="/assets/backend_plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
  <script src="/assets/backend_js/jquery.slimscroll.min.js"></script>
  <script src="/assets/backend_js/fastclick.js"></script>
  <script src="/assets/backend_js/crud.js"></script>
  <script src="/assets/backend_js/adminlte.min.js"></script>
  <script src="/assets/backend_js/dashboard.js"></script>
  <script src="/assets/backend_js/sweetalert.min.js"></script>
  <script src="/assets/backend_js/sweetalert-dev.js"></script>
  <script src="/assets/backend_js/fileupload.js"></script>
  <script src="/assets/backend_js/multi-row.js"></script>
  <script src="/assets/backend_js/validation/validation.js"></script>
  <script src="/assets/js/datatables/jquery.dataTables.min.js"></script>
  <script src="/assets/js/datatables/dataTables.bootstrap.js"></script>
 <script src="/assets/js/checkall.js"></script>
 <script src="/assets/js/enabled-disabled.js"></script>
<script>
   
    
        $(document).ready(function() {
            //check for notification
            //TableManageTableTools.init();
            @if(Session::has('message'))
                    var message_title = "{{Session::get('message')['title']}}";
            var message_body = "{{Session::get('message')['body']}}";
            setTimeout(addNotification(message_title, message_body), 5000);
            @endif

            //set time out for the flash message..
            setTimeout(function(){
                $('#flash-message').hide("slow");
            }, 2000);
        });
    </script>
    {!! Html::script('node_modules/socket.io-client/dist/socket.io.js') !!}
    {!! Html::script('/assets/js/socket-io/socket_functions.js') !!}
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              
            </a>
            
          </li>
        
         
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</div>

