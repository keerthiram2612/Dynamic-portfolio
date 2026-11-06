@extends('admin.layout')
@section('title', 'Profile')

@section('content')
  <h1>Home page profile</h1>

  @if (session('success'))
    <div class="success">{{ session('success') }}</div>
  @endif

  <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Name
      <input type="text" name="name" value="{{ old('name', $profile->name) }}" required>
    </label>
    @error('name') <div class="error">{{ $message }}</div> @enderror

    <label>Role <span class="hint">Shown in the hero, for example "Web developer"</span>
      <input type="text" name="role" value="{{ old('role', $profile->role) }}" required>
    </label>
    @error('role') <div class="error">{{ $message }}</div> @enderror

    <label>Tagline <span class="hint">Up to 200 characters</span>
      <textarea name="tagline" required>{{ old('tagline', $profile->tagline) }}</textarea>
    </label>
    @error('tagline') <div class="error">{{ $message }}</div> @enderror

    <label>Stack <span class="hint">Separate with commas: PHP, Laravel, React</span>
      <input type="text" name="stack" value="{{ old('stack', implode(', ', $profile->stack ?? [])) }}">
    </label>

    <label class="check">
      <input type="checkbox" name="available" value="1" @checked(old('available', $profile->available))>
      Available for work
    </label>

    <label>Email
      <input type="email" name="email" value="{{ old('email', $profile->email) }}" required>
    </label>
    @error('email') <div class="error">{{ $message }}</div> @enderror

    <label>About
      <textarea name="about">{{ old('about', $profile->about) }}</textarea>
    </label>

    <label>Photo <span class="hint">JPG or PNG, up to 2 MB</span>
      @if ($profile->photo)
        <div><img src="{{ asset('storage/'.$profile->photo) }}" alt="" width="96"></div>
      @endif
      <input type="file" name="photo" accept="image/*">
    </label>
    @error('photo') <div class="error">{{ $message }}</div> @enderror

    <label>GitHub URL
      <input type="url" name="github_url" value="{{ old('github_url', $profile->github_url) }}">
    </label>
    @error('github_url') <div class="error">{{ $message }}</div> @enderror

    <label>LinkedIn URL
      <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}">
    </label>
    @error('linkedin_url') <div class="error">{{ $message }}</div> @enderror

    <button type="submit">Save profile</button>
  </form>
@endsection