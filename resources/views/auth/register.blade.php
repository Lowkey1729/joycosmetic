<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registration Form | Joycosmetics</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet"
        href="{{asset('css/auth/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{asset('css/auth/css/style.css')}}">
</head>

<body>

    <div class="wrapper" style="background-image: url('css/auth/images/bg-registration-form-2.jfif');">
        <div class="inner">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h3 style="color: #000;">Registration Form<img src="{{asset('img/core-img/logo.png')}}" width="100px"></h3>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="first_name">First Name</label>
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                            value="{{ old('first_name') }}" required autocomplete="name" autofocus>


                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <div class="form-wrapper">
                        <label for="last_name">Last Name</label>
                        <input id="last_name" name="last_name" type="text" class="form-control  @error('last_name') is-invalid @enderror">

                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                    </div>
                </div>
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
                    <label for="">Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                        value="{{ old('phone') }}" required autocomplete="phone">

                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror


                </div>

                <div class="form-wrapper">
                    <label for="">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                        value="{{ old('address') }}" required autocomplete="address">

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
                <div class="form-wrapper">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                        required autocomplete="new-password">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> I accept the Terms of Use & Privacy Policy.
                        <span class="checkmark"></span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </form>
            <div style="margin: 1em;" class="container">
                <div class="row">
                    <div class="col-6">
                        <a style="font-size: 1.1em; text-decoration: none;"href="{{url('login')}}">Already have an account?</a>
                    </div>

                    <div class="col-6">
                    <a style="font-size: 1.1em; text-decoration: none;"href="{{url('/')}}"> Return to shop page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
