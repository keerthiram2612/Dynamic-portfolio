@extends('admin.layout')
@section('title', $profile->exists ? 'Edit profile' : 'New profile')

@section('content')
  <h1>{{ $profile->exists ? 'Edit profile' : 'New profile' }}</h1>

  <form method="POST" enctype="multipart/form-data"
        action="{{ $profile->exists ? route('admin.profiles.update', $profile) : route('admin.profiles.store') }}">
    @csrf
    @if ($profile->exists) @method('PUT') @endif

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
    <a href="{{ route('admin.profiles.index') }}">Cancel</a>
  </form>
@endsection