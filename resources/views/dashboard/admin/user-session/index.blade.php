@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.user-session-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.user-session-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.user-session-active span img,
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
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session()->get('success') }}</div>
        @endif
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="two-things-align" bis_skin_checked="1">
                <h5>User Sessions</h5>
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
                        <th>Package</th>
                        <th>Assign Session</th>
                        <th>Sessions</th>
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

    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="updateForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Session</h5>
                        <button type="button" class="close" id="close22" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="session">User</label>
                            <input type="text" id="session_user" class="form-control" readonly>
                        </div>
                        <div class="form-group d-none" id="packageDiv">
                            <select name="service" id="service" class="form-control">
                                <option selected disabled>Select Package</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}" data-isAdmin="{{ $package->is_admin }}"
                                        data-slots="{{ $package->slots }}">{{ $package->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="session">Sessions</label>
                            <input type="number" placeholder="Sessions" class="form-control" name="session" id="session">
                            <input type="hidden" name="session_id" id="session_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                        <button type="button" class="btn btn-secondary" id="cancel11" data-dismiss="modal">Cancel</button>
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
        $("#service").on("change", function() {
            var isAdmin = $(this).find(":selected").data("isadmin");
            var slots = $(this).find(":selected").data("slots");

            if (isAdmin == 1) {
                $("#session").attr("readonly", false); // Allow editing
                $("#session").val(slots);
            } else {
                $("#session").attr("readonly", true); // Prevent editing
                $("#session").val(slots); // Set slots value if not admin
            }
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

                        var editUrl = "{{ route('admin.users.session.assign', ['id' => ':id']) }}"
                            .replace(':id', user.id);

                        var serviceName = user.sessions && user.sessions.length > 0 && user.sessions[0]
                            .service ? user.sessions[0].service.name : 'No service assigned';
                        const userName = `${user.name} ${user.last_name}`;

                        var btn = null;
                        if (user.sessions && user.sessions.length > 0) {
                            btn =
                                `<a onclick="editModal(${user.id}, ${user.sessions[0]?.sessions}, '${userName}')" class="t-btn"><img src="{{ asset('assets/images/pencil.png') }}" width="20px"></a>`;
                        } else {
                            btn =
                                `<a href="${editUrl}" class="t-btn"><img src="{{ asset('assets/images/duplicate.png') }}" width="20px"></a>`
                        }

                        var row = [
                            user.id,
                            image,
                            user.name, // First name
                            user.last_name, // Last name
                            user.email,
                            user.phone ? user.phone : 'NA',
                            serviceName,
                            user.sessions && user.sessions.length > 0 && user.sessions[0].sessions ?
                            user.sessions[0].sessions : 0,
                            btn
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


        function editModal(id, sessions, name) {
            if (sessions == 0) {
                $("#packageDiv").removeClass("d-none");
                $("#service").attr("required", true); // Make service required
            } else {
                $("#packageDiv").addClass("d-none");
                $("#service").removeAttr("required"); // Remove required from service
            }

            $("#EditModal").modal("show");

            $("#session_id").val(id);
            $("#session").val(sessions);
            $("#session_user").val(name);
        }

        $("#cancel11 , #close22").click(function() {
            $("#EditModal").modal('hide');
        });

        $("#updateBtn").click(function() {

            var session = $("#session").val();
            var id = $("#session_id").val();
            var service = $("#service").val();

            $.ajax({
                url: "{{ route('admin.users.session.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    session: session,
                    id: id,
                    service: service
                },
                success: function(response) {

                    if (response.success == true) {
                        $("#EditModal").modal('hide');
                        toastr.success(response.message);
                        fetchUsers();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("An error occurred:", xhr.responseJSON.message);
                    if(xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    }
                }
            });
        });

        $(document).ready(function() {

            fetchUsers();

            $('#userTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                ordering: false
            });


        });
    </script>
@endsection
