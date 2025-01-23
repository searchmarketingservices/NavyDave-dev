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
</style>
@section('content')
    <div class="col-lg-10">
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <h5>Edit Slot</h5>
            <form action="{{ route('admin.slot.update', $slot->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="staff_id">Staff <span class="text-danger">*</span></label>
                            <select name="staff_id" id="staff_id" class="form-control @error('staff_id') is-invalid @enderror">
                                <option value="" disabled>Select Staff</option>
                                @foreach ($staff as $s)
                                    <option value="{{ $s->id }}" {{ $slot->staff_id == $s->id ? 'selected' : '' }}>
                                        {{ $s->user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('staff_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="service_id">Service <span class="text-danger">*</span></label>
                            <select name="service_id" id="service_id" class="form-control @error('service_id') is-invalid @enderror">
                                <option value="" disabled>Select Service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" {{ $slot->service_id == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="available_on">Available On <span class="text-danger">*</span></label>
                            <select name="available_on" id="available_on"
                                class="form-control @error('available_on') is-invalid @enderror">
                                <option value="" disabled>Select Days</option>
                                <option value="Monday" {{ $slot->available_on == 'Monday' ? 'selected' : '' }}>Monday</option>
                                <option value="Tuesday" {{ $slot->available_on == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                <option value="Wednesday" {{ $slot->available_on == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                <option value="Thursday" {{ $slot->available_on == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                <option value="Friday" {{ $slot->available_on == 'Friday' ? 'selected' : '' }}>Friday</option>
                                <option value="Saturday" {{ $slot->available_on == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                <option value="Sunday" {{ $slot->available_on == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                            </select>
                            @error('available_on')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="available_from">Available From <span class="text-danger">*</span></label>
                                <input type="time" name="available_from" id="available_from"
                                       class="form-control @error('available_from') is-invalid @enderror"
                                       value="{{ old('available_from', \Carbon\Carbon::parse($slot->available_from)->format('H:i')) }}">
                                @error('available_from')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="available_to">Available To <span class="text-danger">*</span></label>
                            <input type="time" name="available_to" id="available_to"
                                   class="form-control @error('available_to') is-invalid @enderror"
                                   value="{{ old('available_to', \Carbon\Carbon::parse($slot->available_to)->format('H:i')) }}">
                            @error('available_to')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                      </div>

            </div>
                <button type="submit" class="btn btn-success">Update Slot</button>
            </form>
        </div>
    </div>
@endsection
