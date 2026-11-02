<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $byParent = Menu::orderBy('kdmenu')->get()->groupBy(fn ($m) => $m->parent_id ?? 0);

        $rows = collect();
        $walk = function ($parentId, $depth) use (&$walk, $byParent, &$rows) {
            foreach ($byParent->get($parentId, collect()) as $m) {
                $m->depth = $depth;
                $m->has_children = $byParent->has($m->id);
                $rows->push($m);
                $walk($m->id, $depth + 1);
            }
        };
        $walk(0, 0);

        return view('setting.menu.index', compact('rows'));
    }

    public function store(Request $request, MenuService $service)
    {
        $data = $request->validate([
            'parent_id' => 'nullable|integer',
            'nama'      => 'required|string|max:100',
            'url'       => 'nullable|string|max:255',
            'icon'      => 'nullable|string|max:50',
        ]);

        $parent = (! empty($data['parent_id']) && $data['parent_id'] != 0) ? Menu::find($data['parent_id']) : null;
        $service->create($data, $parent);

        return back()->with('success', 'Menu berhasil ditambahkan.');
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'url'  => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        $url = $menu->children()->exists() ? '#' : ($data['url'] ?: '#');

        $menu->update([
            'nmmenu' => $data['nama'],
            'url'    => $url,
            'icon'   => $data['icon'] ?? null,
        ]);

        \Illuminate\Support\Facades\Cache::flush();

        return back()->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu, MenuService $service)
    {
        $service->delete($menu);

        return back()->with('success', 'Menu berhasil dihapus.');
    }
}
