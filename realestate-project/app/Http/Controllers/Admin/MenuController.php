<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::withCount('items')->orderBy('sort_order')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.form', ['menu' => new Menu(['sort_order' => 0])]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'      => ['required', 'string', 'max:80', 'unique:menus,title'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Menu::create($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created.');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.form', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'title'      => ['required', 'string', 'max:80', 'unique:menus,title,' . $menu->id],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $menu->update($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated.');
    }

    public function destroy(Menu $menu)
    {
        foreach ($menu->items as $item) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
        }

        $menu->delete(); // items are removed by cascade

        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted.');
    }
}