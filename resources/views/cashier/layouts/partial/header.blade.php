<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RMS - @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/assets/cashier/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/cashier/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="/assets/cashier/css/swiper.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/backend_fonts/font-awesome/css/font-awesome.css" />
    <link href="/assets/css/sweetalert.css" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/gritter/css/jquery.gritter.css">
    <link href="/assets/js/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <script src="/assets/cashier/bootstrap/js/jquery-2.2.4.min.js"></script>
    <script src="/assets/cashier/bootstrap/js/popper.min.js"></script>
    <script src="/assets/cashier/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/cashier/bootstrap/js/heightLine.js"></script>
    <script src="/assets/cashier/js/swiper.min.js"></script>
    <script src="/assets/js/sweetalert-dev.js"></script>
    <script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="/assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/js/datatables/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/assets/cashier/js/paginathing.js"></script>
    <script type="text/javascript" src="/assets/js/crud.js"></script>
    

    <script>
        function addNotification(title, text){
            $.gritter.add({
                title: title,
                text: text,
                time: 3000
            });
            return false;
        };

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

            //For Pagination Table
            $('#table-pagination tbody').paginathing({
              perPage: 10,
              insertAfter: '.table',
              pageNumbers: true
            });
        });
    </script>
    {!! Html::script('node_modules/socket.io-client/dist/socket.io.js') !!}
    {!! Html::script('/assets/js/socket-io/socket_functions.js') !!}

</head>
<body>
    <div class="wrapper">   
        @if(count(Session::get('message')) != 0)
            <div ></div>
        @endif
        <div class="header-sec">   
            <div class="container">   
                <div class="row"> 
                    <div class="col-md-4 col-4 heightLine_01 head-lbox">
                        <div>  
                            <a class="btn btn-large dash-btn mb-2" href="/Cashier/Dashboard">Dashboard</a>
                            @yield('dayEnd')
                        </div>
                    </div>  
                    <div class="col-md-4 col-4 heightLine_01">
                        <img src="/assets/cashier/images/ros_logo.png" alt="ROS logo" class="ros-logo">
                    </div>  
                    <div class="col-md-4 col-4 heightLine_01 head-rbox">
                        <div>   
                            @yield('nightEnd')
                            <div class="dropdown show pull-right">
                              <button role="button" id="dropdownMenuLink" class="btn btn-primary user-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="/assets/cashier/images/login_img.png" alt="login image">
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="/Cashier/logout">Logout</a>
                              </div>
                            </div> 
                        </div>
                    </div>  
                </div>
            </div>
        </div><!-- header-sec -->

        