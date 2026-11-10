@extends('admin.layout')
@section('title', 'Profiles')

@section('content')
  <div class="top">
    <h1>Profiles</h1>
    <a class="btn" href="{{ route('admin.profiles.create') }}">+ New profile</a>
  </div>

  @if (session('success'))
    <div class="success">{{ session('success') }}</div>
  @endif

  <table>
    <thead>
      <tr><th>Photo</th><th>Name</th><th>Role</th><th>Email</th><th>Available</th><th></th></tr>
    </thead>
    <tbody>
      @forelse ($profiles as $profile)
        <tr>
          <td>
            @if ($profile->photo)
              <img src="{{ asset('storage/'.$profile->photo) }}" alt="" width="48">
            @endif
          </td>
          <td>{{ $profile->name }}</td>
          <td>{{ $profile->role }}</td>
          <td>{{ $profile->email }}</td>
          <td>{{ $profile->available ? 'Yes' : 'No' }}</td>
          <td>
            <div class="actions">
              <a class="btn secondary" href="{{ route('admin.profiles.edit', $profile) }}">Edit</a>
              <form method="POST" action="{{ route('admin.profiles.destroy', $profile) }}"
                    onsubmit="return confirm('Delete this profile?')">
                @csrf @method('DELETE')
                <button type="submit" class="small danger">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="6">No profiles yet.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection