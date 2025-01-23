@extends('guest.layouts.main')
<!-- Flatpickr CSS -->
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<style>
    header .header-nav ul li a.appointment-active::after {
        opacity: 100%;
    }

    .tab {
        display: none;
    }

    .when-user-logout {
        background-color: #ffffff;
        position: relative;
    }

    .when-user-logout::before {
        content: "";
        width: 100%;
        height: 100%;
        background-color: #0080006b;
        position: absolute;
        top: 0;
        filter: blur(50px);
        opacity: 50%;
        z-index: 99;
    }

    .when-user-logout::after {
        content: "Please Login First";
        font-size: 40px;
        font-weight: 600;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        text-align: center;
        color: black;
        z-index: 9999;
        -ms-transform: translateY(-50%);
        transform: translateY(70%);
        width: 100%;
        height: 50%;
    }

    .when-user-logout ul.nav.nav-tabs {
        filter: blur(5px);
    }


    .when-user-logout .tab-content {
        filter: blur(5px);
        height: 60vh;
    }

    .when-user-logout a {
        background-color: #3A3A3A;
        color: white;
        display: inline-flex;
        /* padding: 15px 30px; */
        transition: .3s;
        font-size: 30px;
        margin-top: 40px;
        transform: translateY(250%);
        position: absolute;
        z-index: 999999999;
        top: 80px;
        right: 0;
        margin: auto;
        text-align: center;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 15%;
        cursor: pointer;
        height: 75px;
    }

    #appointment-calendar {
        /* Adjust the style of the calendar container if necessary */
        margin-top: 20px;
    }

    .flatpickr-months .flatpickr-month {
        margin-bottom: 10px !important;
        height: 50px !important;
    }

    .appointment-sec-01 .two-appointment-box-align .input-date-box input {
        padding: 10px !important;
        line-height: 0 !important;
        height: 40px !important;
    }

    .flatpickr-current-month .flatpickr-monthDropdown-months {
        margin-right: 10px;
    }

    .flatpickr-current-month .numInputWrapper {
        border-radius: 10px;
        overflow: hidden;
    }

    .flatpickr-current-month {
        display: flex;
        justify-content: center;
        align-items: center;
        column-gap: 20px;
        height: 45px;
    }

    .flatpickr-current-month {
        display: flex !important;
        height: 45px !important;
    }

    .appointment-sec-01 .two-appointment-box-align .input-date-box input:hover {
        background-color: #ff000000 !important;
    }

    .flatpickr-current-month .numInputWrapper {
        width: 7ch;
    }

    .when-user-logout a:hover {
        background-color: green;
        color: white
    }

    #appointment-calendar .flatpickr-calendar.open,
    .flatpickr-calendar.inline {
        width: 100%;
        height: 100%;
        padding: 20px;
        background-color: #ff000000;
        border: 1px solid #2cc37459;
    }

    .flatpickr-months .flatpickr-month {
        border: 1px solid #2cc37459;
        margin: 0 !important;
        border-bottom-width: 0.5px !important;
    }

    #appointment-calendar .flatpickr-calendar.open,
    .flatpickr-calendar.inline .flatpickr-rContainer {
        width: 100%;
        background-color: #00800000;
        border: 1px solid #2cc374;
        border-top: 0;
    }

    #appointment-calendar .flatpickr-calendar.open,
    .flatpickr-calendar.inline .flatpickr-rContainer .flatpickr-days {
        width: 100%;
        border: 1px solid #2cc374;
        border-right: none;
        border-left: none;
        border-bottom: navajowhite;
    }

    #appointment-calendar .flatpickr-calendar.open,
    .flatpickr-calendar.inline .flatpickr-rContainer .flatpickr-days .dayContainer {
        width: 100% !important;
        max-width: 100%;
        padding: 0px;
        gap: 0 !important;
        column-gap: 0 !important;
        display: flex;
        justify-content: flex-start;
    }

    #appointment-calendar .flatpickr-calendar.open,
    .flatpickr-calendar.inline .flatpickr-rContainer .flatpickr-days .flatpickr-day {
        width: 20% !important;
        max-width: 20% !important;
        border-radius: 0px;
        transition: .3s;
    }

    #appointment-calendar .flatpickr-calendar.open,
    .flatpickr-calendar.inline .flatpickr-rContainer .flatpickr-days .flatpickr-day:hover {
        background-color: #2cc374;
        color: white;
        border-color: #2cc374;
    }

    #appointment-calendar .flatpickr-calendar.open,
    .flatpickr-calendar.inline .flatpickr-rContainer .flatpickr-days .flatpickr-day {
        border: 1px solid #2cc374;
    }

    #appointment-calendar .flatpickr-calendar.open,
    .flatpickr-calendar.inline .flatpickr-rContainer .flatpickr-days .flatpickr-day.flatpickr-disabled {
        border-color: #2cc37433;
    }

    #appointment-calendar .flatpickr-calendar.open,
    .flatpickr-calendar.inline .flatpickr-rContainer .flatpickr-days .flatpickr-day.today {
        background-color: #2cc37496;
        color: #000000;
    }

    #appointment-calendar .flatpickr-calendar.open,
    .flatpickr-calendar.inline .flatpickr-rContainer .flatpickr-days .flatpickr-day.selected {
        background-color: #2cc374;
    }

    .flatpickr-months .flatpickr-prev-month.flatpickr-next-month,
    .flatpickr-months .flatpickr-next-month.flatpickr-next-month {
        right: 40px !important;
        top: 40px !important;
        background-color: #2cc374;
        border-radius: 50px;
        color: white;
    }

    .flatpickr-months .flatpickr-prev-month.flatpickr-prev-month,
    .flatpickr-months .flatpickr-next-month.flatpickr-prev-month {
        left: 40px !important;
        top: 40px !important;
        background-color: #2cc374;
        border-radius: 50px;
        color: white;
    }

    .flatpickr-months .flatpickr-month {
        height: 70px !important;
        display: flex;
        align-items: center;
    }

    .flatpickr-months .flatpickr-month {
        height: 70px !important;
        display: flex;
        align-items: center;
    }

    .flatpickr-months .flatpickr-prev-month.flatpickr-next-month,
    .flatpickr-months .flatpickr-next-month.flatpickr-next-month svg path,
    .flatpickr-months .flatpickr-prev-month.flatpickr-prev-month,
    .flatpickr-months .flatpickr-next-month.flatpickr-prev-month svg path {
        fill: white;
    }

    .flatpickr-months .flatpickr-prev-month.flatpickr-next-month,
    .flatpickr-months .flatpickr-next-month.flatpickr-next-month:hover,
    .flatpickr-months .flatpickr-prev-month.flatpickr-prev-month:hover,
    .flatpickr-months .flatpickr-next-month.flatpickr-prev-month:hover {
        background-color: black;
    }

    .flatpickr-prev-month:hover svg path {
        fill: white !important;
    }

    .main-check-box-click .input-radio-box label .main-label-content .content h4 {
        font-size: 17px;
    }

    .main-check-box-click .input-radio-box label .main-label-content .content {
        display: flex;
        flex-direction: column;
    }

    .main-check-box-click .input-radio-box label .main-label-content .content p {
        font-size: 16px;
        line-height: 1.3em;
    }


    .main-check-box-click .input-radio-box label .main-label-content .discount_container {
    width: 100px;
    text-align: center;
    border: 2px solid #4EAC7B;
    border-radius: 10px;
    background: #4eac7b1f;
    position: absolute;
    right: 20%;
}

