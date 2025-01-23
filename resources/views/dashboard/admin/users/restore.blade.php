@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.restore-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.restore-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.restore-active span img,
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
                <h5>Deleted Users</h5>
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
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><img src="{{ asset('./assets/images/default-user.webp') }}" alt="User Image"
                                    style="width: 50px; height: 50px; border-radius: 50%;"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->city }}</td>
                            <td>{{ $user->state }}</td>
                            <td>{{ $user->zipcode }}</td>
                            <td>{{ $user->address }}</td>
                            <td>
                                <button type="button" class="t-btn" onclick="restoreUser({{ $user->id }})">Restore</button>
                                <button type="button" class="t-btn" onclick="permanentlyDelete({{ $user->id }})">Permanently Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-box">
            <ul>
                <!-- Pagination links will be dynamically inserted here -->
            </ul>
        </div>

    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function restoreUser(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be restored and reactivated.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, restore!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to restore the user
                    $.ajax({
                        url: "/admin/user/" + userId + "/restore", // Replace with your restore route
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}" // CSRF token for security
                        },
                        success: function(response) {
                            Swal.fire('Restored!', 'User has been restored.', 'success');

                            // Remove the row from the table
                            $("#userTableBody tr").filter(function() {
                                return $(this).find("td").first().text() ==
                                userId; // Match the user ID in the first column
                            }).remove();

                            // Optional: You can call a function to refresh the table if you are fetching the users from the backend
                            // fetchUsers(); 
                        },
                        error: function(xhr, status, error) {
                            toastr.error("An error occurred. Please try again.");
                        }
                    });
                }
            });
        }
        function permanentlyDelete(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be permanently deleted and cannot be restored.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete permanently!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to restore the user
                    $.ajax({
                        url: "/admin/user/" + userId + "/permanently/delete", // Replace with your restore route
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}" // CSRF token for security
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', 'The user has been permanently deleted.', 'success');

                            // Remove the row from the table
                            $("#userTableBody tr").filter(function() {
                                return $(this).find("td").first().text() ==
                                userId; // Match the user ID in the first column
                            }).remove();

                            // Optional: You can call a function to refresh the table if you are fetching the users from the backend
                            // fetchUsers(); 
                        },
                        error: function(xhr, status, error) {
                            toastr.error("An error occurred. Please try again.");
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            $('#userTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });
        });
    </script>
@endsection
