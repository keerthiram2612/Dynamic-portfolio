<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    private function rules(): array
    {
        return [
            'title'      => ['required', 'string', 'max:120'],
            'content'    => ['nullable', 'string'],
            'image'      => ['nullable', 'image', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function index(Menu $menu)
    {
        $items = $menu->items;
        return view('admin.items.index', compact('menu', 'items'));
    }

    public function create(Menu $menu)
    {
        return view('admin.items.form', [
            'menu' => $menu,
            'item' => new MenuItem(['sort_order' => 0]),
        ]);
    }

    public function store(Request $request, Menu $menu)
    {
        $data = $request->validate($this->rules());
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        $menu->items()->create($data);

        return redirect()->route('admin.menus.items.index', $menu)->with('success', 'Entry created.');
    }

    public function edit(Menu $menu, MenuItem $item)
    {
        return view('admin.items.form', compact('menu', 'item'));
    }

    public function update(Request $request, Menu $menu, MenuItem $item)
    {
        $data = $request->validate($this->rules());
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $data['image'] = $request->file('image')->store('items', 'public');
        } else {
            unset($data['image']);
        }

        $item->update($data);

        return redirect()->route('admin.menus.items.index', $menu)->with('success', 'Entry updated.');
    }

    public function destroy(Menu $menu, MenuItem $item)
    {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        $item->delete();

        return redirect()->route('admin.menus.items.index', $menu)->with('success', 'Entry deleted.');
    }
}