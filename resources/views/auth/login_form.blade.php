 
@section('pageTitle', $pageTitle)
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  <title>@yield('pageTitle')</title>
</head>

@section('main')
  <div class="form-container">
    <h1 class="form-title">{{ $pageTitle }}</h1>
    <form class="form" method="POST" action="{{ route('auth.login') }}">
      @csrf
      <div class="form-item">
        <label>Email:</label>
        <input class="form-input" type="text" value="{{ old('email') }}" name="email" required>
        @error('email')
          <div class="alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-item"><label>Password:</label><input class="form-input" type="password"  name="password" required>
        @error('password')
          <div class="alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="form-button">Login</button>
    </form>

    <p class="auth-link">You don't have an account? <a href="{{ route('auth.signup') }}">Register here</a></p>
  </div> 