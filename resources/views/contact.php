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
    max-width: 700px;
    margin: 36px auto;
    padding: 0 20px;
  }

  .contact-info {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 20px;
  }

  .contact-info h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #1a5276;
    margin-bottom: 14px;
  }

  .contact-info p {
    font-size: 0.88rem;
    color: #555;
    margin-bottom: 10px;
  }

  .contact-form {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 24px;
  }

  .contact-form h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #1a5276;
    margin-bottom: 16px;
  }

  label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: #444;
    margin-bottom: 5px;
  }

  input, textarea {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 0.92rem;
    margin-bottom: 16px;
    outline: none;
    font-family: 'Segoe UI', sans-serif;
  }

  input:focus, textarea:focus { border-color: #1a5276; }
  textarea { height: 110px; resize: vertical; }

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

  .btn-send {
    width: 100%;
    background-color: #1a5276;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 5px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
  }

  .btn-send:hover { background-color: #154360; }
</style>
@endpush

@section('content')

<div class="page-header">
  <h2>Contact Us</h2>
  <p>We'd love to hear from you</p>
</div>

<div class="container">

  <div class="contact-info">
    <h4>Get In Touch</h4>
    <p>📍 Address: Street 4, Satellite Town, Rawalpindi, Pakistan</p>
    <p>📞 Phone: +92 300 1234567</p>
    <p>✉️ Email: info@stayease.com</p>
    <p>🕐 Working Hours: Mon - Sat, 9am to 9pm</p>
  </div>

  <div class="contact-form">
    <h4>Send us a Message</h4>

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

    <form action="{{ route('contact.store') }}" method="POST">
      @csrf

      <label>Your Name</label>
      <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your name" />

      <label>Email Address</label>
      <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" />

      <label>Message</label>
      <textarea name="message" placeholder="Write your message here...">{{ old('message') }}</textarea>

      <button type="submit" class="btn-send">Send Message</button>

    </form>
  </div>

</div>

@endsection