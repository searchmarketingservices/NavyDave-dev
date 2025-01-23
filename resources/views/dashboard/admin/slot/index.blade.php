@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.slots-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.slots-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.slots-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }

    div#servicesTable_wrapper .dt-buttons button.dt-button.buttons-excel.buttons-html5.t-btn {
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 15px;
        transition: .3s;
        background-color: #7a7a7a6b;
        border: 1px solid #7A7A7A;
        color: #7A7A7A;
    }

    div#servicesTable_wrapper .dt-buttons button.dt-button.buttons-excel.buttons-html5.t-btn:hover {
        background-color: #50bc7a;
        color: white;
        border-color: #50bc7a;
    }

    .main-calendar-box.slots-mana table td {
        height: auto !important;
    }
</style>
@section('content')
    <div class="col-lg-10">
        <div class="main-calendar-box main-calendar-box-list customers-box slots-mana">
            {{-- Display Success Message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="two-things-align">
                <h5>Slots Management</h5>
                <a href="{{ route('admin.slot.create') }}" class="t-btn">Add Slot</a>
            </div>

            <table class="table table-striped" id="Table">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Staff</th>
                        <th>Service</th>
                        <th>Available On</th>
                        <th>Available From</th>
                        <th>Available To</th>
                        <th>Actions</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($slots as $slot)
                        <tr>
                            <td>{{ $slot->id }}</td>
                            <td>{{ $slot->staff ? $slot->staff->user->name : 'No Staff Assigned' }}</td>
                            <td>{{ optional($slot->service)->name }}</td>
                            <td>{{ $slot->available_on }}</td>
                            <td>{{ date('g:i a', strtotime($slot->available_from)) }}</td>
                            <td>{{ date('g:i a', strtotime($slot->available_to)) }}</td>

                            <td>
                                <div class="action-box">
                                    <ul>
                                        <form action="{{ route('admin.slot.edit', $slot->id) }}" method="GET"
                                            style="display: inline;">
                                            @csrf
                                            @method('GET') <!-- Use this if your controller expects DELETE method -->
                                            <button type="submit" style="border: none; background: none; cursor: pointer;">
                                                <img src="/assets/images/pencil.png" alt="Delete" />
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.slot.destroy', $slot->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('POST') <!-- Use this if your controller expects DELETE method -->
                                            <button type="submit" style="border: none; background: none; cursor: pointer;">
                                                <img src="/assets/images/delete.png" alt="Delete" />
                                            </button>
                                        </form>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#Table').DataTable();
    });
</script>
