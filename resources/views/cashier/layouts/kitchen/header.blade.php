<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>RMS - @yield('title')</title>{{--// yield(title) is for only title--}}
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/bootstrap-datepicker/css/datepicker3.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/fullcalendar.css">

   
    <link href="/assets/mystyle/style.css" rel="stylesheet">
    <link href="/assets/css/AdminLTE.css" rel="stylesheet">
    <link href="/assets/css/sweetalert.css" rel="stylesheet">
    <link href="/assets/css/multiple-select.css" rel="stylesheet">
    <link href="/assets/css/jktCuteDropdown.css" refl="stylesheet">
    
    <link href="/assets/js/datatables/dataTables.bootstrap.css" rel="stylesheet">

    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/ionicons/css/ionicons.min.css">

    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/gritter/css/jquery.gritter.css">

    <script src="/assets/js/jquery-2.1.4.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
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
    {!! Html::script('node_modules/socket.io/node_modules/socket.io-client/socket.io.js') !!}
</head>

<body>
<div class="row header">
    <div class="container">
        <div class="row head_row">
            <div class="col-md-2 logo_container">
                {{--@if($headerData->logo != "")--}}
                @if($headerData != "")
                    @if($headerData->logo != "")
                        <img id="filename" class="bottom image header_logo" src="../../../uploads/{{$headerData->logo}}">
                    @else
                        <img id="filename" class="bottom image header_logo" src="assets/images/acepluslogo.png" style="height: 60px; margin-top:30px;">
                    @endif
                @else
                    <img id="filename" class="bottom image header_logo" src="assets/images/acepluslogo.png" style="height: 60px; margin-top:30px;">
                @endif
            </div>
            <div class="col-md-8">
                <h1 class="header-title"><b>Restaurant</b> Ordering System</h1>
            </div>
            <div class="col-md-2 logout">
                <a href="/Cashier/updateDataBeforeLogout" class="logout-font">
                    <span class="glyphicon glyphicon-user"></span> <span class="logout">Logout</span>
                </a>
            </div>
        </div>
    </div>
</div>

