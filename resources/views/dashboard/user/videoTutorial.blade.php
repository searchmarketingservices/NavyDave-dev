@extends('dashboard.layouts.master')
<link rel="stylesheet" href="{{ asset('./assets/css/style.css') }}">

<style>
    .main-box-navy .left-all-links ul li a.dashboard-active, .main-box-navy .left-all-links ul li a:hover {
  background-color: white;
  font-weight: 600;
}

.main-box-navy .left-all-links ul li a.dashboard-active span,.main-box-navy .left-all-links ul li a:hover span {
  background-color: #2CC374;
}

.main-box-navy .left-all-links ul li a.dashboard-active span img,.main-box-navy .left-all-links ul li a:hover span img {
  filter: invert(0) hue-rotate(465deg) brightness(10.5);
}
@media only screen and (max-width: 575px) {
    .main-table-box {
        margin-top: 90px !important;
    }
}
</style>
@section('content')
    <div class="col-lg-10">
        <div class="welcome-and-user-name">
            <h6>Welcome Back,</h6>
            <h5>{{ Auth::user()->name }}</h5>
        </div>
        <div class="maindashboard-box">
           
        </div>
        <div class="main-table-box">
            <section class="pricings-sec-03">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text">
                                <h2>Video <span>Tutorials</span> </h2>
                                <p>Lorem Ipsum Is Simply A Dummy Text Of The Printing.</p>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Single Lesson</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Petty Officer</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Cheif Petty Officer</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">Line Officer</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-5" role="tab">Admiral</a>
                                    </li>
                                </ul><!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                        <video poster="{{ asset('assets/images/Thumbnail 1.png') }}" controls>
                                            <source src="{{ asset('assets/images/IMG_1716.MOV') }}" type="video/mp4">
                                            <source src="{{ asset('assets/images/IMG_1716.MOV') }}" type="video/ogg">
                                        </video>
                                    </div>
                                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                                        <video poster="{{ asset('assets/images/Thumbnail 2.png') }}" controls>
                                            <source src="{{ asset('assets/images/Brookelle.MOV') }}" type="video/mp4">
                                            <source src="{{ asset('assets/images/Brookelle.MOV') }}" type="video/ogg">
                                        </video>
                                    </div>
                                    <div class="tab-pane" id="tabs-3" role="tabpanel">
                                        <video poster="{{ asset('assets/images/Thumbnail 3.png') }}" controls>
                                            <source src="{{ asset('assets/images/Copy of IMG_4541.mp4') }}" type="video/mp4">
                                            <source src="{{ asset('assets/images/Copy of IMG_4541.mp4') }}" type="video/ogg">
                                        </video>
                                    </div>
                                    <div class="tab-pane" id="tabs-4" role="tabpanel">
                                        <video poster="{{ asset('assets/images/Thumbnail 4.png') }}" controls>
                                            <source src="{{ asset('assets/images/Copy of IMG_0038.mp4') }}" type="video/mp4">
                                            <source src="{{ asset('assets/images/Copy of IMG_0038.mp4') }}" type="video/ogg">
                                        </video>
                                    </div>
                                    <div class="tab-pane" id="tabs-5" role="tabpanel">
                                        <video poster="{{ asset('assets/images/Thumbnail 5.png') }}" controls>
                                            <source src="{{ asset('assets/images/Client 1 (1) (1).mp4') }}" type="video/mp4">
                                            <source src="{{ asset('assets/images/Client 1 (1) (1).mp4') }}" type="video/ogg">
                                        </video>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
            </section>
        </div>
    </div>
    <script src="{{ asset('./assets/js/lib.js') }}"></script>
    <script src="{{ asset('./assets/js/custom.js') }}"></script>
@endsection
