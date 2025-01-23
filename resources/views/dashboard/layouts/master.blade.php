<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" sizes="32x32">
    <link rel="stylesheet" href="{{ asset('assets/css/lib.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/adminStyle.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

</head>

<body>

    <header>
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-lg-2 col-md-2">

                    <div class="header-logo">
                        @if (auth()->check())
                            <a
                                href="
                                @if (auth()->user()->hasRole('admin')) {{ route('admin.dashboard') }}
                                @elseif (auth()->user()->hasRole('user'))
                                    {{ route('user.dashboard') }}
                                @elseif (auth()->user()->hasRole('staff'))
                                    {{ route('staff.dashboard') }} @endif">
                                <img src="{{ Storage::url($settings[0]->logo ?? '') }}" alt="Logo">
                            </a>
                        @else
                            <a href="{{ route('login') }}">Login</a>
                        @endif
                    </div>


                </div>
                <div class="col-lg-10 col-md-12">




                    <div class="header-two-things-align">

                        <div class="main-toggle-menu">
                            <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
                            <label for="openSidebarMenu" class="sidebarIconToggle">
                                <div class="spinner diagonal part-1"></div>
                                <div class="spinner horizontal"></div>
                                <div class="spinner diagonal part-2"></div>
                            </label>
                            <div id="sidebarMenu">
                                <ul class="sidebarMenuInner">
                                    @if (auth()->user()->hasRole('admin'))
                                        <li><a href="{{ route('admin.dashboard') }}"
                                                class="dashboard-active"><span><img
                                                        src="{{ asset('./assets/images/Dashboard.png') }}"
                                                        alt=""></span>Dashboard</a></li>
                                        <li><a href="{{ route('admin.profile') }}" class="profile-active"><span><img
                                                        src="{{ asset('./assets/images/Profile.png') }}"
                                                        alt=""></span>Profile</a></li>
                                        <li><a href="{{ route('admin.calendar') }}" class="calendar-active"><span><img
                                                        src="{{ asset('./assets/images/Calendar.png') }}"
                                                        alt=""></span>Calendar</a></li>
                                        <li><a href="{{ route('admin.user.packages') }} "
                                                class="packages-active"><span><img
                                                    src="{{ asset('./assets/images/bxs-user-detail.svg.png') }}"
                                                    alt=""></span>Packages</a></li>
                                        <li><a href="{{ route('admin.appointment') }}"
                                                class="appointment-active"><span><img
                                                        src="{{ asset('./assets/images/appointment.png') }}"
                                                        alt=""></span>Appointments</a></li>
                                        <li><a href="{{ route('admin.appointment-changes') }}"
                                                class="appointment-changes-active"><span><img
                                                        src="{{ asset('./assets/images/appointment.png') }}"
                                                        alt=""></span>Appointments Changes</a></li>
                                        <li><a href="{{ route('admin.users') }}" class="users-active"><span><img
                                                        src="{{ asset('./assets/images/Customers.png') }}"
                                                        alt=""></span>Users</a></li>
                                        <li><a href="{{ route('admin.users.restore') }}"
                                                class="restore-active"><span><img
                                                        src="{{ asset('./assets/images/Customers.png') }}"
                                                        alt=""></span>Restore Deleted Users</a></li>
                                        <li><a href="{{ route('admin.users.session') }}"
                                                class="user-session-active"><span><img
                                                        src="{{ asset('./assets/images/Customers.png') }}"
                                                        alt=""></span>User Sessions</a></li>
                                        <li><a href="{{ route('admin.payment') }}" class="payment-active"><span><img
                                                        src="{{ asset('./assets/images/Payments.png') }}"
                                                        alt=""></span>Payments</a></li>
                                        <li><a href="{{ route('admin.service') }}" class="service-active"><span><img
                                                        src="{{ asset('./assets/images/Services.png') }}"
                                                        alt=""></span>Services</a></li>
                                        <li><a href="{{ route('admin.restrict-slots') }}"
                                                class="restrict-active"><span><img
                                                        src="{{ asset('./assets/images/Services.png') }}"
                                                        alt=""></span>Restrict Slots</a></li>
                                        <li><a href="{{ route('admin.service.assign') }}"
                                                class="service-assign-active"><span><img
                                                        src="{{ asset('./assets/images/service-assign.png') }}"
                                                        alt=""></span>Services Assign</a></li>
                                        <li><a href="{{ route('admin.discount') }}"
                                                class="discount-active"><span><img
                                                        src="{{ asset('./assets/images/service-assign.png') }}"
                                                        alt=""></span>Discounts</a></li>
                                        <li><a href="{{ route('admin.slot') }}" class="slots-active"><span><img
                                                        src="{{ asset('./assets/images/appointment-slot.png') }}"
                                                        alt=""></span>Appointment Slots</a></li>
                                        <li><a href="{{ route('admin.staff') }}" class="staff-active"><span><img
                                                        src="{{ asset('./assets/images/staff.png') }}"
                                                        alt=""></span>Staff Members</a></li>
                                        <li><a href="{{ route('admin.community') }}"
                                                class="community-active"><span><img
                                                        src="{{ asset('./assets/images/Customers.png') }}"
                                                        alt=""></span>Community</a></li>
                                        <li><a href="{{ route('admin.blog') }}" class="blog-active"><span><img
                                                        src="{{ asset('./assets/images/blog.png') }}"
                                                        alt=""></span>Blogs</a></li>
                                        <li><a href="{{ route('admin.subscribers') }}"
                                                class="subscribers-active"><span><img
                                                        src="{{ asset('./assets/images/Profile.png') }}"
                                                        alt=""></span>Subscribers</a></li>
                                        <li><a href="{{ route('admin.setting') }}" class="setting-active"><span><img
                                                        src="{{ asset('./assets/images/setting.png') }}"
                                                        alt=""></span>Front Setting</a></li>
                                        <li><a href="{{ route('admin.google-credentials.form') }}"
                                                class="google-active"><span><img
                                                        src="{{ asset('./assets/images/setting.png') }}"
                                                        alt=""></span>Google Credentials</a></li>
                                    @endif
                                    @if (auth()->user()->hasRole('user'))
                                        <li><a href="{{ route('user.dashboard') }}"
                                                class="dashboard-active"><span><img
                                                        src="{{ asset('./assets/images/Dashboard.png') }}"
                                                        alt=""></span>Dashboard</a></li>
                                        <li><a href="{{ route('user.profile') }} " class="profile-active"><span><img
                                                        src="{{ asset('./assets/images/Profile.png') }}"
                                                        alt=""></span>Profile</a></li>
                                        <li><a href="{{ route('user.packages') }} " class="packages-active"><span>
                                                    <img src="{{ asset('./assets/images/bx-list-plus.svg.png') }}"
                                                        alt="">
                                                </span>Buy a Package</a></li>
                                        {{-- <li><a href="{{ route('user.my-packages') }} "
                                                class="my-packages-active"><span>
                                                    <img
                                                        src="{{ asset('./assets/images/bxs-user-detail.svg.png') }}"
                                                        alt="">
                                                </span>My Packages</a></li> --}}
                                        <li><a href="{{ route('appointment') }}#main-steps-form"
                                                class="book-appointment-active"><span>
                                                    <img src="{{ asset('./assets/images/bx-list-check.svg.png') }}"
                                                        alt="">
                                                </span>Book Appointment</a></li>
                                        <li><a href="{{ route('user.calendar') }}" class="calendar-active"><span><img
                                                        src="{{ asset('./assets/images/Calendar.png') }}"
                                                        alt=""></span>Calendar</a></li>
                                        <li><a href="{{ route('user.appointment') }}"
                                                class="appointment-active"><span><img
                                                        src="{{ asset('./assets/images/Customers.png') }}"
                                                        alt=""></span>Appointments</a></li>
                                        <li><a href="{{ route('user.community') }}"><span><img
                                                        src="{{ asset('./assets/images/Customers.png') }}"
                                                        alt=""></span>Community</a></li>
                                        <li><a href="{{ route('user.video.tutorial') }}"><span><img
                                                        src="{{ asset('./assets/images/bx-play-circle.svg.png') }}"
                                                        alt=""></span>Video Tutorial</a></li>
                                    @endif

                                    @if (auth()->user()->hasRole('staff'))
                                        <li><a href="{{ route('staff.dashboard') }}"
                                                class="dashboard-active"><span><img
                                                        src="{{ asset('./assets/images/Dashboard.png') }}"
                                                        alt=""></span>Dashboard</a></li>
                                        <li><a href="{{ route('staff.profile') }}" class="profile-active"><span><img
                                                        src="{{ asset('./assets/images/Profile.png') }}"
                                                        alt=""></span>Profile</a></li>
                                        <li><a href="{{ route('staff.calendar') }}"
                                                class="calendar-active"><span><img
                                                        src="{{ asset('./assets/images/Calendar.png') }}"
                                                        alt=""></span>Calendar</a></li>
                                        <li><a href="{{ route('staff.appointment') }}"
                                                class="appointment-active"><span><img
                                                        src="{{ asset('./assets/images/Customers.png') }}"
                                                        alt=""></span>Appointments</a></li>
                                        <li><a href="{{ route('staff.community') }}"
                                                class="community-active"><span><img
                                                        src="{{ asset('./assets/images/Customers.png') }}"
                                                        alt=""></span>Community</a></li>
                                        {{-- <li><a href="{{ route('staff.google.credentials.show') }}"
                                                class="staffGoogle-active"><span><img
                                                        src="{{ asset('./assets/images/setting.png') }}"
                                                        alt=""></span>Google Credentials</a></li> --}}
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="header-logo">
                            @if (auth()->check())
                                <a
                                    href="
                                    @if (auth()->user()->hasRole('admin')) {{ route('admin.dashboard') }}
                                    @elseif (auth()->user()->hasRole('user'))
                                        {{ route('user.dashboard') }}
                                    @elseif (auth()->user()->hasRole('staff'))
                                        {{ route('staff.dashboard') }} @endif">
                                    <img src="{{ Storage::url($settings[0]->logo ?? '') }}" alt="Logo">
                                </a>
                            @else
                                <a href="{{ route('login') }}">Login</a>
                            @endif
                        </div>

                        <div class="page-relation-box">

                            <div class="align-box">
                                <p>Pages</p>
                                <p>
                                    @if (auth()->check())
                                        @if (auth()->user()->hasRole('admin'))
                                            {{ ucfirst(request()->path()) }}
                                        @elseif (auth()->user()->hasRole('user'))
                                            {{ ucfirst(request()->path()) }}
                                        @elseif (auth()->user()->hasRole('staff'))
                                            {{ ucfirst(request()->path()) }}
                                        @endif
                                    @else
                                        Guest Dashboard
                                    @endif
                                </p>
                            </div>
                            <div class="page-name">
                                <h6>
                                    @if (auth()->check())
                                        @if (auth()->user()->hasRole('admin'))
                                            Admin Dashboard
                                        @elseif (auth()->user()->hasRole('user'))
                                            User Dashboard
                                        @elseif (auth()->user()->hasRole('staff'))
                                            Staff Dashboard
                                        @endif
                                    @else
                                        Guest Dashboard
                                    @endif
                                </h6>
                            </div>
                        </div>

                        <div class="input-box-other-details">
                            <div class="logout-setting-bell-all align-items-center">
                                <div class="logout-box">
                                    <div class="notification-box-main">
                                        <a href="javascript:void(0)" id="notificationLink-box">
                                            <i class="fa fa-bell" aria-hidden="true"></i> Notifications
                                        </a>
                                        <span id="notificationCount-box">{{ $notifications->count() }}</span>
                                    </div>

                                    <div id="notification-box" style="display: none;">
                                        <div class="main-heading">
                                            <h6>New notifications</h6>
                                            <button id="mark-all-read"
                                                class="btn btn-primary @if ($notifications->count() == 0) d-none @endif">Mark
                                                All as Read</button>
                                        </div>
                                        <div class="new-notfication-box @if ($notifications->count() == 0) d-none @endif"
                                            id="new-notfication-box">
                                            @if ($notifications->count() > 0)
                                                @foreach ($notifications as $notification)
                                                    <a href="#" data-id="{{ $notification->id }}"
                                                        {{-- data-post-id="{{ $notification->data['post_id'] }}" --}}>
                                                        <h5>{{ $notification->data['title'] }}</h5>
                                                        <p>{{ $notification->data['message'] }}</p>
                                                        <p>{{ $notification->created_at->diffForHumans() }}</p>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="no-notification-box @if ($notifications->count() > 0) d-none @endif"
                                            id="no-notification-box">
                                            <i class="fa fa-bell-slash" aria-hidden="true"></i>
                                            - No new notifications -
                                        </div>
                                    </div>
                                    <a href="{{ route('home') }}"><i class="fa fa-globe"
                                            aria-hidden="true"></i>Visit
                                        Site</a>

                                    @if (auth()->user()->hasRole('user'))
                                        <a href="{{ route('user.my-packages') }}">
                                            <svg width="25" height="25" viewBox="0 0 19 19" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.6544 8.38063H16.9044V9.88063H11.6544V8.38063ZM12.4044 11.3806H16.9044V12.8806H12.4044V11.3806ZM10.9044 5.38063H16.9044V6.88063H10.9044V5.38063ZM3.40442 14.3806H10.9044V13.6306C10.9044 11.5629 9.22217 9.88063 7.15442 9.88063H5.65442C3.58667 9.88063 1.90442 11.5629 1.90442 13.6306V14.3806H3.40442ZM6.40442 9.13063C7.90067 9.13063 9.02942 8.00188 9.02942 6.50563C9.02942 5.00938 7.90067 3.88063 6.40442 3.88063C4.90817 3.88063 3.77942 5.00938 3.77942 6.50563C3.77942 8.00188 4.90817 9.13063 6.40442 9.13063Z"
                                                    fill="#9A9A9A" />
                                            </svg>
                                            My Packages</a>
                                    @endif

                                    <a href="{{ route('logout') }}"><i class="fa fa-user"
                                            aria-hidden="true"></i>Logout</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="main-box-navy">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <div class="left-all-links">
                        <ul>
                            @if (auth()->user()->hasRole('admin'))
                                <li><a href="{{ route('admin.dashboard') }}" class="dashboard-active"><span><img
                                                src="{{ asset('./assets/images/Dashboard.png') }}"
                                                alt=""></span>Dashboard</a></li>
                                <li><a href="{{ route('admin.profile') }}" class="profile-active"><span><img
                                                src="{{ asset('./assets/images/Profile.png') }}"
                                                alt=""></span>Profile</a></li>
                                <li><a href="{{ route('admin.calendar') }}" class="calendar-active"><span><img
                                                src="{{ asset('./assets/images/Calendar.png') }}"
                                                alt=""></span>Calendar</a></li>
                                <li><a href="{{ route('admin.user.packages') }} " class="packages-active"><span><img
                                    src="{{ asset('./assets/images/bxs-user-detail.svg.png') }}"
                                    alt=""></span>Packages</a></li>
                                <li><a href="{{ route('admin.appointment') }}" class="appointment-active"><span><img
                                                src="{{ asset('./assets/images/appointment.png') }}"
                                                alt=""></span>Appointments</a></li>
                                <li><a href="{{ route('admin.appointment-changes') }}"
                                        class="appointment-changes-active"><span><img
                                                    src="{{ asset('./assets/images/appointment.png') }}"
                                                    alt=""></span>Appointments Changes</a></li>
                                <li><a href="{{ route('admin.users') }}" class="users-active"><span><img
                                                src="{{ asset('./assets/images/Customers.png') }}"
                                                alt=""></span>Users</a></li>
                                <li><a href="{{ route('admin.users.restore') }}" class="restore-active"><span><img
                                                src="{{ asset('./assets/images/Customers.png') }}"
                                                alt=""></span>Restore Deleted Users</a></li>
                                <li><a href="{{ route('admin.users.session') }}"
                                        class="user-session-active"><span><img
                                                src="{{ asset('./assets/images/Customers.png') }}"
                                                alt=""></span>User Sessions</a></li>
                                <li><a href="{{ route('admin.payment') }}" class="payment-active"><span><img
                                                src="{{ asset('./assets/images/Payments.png') }}"
                                                alt=""></span>Payments</a></li>
                                <li><a href="{{ route('admin.service') }}" class="service-active"><span><img
                                                src="{{ asset('./assets/images/Services.png') }}"
                                                alt=""></span>Services</a></li>
                                <li><a href="{{ route('admin.restrict-slots') }}" class="restrict-active"><span><img
                                                src="{{ asset('./assets/images/Services.png') }}"
                                                alt=""></span>Restrict Slots</a></li>
                                <li><a href="{{ route('admin.service.assign') }}"
                                        class="service-assign-active"><span><img
                                                src="{{ asset('./assets/images/service-assign.png') }}"
                                                alt=""></span>Services Assign</a></li>
                                <li><a href="{{ route('admin.discount') }}" class="discount-active"><span><img
                                                src="{{ asset('./assets/images/service-assign.png') }}"
                                                alt=""></span>Discounts</a></li>
                                <li><a href="{{ route('admin.slot') }}" class="slots-active"><span><img
                                                src="{{ asset('./assets/images/appointment-slot.png') }}"
                                                alt=""></span>Appointment Slots</a></li>
                                <li><a href="{{ route('admin.staff') }}" class="staff-active"><span><img
                                                src="{{ asset('./assets/images/staff.png') }}"
                                                alt=""></span>Staff Members</a></li>
                                <li><a href="{{ route('admin.community') }}" class="community-active"><span><img
                                                src="{{ asset('./assets/images/Customers.png') }}"
                                                alt=""></span>Community</a></li>
                                <li><a href="{{ route('admin.blog') }}" class="blog-active"><span><img
                                                src="{{ asset('./assets/images/blog.png') }}"
                                                alt=""></span>Blogs</a></li>
                                <li><a href="{{ route('admin.subscribers') }}" class="subscribers-active"><span><img
                                                src="{{ asset('./assets/images/Profile.png') }}"
                                                alt=""></span>Subscribers</a></li>
                                <li><a href="{{ route('admin.setting') }}" class="setting-active"><span><img
                                                src="{{ asset('./assets/images/setting.png') }}"
                                                alt=""></span>Front Setting</a></li>
                                <li><a href="{{ route('admin.google-credentials.form') }}"
                                        class="google-active"><span><img
                                                src="{{ asset('./assets/images/setting.png') }}"
                                                alt=""></span>Google Credentials</a></li>
                            @endif
                            @if (auth()->user()->hasRole('user'))
                                <li><a href="{{ route('user.dashboard') }}" class="dashboard-active"><span><img
                                                src="{{ asset('./assets/images/Dashboard.png') }}"
                                                alt=""></span>Dashboard</a></li>
                                <li><a href="{{ route('user.profile') }} " class="profile-active"><span><img
                                                src="{{ asset('./assets/images/Profile.png') }}"
                                                alt=""></span>Profile</a></li>
                                <li><a href="{{ route('user.packages') }} " class="packages-active"><span>
                                            <img src="{{ asset('./assets/images/bx-list-plus.svg.png') }}"
                                                alt="">

                                        </span>Buy a Package</a></li>
                                {{-- <li><a href="{{ route('user.my-packages') }} " class="my-packages-active"><span>
                                    <img
                                    src="{{ asset('./assets/images/bxs-user-detail.svg.png') }}"
                                    alt="">
                                        </span>My Packages</a></li> --}}
                                <li><a href="{{ route('appointment') }}#main-steps-form"
                                        class="book-appointment-active"><span>
                                            <img src="{{ asset('./assets/images/bx-list-check.svg.png') }}"
                                                alt="">
                                        </span>Book Appointment</a></li>
                                <li><a href="{{ route('user.calendar') }}" class="calendar-active"><span><img
                                                src="{{ asset('./assets/images/Calendar.png') }}"
                                                alt=""></span>Calendar</a></li>
                                <li><a href="{{ route('user.appointment') }}" class="appointment-active"><span><img
                                                src="{{ asset('./assets/images/Customers.png') }}"
                                                alt=""></span>Appointments</a></li>
                                <li><a href="{{ route('user.community') }}"><span><img
                                                src="{{ asset('./assets/images/Customers.png') }}"
                                                alt=""></span>Community</a></li>
                                <li><a href="{{ route('user.video.tutorial') }}"><span><img
                                                src="{{ asset('./assets/images/bx-play-circle.svg.png') }}"
                                                alt=""></span>Video Tutorial</a></li>
                            @endif

                            @if (auth()->user()->hasRole('staff'))
                                <li><a href="{{ route('staff.dashboard') }}" class="dashboard-active"><span><img
                                                src="{{ asset('./assets/images/Dashboard.png') }}"
                                                alt=""></span>Dashboard</a></li>
                                <li><a href="{{ route('staff.profile') }}" class="profile-active"><span><img
                                                src="{{ asset('./assets/images/Profile.png') }}"
                                                alt=""></span>Profile</a></li>
                                <li><a href="{{ route('staff.calendar') }}" class="calendar-active"><span><img
                                                src="{{ asset('./assets/images/Calendar.png') }}"
                                                alt=""></span>Calendar</a></li>
                                <li><a href="{{ route('staff.appointment') }}" class="appointment-active"><span><img
                                                src="{{ asset('./assets/images/Customers.png') }}"
                                                alt=""></span>Appointments</a></li>
                                <li><a href="{{ route('staff.community') }}" class="community-active"><span><img
                                                src="{{ asset('./assets/images/Customers.png') }}"
                                                alt=""></span>Community</a></li>
                                {{-- <li><a href="{{ route('staff.google.credentials.show') }}"
                                        class="staffGoogle-active"><span><img
                                                src="{{ asset('./assets/images/setting.png') }}"
                                                alt=""></span>Google Credentials</a></li> --}}
                            @endif
                        </ul>
                    </div>
                </div>

                @yield('content')

            </div>
        </div>
    </section>

    <script>
        function hideTextInAnchors() {
            // Select all anchor tags within the specified class
            const anchors = document.querySelectorAll(
                '.header .header-two-things-align .input-box-other-details .logout-setting-bell-all .logout-box a');

            // Get the current viewport width
            const viewportWidth = window.innerWidth;

            // Loop through each anchor
            anchors.forEach(anchor => {
                // If viewport is 991px or less, hide the text
                if (viewportWidth <= 991) {
                    // Hide the text by setting it to an empty string
                    anchor.childNodes.forEach(node => {
                        if (node.nodeType === Node.TEXT_NODE) {
                            node.textContent = ''; // Remove the text content
                        }
                    });
                } else {
                    // Restore the text content if needed (if you know the text)
                    // Uncomment and replace 'Logout' with the actual text if you need to restore it
                    // anchor.textContent = 'Logout'; // Restore original text if necessary
                }
            });
        }

        // Run on DOMContentLoaded
        document.addEventListener('DOMContentLoaded', hideTextInAnchors);

        // Add event listener for window resize
        window.addEventListener('resize', hideTextInAnchors);


        document.querySelectorAll('.main-box-navy .col-lg-2').forEach(function(col2) {
            // Create a div to wrap the button
            let buttonWrapper = document.createElement('div');
            buttonWrapper.classList.add('button-wrapper'); // Add a custom class to the wrapper div

            // Create the button
            let button = document.createElement('button');
            button.innerHTML = '<i class="fa fa-angle-right" aria-hidden="true"></i>'; // Add icon instead of text
            button.classList.add('resize-btn'); // Add a custom class to the button

            // Append button inside the wrapper div
            buttonWrapper.appendChild(button);

            // Prepend the wrapper div inside the .col-lg-2 (insert at the top)
            col2.insertBefore(buttonWrapper, col2.firstChild);

            // Add event listener to button
            button.addEventListener('click', function() {
                let col10 = col2.nextElementSibling; // Assuming .col-lg-10 is next to .col-lg-2

                // Toggle logic for resizing
                if (col2.classList.contains('col-lg-2')) {
                    // If currently col-lg-2, change to col-lg-1, col-md-1, col-1, and add 'resized' class
                    col2.classList.remove('col-lg-2', 'col-md-2', 'col-2');
                    col2.classList.add('col-lg-1', 'col-md-1', 'col-1', 'resized'); // Add 'resized' class

                    if (col10 && col10.classList.contains('col-lg-10')) {
                        col10.classList.remove('col-lg-10', 'col-md-10', 'col-10');
                        col10.classList.add('col-lg-11', 'col-md-11', 'col-11',
                            'resized'); // Add 'resized' class to col-lg-11 and col-md-11
                    }
                } else {
                    // If currently col-lg-1, change back to col-lg-2, col-md-2, col-2, and remove 'resized' class
                    col2.classList.remove('col-lg-1', 'col-md-1', 'col-1',
                        'resized'); // Remove 'resized' class
                    col2.classList.add('col-lg-2', 'col-md-2', 'col-2'); // Add col-2

                    if (col10 && col10.classList.contains('col-lg-11')) {
                        col10.classList.remove('col-lg-11', 'col-md-11', 'col-11',
                            'resized'); // Remove 'resized' class from col-lg-11 and col-md-11
                        col10.classList.add('col-lg-10', 'col-md-10', 'col-10'); // Add col-10
                    }
                }
            });
        });
    </script>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>



    <script>
        $(document).ready(function() {

            Pusher.logToConsole = false;

            var pusher = new Pusher('3af0341c542582fe2550', {
                cluster: "ap2",
                encrypted: false,
                useTls: true,
            });

            var channel = pusher.subscribe('post-notification-channel');

            channel.bind('post-notification', function(data) {
                $.ajax({
                    url: "{{ route('user.get-notification') }}",
                    type: "GET",
                    success: function(response) {
                        $("#no-notification-box").addClass("d-none");
                        $("#new-notfication-box").removeClass("d-none");

                        $("#notificationCount-box").text(response.count);
                        $("#new-notfication-box").empty();

                        $("#mark-all-read").removeClass("d-none");

                        response.notifications.forEach(function(notification) {
                            $("#new-notfication-box").append(
                                `
                                <a href="#" data-id="${notification.id}" data-post-id="${notification.data['post_id']}">
                                    <h5>${notification.data['title']}</h5>
                                    <p>${notification.data['message']}</p>
                                    <p>${timeAgo(notification.created_at)}</p>
                                </a>`
                            );
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $(document).on('click', '#new-notfication-box a', function(event) {
                event.preventDefault();

                const notificationId = $(this).data('id');
                const postId = $(this).data('post-id');

                $.ajax({
                    url: '/mark-notification-read/' +
                        notificationId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: notificationId
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error marking notification as read:', xhr);
                    }
                });
            });

            $('#mark-all-read').on('click', function() {
                $.ajax({
                    url: '/mark-all-notifications-read',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#new-notfication-box').addClass('d-none');
                        $('#no-notification-box').removeClass('d-none');
                        $("#mark-all-read").addClass("d-none");
                        toastr.success('All notifications marked as read.');
                        $("#notificationCount-box").text(0);
                    },
                    error: function(xhr) {
                        console.error('Error marking all notifications as read:', xhr);
                    }
                });
            });

            function timeAgo(timestamp) {
                const now = new Date();
                const date = new Date(timestamp);
                const seconds = Math.floor((now - date) / 1000);

                let interval = Math.floor(seconds / 31536000);
                if (interval > 1) return `${interval} years ago`;
                interval = Math.floor(seconds / 2592000);
                if (interval > 1) return `${interval} months ago`;
                interval = Math.floor(seconds / 86400);
                if (interval > 1) return `${interval} days ago`;
                interval = Math.floor(seconds / 3600);
                if (interval > 1) return `${interval} hours ago`;
                interval = Math.floor(seconds / 60);
                if (interval > 1) return `${interval} minutes ago`;
                return `${seconds} seconds ago`;
            }

            $('#notificationLink-box').on('click', function(e) {
                e.preventDefault();
                $('#notification-box').toggle();
            });

            $(document).on('click', function(e) {
                var target = $(e.target);
                if (!target.closest('#notification-box').length && !target.closest('#notificationLink-box')
                    .length) {
                    $('#notification-box').hide();
                }
            });
        });
    </script>
</body>

</html>
