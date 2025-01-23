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
                        <h2> Next Slot Booked<br> Successfuly </h2>
                        <p>Your next slot has been successfully booked.</p>
                        <a href="{{ route('appointment') }}" class="t-btn">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


@endsection
