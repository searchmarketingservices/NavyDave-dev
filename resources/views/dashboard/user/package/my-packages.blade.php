@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.my-packages-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.my-packages-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.my-packages-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }

    .main-box-navy .left-all-links ul li a.my-packages-active path,
    .main-box-navy .left-all-links ul li a:hover path {
        fill: #ffffff;
        transition: .3s;
    }

    div#servicesTable_wrapper .dt-buttons button.dt-button.buttons-excel.buttons-html5.t-btn {
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 15px;
        transition: .3s;
        background-color: #7a7a7a6b;
        border: 1px solid #7A7A7A;
        color: #7A7A7A;
    }

    div#servicesTable_wrapper .dt-buttons button.dt-button.buttons-excel.buttons-html5.t-btn:hover {
        background-color: #50bc7a;
        color: white;
        border-color: #50bc7a;
    }
</style>
@section('content')
    <div class="col-lg-10">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="two-things-align">
                <h5>My Packages</h5>
            </div>
        </div>
        <div class="main-table-box main-table-box-list services-table">
            <table id="servicesTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Package Name</th>
                        <th>Sessions</th>
                        <th>Remaining Sessions</th>
                        <th>Used Sessions</th>
                        <th>Source</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $package)
                        <tr>
                            <td>{{ $package['package_id'] }}</td>
                            <td>{{ $package['service_name'] }}</td>
                            <td>{{ $package['sessions'] }}</td>
                            <td>{{ $package['sessions'] - $package['used_sessions'] }}</td>
                            <td>{{ $package['used_sessions'] }}</td>
                            <td>{{ $package['is_free'] == 1 ? 'Granted' : 'Purchased' }}</td>
                            <td>
                                <span
                                    class="badge mt-1 {{ $package['status'] == 'active' ? 'bg-success' : 'bg-danger' }}">{{ $package['status'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<!-- Corrected script tags and loading jQuery once -->
<script src="{{ asset('./assets/js/wow-animate.js') }}"></script>
<script src="{{ asset('./assets/js/lib.js') }}"></script>
<script src="{{ asset('./assets/js/custom.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>

<script>
    $(document).ready(function() {

    });
</script>
