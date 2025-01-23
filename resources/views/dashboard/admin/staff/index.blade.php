@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.staff-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.staff-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.staff-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }
</style>
</head>
@section('content')
    <div class="col-lg-10">
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="two-things-align" bis_skin_checked="1">
                <h5>Staff Members</h5>
                <button type="button" class="btn btn-primary" id="addBtn" data-toggle="modal" data-target="#exampleModal">
                    Add Staff
                </button>
            </div>
            <div class="three-things-align services-box">
                <div class="main-search-form">
                    <form action="">
                        <div class="form-align-box">
                            <div class="box">
                                <div class="input-box">
                                    <input type="text" placeholder="Service Name">
                                </div>
                                <div class="select-box">
                                    <select name="Service Category" id="Service Category">
                                        <option value="Service Category">Service Category</option>
                                        <option value="Service Category-01">Service Category-01</option>
                                        <option value="Service Category-02">Service Category-02</option>
                                        <option value="Service Category-03">Service Category-03</option>
                                    </select>
                                </div>
                            </div>
                            <div class="two-btns-align">
                                <a href="#" class="t-btn">Search Serivce</a>
                                <a href="#" class="t-btn t-btn-gray">Export List</a>
                                <a href="#" class="t-btn t-btn-gray">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="main-table-box main-table-box-list services-table">
            <table id="myTable" class="display">
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
                        {{-- <th>Service</th> --}}
                        <th>Staff Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows will be inserted here -->
                </tbody>
            </table>
        </div>
        <div class="pagination-box">
            <ul>
                <!-- Pagination links will be dynamically inserted here -->
            </ul>
        </div>

    </div>


    <!-- Modal Structure -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="saveStaff" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Staff Member</h5>
                        <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <input type="file" name="image" class="form-control" placeholder="Upload Image">
                        </div>
                        <div class="form-group">
                            <input type="text" name="first_name" class="form-control" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" class="form-control" placeholder="Phone">
                        </div>
                        <div class="form-group">
                            <select name="status" class="form-control">
                                <option value="">Status</option>
                                <option value="Active">Active</option>
                                <option value="In Active">In Active</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="notes" class="form-control" placeholder="Note" cols="5" rows="5"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="saveStaff()" id="createStaff">Add
                            Staff</button>
                        <button type="button" class="btn btn-secondary" id="close2" data-dismiss="modal">Cancel</button>
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
    $(document).ready(function() {
        showStaff();
        // Ensure that the modal is cleaned up correctly when it's hidden
        $('#exampleModal').on('hidden.bs.modal', function() {
            $('.modal-backdrop').remove(); // Remove the backdrop
            $('body').removeClass('modal-open'); // Remove the modal-open class from the body
        });
    });

    $(document).on('click', '#addBtn', function() {
        $("#exampleModal").modal("show");
        console.log("Button clicked");
    });

    $(document).on('click', '#close , #close2', function() {
        $("#exampleModal").modal("hide");
    });

    function saveStaff() {
        var saveStaff = $("#saveStaff");
        var formData = new FormData(saveStaff[0]);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('admin.staff.store') }}",
            type: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {

                    $('#exampleModal').hide();
                    $('.modal-backdrop').hide();
                    $('#saveStaff').trigger('reset');
                    showStaff();
                } else {
                    // Handle validation errors
                    showValidationErrors(response.errors);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', xhr.responseText);
            }
        });
    }

    function showValidationErrors(errors) {
        // Clear previous errors
        $('.text-danger').remove();

        // Loop through the errors and display them
        $.each(errors, function(field, messages) {
            var inputField = $('[name=' + field + ']');
            inputField.after('<span class="text-danger">' + messages.join('<br>') + '</span>');
        });
    }

    function showStaff() {
        $.ajax({
            url: "{{ route('admin.staff.show') }}",
            type: "GET",
            dataType: "json",
            success: function(response) {
                console.log('Server response:', response);
                let table = $('#myTable').DataTable();
                table.clear();
                // Append new data
                response.data.forEach(item => {
                    table.row.add([
                        `<div class="align-box">
                        <div class="input-box-check">
                            <input type="checkbox">
                        </div>
                        <p>${item.id}</p>
                    </div>`,
                        `<img src="{{ Storage::url('${item.image}') }}" alt="Staff Image" style="width: 100px; height: auto;">`,
                        // item.service_id,
                        item.user.name,
                        item.user.email,
                        item.user.phone ? item.user.phone : 'N/A',
                        item.status,
                        `<div class="action-box">
                        <ul>
                            <li><a href="{{ url('admin/staff/edit') }}/${item.id}"><img src="{{ asset('assets/images/pencil.png') }}" alt=""></a></li>
                            <li><button onclick="deleteStaff(${item.id})"><img src="{{ asset('assets/images/delete.png') }}" alt=""></button></li>
                        </ul>
                    </div>`
                    ]);
                });

                // Redraw the DataTable
                table.draw();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
                alert('An error occurred while fetching the data.');
            }
        });
    }


    function deleteStaff(id) {
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
                $.ajax({
                    url: "{{ route('admin.staff.destroy', '') }}/" + id,
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        $('#myTable').DataTable({
                            destroy: true
                        });
                        showStaff();
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                'Staff deleted successfully.',
                                'success'
                            );
                        } else {

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
