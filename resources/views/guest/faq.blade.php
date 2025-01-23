@extends('guest.layouts.main')
<style>
    header .header-nav ul li a.faq-active::after {
        opacity: 100%;

    }
</style>
@section('content')
    <section class="faq-sec-01">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text text-center">
                        <h2>Frequently <span>Asked</span> <br> Questions </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="faq-sec-02">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="tabs-main">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion"
                                            href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Why Navy Dave Golf?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                    aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        There are no preconceived notions on what constitutes the perfect swing. I’m going
                                        to watch you and guide you to making your swing work better for you!
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                            href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Do you give couples or group lessons?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        Because I believe that each swing is unique to the individual, I don’t feel that group lessons would be beneficial to anyone in the group. I don’t want to make you swing MY way. I want to help YOUR swing work best for you!
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                            href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Which lesson package should I purchase?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        Just like the golf swing, there is no perfect fit, it’s whatever you feel would benefit you the most! If you live here full time, you might want the Admiral Package. Most of us find a new area of concern in our golf game every round! Once something clicks, something else decides to become difficult. Two lessons a month could be what works for you. If you are here seasonally, the Senior Officer Package could be the best.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="tabs-main">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingfour">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion"
                                            href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            Where are lessons given?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel"
                                    aria-labelledby="headingfour">
                                    <div class="panel-body">
                                        Lessons are given at my home in my climate controlled garage. The hitting bay is equipped with a top of the line simulator. There is also an iPad to catch and record your swing!
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingSeven">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            data-parent="#accordion" href="#collapseSeven" aria-expanded="false"
                                            aria-controls="collapseSeven">
                                            Do you help with putting too?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingSeven">
                                    <div class="panel-body">
                                        Absolutely! I happen to have a putting green in the back for just such an opportunity!
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingfive">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                            href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                            What do 'smash factor', 'angle of attack',<br>'launch angle' and other jargon mean?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseSix" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingfive">
                                    <div class="panel-body">
                                        DON’T WORRY ABOUT IT! One of the things that drew you to me is the avoidance of all that mess. We will go over your improvements and I will explain the numbers at the end. Our first goal is to get you swinging comfortably and not worrying about that stuff! If we focus on a number, it should be par or better!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
