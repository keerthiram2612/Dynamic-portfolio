@extends('admin.layout')
@section('title', 'Log in')

@section('content')
  <h1>Admin login</h1>
  <form method="POST" action="{{ route('admin.login.submit') }}">
    @csrf
    <label>Email
      <input type="email" name="email" value="{{ old('email') }}" required autofocus>
    </label>
    @error('email') <div class="error">{{ $message }}</div> @enderror

    <label>Password
      <input type="password" name="password" required>
    </label>

    <button type="submit">Log in</button>
  </form>
@endsection