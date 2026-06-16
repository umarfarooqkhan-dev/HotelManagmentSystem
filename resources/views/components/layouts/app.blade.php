<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>StayEase Hotel</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f9fd;
      color: #333;
    }

    nav {
      background-color: #1a5276;
      padding: 14px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .nav-brand {
      color: #fff;
      font-size: 1.3rem;
      font-weight: 700;
      text-decoration: none;
    }

    .nav-links a {
      color: #ccc;
      text-decoration: none;
      margin-left: 20px;
      font-size: 0.92rem;
    }

    .nav-links a:hover { color: #fff; }

    .btn-logout {
      background-color: #c0392b;
      color: #fff !important;
      padding: 5px 14px;
      border-radius: 4px;
      font-size: 0.85rem;
    }

    footer {
      text-align: center;
      padding: 16px;
      font-size: 0.82rem;
      color: #888;
      border-top: 1px solid #ddd;
      background: #fff;
      margin-top: 30px;
    }
  </style>
  @stack('styles')
</head>
<body>

<nav>
  <a class="nav-brand" href="{{ route('home') }}">StayEase Hotel</a>
  <div class="nav-links">
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('rooms') }}">Rooms</a>
    <a href="{{ route('contact') }}">Contact</a>
    @auth
      <a href="{{ route('dashboard') }}">Dashboard</a>
      <form action="{{ route('logout') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn-logout" style="border:none; cursor:pointer;">Logout</button>
      </form>
    @else
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}">Register</a>
    @endauth
  </div>
</nav>

<div>
  @yield('content')
</div>

<footer>© 2026 StayEase Hotel. All rights reserved.</footer>

</body>
</html>