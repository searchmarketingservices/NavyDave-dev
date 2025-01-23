@extends('guest.layouts.main')
<style>
    header .header-nav ul li a.pricing-active::after {
        opacity: 100%;
    }

    .hot .hot-box {
        position: relative;
        position: absolute;
        top: -70px;
        right: -30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hot {
        z-index: 999;
        box-shadow: 0px 0px 20px 0px #00000038;
        position: relative;
        /* margin-left: -340px; */
        margin-top: 130px;
    }

    .hot .hot-box p {
        position: absolute;
        color: #2cc374 !important;
        font-size: 18px;
    }

    .pricing_container {
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>
@section('content')
    <section class="hero-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text">
                        <h1>Golf <span>Lesson</span><br> Packages </h1>
                        <p>All Package bought can be shared with the immediate family. </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-img">
            <img src="assets/images/pricing-main-img.png" alt="">
        </div>
    </section>

    <section class="pricings-sec-01">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="pricing-box-main">
                        @foreach ($services as $s)
                            <div class="pricing-box hot">
                                <h6>{{ $s->name }}</h6>
                                <div class="pricing_container">
                                    <h5>${{ $s->price }}</h5>
                                    @if ($s->discount > 0)
                                        <p><del>${{ $s->original_price }}</del></p>
                                    @endif
                                </div>
                                <p>{{ $s->description }}</p>
                                <p>{{ $s->duration }} {{ $s->type_duration }}</p>
                                <p>{{ $s->slots }} @if ($s->slots > 1)
                                        Sessions
                                    @else
                                        Session
                                    @endif
                                </p>
                                @guest
                                <a href="{{ route('login') }}">Buy Now</a>
                                @endguest
                                @auth
                                <a href="{{ route('user.packages') }}">Buy Now</a>
                                @endauth

                                @if ($s->discount > 0)
                                    <div class="hot-box">
                                        <img class="star" src="{{ asset('assets/images/hot-star.png') }}" alt="">
                                        <p>{{ $s->discount }}% OFF</p>
                                    </div>
                                @endif



                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>


    <section class="pricings-sec-02">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text">
                        <p>Where to start about Navy Dave! Since day one meeting Dave, he has made playing the game of golf
                            fun and less stressful. Dave not only has helped me with my game by making minor changes, but
                            has helped my fiancée with golf lessons. He makes minor changes to help you feel more natural
                            playing while actually making the changes to make you a more natural golfer! Navy Dave is a golf
                            coach who makes you feel comfortable while changing your game and bringing it to new heights! I
                            couldn’t think of a better person to hire as a golf coach and instructor!</p>
                        <h2>Maxx Williams</h2>
                        <p>Navy Dave is great to work with. He takes a few looks at your swing and makes little adjustments
                            to make you improve every time you work with him. When I first met Dave, I was shooting in the
                            mid 90’s. Fast forward to today, and I’m shooting in the mid to low 80’s consistently, and even
                            had a few rounds in the 70’s. I have gotten to the point where if I have a bad shot, I know
                            exactly what I did wrong and I can correct it on my own. Because of Navy Dave, I have a new
                            appreciation towards golf and enjoy every minute out on that golf course. If you are a beginning
                            golfer or just someone who is looking shave a few strokes of your golf game, I strongly suggest
                            working with Navy Dave. He is a lot of fun to work with, has great knowledge of the game, and
                            will improve your golf game. Navy Dave is a great coach, but an even better friend.</p>
                        <h2>Zac Epping</h2>
                        <p>Dave Delano’s insight into what I was doing with my golf swing and my golf game, and then his
                            adjustments, small ones, have me enjoying the game of golf more and more. I truly believe anyone
                            who commits to what Dave sees that could help their golf game will be enjoying and playing their
                            best golf ever. I’m 66 years old and I thought because of aging, my game was on the way down. I
                            was wrong, Dave Delano has me playing my best golf of my life. Thank you Dave Delano.</p>
                        {{-- <h2>Paul Thomforde</h2>
                        <p>Happy to help</p> --}}
                    </div>
                </div>
            </div>
        </div>

    </section>

    {{-- <section class="pricings-sec-03">
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
                                <video poster="assets/images/Thumbnail 1.png" controls>
                                    <source src="assets/images/IMG_1716.MOV" type="video/mp4">
                                    <source src="assets/images/IMG_1716.MOV" type="video/ogg">
                                </video>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <video poster="assets/images/Thumbnail 2.png" controls>
                                    <source src="assets/images/Brookelle.MOV" type="video/mp4">
                                    <source src="assets/images/Brookelle.MOV" type="video/ogg">
                                </video>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <video poster="assets/images/Thumbnail 3.png" controls>
                                    <source src="assets/images/Copy of IMG_4541.mp4" type="video/mp4">
                                    <source src="assets/images/Copy of IMG_4541.mp4" type="video/ogg">
                                </video>
                            </div>
                            <div class="tab-pane" id="tabs-4" role="tabpanel">
                                <video poster="assets/images/Thumbnail 4.png" controls>
                                    <source src="assets/images/Copy of IMG_0038.mp4" type="video/mp4">
                                    <source src="assets/images/Copy of IMG_0038.mp4" type="video/ogg">
                                </video>
                            </div>
                            <div class="tab-pane" id="tabs-5" role="tabpanel">
                                <video poster="assets/images/Thumbnail 5.png" controls>
                                    <source src="assets/images/Client 1 (1) (1).mp4" type="video/mp4">
                                    <source src="assets/images/Client 1 (1) (1).mp4" type="video/ogg">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section> --}}
@endsection
