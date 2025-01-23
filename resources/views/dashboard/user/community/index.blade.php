@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.community-active, .main-box-navy .left-all-links ul li a:hover {
  background-color: white;
  font-weight: 600;
}

.main-box-navy .left-all-links ul li a.community-active span,.main-box-navy .left-all-links ul li a:hover span {
  background-color: #2CC374;
}

.main-box-navy .left-all-links ul li a.community-active span img,.main-box-navy .left-all-links ul li a:hover span img {
  filter: invert(0) hue-rotate(465deg) brightness(10.5);
}
</style>
@section('content')
<div class="col-lg-10">
    <div class="main-calendar-box main-calendar-box-list customers-box">
        <h5> Community Feeds</h5>
        <div class="shadow-box">
            <div class="three-link-align">
                <div class="box">
                   <a href="#"> <img src="{{ asset('assets/images/write-a-post.png') }}" alt=""></a>
                </div>
                <div class="box">
                   <a href="#"> <img src="{{ asset('assets/images/upload-photo.png') }}" alt=""></a>
                </div>
                <div class="box">
                   <a href="#"> <img src="{{ asset('assets/images/upload-video.png') }}" alt=""></a>
                </div>
            </div>
            <div class="large-input-box">
                <input type="text" placeholder="Write something here...">
                <img class="flow-img" src="assets/images/input-box-edit.png" alt="">
            </div>
        </div>

        <div class="shadow-box">
            <div class="person-box">
                <img src="assets/images/tony-stark-img.png" alt="">
                <div class="text">
                    <div class="two-text-align">
                        <h6>Tony Stark</h6>
                        <a href="#">@tony_stark_3000</a>
                    </div>
                    <p>Looking for an amazing scientist who knows how to build a suit
                        that can fly high in the sky without any problem.</p>
                </div>
            </div>
            <div class="input-box-three-icons">
                <div class="large-input-box large-input-box-small ">
                    <input type="text" placeholder="Write something here...">
                    <img class="flow-img" src="{{ asset('assets/images/input-box-edit.png') }}" alt="">
                </div>
                <div class="three-things-align">
                    <ul>
                        <li><a href="#"><img src="{{ asset('assets/images/thums.png') }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ asset('assets/images/message.png') }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ asset('assets/images/back.png')}}" alt=""></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="shadow-box">
            <div class="person-box">
                <img src="assets/images/tony-stark-img.png" alt="">
                <div class="text">
                    <div class="two-text-align">
                        <h6>Tony Stark</h6>
                        <a href="#">@tony_stark_3000</a>
                    </div>
                    <p>Looking for an amazing scientist who knows how to build a suit
                        that can fly high in the sky without any problem.</p>
                </div>
            </div>
            <div class="three-images-align">
                <a href="{{ asset('assets/images/gallery-img-01.png') }}" data-fancybox="images" tabindex="0"><img src="{{ asset('assets/images/gallery-img-01.png') }}" alt=""></a>
                <a href="{{ asset('assets/images/gallery-img-02.png') }}" data-fancybox="images" tabindex="0"><img src="{{ asset('assets/images/gallery-img-02.png') }}" alt=""></a>
                <a href="{{ asset('assets/images/gallery-img-03.png') }}" data-fancybox="images" tabindex="0"><img src="{{ asset('assets/images/gallery-img-03.png') }}" alt=""></a>
            </div>
            <div class="input-box-three-icons">
                <div class="large-input-box large-input-box-small ">
                    <input type="text" placeholder="Write something here...">
                    <img class="flow-img" src="{{ asset('assets/images/input-box-edit.png') }}" alt="">
                </div>
                <div class="three-things-align">
                    <ul>
                        <li><a href="#"><img src="{{ asset('assets/images/thums.png') }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ asset('assets/images/message.png') }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ asset('assets/images/back.png') }}" alt=""></a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
