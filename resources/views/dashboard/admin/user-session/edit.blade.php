@extends('dashboard.layouts.master')

<style>
    .form-box form select {
        height: 50px;
        border-radius: 10px;
        width: 100%;
        border: 1px solid #0000003d;
        color: black;
        padding: 10px;
        font-size: 14px;
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
                    <form action="{{ route('admin.users.session.assign.set', ['id' => $user->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="text" placeholder="Full Name" value="{{ $user->name }}" name="name">
                        <input type="email" placeholder="Type Your Email" value="{{ $user->email }}" name="email">
                        <select name="service" id="service">
                            <option selected disabled>Select Package</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" data-isAdmin="{{ $service->is_admin }}"
                                    data-slots="{{ $service->slots }}">{{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="staff" id="staff">
                            <option selected disabled>Select Staff</option>
                            @foreach ($staff as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->user->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" placeholder="Sessions" id="session" readonly name="sessions">
                        <button type="submit">Set Session</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $("#service").on("change", function() {
            var isAdmin = $(this).find(":selected").data("isadmin");
            var slots = $(this).find(":selected").data("slots");

            if (isAdmin == 1) {
                $("#session").attr("readonly", false); // Allow editing
                $("#session").val(slots);
            } else {
                $("#session").attr("readonly", true); // Prevent editing
                $("#session").val(slots); // Set slots value if not admin
            }
        });
    </script>
@endsection
