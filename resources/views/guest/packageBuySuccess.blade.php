@extends('guest.layouts.main')
@section('content')

<section class="payment-sec-new paymnet-success">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="display-aligns">
                    <div class="img-box">
                        <img src="{{ asset('./assets/images/payment-suc.png') }}" alt="">
                    </div>
                    <div class="text">
                        <h2> Package Bought<br> Successfully </h2>
                        <p>Now Book your Appointment</p>
                        <a href="{{ route('user.dashboard') }}" class="t-btn">View Dashboard</a>
                        <a href="{{ route('appointment') }}#main-steps-form" class="t-btn">Book Your Appointment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


@endsection
