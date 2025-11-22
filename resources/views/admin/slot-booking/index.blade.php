@extends('admin.layouts.app')

@section('title', 'Slot Booking List')

@section('content')
<div class="row">
    <div class="col-lg-12 mx-auto">

        <div class="card shadow-sm border-0">

            {{-- Header --}}
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h4 class="fw-semibold text-primary mb-0">Slot Booking List</h4>

                <a href="{{ route('admin.slot-bookings.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus me-1"></i> Add Booking
                </a>
            </div>

            {{-- Table --}}
            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Agent</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bookings as $index => $b)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $b->agent->name }}</td>
                            <td>{{ $b->customer->brauser_name }}</td>
                            <td>{{ $b->date }}</td>
                            <td>{{ $b->time }}</td>

                            <td>
                                @if ($b->status == 'Pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif ($b->status == 'Confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif ($b->status == 'Cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>

                            <td>{{ $b->remarks }}</td>

                            <td>
                                <a href="{{ route('admin.slot-bookings.edit', $b->id) }}" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.slot-bookings.destroy', $b->id) }}"
                                      method="POST" class="d-inline">
                                      @csrf
                                      @method('DELETE')

                                      <button onclick="return confirm('Are you sure?')"
                                              class="btn btn-sm btn-danger">
                                          <i class="fa fa-trash"></i>
                                      </button>
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                No Slot Bookings Found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection
