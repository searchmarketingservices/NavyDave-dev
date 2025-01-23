@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.users-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.users-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.users-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }

    .t-btn {
        background-color: #353535;
        border: none;
        font-size: 13px;
        border-radius: 10px;
        padding: 10px 20px;
        display: inline-flex;
        transition: .3s;
        color: white;
    }

    .t-btn:hover {
        background-color: #ffffff;
        color: rgb(36, 36, 36);
    }


    .main-table-box.main-table-box-list.services-table tr td:last-child {
        display: flex;
        gap: 10px;
    }

    .main-table-box.main-table-box-list.services-table tr td:last-child button.t-btn {
        background-color: #48bb78;
    }

    .main-table-box.main-table-box-list.services-table tr td:last-child button.t-btn img {
        filter: brightness(0.5) contrast(30.5);
    }

    .main-table-box.main-table-box-list.services-table tr td:last-child button.t-btn:hover {
        background-color: #00ff6a54;
    }
</style>
</head>
@section('content')
    <div class="col-lg-10">
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="two-things-align" bis_skin_checked="1">
                <h5>Users</h5>
                <button type="button" id="addUser" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Add Users
                </button>
            </div>
        </div>
        <div class="main-table-box main-table-box-list services-table">
            <table id="userTable" class="display">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip Code</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">

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
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Users</h5>
                        <button type="button" class="close" data-dismiss="modal" id="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Image:</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        {{-- <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div> --}}
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="form-group">
                            <label for="state">State:</label>
                            <input type="text" class="form-control" id="state" name="state">
                        </div>
                        <div class="form-group">
                            <label for="zipcode">Zipcode:</label>
                            <input type="text" class="form-control" id="zipcode" name="zipcode">
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="saveUser()" id="createStaff">Save</button>
                        <button type="button" id="cancel2" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editUserForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editUserId">
                        <div class="form-group">
                            <label for="editImage">Image:</label>
                            <input type="file" class="form-control" id="editImage" name="image">
                        </div>
                        <div class="form-group">
                            <label for="editFirstName">First Name:</label>
                            <input type="text" class="form-control" id="editFirstName" name="first_name">
                        </div>
                        <div class="form-group">
                            <label for="editLastName">Last Name:</label>
                            <input type="text" class="form-control" id="editLastName" name="last_name">
                        </div>

                        <div class="form-group">
                            <label for="editEmail">Email:</label>
                            <input type="email" class="form-control" id="editEmail" name="email">
                        </div>
                        <div class="form-group">
                            <label for="editPhone">Phone:</label>
                            <input type="text" class="form-control" id="editPhone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="editCity">City:</label>
                            <input type="text" class="form-control" id="editCity" name="city">
                        </div>
                        <div class="form-group">
                            <label for="editState">State:</label>
                            <input type="text" class="form-control" id="editState" name="state">
                        </div>
                        <div class="form-group">
                            <label for="editZipcode">Zipcode:</label>
                            <input type="text" class="form-control" id="editZipcode" name="zipcode">
                        </div>
                        <div class="form-group">
                            <label for="editAddress">Address:</label>
                            <input type="text" class="form-control" id="editAddress" name="address">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="updateUser">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $("#addUser").click(function() {
            $("#exampleModal").modal("show");
        });
        $("#close, #cancel2").click(function() {
            $("#exampleModal").modal("hide");
        });

        function fetchUsers() {
            $.ajax({
                url: "{{ route('admin.users.get') }}",
                method: "GET",
                success: function(response) {

                    // Clear the current table body
                    var table = $('#userTable').DataTable();
                    table.clear(); // Clear existing data

                    // Loop through the users and append them to the table
                    $.each(response.users, function(index, user) {
                        var image = user.image ?
                            `<img width="50px" src="/storage/${user.image}" />` :
                            `<img width="50px" src="{{ asset('./assets/images/default-user.webp') }}" alt="">`;

                        var row = [
                            user.id,
                            image,
                            user.name, // First name
                            user.last_name, // Last name
                            user.email,
                            user.phone ? user.phone : 'NA',
                            user.city ? user.city : 'NA',
                            user.state ? user.state : 'NA',
                            user.zipcode ? user.zipcode : 'NA',
                            user.address ? user.address : 'NA',
                            `<button type="button" class="t-btn editBtn" data-id="${user.id}"><img src="{{ asset('assets/images/pencil.png') }}" width="20px" alt=""></button>
                     <button type="button" class="t-btn deleteBtn" data-id="${user.id}"><img src="{{ asset('assets/images/delete.png') }}" width="20px" alt=""></button>`
                        ];

                        table.row.add(row); // Add new row to the DataTable
                    });

                    // Draw the updated table (without reinitializing the entire DataTable)
                    table.draw();
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred while fetching users:", error);
                }
            });
        }


        function saveUser() {
            // Get form values
            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var city = $("#city").val();
            var state = $("#state").val();
            var zipcode = $("#zipcode").val();
            var address = $("#address").val();
            var image = $("#image")[0].files[0]; // Get the image file

            // Create FormData to handle file upload
            var formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("first_name", first_name);
            formData.append("last_name", last_name);
            formData.append("email", email);
            formData.append("phone", phone);
            formData.append("city", city);
            formData.append("state", state);
            formData.append("zipcode", zipcode);
            formData.append("address", address);
            if (image) {
                formData.append("image", image); // Append image if selected
            }

            $.ajax({
                type: "POST",
                url: "{{ route('admin.users.store') }}",
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Set content type to false to let the browser set it
                success: function(data) {
                    $("#exampleModal").modal("hide");
                    toastr.success("User added successfully");
                    fetchUsers(); // Refresh the table after adding the user
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // Laravel validation error
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

            // Fetch the users on page load
            fetchUsers();

            // Delete user
            $(document).on('click', '.deleteBtn', function() {
                var userId = $(this).data("id"); // Get the ID of the user

                // Ask for confirmation before deleting
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Please check this user's appointments before deactivating. Once deleted, appointments will no longer be accessible.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to delete the user
                        $.ajax({
                            url: "/admin/users/" + userId, // Replace with your delete route
                            type: "DELETE",
                            data: {
                                "_token": "{{ csrf_token() }}" // CSRF token for security
                            },
                            success: function(response) {
                                Swal.fire('Deleted!', 'User has been soft deleted.',
                                    'success');
                                fetchUsers(); // Refresh the user table after deletion
                            },
                            error: function(xhr, status, error) {
                                toastr.error("An error occurred. Please try again.");
                            }
                        });
                    }
                });
            });



            // Edit user
            $(document).on('click', '.editBtn', function() {
                var userId = $(this).data("id");

                // Send AJAX request to get the user details
                $.ajax({
                    url: "/admin/users/" + userId + "/edit", // Adjust the URL to your route
                    method: "GET",
                    success: function(data) {
                        // Populate the modal with user data
                        $("#editUserId").val(data.id);
                        $("#editFirstName").val(data.name); // Populate first name
                        $("#editLastName").val(data.last_name); // Populate last name
                        $("#editEmail").val(data.email);
                        $("#editPhone").val(data.phone);
                        $("#editCity").val(data.city);
                        $("#editState").val(data.state);
                        $("#editZipcode").val(data.zipcode);
                        $("#editAddress").val(data.address);

                        // Show the modal
                        $("#editModal").modal("show");
                    },
                    error: function(xhr, status, error) {
                        toastr.error("An error occurred. Please try again.");
                    }
                });
            });

            // Update user when clicking 'Update' button
            $("#updateUser").click(function() {
                var userId = $("#editUserId").val();
                var formData = new FormData($("#editUserForm")[0]);

                // Update the user via AJAX
                $.ajax({
                    url: "/admin/users/" + userId, // Adjust the URL to your route
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#editModal").modal("hide");
                        toastr.success("User updated successfully");
                        fetchUsers();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // Laravel validation error
                            var errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {
                                toastr.error(value[
                                    0]); // Display each error message using Toastr
                            });
                        } else {
                            toastr.error("An error occurred. Please try again.");
                        }
                    }
                });
            });

            $('#userTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });


        });
    </script>
@endsection
