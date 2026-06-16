@extends('layouts.app')

@push('styles')
<style>
  .page-header {
    background-color: #1a5276;
    color: #fff;
    padding: 24px 30px;
  }

  .page-header h2 { font-size: 1.4rem; }
  .page-header p  { color: #cce4f7; font-size: 0.88rem; margin-top: 4px; }

  .container {
    max-width: 1000px;
    margin: 30px auto;
    padding: 0 20px;
  }

  .stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 30px;
  }

  .stat-box {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 18px;
    text-align: center;
  }

  .stat-box h3 { font-size: 1.8rem; font-weight: 700; color: #1a5276; }
  .stat-box p  { font-size: 0.82rem; color: #666; margin-top: 4px; }

  .card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 24px;
  }

  .card h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #1a5276;
    margin-bottom: 16px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.88rem;
  }

  th {
    background-color: #f0f6fb;
    color: #1a5276;
    padding: 10px 12px;
    text-align: left;
    font-weight: 600;
    border-bottom: 1px solid #ddd;
  }

  td {
    padding: 10px 12px;
    border-bottom: 1px solid #eee;
    color: #444;
  }

  tr:last-child td { border-bottom: none; }
  tr:hover td { background-color: #f9f9f9; }

  .badge {
    font-size: 0.75rem;
    padding: 3px 8px;
    border-radius: 10px;
    font-weight: 600;
  }

  .badge-available  { background: #eafaf1; color: #1e8449; }
  .badge-booked     { background: #fdecea; color: #c0392b; }
  .badge-pending    { background: #fef9e7; color: #b7950b; }
  .badge-confirmed  { background: #eafaf1; color: #1e8449; }
  .badge-cancelled  { background: #fdecea; color: #c0392b; }

  .btn-edit {
    background-color: #1a5276;
    color: #fff;
    border: none;
    padding: 5px 12px;
    border-radius: 4px;
    font-size: 0.8rem;
    cursor: pointer;
    text-decoration: none;
    margin-right: 4px;
  }

  .btn-delete {
    background-color: #c0392b;
    color: #fff;
    border: none;
    padding: 5px 12px;
    border-radius: 4px;
    font-size: 0.8rem;
    cursor: pointer;
    text-decoration: none;
  }

  .btn-edit:hover   { background-color: #154360; }
  .btn-delete:hover { background-color: #a93226; }

  .btn-add {
    background-color: #1a5276;
    color: #fff;
    border: none;
    padding: 7px 16px;
    border-radius: 5px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    float: right;
    margin-top: -36px;
    text-decoration: none;
  }

  .btn-add:hover { background-color: #154360; }

  .success-box {
    background-color: #eafaf1;
    border: 1px solid #27ae60;
    border-radius: 5px;
    padding: 10px 14px;
    margin-bottom: 16px;
    font-size: 0.85rem;
    color: #1e8449;
  }
</style>
@endpush

@section('content')

<div class="page-header">
  <h2>Admin Dashboard</h2>
  <p>Welcome, {{ auth()->user()->name }}! Manage rooms, bookings and users.</p>
</div>

<div class="container">

  @if(session('success'))
    <div class="success-box">✓ {{ session('success') }}</div>
  @endif

  <!-- STATS -->
  <div class="stats">
    <div class="stat-box"><h3>{{ $total_rooms }}</h3><p>Total Rooms</p></div>
    <div class="stat-box"><h3>{{ $available }}</h3><p>Available</p></div>
    <div class="stat-box"><h3>{{ $total_bookings }}</h3><p>Total Bookings</p></div>
    <div class="stat-box"><h3>{{ $total_users }}</h3><p>Registered Users</p></div>
  </div>

  <!-- ROOMS TABLE -->
  <div class="card">
    <h4>Manage Rooms
      <a href="{{ route('admin.room.create') }}" class="btn-add">+ Add Room</a>
    </h4>
    <table>
      <thead>
        <tr>
          <th>Room No</th>
          <th>Type</th>
          <th>Price / Night</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rooms as $room)
        <tr>
          <td>{{ $room->room_number }}</td>
          <td>{{ ucfirst($room->room_type) }}</td>
          <td>Rs. {{ number_format($room->price) }}</td>
          <td><span class="badge badge-{{ $room->status }}">{{ ucfirst($room->status) }}</span></td>
          <td>
            <a href="{{ route('admin.room.edit', $room->id) }}" class="btn-edit">Edit</a>
            <a href="{{ route('admin.room.delete', $room->id) }}"
               class="btn-delete"
               onclick="return confirm('Are you sure?')">Delete</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- BOOKINGS TABLE -->
  <div class="card">
    <h4>All Bookings</h4>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Guest</th>
          <th>Room</th>
          <th>Check-In</th>
          <th>Check-Out</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($bookings as $booking)
        <tr>
          <td>#{{ $booking->id }}</td>
          <td>{{ $booking->user->name }}</td>
          <td>{{ ucfirst($booking->room->room_type) }} {{ $booking->room->room_number }}</td>
          <td>{{ $booking->checkin }}</td>
          <td>{{ $booking->checkout }}</td>
          <td><span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
          <td>
            @if($booking->status == 'pending')
              <a href="{{ route('admin.booking.confirm', $booking->id) }}" class="btn-edit">Confirm</a>
              <a href="{{ route('admin.booking.cancel', $booking->id) }}"  class="btn-delete">Cancel</a>
            @endif
            <a href="{{ route('admin.booking.delete', $booking->id) }}"
               class="btn-delete"
               onclick="return confirm('Are you sure?')">Delete</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- USERS TABLE -->
  <div class="card">
    <h4>Registered Users</h4>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>
            <a href="{{ route('admin.user.delete', $user->id) }}"
               class="btn-delete"
               onclick="return confirm('Are you sure?')">Delete</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- MESSAGES TABLE -->
  <div class="card">
    <h4>Contact Messages</h4>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($messages as $msg)
        <tr>
          <td>#{{ $msg->id }}</td>
          <td>{{ $msg->name }}</td>
          <td>{{ $msg->email }}</td>
          <td>{{ Str::limit($msg->message, 60) }}</td>
          <td>{{ $msg->created_at->format('Y-m-d') }}</td>
          <td>
            <a href="#" class="btn-edit"
               onclick="document.getElementById('msg-{{ $msg->id }}').style.display='flex'; return false;">
               View
            </a>
            <div id="msg-{{ $msg->id }}"
                 style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
                        background:rgba(0,0,0,0.5); z-index:999; align-items:center; justify-content:center;">
              <div style="background:#fff; padding:30px; border-radius:8px; max-width:500px; width:90%; margin:auto;">
                <h4 style="color:#1a5276; margin-bottom:10px;">Message from {{ $msg->name }}</h4>
                <p style="font-size:0.85rem; color:#666; margin-bottom:10px;">📧 {{ $msg->email }}</p>
                <p style="font-size:0.9rem; color:#333; line-height:1.6; word-wrap:break-word;">{{ $msg->message }}</p>
                <br/>
                <button onclick="document.getElementById('msg-{{ $msg->id }}').style.display='none';"
                        style="background:#1a5276; color:#fff; border:none; padding:7px 16px; border-radius:5px; cursor:pointer;">
                  Close
                </button>
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>

@endsection