@extends('dashboard.layouts.master')

<style>
    .main-box-navy .left-all-links ul li a.calendar-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.calendar-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.calendar-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }

    /* Legend styling */
    .legend {
        margin-top: 20px;
    }

    .legend span {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 5px;
        border-radius: 3px;
    }

    .pending-color {
        background-color: #ffc107;
        /* Yellow for pending */
    }

    .confirmed-color {
        background-color: #28a745;
        /* Green for confirmed */
    }

    .canceled-color {
        background-color: #dc3545;
        /* Red for canceled */
    }

    .completed-color {
        background-color: #17a2b8;
        /* Light blue for completed */
    }
</style>

@section('content')
    <div class="col-lg-10">
        <!-- Calendar Section -->
        <div class="main-calendar-box main-calendar-box-list">
            <h5>Calendar (Appointments)</h5>
        </div>

        <div class="main-table-box main-table-box-list">
            <div id="calendar"></div>
        </div>

        <!-- Legend Section -->
        <div class="legend">
            <h6>Legend:</h6>
            <p>
                <span class="pending-color"></span> Pending &nbsp;
                <span class="confirmed-color"></span> Confirmed &nbsp;
                <span class="canceled-color"></span> Canceled &nbsp;
                <span class="completed-color"></span> Completed
            </p>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cancel2">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Appointment ID:</strong> <span id="modalAppointmentId"></span></p>
                    <p><strong>Customer Name:</strong> <span id="modalEventTitle"></span></p>
                    <p><strong>Time Slot:</strong> <span id="modalEventDescription"></span></p>
                    <p><strong>Staff Name:</strong> <span id="modalStaffName"></span></p>
                    <p><strong>Service Name:</strong> <span id="modalServiceName"></span></p>
                    <p><strong>Service Category:</strong> <span id="modalServiceCategory"></span></p>
                    <p><strong>Appointment Status:</strong> <span id="modalAppointmentStatus"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="cancel1" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        $("#cancel1 , #cancel2").click(function() {
            $("#eventModal").modal('hide');
        })
        function formatTime(timeString) {
            const [hour, minute] = timeString.split(':');
            let hours = parseInt(hour);
            let ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12 || 12; // convert 24-hour format to 12-hour format
            return `${hours}:${minute} ${ampm}`;
        }
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var appointments = @json($appointments);

            function getStatusColor(status) {
                switch (status) {
                    case 'pending':
                        return {
                            backgroundColor: '#ffc107', // Yellow for pending
                                borderColor: '#ffc107',
                                textColor: 'black'
                        };
                    case 'confirmed':
                        return {
                            backgroundColor: '#28a745', // Green for confirmed
                                borderColor: '#28a745',
                                textColor: 'white'
                        };
                    case 'canceled':
                        return {
                            backgroundColor: '#dc3545', // Red for canceled
                                borderColor: '#dc3545',
                                textColor: 'white'
                        };
                    case 'completed':
                        return {
                            backgroundColor: '#17a2b8', // Light blue for completed
                                borderColor: '#17a2b8',
                                textColor: 'white'
                        };
                    default:
                        return {
                            backgroundColor: '#2CC374', // Default color
                                borderColor: '#2CC374',
                                textColor: 'white'
                        };
                }
            }

            var events = appointments.map(function(appointment) {
                var statusColors = getStatusColor(appointment.status);

                return {
                    title: appointment.first_name + ' ' + appointment.last_name,
                    start: appointment.appointment_date,
                    backgroundColor: statusColors.backgroundColor,
                    borderColor: statusColors.borderColor,
                    textColor: statusColors.textColor,
                    description: appointment.slot ? formatTime(appointment.slot.available_from) + ' ' + formatTime(appointment.slot.available_to) : '9:00 am - 11:00 am',
                    extendedProps: {
                        description: appointment.slot ? formatTime(appointment.slot.available_from) + ' - ' + formatTime(appointment.slot.available_to) : 'No slot available',
                        status: appointment.status,
                        staff: appointment.staff,
                        service: appointment.service,
                        customer: appointment.customer,
                        id: appointment.id,                        
                    }
                };
            });

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
                events: events,
                eventClick: function(info) {
                    // Populate modal with event details
                    document.getElementById('modalEventTitle').innerText = info.event.title;
                    document.getElementById('modalEventDescription').innerText = info.event
                        .extendedProps.description;
                    document.getElementById('modalAppointmentId').innerText = info.event
                        .extendedProps.id;
                    document.getElementById('modalServiceName').innerText = info.event
                        .extendedProps.service.name;
                    document.getElementById('modalServiceCategory').innerText = info.event
                        .extendedProps.service.category.name;
                    document.getElementById('modalAppointmentStatus').innerText = info.event
                        .extendedProps.status;
                    document.getElementById('modalStaffName').innerText = info.event.extendedProps
                        .staff.user.name;

                    // Show the modal
                    $('#eventModal').modal('show');
                },
                eventContent: function(info) {
                    // Custom event rendering: show title and description (time slot)
                    var titleEl = document.createElement('div');
                    titleEl.innerHTML = '<b>' + info.event.title + '</b>'; // Event title
                        
                    var descriptionEl2 = document.createElement('div');
                    var descriptionEl = document.createElement('div');
                    descriptionEl2.innerHTML = '<small>' + info.event.extendedProps.service.name + '</small>'; // Time slot below title
                    descriptionEl.innerHTML = '<small>' + info.event.extendedProps.description + '</small>'; // Time slot below title
                        
                    // Create a container div to hold both title and description
                    var arrayOfDomNodes = [titleEl, descriptionEl2, descriptionEl,];
                        
                    return { domNodes: arrayOfDomNodes };
                }
            });

            calendar.render();
        });
    </script>
@endsection
