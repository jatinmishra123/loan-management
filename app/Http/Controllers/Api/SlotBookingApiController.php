<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SlotBooking;
use Illuminate\Http\Request;

class SlotBookingApiController extends Controller
{
    // All slot bookings
    public function index()
    {
        $bookings = SlotBooking::with(['agent', 'customer'])
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $bookings
        ], 200);
    }

    // Create Booking
    public function store(Request $request)
    {
        $request->validate([
            'agent_id'    => 'required',
            'customer_id' => 'required',
            'date'        => 'required|date',
            'time'        => 'required',
            'status'      => 'required'
        ]);

        $booking = SlotBooking::create([
            'agent_id'    => $request->agent_id,
            'customer_id' => $request->customer_id,
            'date'        => $request->date,
            'time'        => $request->time,
            'status'      => $request->status,
            'remarks'     => $request->remarks,
            'admin_id'    => auth('admin')->id(),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Slot Booking Created Successfully',
            'data'    => $booking
        ], 201);
    }

    // Show single record
    public function show($id)
    {
        $booking = SlotBooking::with(['agent', 'customer'])->find($id);

        if (!$booking) {
            return response()->json([
                'status'  => false,
                'message' => 'Booking not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $booking,
        ], 200);
    }

    // Update booking
    public function update(Request $request, $id)
    {
        $booking = SlotBooking::find($id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found',
            ], 404);
        }

        $request->validate([
            'agent_id'    => 'required',
            'customer_id' => 'required',
            'date'        => 'required|date',
            'time'        => 'required',
            'status'      => 'required'
        ]);

        $booking->update([
            'agent_id'    => $request->agent_id,
            'customer_id' => $request->customer_id,
            'date'        => $request->date,
            'time'        => $request->time,
            'status'      => $request->status,
            'remarks'     => $request->remarks,
            'admin_id'    => auth('admin')->id(),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Slot Booking Updated Successfully',
            'data'    => $booking
        ], 200);
    }

    // Delete booking
    public function destroy($id)
    {
        $booking = SlotBooking::find($id);

        if (!$booking) {
            return response()->json([
                'status'  => false,
                'message' => 'Booking not found'
            ], 404);
        }

        $booking->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Slot Booking Deleted Successfully'
        ], 200);
    }
}
