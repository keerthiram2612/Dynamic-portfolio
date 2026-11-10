@extends('admin.layout')
@section('title', $menu->exists ? 'Edit menu' : 'New menu')

@section('content')
  <h1>{{ $menu->exists ? 'Edit menu' : 'New menu' }}</h1>

  <form method="POST"
        action="{{ $menu->exists ? route('admin.menus.update', $menu) : route('admin.menus.store') }}">
    @csrf
    @if ($menu->exists) @method('PUT') @endif

    <label>Title <span class="hint">For example: Home, About</span>
      <input type="text" name="title" value="{{ old('title', $menu->title) }}" required>
    </label>
    @error('title') <div class="error">{{ $message }}</div> @enderror

    <label>Order <span class="hint">Lower numbers come first</span>
      <input type="text" name="sort_order" value="{{ old('sort_order', $menu->sort_order) }}">
    </label>
    @error('sort_order') <div class="error">{{ $message }}</div> @enderror

    <button type="submit">Save menu</button>
  </form>
@endsection