.main-check-box-click .input-radio-box label .main-label-content .discount_container p {
    color: #4EAC7B;
    font-weight: 600;
    font-family: inherit;
    font-size: 25px;
}

.main-check-box-click .input-radio-box label .main-label-content .discount_container span {
    color: #4EAC7B;
}

.main-check-box-click .input-radio-box label .main-label-content {
    position: relative;
}

.appointment-sec-01 .main-steps-form ul {
                                display: flex                            ;
                                justify-content: center !important;
                                flex-direction: row;
                                flex-wrap: wrap;
                                gap: 120px !important;
                            }

.appointment-sec-01 .main-steps-form ul li:last-child::after {
    content: none;
}



.user-filter-box-login {
    position: relative;
    text-align: center;
    height: 60vh;
    align-content: center;
}

.user-filter-box-login::before {
    content: "";
    width: 100%;
    height: 100%;
    background-color: #0080006b;
    position: absolute;
    top: 0;
    filter: blur(50px);
    opacity: 50%;
    z-index: 99;
    left: 0;
    right: 0;
    bottom: 0;
}

.user-filter-box-login h2, .user-filter-box-login a {
    z-index: 999999999;
    position: relative;
}



@media only screen and (max-width: 575px){

.main-check-box-click .input-radio-box label .main-label-content .discount_container {
    width: 100px;
    text-align: center;
    border: none;
    border-radius: 0px;
    background: transparent;
    position: absolute;
    right: 5%;
}


.main-check-box-click .input-radio-box label .main-label-content .discount_container p {
    font-size: 18px;
}
}
</style>
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif
    <section class="hero-banner other-pages-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text">
                        <h1><span>Book </span> An <br> Appointment </h1>
                        <a href="#" class="t-btn">My Appointments / Packages</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-img">
            <img src="{{ asset('assets/images/Appointment ( P 1 ).png') }}" alt="">
        </div>
    </section>
    
    


    <section class="appointment-sec-01" id="appointment">
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="main-steps-form" id="main-steps-form">
                        <ul>
                            {{-- class="active-services" --}}
                            {{-- <li><a>
                                    <div class="svg-box">
                                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M41.6667 6.25H8.33341C7.22835 6.25 6.16854 6.68899 5.38714 7.47039C4.60573 8.25179 4.16675 9.3116 4.16675 10.4167V18.75C4.16675 19.8551 4.60573 20.9149 5.38714 21.6963C6.16854 22.4777 7.22835 22.9167 8.33341 22.9167H41.6667C42.7718 22.9167 43.8316 22.4777 44.613 21.6963C45.3944 20.9149 45.8334 19.8551 45.8334 18.75V10.4167C45.8334 9.3116 45.3944 8.25179 44.613 7.47039C43.8316 6.68899 42.7718 6.25 41.6667 6.25ZM8.33341 18.75V10.4167H41.6667V18.75H8.33341ZM41.6667 27.0833H8.33341C7.22835 27.0833 6.16854 27.5223 5.38714 28.3037C4.60573 29.0851 4.16675 30.1449 4.16675 31.25V39.5833C4.16675 40.6884 4.60573 41.7482 5.38714 42.5296C6.16854 43.311 7.22835 43.75 8.33341 43.75H41.6667C42.7718 43.75 43.8316 43.311 44.613 42.5296C45.3944 41.7482 45.8334 40.6884 45.8334 39.5833V31.25C45.8334 30.1449 45.3944 29.0851 44.613 28.3037C43.8316 27.5223 42.7718 27.0833 41.6667 27.0833ZM8.33341 39.5833V31.25H41.6667V39.5833H8.33341Z"
                                                fill="#3A3A3A" />
                                            <path
                                                d="M35.4167 12.5H39.5834V16.6667H35.4167V12.5ZM29.1667 12.5H33.3334V16.6667H29.1667V12.5ZM35.4167 33.3333H39.5834V37.5H35.4167V33.3333ZM29.1667 33.3333H33.3334V37.5H29.1667V33.3333Z"
                                                fill="#3A3A3A" />
                                        </svg>
                                    </div>
                                    <p>Packages</p>
                                </a>
                            </li> --}}
                            {{-- <li><a>
                                    <div class="svg-box">
                                        <svg width="51" height="50" viewBox="0 0 51 50" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M35.0916 23.0166C36.3605 20.8543 36.9084 18.3444 36.6562 15.85C36.2833 12.1333 34.2083 8.84789 30.8166 6.59998L28.5145 10.0708C30.8458 11.6166 32.2645 13.8187 32.5104 16.2666C32.6237 17.4043 32.4821 18.553 32.0958 19.6291C31.7094 20.7052 31.0881 21.6817 30.277 22.4875L27.7937 24.9708L31.1645 25.9604C39.9812 28.5437 40.0833 37.4104 40.0833 37.5H44.25C44.25 33.7729 42.2583 26.4896 35.0916 23.0166Z"
                                                fill="#7A7A7A" />
                                            <path
                                                d="M20.2917 25C24.8876 25 28.6251 21.2625 28.6251 16.6667C28.6251 12.0709 24.8876 8.33337 20.2917 8.33337C15.6959 8.33337 11.9584 12.0709 11.9584 16.6667C11.9584 21.2625 15.6959 25 20.2917 25ZM20.2917 12.5C22.5897 12.5 24.4584 14.3688 24.4584 16.6667C24.4584 18.9646 22.5897 20.8334 20.2917 20.8334C17.9938 20.8334 16.1251 18.9646 16.1251 16.6667C16.1251 14.3688 17.9938 12.5 20.2917 12.5ZM23.4167 27.0834H17.1667C10.273 27.0834 4.66675 32.6896 4.66675 39.5834V41.6667H8.83341V39.5834C8.83341 34.9875 12.5709 31.25 17.1667 31.25H23.4167C28.0126 31.25 31.7501 34.9875 31.7501 39.5834V41.6667H35.9167V39.5834C35.9167 32.6896 30.3105 27.0834 23.4167 27.0834Z"
                                                fill="#7A7A7A" />
                                        </svg>
                                    </div>
                                    <p>Staff</p>
                                </a>
                            </li> --}}

                            
                            <li><a>
                                    <div class="svg-box">
                                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.5833 22.9166H18.7499V27.0833H14.5833V22.9166ZM14.5833 31.25H18.7499V35.4166H14.5833V31.25ZM22.9166 22.9166H27.0833V27.0833H22.9166V22.9166ZM22.9166 31.25H27.0833V35.4166H22.9166V31.25ZM31.2499 22.9166H35.4166V27.0833H31.2499V22.9166ZM31.2499 31.25H35.4166V35.4166H31.2499V31.25Z"
                                                fill="#7A7A7A" />
                                            <path
                                                d="M10.4167 45.8333H39.5833C41.8812 45.8333 43.75 43.9645 43.75 41.6666V12.5C43.75 10.202 41.8812 8.33329 39.5833 8.33329H35.4167V4.16663H31.25V8.33329H18.75V4.16663H14.5833V8.33329H10.4167C8.11875 8.33329 6.25 10.202 6.25 12.5V41.6666C6.25 43.9645 8.11875 45.8333 10.4167 45.8333ZM39.5833 16.6666L39.5854 41.6666H10.4167V16.6666H39.5833Z"
                                                fill="#7A7A7A" />
                                        </svg>
                                    </div>
                                    <p>Date & Time</p>
                                </a>
                            </li>
                            <li><a>
                                    <div class="svg-box">
                                        <svg width="51" height="50" viewBox="0 0 51 50" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M41.9645 17.8875C41.8657 17.6613 41.7275 17.4546 41.5562 17.277L29.0562 4.77704C28.8786 4.60576 28.6719 4.46748 28.4458 4.36871C28.3833 4.33954 28.3166 4.32288 28.2499 4.29996C28.0756 4.24064 27.8941 4.20491 27.7103 4.19371C27.6666 4.18954 27.627 4.16663 27.5833 4.16663H12.9999C10.702 4.16663 8.83325 6.03538 8.83325 8.33329V41.6666C8.83325 43.9645 10.702 45.8333 12.9999 45.8333H37.9999C40.2978 45.8333 42.1666 43.9645 42.1666 41.6666V18.75C42.1666 18.7062 42.1437 18.6666 42.1395 18.6208C42.1293 18.4369 42.0936 18.2553 42.0333 18.0812C42.0124 18.0145 41.9937 17.95 41.9645 17.8875ZM35.0541 16.6666H29.6666V11.2791L35.0541 16.6666ZM12.9999 41.6666V8.33329H25.4999V18.75C25.4999 19.3025 25.7194 19.8324 26.1101 20.2231C26.5008 20.6138 27.0307 20.8333 27.5833 20.8333H37.9999L38.0041 41.6666H12.9999Z"
                                                fill="#7A7A7A" />
                                            <path
                                                d="M17.1667 25H33.8334V29.1666H17.1667V25ZM17.1667 33.3333H33.8334V37.5H17.1667V33.3333ZM17.1667 16.6666H21.3334V20.8333H17.1667V16.6666Z"
                                                fill="#7A7A7A" />
                                        </svg>
                                    </div>
                                    <p>Basic Details</p>
                                </a>
                            </li>
                            <li><a>
                                    <div class="svg-box">
                                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.9873 28.6291L14.8686 36.1708L30.7352 18.0374L27.5977 15.2958L14.2977 30.4958L7.5123 25.3166L4.9873 28.6291ZM45.3186 18.0374L42.1811 15.2958L28.9123 30.4604L27.3436 29.2062L24.7394 32.4604L29.4206 36.2062L45.3186 18.0374Z"
                                                fill="#7A7A7A" />
                                        </svg>
                                    </div>
                                    <p>Schedule</p>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <form id="regForm" method="POST" action="{{ route('appointment.stripe') }}">
                        @csrf
                        @if ($remaining_slots > 0)
                            <input type="hidden" name="appointment_id" id="appointment_id" value="{{ $appointmentId }}">
                        @endif
                        <div class="tab d-none">
                            <div class="text">
                                {{-- <h3>Category</h3> --}}
                                @guest
                                    <div class="when-user-logout">
                                        <a href="{{ route('login') }}">Login</a>
                                        @endif

                                        {{-- <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" onclick="getServices(0)" data-toggle="tab"
                                                    role="tab">All </a>
                                            </li>
                                            @foreach ($categories as $c)
                                                <li class="nav-item">
                                                    <a class="nav-link" onclick="getServices({{ $c->id }})"
                                                        data-toggle="tab" role="tab">{{ $c->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul> --}}
                                        
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                                <div class="main-check-box-click">
                                                    <div id="services-box">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                                <div class="main-check-box-click">
                                                    <div class="input-radio-box">
                                                        <input type="radio" id="html" name="fav_language" value="HTML"
                                                            checked>
                                                        <label for="html">
                                                            <div class="main-label-content">
                                                                <div class="img-box">
                                                                    <img src="assets/images/input-radio-img.jpg"
                                                                        alt="">
                                                                </div>
                                                                <div class="content">
                                                                    <h4>Golf Coaching Session</h4>
                                                                    <p>Duration <b>: 2 Hours</b> </p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="input-radio-box">
                                                        <input type="radio" id="html-01" name="fav_language"
                                                            value="HTML-01">
                                                        <label for="html-01">
                                                            <div class="main-label-content">
                                                                <div class="img-box">
                                                                    <img src="assets/images/input-radio-img.jpg"
                                                                        alt="">
                                                                </div>
                                                                <div class="content">
                                                                    <h4>Golf Coaching Session</h4>
                                                                    <p>Duration <b>: 2 Hours</b> </p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="input-radio-box">
                                                        <input type="radio" id="html-01" name="fav_language"
                                                            value="HTML-01">
                                                        <label for="html-01">
                                                            <div class="main-label-content">
                                                                <div class="img-box">
                                                                    <img src="assets/images/input-radio-img.jpg"
                                                                        alt="">
                                                                </div>
                                                                <div class="content">
                                                                    <h4>Golf Coaching Session</h4>
                                                                    <p>Duration <b>: 2 Hours</b> </p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                                <div class="main-check-box-click">
                                                    <div class="input-radio-box">
                                                        <input type="radio" id="html" name="fav_language"
                                                            value="HTML" checked>
                                                        <label for="html">
                                                            <div class="main-label-content">
                                                                <div class="img-box">
                                                                    <img src="assets/images/input-radio-img.jpg"
                                                                        alt="">
                                                                </div>
                                                                <div class="content">
                                                                    <h4>Golf Coaching Session</h4>
                                                                    <p>Duration <b>: 2 Hours</b> </p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="input-radio-box">
                                                        <input type="radio" id="html-01" name="fav_language"
                                                            value="HTML-01">
                                                        <label for="html-01">
                                                            <div class="main-label-content">
                                                                <div class="img-box">
                                                                    <img src="assets/images/input-radio-img.jpg"
                                                                        alt="">
                                                                </div>
                                                                <div class="content">
                                                                    <h4>Golf Coaching Session</h4>
                                                                    <p>Duration <b>: 2 Hours</b> </p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="input-radio-box">
                                                        <input type="radio" id="html-01" name="fav_language"
                                                            value="HTML-01">
                                                        <label for="html-01">
                                                            <div class="main-label-content">
                                                                <div class="img-box">
                                                                    <img src="assets/images/input-radio-img.jpg"
                                                                        alt="">
                                                                </div>
                                                                <div class="content">
                                                                    <h4>Golf Coaching Session</h4>
                                                                    <p>Duration <b>: 2 Hours</b> </p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tabs-4" role="tabpanel">
                                                <div class="main-check-box-click">
                                                    <div class="input-radio-box">
                                                        <input type="radio" id="html" name="fav_language"
                                                            value="HTML" checked>
                                                        <label for="html">
                                                            <div class="main-label-content">
                                                                <div class="img-box">
                                                                    <img src="assets/images/input-radio-img.jpg"
                                                                        alt="">
                                                                </div>
                                                                <div class="content">
                                                                    <h4>Golf Coaching Session</h4>
                                                                    <p>Duration <b>: 2 Hours</b> </p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="input-radio-box">
                                                        <input type="radio" id="html-01" name="fav_language"
                                                            value="HTML-01">
                                                        <label for="html-01">
                                                            <div class="main-label-content">
                                                                <div class="img-box">
                                                                    <img src="assets/images/input-radio-img.jpg"
                                                                        alt="">
                                                                </div>
                                                                <div class="content">
                                                                    <h4>Golf Coaching Session</h4>
                                                                    <p>Duration <b>: 2 Hours</b> </p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="input-radio-box">
                                                        <input type="radio" id="html-01" name="fav_language"
                                                            value="HTML-01">
                                                        <label for="html-01">
                                                            <div class="main-label-content">
                                                                <div class="img-box">
                                                                    <img src="assets/images/input-radio-img.jpg"
                                                                        alt="">
                                                                </div>
                                                                <div class="content">
                                                                    <h4>Golf Coaching Session</h4>
                                                                    <p>Duration <b>: 2 Hours</b> </p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @guest
                                        </div>
                                        @endif

                                    </div>
                                </div>
                                {{-- <div class="tab d-none">
                                    <div class="text">
                                        <h3>Staff Members</h3>
                                    </div>
                                    <div class="main-check-box-click">
                                        <div id="staff-box">
                                            <div class="input-radio-box">
                                                <label>
                                                    <div class="main-label-content">
                                                        <div class="content p-3">
                                                            <h4>No Staff Found</h4>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div id="staff-box">
                                </div>

                                
                                <div class="tab d-none">
                                    <div class="text">
                                        <h3>Available Date & Time</h3>
                                    </div>
                                    <div class="two-appointment-box-align">
                                        <div class="input-date-box">
                                            {{-- <input type="date" onchange="getSlotsForDate(this.value)" name="appointment_date"
                                                id="appointment_date" placeholder="Your Date" min="{{ date('Y-m-d') }}"> --}}

                                            <!-- Hidden Input Field -->
                                            <input type="text" name="appointment_date" id="appointment_date"
                                                style="display: none;" min="{{ date('Y-m-d') }}">

                                            <!-- Calendar Container -->
                                            <div id="appointment-calendar"></div>
                                        </div>
                                        <div class="main-check-box-click main-check-box-click-time">
                                            <div class="text">
                                                <h6>Available Time Slots</h6>
                                            </div>
                                            <div id="slots-box">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab d-none">
                                    <div class="text">
                                        <h3>Basic Details</h3>
                                    </div>
                                    <div class="appointment-form-box">
                                        <div class="two-input-align">
                                            @if (auth()->check() && auth()->user()->hasRole('user'))
                                                <input type="hidden" name="user_id" id="user_id"
                                                    value="{{ auth()->user()->id }}">
                                            @else
                                                <input type="hidden" name="user_id" id="user_id" value="0">
                                            @endif
                                            <label for="first_name">First Name</label>
                                            <input type="text" placeholder="First Name *" name="first_name"
                                                value="{{ auth()->check() ? auth()->user()->name : '' }}" id="first_name"
                                                @if ($remaining_slots > 0) disabled @endif>
                                            <label for="last_name">Last Name</label>
                                            <input type="text" placeholder="Last Name *" name="last_name" id="last_name"
                                                value="{{ auth()->check() ? auth()->user()->last_name : '' }}"
                                                @if ($remaining_slots > 0) disabled value="{{ $lastName }}" @endif>
                                        </div>
                                        <div class="two-input-align">
                                            <label for="email">Email</label>
                                            <input type="email" placeholder="Email Address *" name="email"
                                                value="{{ auth()->check() ? auth()->user()->email : '' }}"
                                                @if ($remaining_slots > 0) disabled @endif id="email">
                                            <label for="phone" class="mb-1">Phone</label>
                                            @if ($remaining_slots > 0)
                                                <input type="tel" placeholder="Phone Number *" name="phone"
                                                    @if ($remaining_slots > 0) value="{{ $phone }}" @endif>
                                            @else
                                                <input type="tel" placeholder="Phone Number *" name="phone"
                                                    value="{{ auth()->check() ? auth()->user()->phone : '' }}" id="phone">
                                            @endif
                                        </div>
                                        <div class="signle-input-box">
                                            <label for="location" style="margin-top: 10px">Location</label>
                                            <select name="location" id="location">
                                                <option selected value="{{ $settings[0]->location ?? '-' }}">
                                                    {{ $settings[0]->location ?? '-' }}</option>
                                            </select>
                                        </div>
                                        <div class="signle-input-box">
                                            <label for="note">Note</label>
                                            <textarea placeholder="Note" name="note" id="note"></textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="d-none" id="submitted-box">
                                    <div class="text">
                                        <img src="assets/images/single-check.png" alt="">
                                        <h3>Appointment Booked</h3>
                                    </div>
                                    <div class="appointment-booked-details">
                                        <ul>
                                            <li>Staff Member : Navy Dave ( Instructor ) </li>
                                            <li>Date & Time : 20 June 2024 in 09 : 00 AM - 11 : 00 AM</li>
                                            <li>Name : First_Name+Last_Name</li>
                                            <li>Email Address : someone@example.com</li>
                                            <li>Phone Number : (XX) XXX XXXXXXX</li>
                                            <li>Location : Somewhere</li>
                                            <li>Price : $0.00</li>
                                            <li>Note : If Any</li>
                                        </ul>
                                    </div>
                                    <button class="t-btn" id="goBackBtn">Go Back</button>
                                </div>
                                <div class="d-none" id="error-box">
                                    <div class="text">
                                        <img src="assets/images/warning.png" alt="">
                                        <h3 id="errorTitle">Error</h3>
                                    </div>
                                    <div class="appointment-booked-details">
                                        <ul id="errorList">
                                            <!-- Validation errors will be listed here -->
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-none" style="text-align: center;" id="loadingTab">
                                    <div class="appointment-booked-details">
                                        {{-- <p>Loading.....</p> --}}
                                        <img src="{{ asset('assets/images/loading.gif') }}" width="100px" height="100px"
                                            alt="Loading...">
                                    </div>
                                </div>

                                @auth
                                    <div class="two-btns-align">
                                        <a href="#appointment" id="prevBtn" onclick="nextPrev(-1)" class="t-btn t-btn-gray"> Go
                                            Back</a>
                                        <a href="#appointment" id="nextBtn" onclick="nextPrev(1)" class="t-btn"> Save &
                                            Continue</a>
                                    </div>
                                @endauth


                                <div style="text-align:center;margin-top:40px;">
                                    <div class="step"></div>
                                    <div class="step"></div>
                                    {{-- <div class="step"></div> --}}
                                    <div class="step"></div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </section>
            <!-- Flatpickr CSS and JS -->
            <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                @if ($remaining_slots != 0)
                    getStaff({{ $service_id }});
                    getSlots({{ $staff_id }});
                    setTimeout(() => {
                        nextPrev(1);
                        nextPrev(1);
                    }, 1);
                @endif
                var currentTab = 0;
                showTab(currentTab);


                function fixStepIndicator(n) {
                    var i, x = document.getElementsByClassName("step");
                    for (i = 0; i < x.length; i++) {
                        x[i].className = x[i].className.replace(" active", "");
                    }

                    if (n >= 0 && n < x.length) {
                        x[n].className += " active";
                    } else {
                        console.error("Step index is out of bounds:", n);
                    }
                }

                function nextPrev(n) {
                    if(validateForm()){
                        $("#prevBtn")[0].classList.remove("d-none");
                    }
                    
                    if (n == -1) {
                        $("#prevBtn")[0].classList.add("d-none");
                    }
                    var x = document.getElementsByClassName("tab");

                    // Hide the error tab when moving between tabs
                    var errorTab = document.getElementById("error-box");
                    errorTab.classList.add("d-none"); // This hides the error tab

                    // Prevent going out of bounds for previous navigation
                    if (currentTab + n < 0) {
                        return; // Do nothing if trying to go back from the first tab
                    }

                    // Validate the form before moving to the next tab
                    if (n == 1 && !validateForm()) return false;

                    // Hide the current tab
                    x[currentTab].style.display = "none";

                    // Increment or decrement currentTab
                    currentTab += n;

                    // Prevent currentTab from exceeding the last tab (index 3 if 4 tabs)
                    if (currentTab >= x.length) {
                        currentTab = x.length - 1; // Stay at the last tab

                        // If it's the last tab and form is valid, submit via AJAX
                        if (validateForm()) {
                            submitFormWithAjax();
                            return false; // Prevent default form submission
                        }
                    }

                    // Show the correct tab
                    showTab(currentTab);
                }


                function showTab(n) {
                    var x = document.getElementsByClassName("tab");

                    // Hide the error tab when showing a new tab
                    var errorTab = document.getElementById("error-box");
                    errorTab.classList.add("d-none"); // This hides the error tab

                    // Ensure index n is within bounds
                    if (n >= 0 && n < x.length) {
                        // Remove the 'd-none' class if it exists to make sure the tab is visible
                        x[n].classList.remove("d-none");
                        x[n].style.display = "block";

                        @auth
                        // Handle previous button display
                        if (n == 0) {
                            document.getElementById("prevBtn").style.display = "none";
                        } else {
                            document.getElementById("prevBtn").style.display = "inline";
                        }

                        // Handle next button text
                        if (n == (x.length - 1)) {
                            document.getElementById("nextBtn").innerHTML = "Submit";
                        } else {
                            document.getElementById("nextBtn").innerHTML = "Next";
                        }
                    @endauth

                    // Update step indicator
                    fixStepIndicator(n);
                } else {
                    console.error("currentTab is out of bounds:", n);
                }
                }


                function validateForm() {
                    console.log("Validating form...");
                    var x, y, i, valid = true;
                    x = document.getElementsByClassName("tab");

                    // Ensure currentTab is within bounds
                    if (currentTab < 0 || currentTab >= x.length) {
                        console.error("currentTab is out of bounds:", currentTab);
                        return false; // Or handle the error as needed
                    }

                    y = x[currentTab].getElementsByTagName("input");

                    for (i = 0; i < y.length; i++) {
                        if (y[i].value == "") {
                            y[i].className += " invalid";
                            valid = false;

                            // Show the error tab
                            // toastr.error('Please fill out all required fields.');
                        }
                    }

                    // Check if currentTab is within bounds
                    var steps = document.getElementsByClassName("step");
                    if (valid && currentTab < steps.length) {
                        steps[currentTab].className += " finish";
                    }

                    return valid;
                }


                function submitFormWithAjax() {
                    var form = document.getElementById("regForm");

                    var loadingTab = document.getElementById("loadingTab");
                    var successTab = document.getElementById("submitted-box");
                    var errorTab = document.getElementById("error-box");
                    @auth
                    var submitButton = document.getElementById("nextBtn");
                    var prevButton = document.getElementById("prevBtn");
                @endauth

                // Reset the UI
                successTab.classList.add("d-none");
                errorTab.classList.add("d-none");
                loadingTab.classList.remove("d-none");

                // form.submit();

                @if ($remaining_slots == 0)
                    $.ajax({
                        type: "POST",
                        url: "appointment/stripe",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: $(form).serialize(),
                        success: function(data) {
                            window.location.href = data.data;
                            loadingTab.classList.add("d-none");
                            // Hide the submit button after success
                            submitButton.style.display = "none";
                            prevButton.style.display = "none";

                            form.reset();

                            // Clear radio button selections
                            var radios = form.querySelectorAll("input[type='radio']");
                            radios.forEach(function(radio) {
                                radio.checked = false;
                            });

                            $("#service_id").val(null).trigger('change');
                            $("#staff_id").val(null).trigger('change');

                            // Clear validation error highlights (if you are adding "invalid" class for validation)
                            var inputs = form.querySelectorAll("input, textarea");
                            inputs.forEach(function(input) {
                                input.classList.remove("invalid");
                            });


                        },
                        error: function(xhr, status, error) {
                            loadingTab.classList.add("d-none");
                            $("#errorTitle").text("This Slot is not available!");

                            if (xhr.status === 422) { // Validation errors
                                var errors = xhr.responseJSON.errors;
                                var errorList = document.getElementById("errorList");

                                if (errorList) {
                                    errorList.innerHTML = ""; // Clear previous errors

                                    // Loop through and display each validation error
                                    for (var field in errors) {
                                        if (errors.hasOwnProperty(field)) {
                                            errors[field].forEach(function(message) {
                                                var errorItem = document.createElement("li");
                                                errorItem.textContent = message;
                                                errorList.appendChild(errorItem);
                                            });
                                        }
                                    }
                                }

                                errorTab.classList.remove("d-none");
                            } else {
                                console.error("Form submission failed:", error);
                                errorTab.classList.remove("d-none");
                            }
                        }
                    });
                @else

                // Serialized form data
                let formData = $(form).serialize();

                // Convert serialized data into an object
                let params = new URLSearchParams(formData);

                // Remove all `service_id` entries
                params.delete('service_id');

                // Append new `service_id` (e.g., 10 as an example)
                params.append('service_id', {{ $service_id }});

                // Convert the updated parameters back to a string
                let updatedFormData = params.toString();

                console.log(updatedFormData);
                    $.ajax({
                        type: "POST",
                        url: "appointment/nextSlot",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: updatedFormData,
                        success: function(data) {
                            console.log(data);

                            window.location.href = data.data;
                        },
                        error: function(xhr, status, error) {
                            console.log("Error Response:", xhr.responseJSON.error);
                            $("#errorTitle").text("This Slot is not available!");
                            loadingTab.classList.add("d-none");
                            errorTab.classList.remove("d-none");
                        }
                    });
                @endif
                }

                document.getElementById("goBackBtn").addEventListener("click", function() {
                    window.location.reload();
                });

                function fixStepIndicator(n) {
                    var i, x = document.getElementsByClassName("step");
                    for (i = 0; i < x.length; i++) {
                        x[i].className = x[i].className.replace(" active", "");
                    }

                    x[n].className += " active";
                }


                function getServices(id) {
                    $.ajax({
                        type: "GET",
                        url: "get-services/" + id,
                        success: function(data) {
                            $("#services-box").empty();

                            if (data.length == 0) {
                                $("#services-box").append(`
                                    <div class="input-radio-box">
                                        <label>
                                            <div class="main-label-content">
                                                <div class="content p-3">
                                                    <h4>No Service Found</h4>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                `);
                                return;
                            }

                            $("#nextBtn")[0].classList.add("d-none");

                            $("#services-box").append(`
                                <div class="user-filter-box-login">
                                    <h2>Please Buy Package First</h2>
                                    <a href="{{ route('user.packages') }}" class="btn t-btn"> Buy Package </a>
                                </div>
                            `);

                            data.forEach(element => {
                                let serviceID = {{ $service_id }};
                                let checked = serviceID == element.id ? 'checked' : '';
                                $("#services-box").append(`
                                    <div class="input-radio-box">
                                        <input type="hidden" id="service_id-${element.id}" name="service_id" ${checked} onchange="getStaff(${element.id})" value="${element.id}">
                                    </div>
                                `);
                            });


                            // data.forEach(element => {
                            //     let serviceID = {{ $service_id }};
                            //     let checked = serviceID == element.id ? 'checked' : '';
                            //     $("#services-box").append(`
                            //         <div class="input-radio-box">
                            //             <input type="radio" id="service_id-${element.id}" name="service_id" ${checked} onchange="getStaff(${element.id})" value="${element.id}">
                            //             <label for="service_id-${element.id}">
                            //                 <div class="main-label-content">
                            //                     <div class="img-box">
                            //                         <img src="{{ Storage::url('${element.image}') }}" width="50px" height="50px" alt="Service Image">
                            //                     </div>
                            //                     <div class="content">
                            //                         <h4>${element.name}</h4>
                            //                         <p>Duration <b>: ${element.duration} ${element.type_duration}</b> </p>
                            //                         <p>Session <b>: ${element.slots}</b></p>
                            //                         <p>Price <b>: ${(element.discount > 0 ? `<del> $${element.original_price} </del>` : '' )}$${element.price}</b></p>
                            //                     </div>
                            //                     ${element.discount > 0 ? `
                            //                         <div class="discount_container">
                            //                             <p>${element.discount}%</p>
                            //                             <span>Discount</span>
                            //                         </div>` : ''}
                            //                 </div>
                            //             </label>
                            //         </div>
                            //     `);
                            // });
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }

                function getStaff(id) {
                    $.ajax({
                        type: "GET",
                        url: "get-staff/" + id,
                        success: function(data) {
                            $("#staff-box").empty();
                            $("#appointment_date").val(null);

                            if(data.length == 1){
                                data.forEach(element => {
                                let staffId = {{ $staff_id }};
                                let checked = staffId == element.id ? 'checked' : '';
                                    $("#staff-box").append(`
                                            <input type="radio" class="d-none" id="staff_id-${element.id}" name="staff_id" ${checked} onchange="getSlots(${element.id})" value="${element.id}">
                                        </div>
                                    `);

                                    getSlots(element.id);
                                    $(`#staff_id-${element.id}`).prop('checked', true);
                                });
                            }else{
                                data.forEach(element => {
                                let staffId = {{ $staff_id }};
                                let checked = staffId == element.id ? 'checked' : '';
                                    $("#staff-box").append(`
                                        <div class="input-radio-box">
                                            <input type="radio" id="staff_id-${element.id}" name="staff_id" ${checked} onchange="getSlots(${element.id})" value="${element.id}">
                                            <label for="staff_id-${element.id}">
                                                <div class="main-label-content">
                                                    <div class="img-box">
                                                        <img src="{{ Storage::url('${element.image}') }}" width="50px" height="50px" alt="Staff Image">
                                                    </div>
                                                    <div class="content">
                                                        <h4>${element.user.name}</h4>
                                                        <p>Duration <b>: 2 Hours</b> </p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    `);
                                });
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }

                function formatTime(timeString) {
                    const [hour, minute] = timeString.split(':');
                    let hours = parseInt(hour);
                    let ampm = hours >= 12 ? 'pm' : 'am';
                    hours = hours % 12 || 12; // convert 24-hour format to 12-hour format
                    return `${hours}:${minute} ${ampm}`;
                }

                function getSlots(id) {
                    staffID = id;
                    serviceID = $("input[name='service_id']:checked").val();

                    $.ajax({
                        type: "GET",
                        url: "get-slots",
                        data: {
                            staff_id: staffID,
                            service_id: {{ $service_id }}
                            // service_id: serviceID
                        },
                        success: function(data) {
                            $("#nextBtn")[0].classList.remove("d-none");
                            $("#prevBtn")[0].classList.add("d-none");
                            $("#slots-box").empty(); // Clear existing slots
                            $("#appointment_date").val(null);

                            if (data.length == 0) {
                                $("#slots-box").append(`
                                    <div class="input-radio-box">
                                        <label for="">
                                            <div class="main-label-content">
                                                <div class="content">
                                                    <h4 style="">No Slots Available</h4>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                `);
                            }

                            // Separate slots into Morning and Afternoon categories
                            var morningSlots = [];
                            var afternoonSlots = [];

                            data.forEach(element => {
                                const fromTime = new Date('1970-01-01T' + element
                                    .available_from); // Convert available_from to a Date object
                                const hours = fromTime.getHours();

                                if (hours < 12) {
                                    morningSlots.push(element); // AM slot (Morning)
                                } else {
                                    afternoonSlots.push(element); // PM slot (Afternoon)
                                }
                            });

                            // Append Morning heading and slots if there are morning slots
                            if (morningSlots.length > 0) {
                                $("#slots-box").append(`<h3 style="color:#535D71 !important;">Morning</h3>`);
                                morningSlots.forEach(element => {
                                    $("#slots-box").append(`
                                        <div class="input-radio-box">
                                            <input type="radio" id="slot_id-${element.id}" name="slot_id" value="${element.id}" ${element.is_booked ? 'disabled' : ''}>
                                            <label for="slot_id-${element.id}">
                                                <div class="main-label-content">
                                                    <div class="content">
                                                        <h4 style="${element.is_booked ? 'color: #b5b5b5;' : ''}">${formatTime(element.available_from)} - ${formatTime(element.available_to)}</h4>
                                                        <p style="${element.is_booked ? 'color: #b5b5b5;' : ''}">${element.is_booked ? 'Slot Booked' : '1 slot left'}</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    `);
                                });
                            }

                            // Append Afternoon heading and slots if there are afternoon slots
                            if (afternoonSlots.length > 0) {
                                $("#slots-box").append(`<h3 style="color:#535D71 !important;">Afternoon</h3>`);
                                afternoonSlots.forEach(element => {
                                    $("#slots-box").append(`
                                        <div class="input-radio-box">
                                            <input type="radio" id="slot_id-${element.id}" name="slot_id" value="${element.id}" ${element.is_booked ? 'disabled' : ''}>
                                            <label for="slot_id-${element.id}">
                                                <div class="main-label-content">
                                                    <div class="content">
                                                        <h4 style="${element.is_booked ? 'color: #b5b5b5;' : ''}">${formatTime(element.available_from)} - ${formatTime(element.available_to)}</h4>
                                                        <p style="${element.is_booked ? 'color: #b5b5b5;' : ''}">${element.is_booked ? 'Slot Booked' : '1 slot left'}</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    `);
                                });
                            }
                        },

                        error: function(data) {
                            console.log(data);
                        }
                    });
                }

                function getSlotsForDate(data) {

                    var staff_id = $("input[name='staff_id']:checked").val();
                    var service_id = $("input[name='service_id']:checked").val();
                    var date = data;

                    $.ajax({
                        type: "GET",
                        url: "get-slots-for-date",
                        data: {
                            staff_id: staff_id,
                            // service_id: service_id,
                            service_id: {{ $service_id }},
                            date: date
                        },
                        success: function(data) {
                            $("#nextBtn")[0].classList.remove("d-none");

                            $("#slots-box").empty(); // Clear existing slots

                            if (data.length == 0) {
                                $("#slots-box").append(`
                                    <div class="input-radio-box">
                                        <label for="">
                                            <div class="main-label-content">
                                                <div class="content">
                                                    <h4 style="">No Slots Available</h4>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                `);
                            }


                            $("#slots-box").append(`
                                <div style="text-align: center;" id="loadingTab2">
                                    <div class="appointment-booked-details">
                                        {{-- <p>Loading.....</p> --}}
                                        <img src="{{ asset('assets/images/loading.gif') }}" width="100px" height="100px" alt="Loading...">
                                    </div>
                                </div>
                            `);

                            setTimeout(() => {
                                $("#loadingTab2").remove();

                                // Separate slots into Morning and Afternoon categories
                                var morningSlots = [];
                                var afternoonSlots = [];

                                data.forEach(element => {
                                    const fromTime = new Date('1970-01-01T' + element
                                        .available_from); // Convert available_from to a Date object
                                    const hours = fromTime.getHours();

                                    if (hours < 12) {
                                        morningSlots.push(element); // AM slot (Morning)
                                    } else {
                                        afternoonSlots.push(element); // PM slot (Afternoon)
                                    }
                                });

                                // Append Morning heading and slots if there are morning slots
                                if (morningSlots.length > 0) {
                                    $("#slots-box").append(
                                    `<h3 style="color:#535D71 !important;">Morning</h3>`);
                                    morningSlots.forEach(element => {
                                        $("#slots-box").append(`
                                        <div class="input-radio-box">
                                            <input type="radio" id="slot_id-${element.id}" name="slot_id" value="${element.id}" ${element.is_booked ? 'disabled' : ''}>
                                            <label for="slot_id-${element.id}">
                                                <div class="main-label-content">
                                                    <div class="content">
                                                        <h4 style="${element.is_booked ? 'color: #b5b5b5;' : ''}">${formatTime(element.available_from)} - ${formatTime(element.available_to)}</h4>
                                                        <p style="${element.is_booked ? 'color: #b5b5b5;' : ''}">${element.is_booked ? 'Slot Booked' : '1 slot left'}</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    `);
                                    });
                                }

                                // Append Afternoon heading and slots if there are afternoon slots
                                if (afternoonSlots.length > 0) {
                                    $("#slots-box").append(
                                        `<h3 style="color:#535D71 !important;">Afternoon</h3>`);
                                    afternoonSlots.forEach(element => {
                                        $("#slots-box").append(`
                                        <div class="input-radio-box">
                                            <input type="radio" id="slot_id-${element.id}" name="slot_id" value="${element.id}" ${element.is_booked ? 'disabled' : ''}>
                                            <label for="slot_id-${element.id}">
                                                <div class="main-label-content">
                                                    <div class="content">
                                                        <h4 style="${element.is_booked ? 'color: #b5b5b5;' : ''}">${formatTime(element.available_from)} - ${formatTime(element.available_to)}</h4>
                                                        <p style="${element.is_booked ? 'color: #b5b5b5;' : ''}">${element.is_booked ? 'Slot Booked' : '1 slot left'}</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    `);
                                    });
                                }


                            }, 1000);


                        },

                        error: function(data) {
                            console.log(data);
                        }
                    });
                }

                $(document).ready(function() {
                    getServices(0);
                });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Initialize Flatpickr with the hidden input field
                    var calendar = flatpickr("#appointment_date", {
                        dateFormat: "Y-m-d", // Match the backend date format
                        minDate: "{{ date('Y-m-d') }}", // Minimum date set to today
                        inline: true, // Show the calendar inline
                        onChange: function(selectedDates, dateStr, instance) {
                            getSlotsForDate(
                                dateStr); // Trigger your existing function when a new date is selected
                        },
                        onReady: function(selectedDates, dateStr, instance) {
                            instance.open(); // Automatically open the calendar on page load
                        }
                    });

                    // Set the calendar to show on the page
                    document.getElementById('appointment-calendar').appendChild(calendar.calendarContainer);


                    document.addEventListener('DOMContentLoaded', function() {
                        // Initialize Flatpickr with the hidden input field
                        var calendar = flatpickr("#appointment_date", {
                            dateFormat: "Y-m-d", // Match the backend date format
                            minDate: "{{ date('Y-m-d') }}", // Minimum date set to today
                            inline: true, // Show the calendar inline
                            onChange: function(selectedDates, dateStr, instance) {
                                getSlotsForDate(
                                    dateStr
                                ); // Trigger your existing function when a new date is selected
                            },
                            onReady: function(selectedDates, dateStr, instance) {
                                instance.open(); // Automatically open the calendar on page load
                            }
                        });

                        // Set the calendar to show on the page
                        document.getElementById('appointment-calendar').appendChild(calendar.calendarContainer);
                    });

                    @if ($remaining_slots == 0)
                        const phoneInputField = document.querySelector("#phone");

                        // Fetch the phone number from the backend
                        let currentPhone = "{{ auth()->check() ? auth()->user()->phone : '' }}";

                        // Check if the phone number already starts with +1
                        if (!currentPhone.startsWith("+1 ")) {
                            currentPhone = "+1 " + currentPhone.replace(/^(\+1 )?/, ''); // Ensure we don't add extra +1
                        }

                        // Set the value of the input field on page load
                        phoneInputField.value = currentPhone;

                        // Add the input event listener to maintain +1
                        phoneInputField.addEventListener('input', function() {
                            if (!this.value.startsWith("+1 ")) {
                                this.value = "+1 " + this.value.replace(/^(\+1 )?/,
                                    ''); // Add +1 and keep the rest of the input
                            }
                        });

                        // Trigger the input event manually if needed
                        const event = new Event('input');
                        phoneInputField.dispatchEvent(event);


                        const iti = window.intlTelInput(phoneInputField, {
                            initialCountry: "us",
                            geoIpLookup: function(callback) {
                                fetch('https://ipinfo.io/json')
                                    .then(response => response.json())
                                    .then(data => callback(data.country))
                                    .catch(() => callback('US'));
                            },
                            separateDialCode: true,
                            preferredCountries: ['us', 'gb', 'ca', 'au'],
                            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
                        });
                    @endif
                });
            </script>
        @endsection
