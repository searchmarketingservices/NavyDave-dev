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
            <div class="main-table-box main-table-box-list services-table table-responsive">
                <table class="table table-striped" id="Table1">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">User</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Staff</th>
                            <th class="text-center">Service</th>
                            <th class="text-center">Total Session</th>
                            <th class="text-center">Completed Session</th>
                            <th class="text-center">Remaining Session</th>
                            <th class="text-center">Day</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Time</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Payment</th>
                            <th class="text-center">Status</th>
                            {{-- <th class="text-center">Reschedule</th> --}}
                            {{-- <td class="text-center">${element.is_rescheduled == 1 ? `<span class="badge bg-success ms-1">Rescheduled</span>` : `<span class="badge bg-danger ms-1">No</span>`}</td> --}}
                            <th class="text-center">Created at</th>
                            <th class="text-center">Actions</th>
                            <th class="text-center">Reschedule</th>
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
                    <form id="statusForm" action="{{ route('admin.appointment.edit') }}" method="post">
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
                                    {{-- <option value="pending">Pending</option> --}}
                                    <option value="confirmed">Confirmed</option>
                                    {{-- <option value="awaiting_next_slot" disabled>Awaiting Next Slot</option> --}}
                                    <option value="fully_completed" disabled>Fully Completed</option>
                                    <option value="completed">Completed</option>
                                    <option value="canceled">Cancelled</option>
                                </select>
                                <input type="hidden" name="id" id="id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="">Update Status</button>
                            <button type="button" class="btn btn-secondary" id="cancel"
                                data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="rescheduleModal" tabindex="-1" role="dialog" aria-labelledby="rescheduleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="rescheduleForm" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reschedule Appointment</h5>
                            <button type="button" class="close" id="close22" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="id" id="appo_id">
                                <label for="date">Date</label>
                                <input type="date" onchange="getSlotsForDate(this.value)" required min="{{ date('Y-m-d') }}" class="form-control" name="appointment_date" id="date">
                                <input type="hidden" name="staff_id" id="staff_id">
                                <input type="hidden" name="service_id" id="service_id">
                                <input type="hidden" name="previous_date" id="previous_date">
                                <input type="hidden" name="old_slot_id" id="old_slot_id">
                                <input type="hidden" name="new_slot_id" id="new_slot_id">
                            </div>
                            <div class="form-group">
                                <label>Available Slots</label>
                                <div id="slotsContainer" class="d-flex flex-wrap gap-2">
                                    <!-- Slots will be dynamically added here -->
                                </div>
                                <input type="hidden" name="slot_id" id="selectedSlot">
                            </div>
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" name="reason" id="reason" cols="30" rows="10"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="updateBtn">Update</button>
                            <button type="button" class="btn btn-secondary" id="cancel11"
                                data-dismiss="modal">Cancel</button>
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
                    url: "{{ route('admin.appointment.get') }}",
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

             function formatDate(inputDate) {
                // Split the input date to handle it as a local date
                const [year, month, day] = inputDate.split(" ")[0].split("-");
                
                // Format the date as mm/dd/yyyy
                return `${month}/${day}/${year}`;
            }

            function formatDate2(dateString) {
                let date = new Date(dateString);
                return date.toLocaleDateString(); // Returns MM-DD-YYYY
            }

            function getData() {
                $.ajax({
                    url: "{{ route('admin.appointment.index') }}",
                    type: "get",
                    success: function(response) {
                        $("#Table").empty();
                        response.forEach(element => {
                            let createdAtFormatted = formatDate(element.created_at);
                            let isEditable = !["fully_completed", "awaiting_next_slot", "completed",
                                "canceled"
                            ].includes(element.status);
                            let isEditable2 = !["fully_completed", "awaiting_next_slot", "completed"
                            ].includes(element.status);
                            let userBadge = "";
                            if (element.user == null) {
                                userBadge = `<span class="badge bg-danger ms-1">Deleted User</span>`;
                            } else {
                                userBadge = ``;
                            }


                            $('#Table').append(`
                                <tr>
                                    <td class="text-center">${element.id}</td>
                                    <td class="text-center">${element.first_name + ' ' + element.last_name} ${userBadge} </td>
                                    <td class="text-center">${element.email}</td>
                                    <td class="text-center">${element.staff.user.name}</td>
                                    <td class="text-center">${element.service.name}</td>
                                    <td class="text-center">${element.total_slots}</td>
                                    <td class="text-center">${element.completed_slots}</td>
                                    <td class="text-center">${element.total_slots - element.completed_slots}</td>
                                    <td class="text-center">${element.slot ? (element.slot.available_on ? element.slot.available_on : "") : ""}</td>
                                    <td class="text-center">${formatDate(element.appointment_date)}</td>
                                    <td class="text-center">
                                        ${element.slot ? (element.slot.available_from && element.slot.available_to ? 
                                        formatTime(element.slot.available_from) + ' - ' + formatTime(element.slot.available_to) : "") : ""}
                                    </td>
                                    <td class="text-center">$${element.price}</td>
                                    <td class="text-center">${element.payment ? element.payment.status : '-' }</td>
                                    <td class="text-center">${element.status == "awaiting_next_slot" ? "Awaiting Next Slot" : element.status == "fully_completed" ? "Fully Completed" : element.status == "completed" ? "Completed" : element.status == "canceled" ? "Cancelled" : element.status == "pending" ? "Pending" : element.status == "rescheduled" ? "Rescheduled" : "Confirmed"}</td>
                                    <td class="text-center">${formatDate2(element.created_at)}</td>
                                    <td class="text-center">
                                        <div class="action-box mt-2">
                                            <ul>
                                                ${isEditable ? `<li><a onclick="showEditModal(${element.id})"><img src="{{ asset('assets/images/pencil.png') }}" alt=""></a></li>` : "N/A"}
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-box mt-2">
                                            <ul>
                                                ${isEditable2 ? `<li><a onclick="reschedule(${element.id})"><img src="{{ asset('assets/images/pencil.png') }}" alt=""></a></li>` : "N/A"}
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

            function selectSlot(slot) {
                // Highlight selected slot and store the value
                $(".slot-button").removeClass("btn-primary");
                $(".slot-button").addClass("btn-outline-primary");
                $(`[data-slot="${slot}"]`).removeClass("btn-outline-primary");
                $(`[data-slot="${slot}"]`).addClass("btn-primary");
                $("#selectedSlot").val(slot);
            }

            $("#rescheduleForm").submit(function(e) {
                e.preventDefault();
                $("#updateBtn").attr("disabled", true);
                $("#updateBtn").html("Updating...");
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('admin.appointment.reschedule') }}",
                    type: "post",
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        if (response.success == true) {
                            $("#rescheduleModal").modal('hide');
                            toastr.success(response.message);
                            $("#updateBtn").attr("disabled", false);
                            $("#updateBtn").html("Update");
                            getData();
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        $("#updateBtn").attr("disabled", false);
                        $("#updateBtn").html("Update");
                    }
                });
            });

            function reschedule(id) {
                $.ajax({
                    url: "{{ route('admin.appointment.change') }}",
                    type: "get",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $("#rescheduleModal").modal('show');
                        $("#date").val(response.appointment_date);
                        $("#staff_id").val(response.staff_id);
                        $("#service_id").val(response.service_id);
                        $("#appo_id").val(response.id);
                        $("#previous_date").val(response.appointment_date);
                        $("#old_slot_id").val(response.slot_id);
                        getSlotsForDate(response.appointment_date);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            function getSlotsForDate(data) {

                var staff_id = $("#staff_id").val();
                var service_id = $("#service_id").val();
                var date = data;

                $.ajax({
                    type: "GET",
                    url: "{{ route('get-slots-for-date') }}",
                    data: {
                        staff_id: staff_id,
                        service_id: service_id,
                        date: date
                    },
                    success: function(data) {
                        // Clear previous slots
                        $("#slotsContainer").empty();

                        console.log(data);

                        if (data && data.length > 0) {
                            // Create a document fragment
                            const fragment = document.createDocumentFragment();

                            // Loop through the slots and create buttons
                            data.forEach(function(slot) {
                                const button = document.createElement('button');
                                button.type = 'button';
                                button.className =
                                    `btn ${slot.is_booked ? 'btn-outline-danger' : 'btn-outline-primary'} slot-button`;
                                button.dataset.slot = slot.id;
                                button.textContent =
                                    `${formatTime(slot.available_from)} - ${formatTime(slot.available_to)}`;
                                button.disabled = slot.is_booked;

                                if (!slot.is_booked) {
                                    button.onclick = () => selectSlot(slot.id);
                                }

                                // Append button to the fragment
                                fragment.appendChild(button);
                            });

                            // Append the fragment to the container
                            $("#slotsContainer").append(fragment);
                        } else {
                            // Handle no slots available
                            $("#slotsContainer").html('<p class="text-muted">No slots available.</p>');
                        }
                    },
                    error: function(error) {
                        console.error(error);
                        $("#slotsContainer").html(
                            '<p class="text-danger">Failed to load slots. Please try again later.</p>');
                    }

                });
            }

            $("#cancel , #close2").click(function() {
                $("#statusModal").modal('hide');
            });
            $("#cancel11 , #close22").click(function() {
                $("#rescheduleModal").modal('hide');
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
