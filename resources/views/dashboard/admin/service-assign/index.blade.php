@extends('dashboard.layouts.master')



<style>
    .main-box-navy .left-all-links ul li a.service-assign-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.service-assign-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.service-assign-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }

    div#servicesAssign_wrapper .dt-buttons button.dt-button.buttons-excel.buttons-html5.t-btn {
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 15px;
        transition: .3s;
        background-color: #7a7a7a6b;
        border: 1px solid #7A7A7A;
        color: #7A7A7A;
    }

    div#servicesAssign_wrapper .dt-buttons button.dt-button.buttons-excel.buttons-html5.t-btn:hover {
        background-color: #50bc7a;
        color: white;
        border-color: #50bc7a;
    }

    span.select2-dropdown.select2-dropdown--below {
    z-index: 999999999999999 !important;
}

</style>


<!-- Include select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Custom styles for select2 */
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        padding: 5px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .select2-container {
        width: 100% !important;
    }
    .select2-dropdown {
        z-index: 99999 !important;
    }
    .select2-dropdown--below {
        z-index: 99999 !important;
    }

</style>

@section('content')
    <div class="col-lg-10">
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="two-things-align">
                <h5>Services Assign</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="addService()" data-target="#assignService">
                    Add Service
                </button>
            </div>
            <div class="three-things-align services-box">
                <div class="main-search-form">
                    <form action="">
                        <div class="form-align-box">


                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="main-table-box main-table-box-list services-table">
            <table id="servicesAssign" class="display">
                <thead>
                    <tr>
                        <th> ID</th>
                        <th>Staff</th>
                        <th>Service Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated here -->
                </tbody>
            </table>
        </div>

    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="assignService" tabindex="-1" role="dialog" aria-labelledby="assignServiceLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="saveStaff" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Assign Service</h5>
                        <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <div class="form-group">
                            <select class="form-control" name="staff" id="staff">
                                <option selected disabled>Select Staff</option>
                                <!-- Other options -->
                                @foreach ($staff as $sta)
                                    <option value="{{ $sta->id }}">{{ $sta->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="services">Select services:</label>
                        <select name="service_ids[]" id="services" class="form-control" multiple="multiple">
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"> {{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="assignService()" id="createStaff">Assign
                            Service</button>
                        <button type="button" class="btn btn-secondary" id="close2" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


    $(document).ready(function() {
        $('#services').select2();
        showTable();
        $("#close , #close2").on("click", function(){
            $("#assignService").modal('hide');
        });
    });

    function addService() {
        $('#assignService').modal('show');
    }

    function showTable() {
        $.ajax({
            url: "{{ route('admin.service.assign.show') }}",
            type: "GET",
            dataType: "json",
            success: function(response) {
                let groupedData = {};
                // response.services.forEach(function(item) {
                //     if (!groupedData[item.staff_id]) {
                //         groupedData[item.staff_id] = {
                //             id: item.staff.id,
                //             staff_name: item.staff.user.name,
                //             services: []
                //         };
                //     }
                //     console.log(item);
                //     if(item.service == null){
                //         item.service = {
                //             name: 'No Service'
                //         };
                //     }
                //     groupedData[item.staff_id].services.push(item.service.name);
                // });
                response.services.forEach(function(item) {
    if (item.staff && !groupedData[item.staff_id]) {
        groupedData[item.staff_id] = {
            id: item.staff.id,
            staff_name: item.staff.user.name,
            services: []
        };
    }
    if (item.service == null) {
        item.service = { name: 'No Service' };
    }
    if (item.staff) {
        groupedData[item.staff_id].services.push(item.service.name);
    }
});


                // Convert grouped data to an array
                let tableData = Object.keys(groupedData).map(key => {
                    return {
                        id: groupedData[key].id,
                        staff_name: groupedData[key].staff_name,
                        services: groupedData[key].services.join(', ')
                    };
                });
                $('#servicesAssign').DataTable({
                    destroy: true,
                    data: tableData,
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'staff_name'
                        },
                        {
                            data: 'services'
                        },
                        {
                            data: 'id',
                            render: function(data, type, row) {
                                return `<div class="action-box">
                                <ul>
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
        });
    }



    function deleteService(id) {
        console.log(id);
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
                    url: "{{ route('admin.service.assign.destroy', '') }}/" + id,
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        $("servicesAssign").DataTable({
                            destroy: true
                        });
                        showTable();
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                'Staff deleted successfully.',
                                'success'
                            );
                            showTable();
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



    function assignService() {
        let formData = new FormData(document.getElementById('saveStaff'));

        $.ajax({
            url: '{{ route('admin.service.assign.store') }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $("servicesAssign").DataTable({
                        destroy: true
                    });

                    Swal.fire(
                        'Created!',
                        'Staff Created successfully.',
                        'success'
                    );
                    showTable();
                    $('#assignService').hide();
                    $('.modal-backdrop').hide();
                    $('#saveStaff').trigger("reset");
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                // Handle validation errors and display them
            }
        });
    }

</script>
