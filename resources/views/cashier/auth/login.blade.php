<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Log In</title>
    <link rel="stylesheet" type="text/css" href="/assets/cashier/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/cashier/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/assets/cashier/css/styles.css" /> 
    <link rel="stylesheet" type="text/css" href="/assets/cashier/css/swiper.min.css"/> 
    <link rel="stylesheet" type="text/css" href="/assets/cashier/bootstrap/font-awesome/css/font-awesome.css" />

    <script src="/assets/cashier/bootstrap/js/jquery-2.2.4.min.js"></script>
    <script src="/assets/cashier/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/cashier/js/swiper.min.js"></script> 
</head>
<body id="login">
    <div class="wrapper">
        <div class="login-header-sec container-fluid">   
            <div class="row"> 
                <img src="/assets/cashier/images/ros_logo.png" alt="ROS logo" class="ros-logo">
            </div>
            <div class="row cmn-ttl cmn-ttl-log">
                <div class="container"> 
                    <h3>LOG IN</h3>
                </div> 
            </div>
        </div><!-- login-header-sec -->

        <div class="content container"> 
            <div class="row">   
                <div class="col-lg-6 col-md-6"> 
                    {!! Form::open(array('url' => 'login','class'=>'login-form'))!!}
                        @if ($errors->has())
                            <p class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </p>
                        @endif
                        <meta name="csrf-token" content="{{ csrf_token() }}" />
                        <div class="form-group row">
                            <label for="inputUsername" class="col-lg-3 col-md-5 col-form-label">User Name</label>
                            <div class="col-lg-8 col-md-7">
                              <input type="text" class="form-control" id="inputUsername" name="user_name" value="{{ Request::old('user_name') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-lg-3 col-md-5 col-form-label">Password</label>
                            <div class="col-lg-8 col-md-7">
                                <input type="password" class="form-control" id="inputPassword" name="password">
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <!-- Ending Form -->
                </div>
                <div class="col-lg-5 offset-lg-1 col-md-6 count-btn">   
                    <button class="btn btn-primary num-btn" id="0">0</button>
                    <button class="btn btn-primary num-btn" id="1">1</button>
                    <button class="btn btn-primary num-btn" id="2">2</button>
                    <button class="btn btn-primary num-btn" id="3">3</button>
                    <button class="btn btn-primary num-btn" id="4">4</button>
                    <button class="btn btn-primary num-btn" id="5">5</button>
                    <button class="btn btn-primary num-btn" id="6">6</button>
                    <button class="btn btn-primary num-btn" id="7">7</button>
                    <button class="btn btn-primary num-btn" id="8">8</button>
                    <button class="btn btn-primary num-btn" id="9">9</button>
                    <button class="btn clear-btn">Clear</button>
                    <button class="btn enter-btn">Enter</button>
                </div>
            </div>
        </div>     

        <div class="footer text-center">  
            <img src="/assets/cashier/images/aceplus_logo.png" alt="Aceplus logo">
        </div><!-- footer -->
    </div><!-- wrapper -->

    <script type="text/javascript">
        //Function For add numeric to input
        function jQ_append(id_of_input, text){
            var input_id = '#'+id_of_input;
            $(input_id).val($(input_id).val() + text);
        }

        $(document).ready(function(){
            inputRAw            = 'inputUsername';//Default mouse down is user
            //User Login Button
            $('input').mousedown(function() {
                inputRAw        = $(this).attr('id');
            });

            $('.num-btn').click(function(){
                number        = $(this).attr('id');
                jQ_append(inputRAw, number);
            });

            //Clear Button
            $('.clear-btn').click(function(){
                $('input').val('');
            });

            //Enter Button
            $('.enter-btn').click(function(){
                $('.login-form').submit();
            });
        });
    </script>
</body>
</html>