@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.appointment-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.appointment-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.appointment-active span img,
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
                <h5> Appointments</h5>
            </div>
        </div>
        <div class="main-table-box main-table-box-list services-table">
            <table class="table table-striped" id="Table1">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Staff</th>
                        <th class="text-center">Service</th>
                        <th class="text-center">Day</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Time</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Payment</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created at</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="Table">
                    <!-- Rows will be inserted here using Ajax -->
                </tbody>
            </table>

        </div>
    </div>

    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="statusForm" action="{{ route('staff.appointment.edit') }}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                        <button type="button" class="close" id="close2" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                            <input type="hidden" name="id" id="id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="">Update Status</button>
                        <button type="button" class="btn btn-secondary" id="cancel" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function formatTime(timeString) {
            const [hour, minute] = timeString.split(':');
            let hours = parseInt(hour);
            let ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12 || 12; // convert 24-hour format to 12-hour format
            return `${hours}:${minute} ${ampm}`;
        }

        function showEditModal(id) {
            $.ajax({
                url: "{{ route('staff.appointment.show') }}",
                type: "get",
                data: {
                    id: id
                },
                success: function(response) {
                    $("#statusModal").modal('show');
                    $("#status").find('option[value="' + response.status + '"]').attr('selected', true);
                    $("#id").val(response.id);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function formatDate(dateString) {
            let date = new Date(dateString);
            return date.toISOString().split('T')[0]; // Returns YYYY-MM-DD
        }


        function getData() {
            $.ajax({
                url: "{{ route('staff.appointment.get') }}",
                type: "get",
                success: function(response) {
                    $("#Table").empty();
                    response.forEach(element => {
                        let createdAtFormatted = formatDate(element.created_at);
                        $('#Table').append(`
                            <tr>
                                <td class="text-center">${element.id}</td>
                                <td class="text-center">${element.first_name + ' ' + element.last_name}</td>
                                <td class="text-center">${element.email}</td>
                                <td class="text-center">${element.staff.user.name}</td>
                                <td class="text-center">${element.service.name}</td>
                                <td class="text-center">${element.slot.available_on}</td>
                                <td class="text-center">${element.appointment_date}</td>
                                <td class="text-center">${formatTime(element.slot.available_from) + ' - ' + formatTime(element.slot.available_to)}</td>
                                <td class="text-center">$${element.price}</td>
                                <td class="text-center">${element.payment ? element.payment.status : '-' }</td>
                                <td class="text-center">${element.status == "awaiting_next_slot" ? "Awaiting Next Slot" : element.status == "fully_completed" ? "Fully Completed" : element.status == "completed" ? "Completed" : element.status == "canceled" ? "Canceled" : element.status == "pending" ? "Pending" : "Confirmed"}</td>
                                <td class="text-center">${createdAtFormatted}</td>
                                <td class="text-center">
                                    <div class="action-box mt-2">
                                        <ul>
                                            <li><a onclick="showEditModal(${element.id})"><img src="{{ asset('assets/images/pencil.png') }}" alt=""></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        `);
                    })
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $("#cancel , #close2").click(function() {
            $("#statusModal").modal('hide');
        });
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
