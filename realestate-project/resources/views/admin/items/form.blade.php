@extends('admin.layout')
@section('title', $item->exists ? 'Edit entry' : 'New entry')

@section('content')
  <h1>{{ $item->exists ? 'Edit entry' : 'New entry' }} in {{ $menu->title }}</h1>

  <form method="POST" enctype="multipart/form-data"
        action="{{ $item->exists
            ? route('admin.menus.items.update', [$menu, $item])
            : route('admin.menus.items.store', $menu) }}">
    @csrf
    @if ($item->exists) @method('PUT') @endif

    <label>Title
      <input type="text" name="title" value="{{ old('title', $item->title) }}" required>
    </label>
    @error('title') <div class="error">{{ $message }}</div> @enderror

    <label>Content
      <textarea name="content">{{ old('content', $item->content) }}</textarea>
    </label>
    @error('content') <div class="error">{{ $message }}</div> @enderror

    <label>Image <span class="hint">JPG or PNG, up to 2 MB</span>
      @if ($item->image)
        <div><img src="{{ asset('storage/'.$item->image) }}" alt="" width="96"></div>
      @endif
      <input type="file" name="image" accept="image/*">
    </label>
    @error('image') <div class="error">{{ $message }}</div> @enderror

    <label>Order
      <input type="text" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}">
    </label>
    @error('sort_order') <div class="error">{{ $message }}</div> @enderror

    <button type="submit">Save entry</button>
    <a href="{{ route('admin.menus.items.index', $menu) }}">Cancel</a>
  </form>
@endsection