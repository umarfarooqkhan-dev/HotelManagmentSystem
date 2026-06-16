@extends('layouts.app')

@push('styles')
<style>
  .page-header {
    background-color: #1a5276;
    color: #fff;
    padding: 30px;
    text-align: center;
  }

  .page-header h2 { font-size: 1.6rem; }
  .page-header p  { color: #cce4f7; font-size: 0.9rem; margin-top: 5px; }

  .container {
    max-width: 900px;
    margin: 36px auto;
    padding: 0 20px;
  }

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

  .badge {
    font-size: 0.75rem;
    padding: 3px 8px;
    border-radius: 10px;
    font-weight: 600;
  }

  .badge-pending   { background: #fef9e7; color: #b7950b; }
  .badge-confirmed { background: #eafaf1; color: #1e8449; }
  .badge-cancelled { background: #fdecea; color: #c0392b; }

  .no-bookings {
    text-align: center;
    color: #888;
    font-size: 0.95rem;
    padding: 30px;
  }

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
  <h2>My Dashboard</h2>
  <p>Welcome, {{ auth()->user()->name }}! Manage your bookings here.</p>
</div>

<div class="container">

  @if(session('success'))
    <div class="success-box">✓ {{ session('success') }}</div>
  @endif

  <div class="card">
    <h4>My Bookings</h4>

    @if($bookings->isEmpty())
      <div class="no-bookings">You have no bookings yet. <a href="{{ route('rooms') }}">Book a room!</a></div>
    @else
      <table>
        <thead>
          <tr>
            <th>Room</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Guests</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($bookings as $booking)
          <tr>
            <td>{{ ucfirst($booking->room->room_type) }} — {{ $booking->room->room_number }}</td>
            <td>{{ $booking->checkin }}</td>
            <td>{{ $booking->checkout }}</td>
            <td>{{ $booking->guests }}</td>
            <td><span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

</div>

@endsection