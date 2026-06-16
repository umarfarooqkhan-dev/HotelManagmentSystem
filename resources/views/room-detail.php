@extends('layouts.app')

@push('styles')
<style>
  .container {
    max-width: 700px;
    margin: 36px auto;
    padding: 0 20px;
  }

  .room-image {
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #ddd;
  }

  .room-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 24px;
    margin-top: 20px;
  }

  .room-card h2 {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1a5276;
    margin-bottom: 6px;
  }

  .price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a5276;
    margin-bottom: 16px;
  }

  .price span { font-size: 0.82rem; font-weight: 400; color: #888; }

  .badge {
    font-size: 0.78rem;
    padding: 3px 10px;
    border-radius: 10px;
    font-weight: 600;
    margin-left: 10px;
  }

  .badge-available { background: #eafaf1; color: #1e8449; }
  .badge-booked    { background: #fdecea; color: #c0392b; }

  .divider { border: none; border-top: 1px solid #eee; margin: 16px 0; }

  .room-card h4 { font-size: 0.95rem; font-weight: 700; color: #444; margin-bottom: 8px; }
  .room-card p  { font-size: 0.88rem; color: #666; line-height: 1.7; margin-bottom: 16px; }

  .amenities { list-style: none; padding: 0; margin-bottom: 16px; }
  .amenities li { font-size: 0.88rem; color: #555; padding: 4px 0; }
  .amenities li::before { content: "✓ "; color: #1e8449; font-weight: 700; }

  .btn-row { display: flex; gap: 10px; margin-top: 20px; }

  .btn-book {
    flex: 1; background-color: #1a5276; color: #fff;
    border: none; padding: 10px; border-radius: 5px;
    font-size: 0.92rem; font-weight: 600; text-align: center; text-decoration: none;
  }

  .btn-book:hover { background-color: #154360; }

  .btn-back {
    flex: 1; background-color: #fff; color: #1a5276;
    border: 1px solid #1a5276; padding: 10px; border-radius: 5px;
    font-size: 0.92rem; font-weight: 600; text-align: center; text-decoration: none;
  }

  .btn-back:hover { background-color: #eaf4fb; }

  .btn-unavailable {
    flex: 1; background-color: #ccc; color: #fff;
    border: none; padding: 10px; border-radius: 5px;
    font-size: 0.92rem; font-weight: 600; text-align: center; cursor: not-allowed;
  }
</style>
@endpush

@section('content')

<div class="container">

  <img src="{{ asset($room->image) }}" alt="Room Image" class="room-image" />

  <div class="room-card">

    <h2>
      {{ ucfirst($room->room_type) }} Room — {{ $room->room_number }}
      <span class="badge badge-{{ $room->status }}">{{ ucfirst($room->status) }}</span>
    </h2>

    <div class="price">Rs. {{ number_format($room->price) }} <span>/ night</span></div>

    <hr class="divider" />

    <h4>Description</h4>
    <p>{{ $room->description }}</p>

    <hr class="divider" />

    <h4>Amenities</h4>
    <ul class="amenities">
      <li>Free Wi-Fi</li>
      <li>Air Conditioning</li>
      <li>Attached Bathroom</li>
      <li>24/7 Hot Water</li>
      <li>Daily Housekeeping</li>
      <li>Room Service</li>
    </ul>

    <div class="btn-row">
      <a href="{{ route('rooms') }}" class="btn-back">← Back to Rooms</a>
      @if($room->status == 'available')
        <a href="{{ route('booking', $room->id) }}" class="btn-book">Book This Room</a>
      @else
        <span class="btn-unavailable">Currently Unavailable</span>
      @endif
    </div>

  </div>
</div>

@endsection