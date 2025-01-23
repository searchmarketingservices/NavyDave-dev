    @extends('dashboard.layouts.master')
    <style>
        .main-box-navy .left-all-links ul li a.appointment-changes-active,
        .main-box-navy .left-all-links ul li a:hover {
            background-color: white;
            font-weight: 600;
        }

        .main-box-navy .left-all-links ul li a.appointment-changes-active span,
        .main-box-navy .left-all-links ul li a:hover span {
            background-color: #2CC374;
        }

        .main-box-navy .left-all-links ul li a.appointment-changes-active span img,
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
                    <h5>Appointments Changes</h5>
                </div>
            </div>
            <div class="main-table-box main-table-box-list services-table table-responsive">
                <table class="table table-striped" id="Table1">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">User Name</th>
                            <th class="text-center">Appointment ID</th>
                            <th class="text-center">Previous Date</th>
                            <th class="text-center">New Date</th>
                            {{-- <th class="text-center">Old Slot</th>
                            <th class="text-center">New Slot</th> --}}
                            <th class="text-center">Changed By</th>
                            <th class="text-center">Reason</th>
                            <th class="text-center">Created At</th>
                        </tr>
                    </thead>
                    <tbody id="Table">
                        @foreach ($changes as $change)
                        {{-- {{ dd($change) }} --}}
                            <tr>
                                <td class="text-center">{{ $change->id }}</td>
                                <td class="text-center">{{ $change->appointment ? $change->appointment->first_name . ' ' . $change->appointment->last_name : 'N/A' }}</td>
                                <td class="text-center">{{ $change->appointment_id }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($change->previous_date)->format('m-d-Y') }}
                                    <br />

                                    <small>
                                        {{ $change->oldSlot ? date('g:i a', strtotime($change->oldSlot->available_from)) . ' to ' . date('g:i a', strtotime($change->oldSlot->available_to)) : 'N/A' }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($change->new_date)->format('m-d-Y') }}
                                    <br />
                                    <small>
                                        {{ $change->newSlot ? date('g:i a', strtotime($change->newSlot->available_from)) . ' to ' . date('g:i a', strtotime($change->newSlot->available_to)) : 'N/A' }}
                                    </small>
                                </td>
                                {{-- <td class="text-center">{{ $change->oldSlot ? date('g:i a', strtotime($change->oldSlot->available_from)) . ' to ' . date('g:i a', strtotime($change->oldSlot->available_to)) : 'N/A' }}</td>
                                <td class="text-center">{{ $change->newSlot ? date('g:i a', strtotime($change->newSlot->available_from)) . ' to ' . date('g:i a', strtotime($change->newSlot->available_to)) : 'N/A' }}</td> --}}
                                <td class="text-center">{{ $change->changedBy ? $change->changedBy->name : 'System' }}</td>
                                <td class="text-center">{{ $change->reason ?? 'N/A' }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($change->created_at)->format('m-d-Y H:i') }}</td>
                            </tr>
                        @endforeach
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function formatDate(time) {
                const [hour, minute] = time.split(":");
                const ampm = hour >= 12 ? "PM" : "AM";
                const formattedHour = hour % 12 || 12;
                return `${formattedHour}:${minute} ${ampm}`;
            }
        </script>
    @endsection
