@extends('admin.layouts.app')

@section('title', 'Create Slot Booking')

@section('content')
<div class="row">
    <div class="col-lg-14 mx-auto">

        <div class="card shadow-sm border-0">

            {{-- Header --}}
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h4 class="fw-semibold text-primary mb-0">Create Slot Booking</h4>
                <a href="{{ route('admin.slot-bookings.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Back
                </a>
            </div>

            {{-- Body --}}
            <div class="card-body">
                <form action="{{ route('admin.slot-bookings.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">

                        {{-- Agent --}}
                        <div class="col-md-6">
                            <label class="form-label">Select Agent <span class="text-danger">*</span></label>
                            <select name="agent_id" class="form-select" required>
                                <option value="">-- Select Agent --</option>
                                @foreach ($agents as $a)
                                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Customer --}}
                        <div class="col-md-6">
                            <label class="form-label">Select Customer <span class="text-danger">*</span></label>
                            <select name="customer_id" class="form-select" required>
                                <option value="">-- Select Customer --</option>
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}">{{ $c->brauser_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Date --}}
                        <div class="col-md-4">
                            <label class="form-label">Booking Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" required>
                        </div>

                        {{-- Time (30 min gap) --}}
                        <div class="col-md-4">
                            <label class="form-label">Time (30 minutes) <span class="text-danger">*</span></label>
                            <select name="time" class="form-select" required>
    <option value="">-- Select Time --</option>
    @php
        for ($h = 0; $h < 24; $h++) {
            for ($m = 0; $m < 60; $m += 30) {
                $time24 = sprintf('%02d:%02d', $h, $m); // database value
                $time12 = date("h:i A", strtotime($time24)); // display value
                echo "<option value='$time24'>$time12</option>";
            }
        }
    @endphp
</select>

                        </div>

                        {{-- Status --}}
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        {{-- Remarks --}}
                        <div class="col-12">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3" class="form-control" placeholder="Add any notes"></textarea>
                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-1"></i> Save Booking
                        </button>

                        <a href="{{ route('admin.slot-bookings.index') }}" class="btn btn-light">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>
@endsection
