@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.discount-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.discount-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.discount-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }
</style>
</head>
@section('content')
    <div class="col-lg-10">
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="two-things-align" bis_skin_checked="1">
                <h5>Discounts</h5>
                <button type="button" class="btn btn-primary" id="addDiscountBtn">
                    Add Discount
                </button>
            </div>
        </div>
        <div class="main-table-box main-table-box-list services-table">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Package</th>
                        <th>Discount %</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="myTableBody">
                    {{-- -- Rows will be inserted here -- --}}
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="addDiscountModal" tabindex="-1" role="dialog" aria-labelledby="addDiscountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="saveData" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDiscountModalLabel">Add Discount</h5>
                        <button type="button" class="close" data-dismiss="modal" id="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="date">Select Package:</label>
                            <select name="service_id" id="service_id" class="form-control">
                                <option selected disabled>Select Package</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date">Select Discount %:</label>
                            <input type="number" class="form-control" id="percentage" name="percentage">
                        </div>
                        <div class="form-group">
                            <label for="date">Select Start Date:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>
                        <div class="form-group">
                            <label for="date">Select End Date:</label>
                            <input type="date" class="form-control" id="expired_date" name="expired_date">
                        </div>
                        <div class="form-group">
                            <label for="date">Select Status:</label>
                            <select name="status" id="status" class="form-control">
                                <option selected disabled>Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Expired</option>
                            </select>
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

    <div class="modal fade" id="editDiscountModal" tabindex="-1" role="dialog" aria-labelledby="editDiscountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="updateData" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDiscountModalLabel">Update Discount</h5>
                        <button type="button" class="close" data-dismiss="modal" id="close3" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="editId" name="id">
                        <div class="form-group">
                            <label for="date">Select Package:</label>
                            <select name="service_id" id="editServiceId" class="form-control">
                                <option selected disabled>Select Package</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date">Select Discount %:</label>
                            <input type="number" class="form-control" id="editPercentage" name="percentage">
                        </div>
                        <div class="form-group">
                            <label for="date">Select Start Date:</label>
                            <input type="date" class="form-control" id="editStartDate" name="start_date">
                        </div>
                        <div class="form-group">
                            <label for="date">Select End Date:</label>
                            <input type="date" class="form-control" id="editExpiredDate" name="expired_date">
                        </div>
                        <div class="form-group">
                            <label for="date">Select Status:</label>
                            <select name="status" id="editStatus" class="form-control">
                                <option selected disabled>Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Expired</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="updateData()"
                            id="updateStaff">Update</button>
                        <button type="button" id="cancel3" class="btn btn-secondary"
                            data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).on('click', '#addDiscountBtn', function() {
        $("#addDiscountModal").modal("show");
    });

    $(document).on('click', '#close', function() {
        $("#addDiscountModal").modal("hide");
    });

    $(document).on('click', '#cancel2', function() {
        $("#addDiscountModal").modal("hide");
    });

    $(document).on('click', '#close3', function() {
        $("#editDiscountModal").modal("hide");
    });

    $(document).on('click', '#cancel3', function() {
        $("#editDiscountModal").modal("hide");
    });

    function formatDate(inputDate) {
        // Split the input date to handle it as a local date
        const [year, month, day] = inputDate.split(" ")[0].split("-");
        
        // Format the date as mm/dd/yyyy
        return `${month}/${day}/${year}`;
    }

    function getData() {
        $.ajax({
            url: "{{ route('admin.discount.get') }}",
            type: "GET",
            success: function(response) {
                let table = $('#myTable').DataTable();
                table.clear(); // Clear existing data
                response.discounts.forEach(discount => {
                    table.row.add([
                        discount.id,
                        discount.service.name,
                        discount.percentage,
                        formatDate(discount.start_date),
                        formatDate(discount.expired_date),
                        discount.status == 1 ? 'Active' : 'Expired',
                        `<div class="action-box">
                        <a href="#" class="edit"><img src="{{ asset('assets/images/pencil.png') }}" alt=""></a>
                        <a href="#" class="delete"><img src="{{ asset('assets/images/delete.png') }}" alt=""></a>
                     </div>`
                    ]).draw();
                });
            },
            error: function(xhr) {
                toastr.error("Failed to load data.");
            }
        });
    }

    // Duplicate href
    // <a href="#" class="duplicate"><img src="{{ asset('assets/images/duplicate.png') }}" alt=""></a>



    function saveData() {
        // Disable the button to prevent multiple submissions and indicate saving
        $("#createStaff").prop("disabled", true).text("Saving...");

        // Clear previous error messages and invalid classes
        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").remove();

        $.ajax({
            url: "{{ route('admin.discount.store') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                service_id: $('#service_id').val(),
                percentage: $('#percentage').val(),
                start_date: $('#start_date').val(),
                expired_date: $('#expired_date').val(),
                status: $('#status').val(),
            },
            success: function(response) {
                if (response.success === true) {
                    // Reset form inputs
                    $("#service_id").val('');
                    $("#percentage").val('');
                    $("#start_date").val('');
                    $("#expired_date").val('');
                    $("#status").val('');

                    // Close the modal, display success, and refresh data
                    $("#addDiscountModal").modal("hide");
                    toastr.success(response.message);
                    getData();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        // Add Bootstrap's invalid class and display error message
                        let field = $(`#${key}`);
                        field.addClass("is-invalid");
                        field.siblings(".invalid-feedback").remove(); // Remove old errors
                        field.after(
                            `<div class="invalid-feedback">${value[0]}</div>`); // Show error
                        toastr.error(value[0]); // Show error in toastr
                    });
                } else {
                    console.log("Error Response:", xhr);
                    toastr.error("An error occurred. Please try again.");
                }
            },
            complete: function() {
                // Re-enable the button after the request
                $("#createStaff").prop("disabled", false).text("Save");
            }
        });
    }

    function updateData() {
        // Disable the button to prevent multiple submissions and indicate saving
        $("#updateStaff").prop("disabled", true).text("Saving...");

        // Clear previous error messages and invalid classes    
        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").remove();

        $.ajax({
            url: "{{ route('admin.discount.update') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: $('#editId').val(),
                service_id: $('#editServiceId').val(),
                percentage: $('#editPercentage').val(),
                start_date: $('#editStartDate').val(),
                expired_date: $('#editExpiredDate').val(),
                status: $('#editStatus').val(),
            },
            success: function(response) {
                if (response.success === true) {
                    // Close the modal, display success, and refresh data
                    $("#editDiscountModal").modal("hide");
                    toastr.success(response.message);
                    getData();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        // Add Bootstrap's invalid class and display error message
                        let field = $(`#${key}`);
                        field.addClass("is-invalid");
                        field.siblings(".invalid-feedback").remove(); // Remove old errors
                        field.after(
                            `<div class="invalid-feedback">${value[0]}</div>`); // Show error
                        toastr.error(value[0]); // Show error in toastr
                    });
                } else {
                    console.log("Error Response:", xhr);
                    toastr.error("An error occurred. Please try again.");
                }
            },
            complete: function() {
                // Re-enable the button after the request
                $("#updateStaff").prop("disabled", false).text("Save");
            }
        });
    }

    $(document).on('click', '.edit', function() {
        var id = $(this).closest('tr').find('td').eq(0).text();
        var serviceName = $(this).closest('tr').find('td').eq(1).text();
        var percentage = $(this).closest('tr').find('td').eq(2).text();
        var start_date = $(this).closest('tr').find('td').eq(3).text();
        var expired_date = $(this).closest('tr').find('td').eq(4).text();
        var status = $(this).closest('tr').find('td').eq(5).text() === 'Active' ? 1 : 0;

        // Populate modal fields
        $("#editId").val(id);
        $("#editPercentage").val(percentage);
        $("#editStartDate").val(start_date);
        $("#editExpiredDate").val(expired_date);
        $("#editStatus").val(status);

        // Dynamically set the selected option in the service dropdown
        $("#editServiceId").find('option').each(function() {
            if ($(this).text() === serviceName) {
                $(this).prop('selected', true);
            } else {
                $(this).prop('selected', false);
            }
        });

        $("#editDiscountModal").modal("show");
    });


    $(document).on('click', '.delete', function() {
        let id = $(this).closest('tr').find('td').eq(0).text();
        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/discount/delete') }}/${id}`,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        toastr.success("Discount deleted successfully.");
                        getData();
                    },
                    error: function() {
                        toastr.error("Failed to delete discount.");
                    }
                });
            }
        });
    });



    $(document).on('click', '.duplicate', function() {
        let id = $(this).closest('tr').find('td').eq(0).text();
        $.ajax({
            url: `{{ url('admin/discount/duplicate') }}/${id}`,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {

                if (response.success === true) {
                    // Reset form inputs
                    $("#service_id").val('');
                    $("#percentage").val('');
                    $("#start_date").val('');
                    $("#expired_date").val('');
                    $("#status").val('');
                    // Close the modal, display success, and refresh data   
                    $("#addDiscountModal").modal("hide");
                    toastr.success(response.message);
                    getData();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error("Failed to duplicate discount.");
            },
            complete: function() {
                // Re-enable the button after the request
                $("#updateStaff").prop("disabled", false).text("Save");
            }

        });
    });



    $(document).ready(function() {
        getData();
        $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
