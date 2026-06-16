@extends('layouts.app')

@push('styles')
<style>
  .page-header {
    background-color: #1a5276;
    color: #fff;
    padding: 24px 30px;
  }

  .page-header h2 { font-size: 1.4rem; }

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

  input, select, textarea {
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

  input:focus, select:focus, textarea:focus { border-color: #1a5276; }
  textarea { height: 100px; resize: vertical; }

  .error-box {
    background-color: #fdecea;
    border: 1px solid #e74c3c;
    border-radius: 5px;
    padding: 10px 14px;
    margin-bottom: 16px;
    font-size: 0.85rem;
    color: #c0392b;
  }

  .current-image {
    font-size: 0.82rem;
    color: #888;
    margin-top: -10px;
    margin-bottom: 16px;
  }

  .btn-row { display: flex; gap: 10px; margin-top: 6px; }

  .btn-submit {
    flex: 1;
    background-color: #1a5276;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 5px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
  }

  .btn-submit:hover { background-color: #154360; }

  .btn-back {
    flex: 1;
    background-color: #fff;
    color: #1a5276;
    border: 1px solid #1a5276;
    padding: 10px;
    border-radius: 5px;
    font-size: 0.95rem;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
  }

  .btn-back:hover { background-color: #eaf4fb; }
</style>
@endpush

@section('content')

<div class="page-header">
  <h2>Edit Room</h2>
</div>

<div class="form-wrapper">
  <div class="form-card">
    <h4>Edit Room Details</h4>

    @if($errors->any())
      <div class="error-box">
        @foreach($errors->all() as $error)
          • {{ $error }}<br>
        @endforeach
      </div>
    @endif

    <form action="{{ route('admin.room.update', $room->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('POST')

      <label>Room Number</label>
      <input type="text" name="room_number" value="{{ $room->room_number }}" required />

      <label>Room Type</label>
      <select name="room_type" required>
        <option value="single" {{ $room->room_type == 'single' ? 'selected' : '' }}>Single</option>
        <option value="double" {{ $room->room_type == 'double' ? 'selected' : '' }}>Double</option>
        <option value="suite"  {{ $room->room_type == 'suite'  ? 'selected' : '' }}>Suite</option>
      </select>

      <label>Price Per Night (Rs.)</label>
      <input type="number" name="price" value="{{ $room->price }}" required />

      <label>Description</label>
      <textarea name="description">{{ $room->description }}</textarea>

      <label>Room Image (leave empty to keep current)</label>
      <input type="file" name="image" accept="image/*" />
      <div class="current-image">Current image: {{ $room->image }}</div>

      <label>Status</label>
      <select name="status" required>
        <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
        <option value="booked"    {{ $room->status == 'booked'    ? 'selected' : '' }}>Booked</option>
      </select>

      <div class="btn-row">
        <a href="{{ route('admin') }}" class="btn-back">← Back</a>
        <button type="submit" class="btn-submit">Save Changes</button>
      </div>

    </form>
  </div>
</div>

@endsection