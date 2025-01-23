@extends('guest.layouts.main')
<style>
    header .header-nav ul li a.home-active::after {
        opacity: 100%;

    }

    .home-sec-02.home-sec-07 .pricing-box.hot .pricing-box-content .pricing_container {
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
                        <h1>Your <span>Swing</span>, Our<br> Mission </h1>
                        <p>Customized Golf Instruction To Improve Your Swing & Better Your Game</p>
                        <a href="{{ route('appointment') }}" class="t-btn">Book Appointment</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-img">
            <img src="assets/images/image.png" alt="">
        </div>
    </section>

    <section class="home-sec-01">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="text">
                        <h3>Unleash Naval Precision</h3>
                        <h2>Let’s Find Your <span>Swing</span></h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="text">
                        <p>NavyDaveGolf is here to help guide you to your best golf. There is no ONE perfect swing, but
                            there is a perfect swing for you!</p>
                        <p>Navy Dave uses his unique approach to help you find the best version of you.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="swing-box">
                        <img src="assets/images/home-sec-01-img-01.png" alt="">
                        <h6>Mental Game<br> Mastery</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="swing-box">
                        <img src="assets/images/home-sec-01-img-02.png" alt="">
                        <h6>On-Course<br> Strategy Sessions</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="swing-box">
                        <img src="assets/images/home-sec-01-img-03.png" alt="">
                        <h6>Personalized<br> Swing Analysis</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="swing-box">
                        <img src="assets/images/home-sec-01-img-04.png" alt="">
                        <h6>Customized<br> Training Programs</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-sec-02">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12">
                    <div class="main-img">
                        <img src="assets/images/home-sec-02-img.png" alt="">
                    </div>
                </div>
                <div class="col-lg-7 col-md-12">
                    <div class="text">
                        <h3>Navy Dave Golf</h3>
                        <h2>Meet <span> Navy Dave</span></h2>
                        <p>Navy Dave, with 30 years of golf experience, believes in cultivating your unique 'perfect swing'.
                            In his state-of-the-art studio, he offers personalized instruction emphasizing your individual
                            style and strengths to ensure you play your best golf.</p>
                        <div class="two-thing-aline">
                            <div class="btn-box">
                                <a href="{{ route('about') }}" class="t-btn">Learn More</a>
                            </div>
                            <div class="video-btn-box">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal">
                                    <img src="assets/images/video-icon.png" alt=""> Video Presentation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="home-sec-03">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text text-center">
                        <h3>Precision In Every Stroke</h3>
                        {{-- <h2>Welcome To Navy <span>Dave's Swing</span> Academy</h2> --}}
                        <h2>Welcome to Navy <span>Dave Golf</span> </h2>
                        <img src="assets/images/ImageCover.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="home-sec-02 home-sec-04">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12">
                    <div class="text">
                        <h3>Training Scheduled</h3>
                        <h2>Tailored <span> Approach</span></h2>
                        <p>Your goals, are OUR goals! Not everyone is trying to win the Masters. You may not even be worried
                            about winning your club title. If you’re here, you do want to play better! NavyDaveGolf is here
                            to help you to your specific goal!</p>
                        <div class="two-thing-aline">
                            <div class="btn-box">
                                <a href="{{ route('appointment') }}" class="t-btn">Book a lesson</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="main-img">
                        <img src="assets/images/Side Image.png" alt="">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="home-sec-02 home-sec-04 home-sec-05">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12">
                    <div class="main-img">
                        <img src="assets/images/Side Image (1).png" alt="">
                    </div>
                </div>
                <div class="col-lg-7 col-md-12">
                    <div class="text">
                        <h3>Navy Dave Golf</h3>
                        <h2>What Makes Me <span> Different</span></h2>
                        <p> We don’t believe in a
                            singular approach. While in the Navy, I earned the qualification of Master Training Specialist.
                            It’s a fancy way to say I know 537 different ways to make a lightbulb turn on. Together, we will
                            work with your strengths to make your bulb the brightest!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-sec-06">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text text-center">
                        <h3>Navy Dave Golf</h3>
                        <h2>What Clients Are <span> Saying </span></h2>
                    </div>
                </div>
            </div>
            <div class="row testi-slider">
                <div class="col-lg-4 col-md-6">
                    <div class="testi-img-box">
                        <div class="person-heading">
                            <img src="assets/images/r2.png" alt="">
                            <h5>Jenny K Burchette</h5>
                            <h6>Local Guide</h6>
                            <img src="assets/images/testi-inverted-comas.png" alt="">
                        </div>
                        <div class="person-comment">
                            <a href="https://www.google.com/search?q=navy+dave+golf&sca_esv=28f8fab5923385a6&sxsrf=ADLYWIIqPQyG4ZyAHjuSXE3pBHESZnC9KA%3A1729025787789&ei=-9YOZ_zzL-OYkdUPkNebYA&ved=0ahUKEwi83Y3_opGJAxVjTKQEHZDrBgwQ4dUDCA8&uact=5&oq=navy+dave+golf&gs_lp=Egxnd3Mtd2l6LXNlcnAiDm5hdnkgZGF2ZSBnb2xmSAdQAFgAcAB4AJABAJgBAKABAKoBALgBA8gBAJgCAKACAJgDAJIHAKAHAA&sclient=gws-wiz-serp#lrd=0x872bad1f47089b73:0x20767639374507b1,1,,,,"
                                target="_blank" class="text-dark">
                                <p>{{ \Illuminate\Support\Str::limit(
                                    "There is no one better than Navy Dave! I needed trustworthy help purchasing new clubs for my
                                                                                                                                                                                                                                                                                                                                                                                husband. I was in over my head and asked a friend where to begin; his immediate answer was
                                                                                                                                                                                                                                                                                                                                                                                Navy Dave. I reached out and Dave was easy to contact, and beyond helpful! He is patient,
                                                                                                                                                                                                                                                                                                                                                                                funny, and an excellent educator! He walked me through the process of buying clubs that my
                                                                                                                                                                                                                                                                                                                                                                                husband would be proud to own, while sticking to my tight budget. That gift reveal was the
                                                                                                                                                                                                                                                                                                                                                                                greatest surprise for my husband and I couldn’t have done it without Navy Dave! He also gave
                                                                                                                                                                                                                                                                                                                                                                                my husband a brief golf lesson while we were in his incredible indoor golf studio. Within a
                                                                                                                                                                                                                                                                                                                                                                                few moments of watching my hubby’s swing, he gave him a suggestion to slightly tweak his
                                                                                                                                                                                                                                                                                                                                                                                form and it totally transformed his golf swing!! What?! We were amazed! Needless to say we
                                                                                                                                                                                                                                                                                                                                                                                will be back. Navy Dave is an extremely knowledgeable golf instructor, but even better than
                                                                                                                                                                                                                                                                                                                                                                                that, he is a wonderful person. I give him my highest recommendation!",
                                    269,
                                ) }}
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testi-img-box">
                        <div class="person-heading">
                            <img src="assets/images/r1.png" alt="">
                            <h5>T&B Berens</h5>
                            <img src="assets/images/testi-inverted-comas.png" alt="">
                        </div>
                        <div class="person-comment">
                            <a href="https://www.google.com/search?q=navy+dave+golf&sca_esv=28f8fab5923385a6&sxsrf=ADLYWIIqPQyG4ZyAHjuSXE3pBHESZnC9KA%3A1729025787789&ei=-9YOZ_zzL-OYkdUPkNebYA&ved=0ahUKEwi83Y3_opGJAxVjTKQEHZDrBgwQ4dUDCA8&uact=5&oq=navy+dave+golf&gs_lp=Egxnd3Mtd2l6LXNlcnAiDm5hdnkgZGF2ZSBnb2xmSAdQAFgAcAB4AJABAJgBAKABAKoBALgBA8gBAJgCAKACAJgDAJIHAKAHAA&sclient=gws-wiz-serp#lrd=0x872bad1f47089b73:0x20767639374507b1,1,,,,"
                                target="_blank" class="text-dark">
                                <p>{{ \Illuminate\Support\Str::limit(
                                    "Navy Dave looked at my swing and ability and gave me instruction in a simple and positive
                                                                                                                                                                                                                                                                                                                                                                                approach. His video reminders after my 2 hr lesson helped me immensely to review what I
                                                                                                                                                                                                                                                                                                                                                                                learned. He has a very unique style of teaching and gave me enthusiasm to improve my game.",
                                    269,
                                ) }}
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testi-img-box">
                        <div class="person-heading">
                            <img src="assets/images/r3.png" alt="">
                            <h5>Keith Davis</h5>
                            <h6>Local Guide</h6>
                            <img src="assets/images/testi-inverted-comas.png" alt="">
                        </div>
                        <div class="person-comment">
                            <a href="https://www.google.com/search?q=navy+dave+golf&sca_esv=28f8fab5923385a6&sxsrf=ADLYWIIqPQyG4ZyAHjuSXE3pBHESZnC9KA%3A1729025787789&ei=-9YOZ_zzL-OYkdUPkNebYA&ved=0ahUKEwi83Y3_opGJAxVjTKQEHZDrBgwQ4dUDCA8&uact=5&oq=navy+dave+golf&gs_lp=Egxnd3Mtd2l6LXNlcnAiDm5hdnkgZGF2ZSBnb2xmSAdQAFgAcAB4AJABAJgBAKABAKoBALgBA8gBAJgCAKACAJgDAJIHAKAHAA&sclient=gws-wiz-serp#lrd=0x872bad1f47089b73:0x20767639374507b1,1,,,,"
                                target="_blank" class="text-dark">
                                <p>{{ \Illuminate\Support\Str::limit(
                                    "What a terrific golf coach!! Lessons with Dave are full of laughs and he really focuses on
                                                                                                                                                                                                                                                                                                                                                    keeping it simple. As a result the time together flies by, it is a relaxed learning
                                                                                                                                                                                                                                                                                                                                                    environment, and I'm seeing immediate results. Dave isn't trying to fit me into a
                                                                                                                                                                                                                                                                                                                                                    one-size-fits-all 'PGA Tour' swing, but instead is helping me to make the best of my senior
                                                                                                                                                                                                                                                                                                                                                    swing! I have to add how nice is it to have a long lesson in his state-of-the-art indoor,
                                                                                                                                                                                                                                                                                                                                                    AIR CONDITIONED teaching studio!",
                                    269,
                                ) }}
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testi-img-box">
                        <div class="person-heading">
                            <img src="assets/images/r4.png" alt="">
                            <h5>Tye Van Haren</h5>
                            <img src="assets/images/testi-inverted-comas.png" alt="">
                        </div>
                        <div class="person-comment">
                            <a href="https://www.google.com/search?q=navy+dave+golf&sca_esv=28f8fab5923385a6&sxsrf=ADLYWIIqPQyG4ZyAHjuSXE3pBHESZnC9KA%3A1729025787789&ei=-9YOZ_zzL-OYkdUPkNebYA&ved=0ahUKEwi83Y3_opGJAxVjTKQEHZDrBgwQ4dUDCA8&uact=5&oq=navy+dave+golf&gs_lp=Egxnd3Mtd2l6LXNlcnAiDm5hdnkgZGF2ZSBnb2xmSAdQAFgAcAB4AJABAJgBAKABAKoBALgBA8gBAJgCAKACAJgDAJIHAKAHAA&sclient=gws-wiz-serp#lrd=0x872bad1f47089b73:0x20767639374507b1,1,,,,"
                                target="_blank" class="text-dark">
                                <p>{{ \Illuminate\Support\Str::limit(
                                    "Dave has a unique way of connecting with you and taking your swing and improving it, not
                                                                                                                                                                                                                                                                                                                                trying to make it someone else’s swing. He is able to show you why and how to make
                                                                                                                                                                                                                                                                                                                                modifications that are comfortable to get desired results. He has a relaxing and inviting
                                                                                                                                                                                                                                                                                                                                atmosphere and clearly loves what he does and is knowledgeable in his approach and teaching.
                                                                                                                                                                                                                                                                                                                                Highly recommend Navy Dave!!",
                                    269,
                                ) }}
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="home-sec-02 home-sec-07">
        <div class="container">
            <div class="row ">
                <div class="col-lg-5 col-md-12">
                    @foreach ($services->take(1) as $s)
                        <div class="pricing-box hot" style="margin-left: 0">
                            <div class="pricing-box-content">
                                <h4>{{ $s->name }}</h4>
                                <div class="pricing_container">
                                    <h5>${{ $s->price }}</h5>
                                    @if ($s->discount > 0)
                                        <p><del>${{ $s->original_price }}</del></p>
                                    @endif
                                </div>
                                <p>{{ \Illuminate\Support\Str::limit($s->description, 71) }}</p>
                                @if ($s->discount > 0)
                                    <div class="hot-box">
                                        <img class="star" src="{{ asset('assets/images/hot-star.png') }}"
                                            alt="">
                                        <p>{{ $s->discount }}% OFF</p>
                                    </div>
                                @endif
                            </div>
                            <div class="sessions-box">
                                <p><img src="{{ asset('assets/images/timer.png') }}" alt=""
                                        style="filter: invert(48%) sepia(48%) saturate(1225%) hue-rotate(83deg) brightness(92%) contrast(93%);">
                                    {{ $s->duration }} {{ $s->type_duration }}</p>
                                <p>{{ $s->slots }} @if ($s->slots > 1)
                                        Sessions
                                    @else
                                        Session
                                    @endif
                                </p>
                                @guest
                                <a href="{{ route('login') }}" class="t-btn">Book Now</a>
                                @endguest
                                @auth
                                <a href="{{ route('user.packages') }}" class="t-btn">Book Now</a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-7 col-md-12">
                    <div class="text">
                        <h3>Exclusive Offers</h3>
                        <h2>Get Your <span> Package </span> Now </h2>
                        <p>All lesson packages include a “before and after” video, showing you your progress from where you
                            started to where you are now.</p>
                        <div class="two-thing-aline">
                            <div class="btn-box">
                                <a href="{{ route('pricing') }}" class="t-btn new">View All Packages <img
                                        src="assets/images/right-arrow.png" alt=""> </a>
                            </div>
                        </div>
                    </div>
                    @foreach ($services->take(2)->skip(1) as $s)
                        <div class="pricing-box hot">
                            <div class="pricing-box-content ">
                                <h4>{{ $s->name }}</h4>
                                <div class="pricing_container">
                                    <h5>${{ $s->price }}</h5>
                                    @if ($s->discount > 0)
                                        <p><del>${{ $s->original_price }}</del></p>
                                    @endif
                                </div>
                                {{-- <p>{{ $s->description }}</p> --}}
                                <p>{{ \Illuminate\Support\Str::limit($s->description, 71) }}</p>
                                @if ($s->discount > 0)
                                    <div class="hot-box">
                                        <img class="star" src="{{ asset('assets/images/hot-star.png') }}"
                                            alt="">
                                        <p>{{ $s->discount }}% OFF</p>
                                    </div>
                                @endif
                            </div>
                            <div class="sessions-box">
                                <p><img src="{{ asset('assets/images/timer.png') }}" alt=""
                                        style="filter: invert(48%) sepia(48%) saturate(1225%) hue-rotate(83deg) brightness(92%) contrast(93%);">
                                    {{ $s->duration }} {{ $s->type_duration }}</p>
                                <p>{{ $s->slots }} @if ($s->slots > 1)
                                        Sessions
                                    @else
                                        Session
                                    @endif
                                </p>
                                @guest
                                <a href="{{ route('login') }}" class="t-btn">Book Now</a>
                                @endguest
                                @auth
                                <a href="{{ route('user.packages') }}" class="t-btn">Book Now</a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </section>
@endsection
