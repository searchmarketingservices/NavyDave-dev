@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.restrict-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.restrict-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.restrict-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }

    .dt-buttons {
        margin-bottom: 15px;
    }

    .dt-buttons button.dt-button {
        background-color: #48bb78 !important;
        font-size: 14px !important;
        color: white !important;
        padding: 10px 20px !important;
        border-radius: 15px !important;
        transition: .3s !important;
        border: none !important;
    }

    .dt-buttons button.dt-button:hover {
        background-color: black !important;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        height: 40px !important;
        border: 1px solid #00000040 !important;
        border-radius: 15px !important;
        padding: 10px !important;
        font-size: 12px !important;
        color: #CACACA !important;
        background-color: white !important;
        max-width: 250px !important;
        width: 250px !important;
        padding-left: 30px !important;
    }
</style>
@section('content')
    <div class="col-lg-10">
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session()->get('success') }}</div>
        @endif
        <div class="main-calendar-box main-calendar-box-list customers-box mt-0 mb-0">
            <div class="two-things-align">
                <h5>Restrict Slots</h5>
                <button type="button" id="addUser" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Add Restrict Slots
                </button>
            </div>
        </div>
        <div class="main-table-box main-table-box-list services-table">
            <table class="table table-striped" id="Table1">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="Table">
                    <!-- Rows will be inserted here using Ajax -->
                </tbody>
            </table>

        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="saveData" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Restrict Slots</h5>
                        <button type="button" class="close" data-dismiss="modal" id="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="date">Select Date:</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="saveData()" id="createStaff">Save</button>
                        <button type="button" id="cancel2" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editData" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Update Restrict Slots</h5>
                        <button type="button" class="close" data-dismiss="modal" id="close3" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="editId" name="id">
                        <div class="form-group">
                            <label for="date">Select Date:</label>
                            <input type="date" class="form-control" id="editDate" name="date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="editData()" id="createStaff">Save</button>
                        <button type="button" id="cancel3" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $("#addUser").click(function() {
            $("#exampleModal").modal("show");
        });
        $("#close, #cancel2").click(function() {
            $("#exampleModal").modal("hide");
        });
        $("#close3, #cancel3").click(function() {
            $("#editModal").modal("hide");
        });

        function formatTime(timeString) {
            const [hour, minute] = timeString.split(':');
            let hours = parseInt(hour);
            let ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12 || 12; // convert 24-hour format to 12-hour format
            return `${hours}:${minute} ${ampm}`;
        }

        function formatDate(inputDate) {
            // Split the input date to handle it as a local date
            const [year, month, day] = inputDate.split(" ")[0].split("-");
            
            // Format the date as mm/dd/yyyy
            return `${month}/${day}/${year}`;
        }


        function getData() {
            $.ajax({
                url: "{{ route('admin.restrict_slots.get') }}",
                type: "get",
                success: function(response) {
                    $("#Table").empty();
                    const sortedData = response.data.sort((a, b) => b.id - a.id);

                    sortedData.forEach(element => {
                        $('#Table').append(`
                            <tr>
                                <td class="text-center">${element.id}</td>
                                <td class="text-center">${formatDate(element.date)}</td>
                                <td class="text-center">
                                    <div class="action-box mt-2">
                                        <ul class="d-flex justify-content-center alidn-items-center">
                                            <li><a onclick="showEditModal(${element.id})"><img src="{{ asset('assets/images/pencil.png') }}" alt=""></a></li>
                                            <li><a onclick="deleteData(${element.id})"><img src="{{ asset('assets/images/delete.png') }}" alt=""></a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        `);
                    });

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function deleteData(id) {
            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with deletion if confirmed
                    $.ajax({
                        url: "{{ route('admin.restrict_slot.delete', ':id') }}".replace(':id', id),
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your record has been deleted.',
                                'success'
                            );
                            getData(); // Refresh data after deletion
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'An error occurred. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        }


        function showEditModal(id) {
            var url = "{{ route('admin.restrict_slot.edit', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                method: "GET",
                success: function(data) {
                    // Populate the modal with user data
                    $("#editId").val(data.data.id);
                    $("#editDate").val(data.data.date);

                    // Show the modal
                    $("#editModal").modal("show");
                },
                error: function(xhr, status, error) {
                    toastr.error("An error occurred. Please try again.");
                }
            });
        }


        function saveData() {
            var date = $("#date").val();
            // Create FormData to handle file upload
            var formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("date", date);

            $.ajax({
                type: "POST",
                url: "{{ route('admin.restrict_slot.store') }}",
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Set content type to false to let the browser set it
                success: function(data) {
                    $("#exampleModal").modal("hide");
                    toastr.success("Restrict Slot added successfully");
                    getData();
                    $("#date").val('')
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // Laravel validation error
                        $("#date").val('')
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]); // Display each error message using Toastr
                        });
                    } else {
                        toastr.error("An error occurred. Please try again.");
                    }
                }
            });
        }

        function editData() {
            var id = $("#editId").val();
            var date = $("#editDate").val();
            // Create FormData to handle file upload
            var formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("id", id);
            formData.append("date", date);

            $.ajax({
                type: "POST",
                url: "{{ route('admin.restrict_slot.update') }}",
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Set content type to false to let the browser set it
                success: function(data) {
                    $("#editModal").modal("hide");
                    toastr.success("Restrict Slot Updated successfully!");
                    getData();
                    $("#editId").val('');
                    $("#editDate").val('');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]); // Display each error message using Toastr
                        });
                    } else {
                        toastr.error("An error occurred. Please try again.");
                    }
                }
            });
        }

        $(document).ready(function() {
            getData();

            setTimeout(function() {
                $("#Table1").DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copy',
                            text: 'Copy Data',
                            className: 't-btn'
                        },
                        {
                            extend: 'csv',
                            text: 'Export to CSV',
                            className: 't-btn'
                        },
                        {
                            extend: 'excel',
                            text: 'Export to Excel',
                            className: 't-btn'
                        },
                        {
                            extend: 'pdf',
                            text: 'Export to PDF',
                            className: 't-btn'
                        },
                        {
                            extend: 'print',
                            text: 'Print Table',
                            className: 't-btn'
                        }
                    ],
                    "order": [
                        [0, "desc"]
                    ]
                });
            }, 1000);


        });
    </script>
@endsection
