<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::withCount('users')->orderBy('nama')->get();
        return view('setting.level.index', compact('levels'));
    }

    public function create()
    {
        return view('setting.level.form', [
            'level' => new Level(),
            'menus' => $this->tree(),
            'access' => [],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['nama' => 'required|string|max:100|unique:levels,nama']);
        $level = Level::create(['nama' => strtolower(trim($data['nama']))]);
        $this->saveAccess($level, $request->input('access', []));

        return redirect()->route('setting.level.index')->with('success', 'Level berhasil dibuat.');
    }

    public function edit(Level $level)
    {
        $access = $level->menus
            ->mapWithKeys(
                fn($m) => [
                    $m->id => [
                        'view' => $m->pivot->can_view,
                        'add' => $m->pivot->can_add,
                        'edit' => $m->pivot->can_edit,
                        'del' => $m->pivot->can_del,
                    ],
                ],
            )
            ->all();

        return view('setting.level.form', ['level' => $level, 'menus' => $this->tree(), 'access' => $access]);
    }

    public function update(Request $request, Level $level)
    {
        $data = $request->validate(['nama' => "required|string|max:100|unique:levels,nama,{$level->id}"]);

        if (!$level->is_system) {
            $level->update(['nama' => strtolower(trim($data['nama']))]);
        }
        $this->saveAccess($level, $request->input('access', []));

        return redirect()->route('setting.level.index')->with('success', 'Level berhasil diperbarui.');
    }

    public function destroy(Level $level)
    {
        if ($level->is_system) {
            throw ValidationException::withMessages(['level' => 'Level sistem tidak dapat dihapus.']);
        }
        if ($level->users()->exists()) {
            throw ValidationException::withMessages(['level' => 'Level masih dipakai oleh user.']);
        }

        $level->delete();
        Level::forgetAccess($level->id);

        return back()->with('success', 'Level berhasil dihapus.');
    }

    private function tree()
    {
        return Menu::whereNull('parent_id')->with('childrenRecursive')->orderBy('urutan')->get();
    }

    private function saveAccess(Level $level, array $access): void
    {
        $leafIds = Menu::whereDoesntHave('children')->pluck('id')->flip();

        $sync = [];
        foreach ($access as $menuId => $acts) {
            if (!isset($leafIds[$menuId])) {
                continue;
            } // hanya menu paling ujung yang punya izin

            $add = isset($acts['add']);
            $edit = isset($acts['edit']);
            $del = isset($acts['del']);
            $sync[$menuId] = [
                'can_view' => isset($acts['view']) || $add || $edit || $del, // add/edit/del selalu butuh view
                'can_add' => $add,
                'can_edit' => $edit,
                'can_del' => $del,
            ];
        }

        $level->menus()->sync($sync);
        Level::forgetAccess($level->id);
    }
}
