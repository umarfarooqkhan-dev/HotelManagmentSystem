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

  .form-wrapper {
    max-width: 600px;
    margin: 36px auto;
    padding: 0 20px;
  }

  .form-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 30px;
  }

  .form-card h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a5276;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
  }

  label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: #444;
    margin-bottom: 5px;
  }

  input, select {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 0.92rem;
    margin-bottom: 16px;
    outline: none;
    font-family: 'Segoe UI', sans-serif;
    background-color: #fff;
  }

  input:focus, select:focus { border-color: #1a5276; }

  .error-box {
    background-color: #fdecea;
    border: 1px solid #e74c3c;
    border-radius: 5px;
    padding: 10px 14px;
    margin-bottom: 16px;
    font-size: 0.85rem;
    color: #c0392b;
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

  .section-label {
    font-size: 0.88rem;
    font-weight: 700;
    color: #1a5276;
    margin-bottom: 14px;
  }

  .divider { border: none; border-top: 1px solid #eee; margin: 20px 0; }

  .two-col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
  }

  .btn-submit {
    width: 100%;
    background-color: #1a5276;
    color: #fff;
    border: none;
    padding: 11px;
    border-radius: 5px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    margin-top: 6px;
  }

  .btn-submit:hover { background-color: #154360; }
</style>
@endpush

@section('content')

<div class="page-header">
  <h2>Book a Room</h2>
  <p>Fill in the details below to complete your booking</p>
</div>

<div class="form-wrapper">
  <div class="form-card">
    <h4>Booking Form</h4>

    @if(session('success'))
      <div class="success-box">✓ {{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="error-box">
        @foreach($errors->all() as $error)
          • {{ $error }}<br>
        @endforeach
      </div>
    @endif

    <form action="{{ route('booking.store') }}" method="POST">
      @csrf

      <div class="section-label">Room Details</div>

      <label>Select Room</label>
      <select name="room_id">
        <option value="">-- Select a Room --</option>
        @foreach($rooms as $r)
          <option value="{{ $r->id }}" {{ $room->id == $r->id ? 'selected' : '' }}>
            {{ ucfirst($r->room_type) }} Room — {{ $r->room_number }} (Rs. {{ number_format($r->price) }})
          </option>
        @endforeach
      </select>

      <label>Number of Guests</label>
      <select name="guests">
        <option value="">-- Select --</option>
        <option value="1">1 Guest</option>
        <option value="2">2 Guests</option>
        <option value="3">3 Guests</option>
        <option value="4">4+ Guests</option>
      </select>

      <div class="two-col">
        <div>
          <label>Check-In Date</label>
          <input type="date" name="checkin" />
        </div>
        <div>
          <label>Check-Out Date</label>
          <input type="date" name="checkout" />
        </div>
      </div>

      <hr class="divider" />

      <div class="section-label">Special Requests (optional)</div>
      <input type="text" name="requests" placeholder="Any special requests?" />

      <button type="submit" class="btn-submit">Confirm Booking</button>

    </form>
  </div>
</div>

@endsection