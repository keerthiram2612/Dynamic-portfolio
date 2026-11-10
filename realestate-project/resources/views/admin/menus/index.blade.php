@extends('admin.layout')
@section('title', 'Menus')

@section('content')
  <div class="top">
    <h1>Menus</h1>
    <a class="btn" href="{{ route('admin.menus.create') }}">+ New menu</a>
  </div>

  @if (session('success'))
    <div class="success">{{ session('success') }}</div>
  @endif

  <table>
    <thead><tr><th>Order</th><th>Title</th><th>Entries</th><th></th></tr></thead>
    <tbody>
      @forelse ($menus as $menu)
        <tr>
          <td>{{ $menu->sort_order }}</td>
          <td>{{ $menu->title }}</td>
          <td>{{ $menu->items_count }}</td>
          <td>
            <div class="actions">
              <a class="btn" href="{{ route('admin.menus.items.index', $menu) }}">Entries</a>
              <a class="btn secondary" href="{{ route('admin.menus.edit', $menu) }}">Rename</a>
              <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}"
                    onsubmit="return confirm('Delete this menu and all its entries?')">
                @csrf @method('DELETE')
                <button type="submit" class="small danger">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="4">No menus yet. Create one, for example "Home" or "About".</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection