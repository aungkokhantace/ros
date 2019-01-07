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
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
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

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .topnav {
            overflow: hidden;
            background-color: #3c8dbc;
        }

        .topnav .item-list {
            float: left;
            display: block;
            color: #f2f2f2;
            padding: 17px 16px;
            text-decoration: none;
            font-size: 15px;
        }

        .topnav .icon {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 17px 16px;
            text-decoration: none;
            font-size: 15px;
        }

        .logo {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 20px;
            width: 200px;
        }

        .topnav a:hover {
            background-color: #357ca5;
        }

        .topnav .icon {
            display: none;
        }

        @media screen and (max-width: 600px) {
            .topnav a:not(:first-child) {display: none;}
            .topnav a.icon {
                float: right;
                display: block;
            }
        }

        @media screen and (max-width: 600px) {
            .topnav.responsive {position: relative;}
            .topnav.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }

        .active {
            background-color: #357ca5;
            color: white !important;
        }

        .logout {
            float: right;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 17px 16px;
            text-decoration: none;
            font-size: 15px;
        }

        .tbname {
            background: #11463d;
            color: white;
            min-width: 250px;
        }

        .tbname h4 {
            font-size: 30px;
            font-weight: bolder;
            font-family: 'Source Sans Pro', sans-serif;
        }

        tbody tr .item-list {
            font-size: 13px;
            font-weight: bolder;
            font-family: 'Source Sans Pro', sans-serif;
        }

        tbody tr td {
            font-size: 13px;
            font-weight: bolder;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .btn-group input {
            width: 120px;
            font-weight: bolder;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .btn-group button {
            width: 120px;
            font-weight: bolder;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .tr_header td span {
            font-weight: bolder;
            font-family: 'Source Sans Pro', sans-serif;
        }
        .modal-body div {
            text-align: center;
            float: left;
            font-weight: bolder;
            font-size: 13px;
            font-family: 'Source Sans Pro', sans-serif;
        }
        .modal-body table {
            border: 1px !important;
        }

        .btn-group .taken {
            float: right;
        }

        .min-width {
            min-width: 100px;
        }

        .order-min-width {
            min-width: 150px;
        }

        .item-list table tr td {
            border: none !important;
        }

        tbody tr .item-list {
            padding-left: 0 !important;
        }

        .td-min-width {
            width: 70px;
        }

        .tdname {
            min-width: 300px;
        }

        .td-item {
            text-align: left !important;
        }

        body .tr_header {
            font-weight: bolder;
            font-family: 'Source Sans Pro', sans-serif;
        }

        body tbody {
            font-size: 14px;
            font-weight: bolder;
            font-family: 'Source Sans Pro', sans-serif;
        }

    </style>
</head>

<header>
    <div class="topnav" id="myTopnav">
        <a href="index2.html" class="logo">
            <b>Kitchen</b>@ROS
        </a>
        <a href="/Kitchen/kitchen" @if(Request::path() == 'Kitchen/kitchen') class="item-list active" @else class="item-list" @endif>
            <i class="fa fa-sliders"></i>
            &nbsp;<span><b>Table View</b></span>
        </a>
        <a href="/Kitchen/productView" @if(Request::path() == 'Kitchen/productView') class="item-list active" @else class="item-list" @endif>
            <i class="fa fa-suitcase"></i>
            &nbsp;<span><b>Product View</b></span>
        </a>
        <a href="/Kitchen/stock-requisition" @if(Request::path() == 'Kitchen/stock-requisition') class="item-list active" @else class="item-list" @endif>
            <i class="fa fa-wpforms"></i>
            &nbsp;<b>Stock Requisition Form</b></span>
        </a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
        <a href="/Backend/updateDataBeforeLogout" class="logout">
            <i class="fa fa-circle-o text-danger"></i> <span>Logout</span>
        </a>
    </div>

    <div style="padding-left:16px">

    </div>

    <script>
        function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }
    </script>
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
</header>
<div class="container-fluid">
    <div class="row">
        <div id="body">
            <!-- Blog Entries Column -->
            @yield('content')
        </div>
    </div>
</div>
@include('Backend.layouts.kitchen.footer')
{{--@include('sweet::alert')--}}
@include('sweet::alert')
