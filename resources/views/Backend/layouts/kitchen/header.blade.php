<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ROS - @yield('title')</title>{{--// yield(title) is for only title--}}
    <link rel="stylesheet" href="/assets/backend_css/bootstrap.min.css">
      <link rel="stylesheet" href="/assets/backend_css/AdminLTE.min.css">
  <link rel="stylesheet" href="/assets/backend_css/AdminLTE.css">
  <link rel="stylesheet" href="/assets/backend_fonts/font-awesome/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="/assets/backend_css/jquery-jvectormap.css"> -->
  <link rel="stylesheet" href="/assets/backend_plugins/bootstrap-datepicker/css/datepicker3.css">
  <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Oswald|Slabo+27px" rel="stylesheet">
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
  <!-- <link rel="stylesheet" href="/assets/backend_css/datepicker3.css"> -->
  <link href="/assets/css/multiple-select.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/stock_requisition_style.css') }}">

  <script src="/assets/backend_js/jquery.min.js"></script>
  <!-- <script src="/assets/js/jquery-2.1.4.js"></script> -->
<script src="/assets/backend_js/jquery-ui/jquery-ui.min.js"></script>
  <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>



  <script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
  <script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
  <script src="/assets/backend_plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script src="/assets/backend_js/booking_validation.js"></script>

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
  <script src="/assets/js/datatables/jquery.dataTables.min.js"></script>
  <script src="/assets/js/datatables/dataTables.bootstrap.js"></script>
 <script src="/assets/js/checkall.js"></script>
 <script src="/assets/js/enabled-disabled.js"></script>


    <link href="/assets/css/AdminLTE.css" rel="stylesheet">
    <link href="/assets/css/sweetalert.css" rel="stylesheet">
    <link href="/assets/css/multiple-select.css" rel="stylesheet">

    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/ionicons/css/ionicons.min.css">

    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/gritter/css/jquery.gritter.css">


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
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header kitchen_header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span ><b>Kitchen</b>@ROS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-fixed-top">
      <!-- Sidebar toggle button-->
      <div class="navbar-custom-menu " style="float:left">

        <ul class="nav navbar-nav">

        <li  @if(Request::path() == 'Kitchen/kitchen')class="active" @endif>

          <a href="/Kitchen/kitchen">
            <i class="fa fa-sliders"></i> <span>Table View</span>
            <span class="pull-right-container">

            </span>
          </a>

        </li>
        <li  @if(Request::path() == 'Kitchen/productView') class="active" @endif>

          <a href="/Kitchen/productView">
           <i class="fa fa-suitcase"></i> <span>Product View</span>
            <span class="pull-right-container">

            </span>
          </a>

        </li>
        <li  @if(Request::path() == 'Kitchen/stock-requisition') class="active" @endif>
            <a href="/Kitchen/stock-requisition">
                <i class="fa fa-wpforms"></i>&nbsp;&nbsp;<span><b>Stock Requisition Form</b></span>
                <span class="pull-right-container"></span>
            </a>
        </li>
       </ul>

      </div>

      <div class="navbar-custom-menu">



        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">

                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">

                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">

                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">

                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">

                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>

                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>

          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
          <li>

          <a href="/Backend/updateDataBeforeLogout">
           <i class="fa fa-circle-o text-danger"></i> <span>Logout</span>
            <span class="pull-right-container">

            </span>
          </a>

        </li>
        </ul>
      </div>
    </nav>
  </header>
</div>

<!-- <body>
<div class="row header">
    <div class="container">
        <div class="row head_row">

            <div class="col-md-4 logout">
                @if (Auth::guard('Cashier')->user())
                    {{Auth::guard('Cashier')->user()->user_name . " (" . Auth::guard('Cashier')->user()->roles->name . ")" }}
                @endif
                <a href="/Cashier/updateDataBeforeLogout" class="logout-font">
                    <span class="glyphicon glyphicon-user"></span> <span class="logout">Logout</span>
                </a>
            </div>
        </div>
    </div>
</div> -->
