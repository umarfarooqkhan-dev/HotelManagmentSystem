<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Home page
    public function index()
    {
        $rooms = Room::where('status', 'available')->limit(3)->get();
        return view('home', compact('rooms'));
    }

    // Rooms page
    public function rooms()
    {
        $rooms = Room::all();
        return view('rooms', compact('rooms'));
    }

    // Room detail page
    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('room-detail', compact('room'));
    }
}