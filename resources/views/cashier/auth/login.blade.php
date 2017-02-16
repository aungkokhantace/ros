<!DOCTYPE html>
<html>
<head>
    <title>Log In</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/mystyle/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row middle">
        <div class="col-md-5 col-md-offset-3 login-left">
            <p id="logo"><strong>Restaurant</strong> Management System</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3 login-left">
            <div class="border">
                <div class="login">
                     User Login
                </div>
                <!-- Starting Form -->
                {!! Form::open(array('url' => 'login'))!!}
                        @if ($errors->has())
                            <p class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </p>
                        @endif
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    <div class="user">
                        <div class="col-md-2">
                            <span class="glyphicon glyphicon-user user_color"></span>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="user_name" id="username"
                                   value="{{ Request::old('user_name') }}" class="form-control" placeholder="Username">
                        </div>
                    </div>
                    <br>
                    <!-- Inserting Password -->
                    <div class="user">
                        <div class="col-md-2">
                            <span class="glyphicon glyphicon-lock user_color"></span>
                        </div>
                        <div class="col-md-9">
                            <input type="password" name="password" id="pw" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="col-md-11 col-md-offset-1 gap">
                        <!-- -->
                    </div>

                    <div class="col-md-10 col-md-offset-1">
                        <button type="submit" class="btn btn-default fill_color login_btn" name="login">LOG IN</button>
                    </div>
                {!! Form::close() !!}
                <!-- Ending Form -->
            </div>
        </div>
    </div>
</div>
</body>
</html>