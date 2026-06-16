<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Show booking form
    public function index($id)
    {
        $room  = Room::findOrFail($id);
        $rooms = Room::where('status', 'available')->get();
        return view('booking', compact('room', 'rooms'));
    }

    // Save booking
    public function store(Request $request)
    {
        $request->validate([
            'room_id'  => 'required',
            'guests'   => 'required',
            'checkin'  => 'required|date',
            'checkout' => 'required|date|after:checkin',
        ]);

        Booking::create([
            'user_id'  => auth()->id(),
            'room_id'  => $request->room_id,
            'checkin'  => $request->checkin,
            'checkout' => $request->checkout,
            'guests'   => $request->guests,
            'requests' => $request->requests,
        ]);

        // update room status to booked
        Room::where('id', $request->room_id)->update(['status' => 'booked']);

        return redirect()->route('dashboard')->with('success', 'Booking confirmed!');
    }

    // User dashboard
    public function dashboard()
    {
        $bookings = Booking::where('user_id', auth()->id())->with('room')->get();
        return view('dashboard', compact('bookings'));
    }
}