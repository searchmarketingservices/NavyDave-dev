@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.service-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.service-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.service-active span img,
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
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="two-things-align">
                <h5>Services Management</h5>
                <a href="{{ route('admin.service.create') }}" class="t-btn">
                    Add Service
                </a>
            </div>
        </div>
        <div class="main-table-box main-table-box-list services-table">
            <table id="servicesTable" class="display">
                <thead>
                    <tr>
                        <th>
                            <div class="align-box">
                                <div class="input-box-check">
                                    <input type="checkbox">
                                </div>
                                <p>ID</p>
                            </div>
                        </th>
                        <th>Image</th>
                        <th>Service Name</th>
                        <th>Category</th>
                        <th>Duration</th>
                        <th>Sessions</th>
                        <th>Type Duration</th>
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
                url: "{{ route('admin.service.show') }}", // Update with the correct route
                type: "GET",
                dataType: "json",
                dataSrc: "services"
            },
            columns: [{
                    data: null,
                    render: function(data, type, row) {
                        return `<div class="align-box">
                                <div class="input-box-check">
                                    <input type="checkbox">
                                </div>
                                <p>${data.id}</p>
                            </div>`;
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
                    data: 'category',
                    render: function(data) {
                        return data.name; // Ensure this matches your data structure
                    }
                },
                {
                    data: 'duration'
                },
                {
                    data: 'slots'
                },
                {
                    data: 'type_duration'
                },
                {
                    data: 'price',
                    render: function(data) {
                        return `$${data}`;
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `<div class="action-box">
                            <ul>
                                <li><a href="/admin/service/${data}/edit"><img src="/assets/images/pencil.png" alt=""></a></li>
                                <li><button onclick="deleteService(${data})"><img src="/assets/images/delete.png" alt=""></button></li>
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
                    title: 'Services List'
                }
            ]

        });
    }


    function deleteService(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to Delete this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.service.destroy', '') }}/" + id,
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        $('#servicesTable').DataTable().ajax.reload();
                        $('#servicesTable').DataTable().clear();
                        $('#servicesTable').DataTable().destroy();
                        showTable();
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                'Staff deleted successfully.',
                                'success'
                            );
                            toastr.success('Staff deleted successfully!');
                        } else {
                            toastr.error('Failed to delete staff. Please try again.');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred while trying to delete the staff.');
                        console.error('Error:', error);
                    }
                });
            }
        });
    }
</script>
