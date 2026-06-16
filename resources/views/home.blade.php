@extends('layouts.app')

@section('content')

@push('styles')
<style>
  .hero {
    background-color: #1a5276;
    color: #fff;
    padding: 60px 0;
    text-align: center;
  }

  .hero h1 { font-size: 2rem; font-weight: 700; }
  .hero p  { color: #cce4f7; margin-bottom: 30px; }

  .search-box {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    max-width: 750px;
    margin: 0 auto;
    color: #333;
  }

  .search-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
  }

  .search-box input,
  .search-box select {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 0.9rem;
  }

  .search-box label {
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 4px;
    display: block;
  }

  .btn-search {
    background-color: #1a5276;
    color: #fff;
    border: none;
    padding: 9px 20px;
    border-radius: 5px;
    width: 100%;
    margin-top: 15px;
    font-size: 0.95rem;
    cursor: pointer;
  }

  .stats {
    background-color: #f0f6fb;
    padding: 30px 0;
  }

  .stats-row {
    max-width: 800px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    padding: 0 20px;
    text-align: center;
  }

  .stat-box h3 { font-size: 2rem; font-weight: 800; color: #1a5276; }
  .stat-box p  { color: #555; font-size: 0.88rem; }

  .section {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
  }

  .section-title { text-align: center; margin-bottom: 30px; }
  .section-title h2 { font-size: 1.6rem; font-weight: 700; color: #1a5276; }
  .section-title p  { color: #666; font-size: 0.9rem; margin-top: 5px; }

  .rooms-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }

  .room-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
  }

  .room-card img { width: 100%; height: 160px; object-fit: cover; }
  .room-info { padding: 14px; }
  .room-info h5 { font-size: 0.98rem; font-weight: 700; color: #1a5276; margin-bottom: 5px; }
  .room-info p  { font-size: 0.83rem; color: #666; margin-bottom: 10px; }

  .price { font-weight: 700; color: #1a5276; font-size: 1rem; margin-bottom: 10px; }
  .price span { font-size: 0.78rem; font-weight: 400; color: #888; }

  .room-actions { display: flex; gap: 8px; }

  .btn-book {
    flex: 1; background-color: #1a5276; color: #fff;
    border: none; padding: 7px; border-radius: 5px;
    font-size: 0.83rem; font-weight: 600; text-align: center; text-decoration: none;
  }

  .btn-detail {
    flex: 1; background-color: #fff; color: #1a5276;
    border: 1px solid #1a5276; padding: 7px; border-radius: 5px;
    font-size: 0.83rem; font-weight: 600; text-align: center; text-decoration: none;
  }

  .features { background-color: #f0f6fb; padding: 50px 0; }

  .features-grid {
    max-width: 800px; margin: 0 auto;
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 20px; padding: 0 20px; text-align: center;
  }

  .feature-item .icon { font-size: 1.8rem; }
  .feature-item h6 { font-weight: 700; color: #1a5276; margin: 8px 0 4px; }
  .feature-item p  { font-size: 0.82rem; color: #666; }
</style>
@endpush

<!-- HERO -->
<section class="hero">
  <div style="max-width:900px; margin:0 auto; padding:0 20px;">
    <h1>Welcome to StayEase Hotel</h1>
    <p>Comfortable and affordable rooms. Book your stay today.</p>
    <div class="search-box">
      <div class="search-row">
        <div>
          <label>Check-In</label>
          <input type="date" />
        </div>
        <div>
          <label>Check-Out</label>
          <input type="date" />
        </div>
        <div>
          <label>Room Type</label>
          <select>
            <option>Any</option>
            <option>Single</option>
            <option>Double</option>
            <option>Suite</option>
          </select>
        </div>
        <div>
          <label>Guests</label>
          <select>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4+</option>
          </select>
        </div>
      </div>
      <button class="btn-search" onclick="window.location='{{ route('rooms') }}'">Search Rooms</button>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="stats">
  <div class="stats-row">
    <div class="stat-box"><h3>{{ $rooms->count() }}+</h3><p>Available Rooms</p></div>
    <div class="stat-box"><h3>500+</h3><p>Bookings Made</p></div>
    <div class="stat-box"><h3>8+</h3><p>Years of Service</p></div>
    <div class="stat-box"><h3>4.8★</h3><p>Average Rating</p></div>
  </div>
</section>

<!-- ROOMS -->
<section class="section">
  <div class="section-title">
    <h2>Available Rooms</h2>
    <p>Pick a room that fits your needs and budget</p>
  </div>
  <div class="rooms-grid">
    @foreach($rooms as $room)
    <div class="room-card">
      <img src="{{ asset($room->image) }}" alt="{{ $room->room_type }}" />
      <div class="room-info">
        <h5>{{ ucfirst($room->room_type) }} Room — {{ $room->room_number }}</h5>
        <p>{{ $room->description }}</p>
        <div class="price">Rs. {{ number_format($room->price) }} <span>/ night</span></div>
        <div class="room-actions">
          <a href="{{ route('booking', $room->id) }}" class="btn-book">Book Now</a>
          <a href="{{ route('room.detail', $room->id) }}" class="btn-detail">Details</a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>

<!-- FEATURES -->
<section class="features">
  <div class="section-title">
    <h2>Why Choose Us</h2>
    <p>We keep things simple and comfortable</p>
  </div>
  <div class="features-grid">
    <div class="feature-item"><div class="icon">📶</div><h6>Free Wi-Fi</h6><p>Available in all rooms.</p></div>
    <div class="feature-item"><div class="icon">🔒</div><h6>24/7 Security</h6><p>CCTV and trained staff.</p></div>
    <div class="feature-item"><div class="icon">🍽️</div><h6>Room Service</h6><p>Food at your doorstep.</p></div>
    <div class="feature-item"><div class="icon">🅿️</div><h6>Free Parking</h6><p>Secure parking available.</p></div>
  </div>
</section>

@endsection