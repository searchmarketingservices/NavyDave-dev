@extends('guest.layouts.main')
@section('content')

<section class="payment-sec-new paymnet-success">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="display-aligns">
                    <div class="img-box">
                        <img src="{{ asset('./assets/images/payment-error.png') }}" alt="">
                    </div>
                    <div class="text">
                        <h2> An Error Occurred! </h2>
                        <p>Your payment received and your appointment booked successfully  </p>
                        <a href="{{ route('appointment') }}" class="t-btn">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


@endsection
