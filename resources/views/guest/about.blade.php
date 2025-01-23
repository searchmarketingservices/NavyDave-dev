@extends('guest.layouts.main')
<style>
    header .header-nav ul li a.about-active::after{
        opacity: 100%;

    }
</style>
@section('content')
<section class="hero-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text">
                    <h1>About Navy<br> Dave <span>Golf</span> </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-img">
        <img src="assets/images/hero-about-img.png" alt="">
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
                    <p>Navy Dave, with 30 years of golf experience, believes in cultivating your unique 'perfect swing'. In his state-of-the-art studio, he offers personalized instruction emphasizing your individual style and strengths to ensure you play your best golf.</p>
                    <div class="two-thing-aline">
                       {{-- <div class="video-btn-box">
                        <a href="#">
                            <img src="assets/images/video-icon.png" alt="">
                            Video Presentation
                        </a>
                       </div> --}}
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

<section class="home-sec-01">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="swing-box">
                    <img src="assets/images/about-us-img-01.png" alt="">
                    <h6>Fields</h6>
                    <p>10 Picturesque and well<br> equipped courses.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="swing-box">
                    <img src="assets/images/about-us-img-02.png" alt="">
                    <h6>Awards</h6>
                    <p>300+ Tournaments and event<br> days each year.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="swing-box">
                    <img src="assets/images/about-us-img-03.png" alt="">
                    <h6>Active Members</h6>
                    <p>1000+ active members and<br> club ambassadors.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="swing-box">
                    <img src="assets/images/about-us-img-04.png" alt="">
                    <h6>Professional<br> Trainers</h6>
                    <p>10 professional instructors for<br> all levels.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-us-sec-01">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-4">
                <div class="text">
                    <h2>Golf  <span>Highlights</span> </h2>
                    <p>Here are a few of my most memorable moments in golf:</p>
                    <ul>
                        <li>Hit a ball on every continent except Antarctica</li>
                        <li>Hit a ball from the Northern Hemisphere to the Southern Hemisphere (over the equator)</li>
                        <li>Hit a ball from today to tomorrow and visa versa (International Date Line)</li>
                        <li>Shot even par in competition (amateur)</li>
                        <li>Was part of two winning Rainier Cup teams (set up a little like the Ryder cup, but between services)</li>
                        <li>Eagled a golf hole from at least 80 yards or more out 15+ times</li>
                        <li>Has two hole in ones (141 yds, 194 yds)</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="main-img">
                    <img src="assets/images/about-golf-img.png" alt="">
                </div>
            </div>
        </div>
        <div class="row align-items-center about-new-row">
            <div class="col-lg-5 col-md-5">
                <div class="main-parent-img">
                    <img src="assets/images/main-stroy-img.png" alt="">
                </div>
            </div>
            <div class="col-lg-7 col-md-7">
                <div class="text">
                    <h2>Navy <span>Dave's</span> Story</h2>
                    <p>For 20 years, I proudly served the US Navy. I boarded non compliant illegal Iraqi oil smugglers from 1996-2001 and did 2 tours boots on the ground in Iraq out of Al Asad. I ended up completing 10 total deployments.</p>
                    <p>In my time, I suffered injuries. Some seen, others not seen. I retired in 2014 and tried to go to work. I was a first assistant manager in the Safeway non commissioned officer to first assistant manager program. When Albertsons bought out Safeway, the program went away. I found a job as a manager for Starbucks. I started losing my mental acuity with writing schedules. My next issue started when I could tell you how to make the drink, but couldn’t physically do it. The final “act” was when I thought I was having a heart attack. In the ER, I was told I had an anxiety attack, something I’d never even heard of. Soon after I was diagnosed with PTSD. </p>
                    <p>Since 2017, I’ve been struggling with depression, anxiety, self worth and not being able to work. In going through counseling, I was asked what I liked to do outside. I said golf. He said “then you should golf!” A doctor actually prescribed me golf! Since I couldn’t seem to hold down a “normal” 9-5, I volunteered as a state director and assistant Regional Director for the Veteran Golfers Association. Those positions gave me purpose and allowed me to help others. </p>
                    <p>In that same way, a few things that I’m proud of are leading others by example and finding ways to help others. Every individual is unique and gifted in a very specific way. We don’t all learn the same. I earned my Master Training Specialist certification by finding ways to reach everyone. During my down time in Iraq, I helped teach an ASVAB prep course to Soldiers and Marines to raise their scores high enough to apply for warrant officer programs. The students named me their favorite and most valued instructor. I truly enjoyed being a part of their success!</p>
                    <p>I’d been acting as a volunteer marshal at a golf course one day a week for the past year. In that time, I’ve helped people with their golf swings. Not with an entirely new swing or a “PGA tour” swing but with adjusting their own swing to help it work better for them.  I’ve worked with old and young, men and women, good and “weekend warrior”. I’ve helped them all get better!</p>
                    <p>I’ve also caddied for a few professional golfers on the mini tours in Arizona and Utah. I was proud to be a part of 5 top 10 finishes including 2 seconds!</p>
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
                    <h2>Reviews</h2>
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
                        <a href="https://www.google.com/search?q=navy+dave+golf&sca_esv=28f8fab5923385a6&sxsrf=ADLYWIIqPQyG4ZyAHjuSXE3pBHESZnC9KA%3A1729025787789&ei=-9YOZ_zzL-OYkdUPkNebYA&ved=0ahUKEwi83Y3_opGJAxVjTKQEHZDrBgwQ4dUDCA8&uact=5&oq=navy+dave+golf&gs_lp=Egxnd3Mtd2l6LXNlcnAiDm5hdnkgZGF2ZSBnb2xmSAdQAFgAcAB4AJABAJgBAKABAKoBALgBA8gBAJgCAKACAJgDAJIHAKAHAA&sclient=gws-wiz-serp#lrd=0x872bad1f47089b73:0x20767639374507b1,1,,,," target="_blank"
                            class="text-dark">
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
                        <a href="https://www.google.com/search?q=navy+dave+golf&sca_esv=28f8fab5923385a6&sxsrf=ADLYWIIqPQyG4ZyAHjuSXE3pBHESZnC9KA%3A1729025787789&ei=-9YOZ_zzL-OYkdUPkNebYA&ved=0ahUKEwi83Y3_opGJAxVjTKQEHZDrBgwQ4dUDCA8&uact=5&oq=navy+dave+golf&gs_lp=Egxnd3Mtd2l6LXNlcnAiDm5hdnkgZGF2ZSBnb2xmSAdQAFgAcAB4AJABAJgBAKABAKoBALgBA8gBAJgCAKACAJgDAJIHAKAHAA&sclient=gws-wiz-serp#lrd=0x872bad1f47089b73:0x20767639374507b1,1,,,," target="_blank"
                            class="text-dark">
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
                        <a href="https://www.google.com/search?q=navy+dave+golf&sca_esv=28f8fab5923385a6&sxsrf=ADLYWIIqPQyG4ZyAHjuSXE3pBHESZnC9KA%3A1729025787789&ei=-9YOZ_zzL-OYkdUPkNebYA&ved=0ahUKEwi83Y3_opGJAxVjTKQEHZDrBgwQ4dUDCA8&uact=5&oq=navy+dave+golf&gs_lp=Egxnd3Mtd2l6LXNlcnAiDm5hdnkgZGF2ZSBnb2xmSAdQAFgAcAB4AJABAJgBAKABAKoBALgBA8gBAJgCAKACAJgDAJIHAKAHAA&sclient=gws-wiz-serp#lrd=0x872bad1f47089b73:0x20767639374507b1,1,,,," target="_blank"
                            class="text-dark">
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
                        <a href="https://www.google.com/search?q=navy+dave+golf&sca_esv=28f8fab5923385a6&sxsrf=ADLYWIIqPQyG4ZyAHjuSXE3pBHESZnC9KA%3A1729025787789&ei=-9YOZ_zzL-OYkdUPkNebYA&ved=0ahUKEwi83Y3_opGJAxVjTKQEHZDrBgwQ4dUDCA8&uact=5&oq=navy+dave+golf&gs_lp=Egxnd3Mtd2l6LXNlcnAiDm5hdnkgZGF2ZSBnb2xmSAdQAFgAcAB4AJABAJgBAKABAKoBALgBA8gBAJgCAKACAJgDAJIHAKAHAA&sclient=gws-wiz-serp#lrd=0x872bad1f47089b73:0x20767639374507b1,1,,,," target="_blank"
                            class="text-dark">
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


<section class="about-us-sec-02">
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <div class="text text-center">
                    <h2>What <span>Makes Me</span> Different</h2>
                    <p>There is no perfect swing. My experience in this game has taught me that. We don’t believe in a singular approach. While in the Navy, I earned the qualification of Master Training Specialist. It’s a fancy way to say I know 537 different ways to make a lightbulb turn on. Together, we will work with your strengths to make your bulb the brightest!</p>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection