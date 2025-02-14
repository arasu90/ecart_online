<!doctype html>
<html lang="en">

<head>
    <title>Login 10</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('admin-assets/login/css/style.css') }}">

</head>

@php
    $login_bg_img = "admin-assets/login/images/bg.jpg";
@endphp
<body class="img js-fullheight" style="background-image: url('{{ asset($login_bg_img)}}');">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Login</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <form action="{{route('admin.validatelogin')}}" method="post" class="signin-form">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}">
                                @error('username')
                                    <span class="text-danger bg-white rounded-lg px-sm-2 mx-sm-4" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div>
                                <input id="password-field" type="password" class="form-control" name="password" placeholder="Password">
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                        </div>
                            @error('password')
                                <span class="text-danger bg-white rounded-lg px-sm-2 mx-sm-4" role="alert">{{ $message }}</span>
                            @enderror
                            <div class="form-group">
                                @if(Session::has('login_error'))
                                <span class="text-danger bg-white rounded-lg px-sm-2 mx-sm-4" role="alert">{{ Session::get('login_error') }}</span>
                                @endif
                                <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                            </div>
                            <!-- <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary">Remember Me
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="#" style="color: #fff">Forgot Password</a>
                                </div>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('admin-assets/login/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/login/js/popper.js') }}"></script>
    <script src="{{ asset('admin-assets/login/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-assets/login/js/main.js') }}"></script>

</body>

</html>
