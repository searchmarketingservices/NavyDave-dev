@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.packages-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.packages-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.packages-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }

    .main-box-navy .left-all-links ul li a.packages-active path, .main-box-navy .left-all-links ul li a:hover path{
        fill:#ffffff;
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

    div#servicesTable_wrapper .dt-buttons button.dt-button.buttons-pdf.buttons-html5.t-btn {
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 15px;
        transition: .3s;
        background-color: #7a7a7a6b;
        border: 1px solid #7A7A7A;
        color: #7A7A7A;
    }

    div#servicesTable_wrapper .dt-buttons button.dt-button.buttons-pdf.buttons-html5.t-btn:hover {
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
                <h5>Packages</h5>
            </div>
        </div>
        <div class="main-table-box main-table-box-list services-table">
            <table id="servicesTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Package Name</th>
                        <th>Sessions</th>
                        <th>Discount</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated here -->
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
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script> --}}

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

<script>
    $(document).ready(function() {
        showTable();
    });
    showTable();

    function showTable() {
        $('#servicesTable').DataTable({
            ajax: {
                url: "{{ route('user.packages.show') }}", // Update with the correct route
                type: "GET",
                dataType: "json",
                dataSrc: "services"
            },
            columns: [{
                    data: null,
                    render: function(data, type, row) {
                        return `<p class="text-center">${data.id}</p>`;
                    }
                },
                {
                    data: 'image',
                    render: function(data) {
                        return `<img src="{{ Storage::url('${data}') }}" alt="" width="100" height="100">`;
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: 'slots'
                },
                // {
                //     data: 'price',
                //     render: function(data) {
                //         return `$${data}`;
                //     }
                // },
                {
                    data: 'discount',
                    render: function(data) {
                        if (data != 0) {
                            return `${data}%`;
                        }else{
                            return 'N/A';
                        }
                    }
                },
                {
                data: 'price',
                    render: function(data, type, row) {
                        if (row.original_price && row.original_price > data) {
                            return `
                                <div>
                                    <small style="text-decoration: line-through; color: red;">$${row.original_price}</small>
                                    <span>$${data}</span>
                                </div>
                            `;
                        } else {
                            return `$${data}`;
                        }
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `<div class="action-box">
                            <ul>
                                <form action="{{ route('user.package.buy') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="${data}">
                                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                    <button type="submit" class="btn btn-success">Buy Package</button>
                                </form>
                            </ul>
                        </div>`;
                    }
                }
            ],
            dom: 'Bfrtip', // Add the Buttons extension
            buttons: [{
                    extend: 'excelHtml5',
                    text: 'Export Excel',
                    title: 'Services List',
                    className: 't-btn',
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Export PDF',
                    title: 'Services List',
                    className: 't-btn',
                }
            ]

        });
    }
</script>
