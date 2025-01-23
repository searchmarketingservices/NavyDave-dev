@extends('guest.layouts.main')
{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('./assets/images/favicon.png') }}" type="favicon.png" sizes="32x32">
    <link rel="stylesheet" href="{{ asset('./assets/css/lib.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/css/style.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        .main-box-navy2 {
            padding: 50px;
            background-color: #eeeeee;
            padding-top: 0;
            background: url(https://images.squarespace-cdn.com/content/v1/5a9eeefe3e2d09d0e23f795d/1521482986989-96M3DCV5UHODBFA0KQL3/golf-09.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .bg-white2 {
            background-color: #ffffff80 !important;
            backdrop-filter: blur(16px);
            border: #ccc 1px solid;
        }

        .col-md-6.offset-md-3.bg-white2.p-5 .register-btn {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .col-md-6.offset-md-3.bg-white2.p-5 .register-btn a {
            color: black;
            font-size: 18px;
            font-weight: 600;
            transition: .3s;
        }

        .col-md-6.offset-md-3.bg-white2.p-5 .register-btn a:hover {
            color: #4c4d4c;
        }
    </style>
{{-- </head>

<body> --}}

    @section('content')

    <section class="new-form login-form"
        style="background-image: url({{ asset('./assets/images/new-register-bg.png') }})">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="vertical-align-box">
                        <div class="logo-box">
                            {{-- <a href="{{ route('home') }}"><img src="{{ Storage::url($settings[0]->logo ?? '') }}"
                                    alt=""></a> --}}
                        </div>
                        <div class="form-box">
                            <div class="text">
                                <h2>Create A New <br> <span>Account</span> </h2>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('register.post') }}" method="POST" autocomplete="off">
                                    @csrf
                                    <input type="hidden" name="country" value="united states">
                                    <div class="single-input-box two-inputs-alin">
                                        <input type="text" name="name" id="name" placeholder="First Name *"
                                            value="{{ old('name') }}" required>
                                            <input type="text" name="last_name" id="last_name" placeholder="Last Name *"
                                            value="{{ old('last_name') }}" required>
                                    </div>
                                    <div class="single-input-box two-inputs-alin">
                                        <input type="email" name="email" id="email"
                                            placeholder="Email Address *" value="{{ old('email') }}" required>
                                        <input type="tel" name="phone" id="phone" placeholder="Phone Number *"
                                            value="{{ old('phone') }}">
                                    </div>
                                    <div class="single-input-box two-inputs-alin">
                                        <input type="text" name="city" id="city" placeholder="City *"
                                            value="{{ old('city') }}">
                                        <input type="text" name="zipcode" id="zipcode" placeholder="Zip Code *" value="{{ old('zipcode') }}" required>
                                    </div>
                                    <div class="single-input-box two-inputs-alin">
                                        <select name="state" id="state" required>
                                            <option value="">Select State *</option>
                                            @php
                                                $states = [
                                                    'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 
                                                    'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'FL' => 'Florida', 'GA' => 'Georgia', 
                                                    'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 
                                                    'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 
                                                    'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 
                                                    'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 
                                                    'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 
                                                    'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 
                                                    'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 
                                                    'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming'
                                                ];
                                            @endphp
                                            @foreach($states as $name)
                                                <option value="{{ $name }}" {{ old('state') == $name ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" placeholder="Address *" name="address" id="address"
                                            value="{{ old('address') }}">
                                    </div>
                                    <div class="single-input-box two-inputs-alin">
                                        <input type="password" placeholder="Password *" name="password" id="password"
                                            required>
                                        <input type="password" placeholder="Confirm Password *"
                                            name="password_confirmation" id="password_confirmation" required>

                                    </div>
                                    <div class="input-check-box">
                                        <input type="checkbox" id="show-password" name="remember-me"
                                            onclick="togglePassword()">
                                        <label for="show-password">Show password</label>
                                    </div>

                                    <button type="submit">Register Now</button>

                                </form>
                            </div>
                        </div>

                        <div class="form-btm-content">
                            <p> <a href="{{ route('login') }}">Back to Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    @endsection

    <script src="{{ asset('./assets/js/wow-animate.js') }}"></script>
    <script src="{{ asset('./assets/js/lib.js') }}"></script>
    <script src="{{ asset('./assets/js/custom.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password_confirmation");
            var passwordField2 = document.getElementById("password");

            var checkbox = document.getElementById("show-password");

            if (checkbox.checked) {
                passwordField.type = "text";
                passwordField2.type = "text";
            } else {
                passwordField.type = "password";
                passwordField2.type = "password";
            }
        }
    </script>

{{-- </body>

</html> --}}
