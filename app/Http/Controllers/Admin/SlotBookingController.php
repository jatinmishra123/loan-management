<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SlotBooking;
use App\Models\Agent;
use App\Models\Customer;
use Illuminate\Http\Request;

class SlotBookingController extends Controller
{
    public function index()
    {
        $bookings = SlotBooking::with(['agent', 'customer'])
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.slot-booking.index', compact('bookings'));
    }

    public function create()
    {
        return view('admin.slot-booking.create', [
            'agents'    => Agent::all(),
            'customers' => Customer::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'agent_id'    => 'required',
            'customer_id' => 'required',
            'date'        => 'required|date',
            'time'        => 'required',
            'status'      => 'required',
        ]);

        SlotBooking::create([
            'agent_id'    => $request->agent_id,
            'customer_id' => $request->customer_id,
            'date'        => $request->date,
            'time'        => $request->time,
            'status'      => $request->status,
            'remarks'     => $request->remarks,
            'created_by'  => auth('admin')->id(),   // ✅ Added
        ]);

        return redirect()->route('admin.slot-bookings.index')
            ->with('success', 'Slot Booking Created Successfully');
    }

    public function edit($id)
    {
        $booking = SlotBooking::findOrFail($id);

        return view('admin.slot-booking.edit', [
            'booking'   => $booking,
            'agents'    => Agent::all(),
            'customers' => Customer::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'agent_id'    => 'required',
            'customer_id' => 'required',
            'date'        => 'required|date',
            'time'        => 'required',
            'status'      => 'required',
        ]);

        $booking = SlotBooking::findOrFail($id);

        $booking->update([
            'agent_id'    => $request->agent_id,
            'customer_id' => $request->customer_id,
            'date'        => $request->date,
            'time'        => $request->time,
            'status'      => $request->status,
            'remarks'     => $request->remarks,
            'created_by'  => auth('admin')->id(),   
        ]);

        return redirect()->route('admin.slot-bookings.index')
            ->with('success', 'Slot Booking Updated Successfully');
    }

    public function destroy($id)
    {
        SlotBooking::findOrFail($id)->delete();

        return redirect()->route('admin.slot-bookings.index')
            ->with('success', 'Slot Booking Deleted Successfully');
    }
}
