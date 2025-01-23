@extends('guest.layouts.main')
<style>
    header .header-nav ul li a.contact-active::after {
        opacity: 100%;
    }
</style>
@section('content')
    <section class="contact-us-sec-01">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text text-center">
                        <h2>Get In <span>Touch</span> </h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center ">
                <div class="col-lg-4 col-md-4">
                    <div class="text-box">
                        <img src="assets/images/timer.png" alt="">
                        <ul>
                            <li>Monday : 09 : 00 AM - 08 : 00 PM </li>
                            <li>Tuesday : 09 : 00 AM - 08 : 00 PM </li>
                            <li>Wednesday : CLOSED</li>
                            <li>Thursday : 09 : 00 AM - 08 : 00 PM </li>
                            <li>Friday : 09 : 00 AM - 08 : 00 PM </li>
                            <li>Saturday : 09 : 00 AM - 08 : 00 PM </li>
                            <li>Sunday : 09 : 00 AM - 08 : 00 PM </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="text-box">
                        <img src="assets/images/map.png" alt="">
                        <ul>
                            <li><a href="#">{{ $settings[0]->location }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="text-box">
                        <img src="assets/images/phone-img.png" alt="">
                        <ul>
                            <li>Telephone : <a href="tel:{{ $settings[0]->phone }}">{{ $settings[0]->phone }}</a></li>
                            <li>Email : <a href="mailto:{{ $settings[0]->email }}">{{ $settings[0]->email }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="contact-us-sec-02">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="text">
                        <h3>Contact Us</h3>
                        <h2>Have <span>Questions?</span> <br> Get in Touch!</h2>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <input type="text" name="fullname" placeholder="Full Name *" value="{{ old('fullname') }}">
                            @if ($errors->has('fullname'))
                                <small class="text-danger">{{ $errors->first('fullname') }}</small>
                            @endif

                            <input type="email" name="email" placeholder="Email Address *" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <small class="text-danger">{{ $errors->first('email') }}</small>
                            @endif

                            <input type="text" name="subject" placeholder="Subject *" value="{{ old('subject') }}">
                            @if ($errors->has('subject'))
                                <small class="text-danger">{{ $errors->first('subject') }}</small>
                            @endif

                            <textarea name="message" placeholder="Message *">{{ old('message') }}</textarea>
                            @if ($errors->has('message'))
                                <small class="text-danger">{{ $errors->first('message') }}</small>
                            @endif

                            <button type="submit">Submit</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="iframe-map-box">
                        <iframe
                            {{-- src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1685.782160306272!2d-0.4842474926859999!3d53.30644344780103!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48785ea1c9fe7731%3A0xf84ab5086f7db55c!2sWelton%2C%20Lincoln%2C%20UK!5e0!3m2!1sen!2s!4v1724452231619!5m2!1sen!2s" --}}
                            src="https://maps.google.com/maps?t=m&output=embed&iwloc=near&z=12&q=3728+E+Welton+Ln+%2CGilbert%2C+AZ%2C+85295"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
