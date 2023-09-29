@section('main')
{{--  @section('pageTitle', $pageTitle)  --}}
<!DOCTYPE html> 
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Login Form | 2</title> 
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
  <body>
    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Halaman Login</span></div>
        <form method="POST" action="{{ route('auth.login2') }}">
          
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" value="{{ old('email') }}" placeholder="Email or Phone" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" required>
          </div>
          <div class="pass"><a href="#">Forgot password?</a></div>
          <div class="row button">
            <input type="submit" value="Login">
          </div>
          <div class="signup-link">Not a member? <a href="{{ route('auth.signup') }}">Signup now</a></div>
        </form>
      </div>
    </div>

  </body>
</html>