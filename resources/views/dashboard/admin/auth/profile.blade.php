@extends('dashboard.layouts.master')

<style>
    .main-box-navy .left-all-links ul li a.profile-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.profile-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.profile-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }
</style>

@section('content')
    <div class="col-lg-10">
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="main-table-box main-table-box-list services-table">
                @if ($errors->count() > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="text">
                    {{-- {{ dd($user) }} --}}
                    <h2>{{ $user->name }}</h2>
                </div>
                <div class="form-box">
                    <form action="profile/update/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" placeholder="Full Name" value="{{ $user->name }}" name="name">
                        <input type="email" placeholder="Type Your Email" value="{{ $user->email }}" name="email">
                        <input type="tel" placeholder="Type Your Phone Number"
                            value="{{ $user->phone ? $user->phone : '' }}" name="phone">
                        <input type="text" placeholder="Address" value="{{ $user->address ? $user->address : '' }}"
                            name="address">
                        <input type="text" placeholder="City" value="{{ $user->city ? $user->city : '' }}"
                            name="city">
                        <select name="state" class="form-select" id="stste">
                            <option value="">Select State</option>
                            @php
                                $states = [
                                    'AL' => 'Alabama',
                                    'AK' => 'Alaska',
                                    'AZ' => 'Arizona',
                                    'AR' => 'Arkansas',
                                    'CA' => 'California',
                                    'CO' => 'Colorado',
                                    'CT' => 'Connecticut',
                                    'DE' => 'Delaware',
                                    'FL' => 'Florida',
                                    'GA' => 'Georgia',
                                    'HI' => 'Hawaii',
                                    'ID' => 'Idaho',
                                    'IL' => 'Illinois',
                                    'IN' => 'Indiana',
                                    'IA' => 'Iowa',
                                    'KS' => 'Kansas',
                                    'KY' => 'Kentucky',
                                    'LA' => 'Louisiana',
                                    'ME' => 'Maine',
                                    'MD' => 'Maryland',
                                    'MA' => 'Massachusetts',
                                    'MI' => 'Michigan',
                                    'MN' => 'Minnesota',
                                    'MS' => 'Mississippi',
                                    'MO' => 'Missouri',
                                    'MT' => 'Montana',
                                    'NE' => 'Nebraska',
                                    'NV' => 'Nevada',
                                    'NH' => 'New Hampshire',
                                    'NJ' => 'New Jersey',
                                    'NM' => 'New Mexico',
                                    'NY' => 'New York',
                                    'NC' => 'North Carolina',
                                    'ND' => 'North Dakota',
                                    'OH' => 'Ohio',
                                    'OK' => 'Oklahoma',
                                    'OR' => 'Oregon',
                                    'PA' => 'Pennsylvania',
                                    'RI' => 'Rhode Island',
                                    'SC' => 'South Carolina',
                                    'SD' => 'South Dakota',
                                    'TN' => 'Tennessee',
                                    'TX' => 'Texas',
                                    'UT' => 'Utah',
                                    'VT' => 'Vermont',
                                    'VA' => 'Virginia',
                                    'WA' => 'Washington',
                                    'WV' => 'West Virginia',
                                    'WI' => 'Wisconsin',
                                    'WY' => 'Wyoming',
                                ];
                            @endphp
                            @foreach ($states as $name)
                                <option value="{{ $name }}" {{ $user->state == $name ? 'selected' : '' }}>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                        <input type="text" placeholder="Change Password" name="password">
                        @if ($user->image)
                            <img src="{{ Storage::url($user->image) }}" alt="" height="200" width="200">
                            <input type="hidden" name="old_image" value="{{ $user->image }}">
                        @endif
                        <input type="file" name="image" id="image" class="form-control">
                        <button type="submit">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
