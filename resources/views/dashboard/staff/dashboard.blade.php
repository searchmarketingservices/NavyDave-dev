@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.dashboard-active, .main-box-navy .left-all-links ul li a:hover {
  background-color: white;
  font-weight: 600;
}

.main-box-navy .left-all-links ul li a.dashboard-active span,.main-box-navy .left-all-links ul li a:hover span {
  background-color: #2CC374;
}

.main-box-navy .left-all-links ul li a.dashboard-active span img,.main-box-navy .left-all-links ul li a:hover span img {
  filter: invert(0) hue-rotate(465deg) brightness(10.5);
}
</style>
@section('content')
    <div class="col-lg-10">
        <div class="welcome-and-user-name">
            <h6>Welcome Back,</h6>
            <h5>{{ Auth::user()->name }} (Staff)</h5>
        </div>
        <div class="maindashboard-box">
            <div class="four-things-align">
                <div class="box">
                    <div class="text">
                        <h6>Approved Appointments</h6>
                        <div class="price-box">
                            <h5>{{ $approvedAppointments }}</h5>
                        </div>
                    </div>
                    <div class="img-box">
                        <img src="{{ asset('./assets/images/dashboard-img-02.png') }}" alt="">
                    </div>
                </div>
                <div class="box">
                    <div class="text">
                        <h6>Appointments</h6>
                        <div class="price-box price-box-in-minus">
                            <h5>{{ $totalAppointments }}</h5>
                        </div>
                    </div>
                    <div class="img-box">
                        <img src="{{ asset('./assets/images/dashboard-img-03.png') }}" alt="">
                    </div>
                </div>
                <div class="box">
                    <div class="text">
                        <h6>Pending Appointments</h6>
                        <div class="price-box">
                            <h5>{{ $pendingAppointments }}</h5>
                        </div>
                    </div>
                    <div class="img-box img-box-gray">
                        <img src="{{ asset('./assets/images/dashboard-img-03.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="main-table-box">
            <h3>Appointments</h3>
            <table>
                <tr>
                    <th class="text-start">User</th>
                    <th class="text-start">Date & Time</th>
                    <th class="text-start">STATUS</th>
                    <th class="text-start">Day</th>
                </tr>

                @foreach ($appointments as $a)
                    <tr>
                        <td class="text-start">
                            <div class="person-box">
                                <div class="box">
                                    <h5>{{ $a->first_name }} {{ $a->last_name }}</h5>
                                    <h6>{{ $a->email }}</h6>
                                </div>
                            </div>
                        </td>
                        <td class="text-start">
                            <div class="date-time-box">
                                <h5>{{ \Carbon\Carbon::parse($a->slot->available_from)->format('h : i A') }} -
                                    {{ \Carbon\Carbon::parse($a->slot->available_to)->format('h : i A') }}</h5>
                                <h6>{{ $a->appointment_date }}</h6>
                            </div>
                        </td>
                        <td class="text-start">
                            <div class="paid-unpaid-box">
                                <p class="paid-text">
                                    {{ $a->payment ? 'Paid' : 'Unpaid' }} -
                                    @switch($a->status)
                                        @case('awaiting_next_slot')
                                            Awaiting Next Slot
                                        @break

                                        @case('fully_completed')
                                            Fully Completed
                                        @break

                                        @case('completed')
                                            Completed
                                        @break

                                        @case('canceled')
                                            Canceled
                                        @break

                                        @case('pending')
                                            Pending
                                        @break

                                        @default
                                            Confirmed
                                    @endswitch
                                </p>
                            </div>
                        </td>
                        <td class="text-start">
                            <div class="day-box">
                                <p>{{ $a->slot->available_on }}</p>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
