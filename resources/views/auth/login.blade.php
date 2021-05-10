<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sign in Form | Joycosmetics</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet"
        href="{{asset('css/auth/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{asset('css/auth/css/style.css')}}">
</head>

<body>

    <div class="wrapper" style="background-image: url('css/auth/images/bg-registration-form-2.jpg');">
        <div class="inner">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h3 style="color: #000;">Sign In Form <img src="{{asset('img/core-img/logo.png')}}" width="100px"></h3>

                <div class="form-wrapper">
                    <label for="">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror


                </div>
                <div class="form-wrapper">
                    <label for="">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror


                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Remember me
                        <span class="checkmark"></span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ __('Sign In') }}
                </button>
                <br>
                @if (Route::has('password.request'))
                <a style="font-size: 1.1em; text-decoration: none;"  href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif

                <div style="margin-top: 0.5em;" class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <a style="font-size: 1.1em; text-decoration: none;" href="{{url('register')}}">Not a member yet?</a>
                    </div>

                    <div class="col-lg-6">
                    <a style="font-size: 1.1em; text-decoration: none;"href="{{url('/')}}"> Return to shop page</a>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </div>

</body>

</html>
