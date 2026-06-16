<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Admin dashboard
    public function index()
    {
        $rooms        = Room::all();
        $bookings     = Booking::with('user', 'room')->latest()->get();
        $users        = User::where('role', 'user')->get();
        $messages     = Contact::latest()->get();
        $total_rooms  = Room::count();
        $available    = Room::where('status', 'available')->count();
        $total_bookings = Booking::count();
        $total_users  = User::where('role', 'user')->count();

        return view('admin', compact(
            'rooms', 'bookings', 'users', 'messages',
            'total_rooms', 'available', 'total_bookings', 'total_users'
        ));
    }

    // Add room form
    public function createRoom()
    {
        return view('admin-add-room');
    }

    // Save new room
    public function storeRoom(Request $request)
    {
        $request->validate([
            'room_number' => 'required',
            'room_type'   => 'required',
            'price'       => 'required|numeric',
        ]);

        $image = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path(), $image);
        }

        Room::create([
            'room_number' => $request->room_number,
            'room_type'   => $request->room_type,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $image,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin')->with('success', 'Room added successfully!');
    }

    // Edit room form
    public function editRoom($id)
    {
        $room = Room::findOrFail($id);
        return view('admin-edit-room', compact('room'));
    }

    // Update room
    public function updateRoom(Request $request, $id)
    {
        $room  = Room::findOrFail($id);
        $image = $room->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path(), $image);
        }

        $room->update([
            'room_number' => $request->room_number,
            'room_type'   => $request->room_type,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $image,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin')->with('success', 'Room updated successfully!');
    }

    // Delete room
    public function deleteRoom($id)
    {
        Room::findOrFail($id)->delete();
        return redirect()->route('admin')->with('success', 'Room deleted successfully!');
    }

    // Confirm booking
    public function confirmBooking($id)
    {
        Booking::findOrFail($id)->update(['status' => 'confirmed']);
        return redirect()->route('admin')->with('success', 'Booking confirmed!');
    }

    // Cancel booking
    public function cancelBooking($id)
    {
        Booking::findOrFail($id)->update(['status' => 'cancelled']);
        return redirect()->route('admin')->with('success', 'Booking cancelled!');
    }

    // Delete booking
    public function deleteBooking($id)
    {
        Booking::findOrFail($id)->delete();
        return redirect()->route('admin')->with('success', 'Booking deleted!');
    }

    // Delete user
    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin')->with('success', 'User deleted!');
    }
}