<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NAVY DAVE GOLF</title>
    <link rel="icon" href="{{ asset('./assets/images/favicon.png') }}" type="favicon.png" sizes="32x32">
    <link rel="stylesheet" href="{{ asset('./assets/css/lib.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />

</head>

<body>
    <!-- javascript:void(0) -->

    <!-- <h1 class="wow fadeInRight" data-wow-duration="3s">hello</h1> -->

    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <div class="header-logo">
                        <a href="{{ route('home') }}"><img src="{{ Storage::url($settings[0]->logo ?? '') }}"
                                alt=""></a>
                    </div>
                </div>
                <div class="col-lg-8 disple-none-mb">
                    <div class="header-nav">
                        <ul>
                            <li><a href="{{ route('home') }}" class="home-active">Home</a></li>
                            <li><a href="{{ route('about') }}" class="about-active">About</a></li>
                            <li><a href="{{ route('pricing') }}" class="pricing-active">Packages</a></li>
                            <li><a href="{{ route('appointment') }}" class="appointment-active">Appointments</a></li>
                            <li><a href="{{ route('blogs') }}" class="blog-active">Blogs</a></li>
                            <li><a href="{{ route('faq') }}" class="faq-active">FAQ</a></li>
                            <li><a href="{{ route('contact') }}" class="contact-active">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 disple-none-mb">
                    <div class="header-cart-search">
                        <ul>
                            {{-- <li><a href="#"><img src="{{ asset('./assets/images/shopping-cart.png') }}"
                                        alt=""></a></li>
                            <li><a href="#"><img src="{{ asset('./assets/images/search-icon.png') }}"
                                        alt=""></a></li> --}}
                            <li class="drop-dwon-menu"><a>
                                    <img src="{{ asset('./assets/images/person-user.png') }}" alt=""></a>
                                @guest
                                    <ul class="drop-dwon-menu">
                                        <li><a href="{{ route('login') }}">Login</a></li>
                                        <li><a href="{{ route('register') }}">Sign Up</a></li>
                                    </ul>
                                @else
                                    <ul class="drop-dwon-menu">
                                        @if (auth()->check() && auth()->user()->hasRole('user'))
                                        <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                        <li><a href="{{ route('user.profile') }}">Profile</a></li>                    
                                        @endif
                                        @if (auth()->check() && auth()->user()->hasRole('admin'))
                                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                        <li><a href="{{ route('admin.profile') }}">Profile</a></li>
                                        @endif
                                        @if (auth()->check() && auth()->user()->hasRole('staff'))
                                        <li><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                                        <li><a href="{{ route('staff.profile') }}">Profile</a></li>       
                                        @endif
                                        <li><a href="{{ route('logout') }}">Logout</a></li>
                                    </ul>
                                @endguest
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="super-container">
                    <div class="slide-container">
                        <div class="stripe toggle-nav js-nav">
                            <div class="hamburger-box">
                                <div class="bun top"></div>
                                <div class="meat"></div>
                                <div class="bun bottom"></div>
                            </div>
                        </div>
                        <div class="nav-wrap">
                            <nav class="menu">
                                <ul>
                                    <li><a href="{{ route('home') }}" class="home-active">Home</a></li>
                                    <li><a href="{{ route('about') }}" class="about-active">About</a></li>
                                    <li><a href="{{ route('pricing') }}" class="pricing-active">Packages</a></li>
                                    <li><a href="{{ route('appointment') }}"
                                            class="appointment-active">Appointments</a></li>
                                    <li><a href="{{ route('blogs') }}" class="blog-active">Blogs</a></li>
                                    <li><a href="{{ route('faq') }}" class="faq-active">FAQ</a></li>
                                    <li><a href="{{ route('contact') }}" class="contact-active">Contact Us</a></li>
                                    @guest
                                        <li><a href="{{ route('login') }}">login</a></li>
                                        <li><a href="{{ route('register') }}">sign up</a></li>
                                    @else
                                        <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                        <li><a href="{{ route('user.profile') }}">Profile</a></li>
                                        <li><a href="{{ route('logout') }}">Logout</a></li>
                                    @endguest
                                    {{-- <li><a href="{{ route('login') }}">login</a></li>
                                    <li><a href="#"><img src="{{ asset('./assets/images/shopping-cart.png') }}"
                                                alt=""></a></li>
                                    <li><a href="#"><img src="{{ asset('./assets/images/search-icon.png') }}"
                                                alt=""></a></li>
                                    <li><a href="#"><img src="{{ asset('./assets/images/person-user.png') }}"
                                                alt=""></a></li> --}}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <footer style="padding-top: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="main-footer-logo">

                        <a href="{{ route('home') }}"> <img src="{{ Storage::url($settings[0]->logo ?? '') }}"
                                alt="Logo"></a>
                                
                                <p>{{ $settings[0]->footer_description ?? 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.' }}</p>

                                <div class="socail-icons">
                                    <ul>
                                        <li><a href="{{ $settings[0]->instagram_link ?? '#' }}"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                        <li><a href="{{ $settings[0]->facebook_link ?? '#' }}"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        {{-- <li><a href="{{ $settings[0]->twitter_link ?? '#' }}"><i class="fa fa-twitter" aria-hidden="true"></i></a></li> --}}
                                    </ul>
                                </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="heading-footer">
                        <h6>Quick Links</h6>
                    </div>
                    <div class="footer-links">
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('pricing') }}">Packages</a></li>
                            <li><a href="{{ route('about') }}">About</a></li>
                            <li><a href="{{ route('appointment') }}">Appointments</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            <li><a href="{{ route('blogs') }}">Blogs</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="heading-footer">
                        <h6>Subscribe</h6>
                    </div>
                    <div class="footer-email-submit">
                        {{-- @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}

                        <form action="{{ route('user.subscribe') }}" method="POST">
                            @csrf
                            <input type="email" placeholder="Get product updates" name="email" id="email" required>
                            <button type="submit"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                        </form>
                    </div>
                    <div class="links-email-number">
                        <ul>
                            <li><a href="tel:{{ $settings[0]->phone ?? '-' }}">{{ $settings[0]->phone ?? '-' }}</a>
                            </li>
                            <li><a
                                    href="mailto:{{ $settings[0]->email ?? '-' }}">{{ $settings[0]->email ?? '-' }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row footer-btm-line">
                <div class="col-lg-4 col-md-4">
                    {{-- <div class="socail-icons">
                        <ul>
                            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        </ul>
                    </div> --}}
                </div>
                {{-- <div class="col-lg-4 col-md-4">
                    <div class="copy-right">
                        <p>Copyright 2024</p>
                    </div>
                </div> --}}
                <div class="col-lg-12 col-md-12">
                    <div class="site-copy-right text-center">
                        <p>Copyright 2024 | All rights reserved by <a href="{{ route('home') }}">NAVY DAVE GOLF</a> </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Video Presentation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="video-box">
                        <video poster="assets/images/video-poster.png" controls="">
                            <source src="assets/images/main-video.mp4" type="video/mp4">
                            <source src="assets/images/main-video.mp4" type="video/ogg">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <script src="{{ asset('./assets/js/wow-animate.js') }}"></script>
    <script src="{{ asset('./assets/js/lib.js') }}"></script>
    <script src="{{ asset('./assets/js/custom.js') }}"></script>
    <!-- Update jQuery to a newer version -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Slick Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
        $(document).on('ready', function() {

            wow = new WOW({
                animateClass: 'animated',
                offset: 100,
                callback: function(box) {
                    console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
                }
            });

            wow.init();


        });
        $(document).ready(function() {
            $('.testi-slider').slick({

                autoplay: true,


            });
        });
    </script>


</body>

</html>
