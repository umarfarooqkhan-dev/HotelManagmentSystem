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

  .filter-bar {
    background: #fff;
    border-bottom: 1px solid #ddd;
    padding: 14px 30px;
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
  }

  .filter-bar label { font-size: 0.85rem; font-weight: 600; color: #444; }

  .filter-bar select,
  .filter-bar input {
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 0.88rem;
    outline: none;
  }

  .btn-filter {
    background-color: #1a5276;
    color: #fff;
    border: none;
    padding: 6px 16px;
    border-radius: 5px;
    font-size: 0.88rem;
    cursor: pointer;
  }

  .btn-reset {
    background-color: #888;
    color: #fff;
    border: none;
    padding: 6px 16px;
    border-radius: 5px;
    font-size: 0.88rem;
    cursor: pointer;
  }

  .rooms-container {
    max-width: 1000px;
    margin: 30px auto;
    padding: 0 20px;
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

  .room img { width: 100%; height: 160px; object-fit: cover; }
  .room-info { padding: 14px; }

  .room-info h5 {
    font-size: 0.98rem;
    font-weight: 700;
    color: #1a5276;
    margin-bottom: 5px;
  }

  .room-info p { font-size: 0.83rem; color: #666; margin-bottom: 10px; line-height: 1.5; }

  .price { font-weight: 700; color: #1a5276; font-size: 1rem; margin-bottom: 10px; }
  .price span { font-size: 0.78rem; font-weight: 400; color: #888; }

  .badge { font-size: 0.75rem; padding: 2px 8px; border-radius: 10px; font-weight: 600; float: right; }
  .badge-available { background: #eafaf1; color: #1e8449; }
  .badge-booked    { background: #fdecea; color: #c0392b; }

  .room-actions { display: flex; gap: 8px; margin-top: 8px; }

  .btn-book {
    flex: 1; background-color: #1a5276; color: #fff;
    border: none; padding: 7px; border-radius: 5px;
    font-size: 0.83rem; font-weight: 600; text-align: center; text-decoration: none;
  }

  .btn-book:hover { background-color: #154360; }

  .btn-detail {
    flex: 1; background-color: #fff; color: #1a5276;
    border: 1px solid #1a5276; padding: 7px; border-radius: 5px;
    font-size: 0.83rem; font-weight: 600; text-align: center; text-decoration: none;
  }

  .btn-detail:hover { background-color: #eaf4fb; }

  .btn-unavailable {
    flex: 1; background-color: #ccc; color: #fff;
    border: none; padding: 7px; border-radius: 5px;
    font-size: 0.83rem; font-weight: 600; text-align: center; cursor: not-allowed;
  }

  @media (max-width: 768px) { .rooms-container { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 500px) { .rooms-container { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

<div class="page-header">
  <h2>Our Rooms</h2>
  <p>Choose a room that fits your needs and budget</p>
</div>

<!-- FILTER BAR -->
<div class="filter-bar">
  <label>Type:</label>
  <select id="filterType">
    <option value="all">All</option>
    <option value="single">Single</option>
    <option value="double">Double</option>
    <option value="suite">Suite</option>
  </select>

  <label>Status:</label>
  <select id="filterStatus">
    <option value="all">All</option>
    <option value="available">Available</option>
    <option value="booked">Booked</option>
  </select>

  <label>Max Price (Rs.):</label>
  <input type="number" id="filterPrice" placeholder="e.g. 5000" style="width:110px;" />

  <button class="btn-filter" onclick="filterRooms()">Filter</button>
  <button class="btn-reset"  onclick="resetFilter()">Reset</button>
</div>

<!-- ROOMS GRID -->
<div class="rooms-container" id="roomsGrid">
  @foreach($rooms as $room)
  <div class="room-card" data-type="{{ $room->room_type }}" data-status="{{ $room->status }}" data-price="{{ $room->price }}">
    <div class="room">
      <img src="{{ asset($room->image) }}" alt="{{ $room->room_type }}" />
    </div>
    <div class="room-info">
      <h5>
        {{ ucfirst($room->room_type) }} Room — {{ $room->room_number }}
        <span class="badge badge-{{ $room->status }}">{{ ucfirst($room->status) }}</span>
      </h5>
      <p>{{ $room->description }}</p>
      <div class="price">Rs. {{ number_format($room->price) }} <span>/ night</span></div>
      <div class="room-actions">
        @if($room->status == 'available')
          <a href="{{ route('booking', $room->id) }}" class="btn-book">Book Now</a>
        @else
          <span class="btn-unavailable">Unavailable</span>
        @endif
        <a href="{{ route('room.detail', $room->id) }}" class="btn-detail">Details</a>
      </div>
    </div>
  </div>
  @endforeach
</div>

<script>
  function filterRooms() {
    const type   = document.getElementById('filterType').value;
    const status = document.getElementById('filterStatus').value;
    const price  = document.getElementById('filterPrice').value;
    const cards  = document.querySelectorAll('.room-card');

    cards.forEach(card => {
      const typeMatch   = type   === 'all' || card.dataset.type   === type;
      const statusMatch = status === 'all' || card.dataset.status === status;
      const priceMatch  = price  === ''    || parseInt(card.dataset.price) <= parseInt(price);
      card.style.display = (typeMatch && statusMatch && priceMatch) ? 'block' : 'none';
    });
  }

  function resetFilter() {
    document.getElementById('filterType').value   = 'all';
    document.getElementById('filterStatus').value = 'all';
    document.getElementById('filterPrice').value  = '';
    document.querySelectorAll('.room-card').forEach(c => c.style.display = 'block');
  }
</script>

@endsection