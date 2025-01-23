@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.setting-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.setting-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.setting-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
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
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="two-things-align">
                <h5>Front Settings</h5>
                {{-- <a href="{{ route('admin.setting.create') }}" class="t-btn">
                    Add Settings
                </a> --}}
            </div>
        </div>
        <div class="main-table-box main-table-box-list services-table table-responsive">
            <table id="settingTable" class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th>Logo</th>
                        <th>App Name</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Email</th>
                        <th>@ Copyright</th>
                        <th>Facebook Link</th>
                        <th>Twitter Link</th>
                        <th>Instagram Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($settings as $item)
                        <tr>
                            <td>{{ $item->id ?? '' }}</td>
                            <td><img src="{{ Storage::url($item->logo) ?? '' }} " width="100%" height="auto"
                                    alt=""></td>
                            <td>{{ $item->app_name ?? '' }}</td>
                            <td>{{ $item->phone ?? '' }}</td>
                            <td>{{ $item->location ?? '' }}</td>
                            <td>{{ $item->email ?? '' }}</td>
                            <td>{{ $item->copyright ?? '' }}</td>
                            <td>{{ $item->facebook_link ?? '' }}</td>
                            <td>{{ $item->twitter_link ?? '' }}</td>
                            <td>{{ $item->instagram_link ?? '' }}</td>
                            <td><a href="{{ route('admin.setting.edit', $item->id) }}" class="t-btn"><img
                                        src="{{ asset('assets/images/pencil.png') }}" alt=""></a></td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>

<script type="text/javascript">
    $(document).on('ready', function() {
        wow = new WOW({
            animateClass: 'animated',
            offset: 100,
            callback: function(box) {
                console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
            }
        });

        wow.init();
    });
</script>
