@extends('layouts.master')
@section('pageTitle', $pageTitle)
@section('main')
    <div class='form-container'>
        <h1 class='form-title'>{{ $pageTitle }}</h1>
        <form class='form' method='POST' action='{{ route('auth.signup') }}'>
            @csrf 
            <div class='form-item'><label>name</label> <input class='form-input' name='name'/>  </div>
            <div class='form-item'><label>email</label> <input class='form-input' name='email' /> 
            @error('email')
            <div class='alert-danger'>{{ $message }}</div>
            @enderror </div>
            <div class='form-item'><label>password</label><input type="password" class='form-input' name='password'/></div>
            <button type='submit' class='form-button'>submit</button>
        </form>
        <p class="auth-link">Already have an account? <a href="{{ route('auth.login') }}">Login here</a></p>
 
    </div>
@endsection
