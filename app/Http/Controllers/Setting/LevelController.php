<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LevelController extends Controller
{
    public function index()
    {
        // Ambil daftar level unik dari tabel ms_level sistem lama
        $levelNames = DB::connection('mysql')
            ->table('ms_level')
            ->select('nama_level')
            ->distinct()
            ->orderBy('nama_level')
            ->get();

        $levels = $levelNames->map(function ($item, $index) {
            $userCount = DB::connection('billing')
                ->table('b_ms_user')
                ->where(function ($q) use ($item) {
                    $q->where('akses_satu_sehat', $item->nama_level)
                      ->orWhere('akses', $item->nama_level);
                })
                ->where('aktif', '1')
                ->count();

            return (object) [
                'id'          => $item->nama_level,
                'nama'        => $item->nama_level,
                'nama_level'  => $item->nama_level,
                'is_system'   => strtolower($item->nama_level) === 'superuser',
                'users_count' => $userCount,
                'created_at'  => null,
            ];
        });

        return view('setting.level.index', compact('levels'));
    }

    public function create()
    {
        $dummyLevel = (object) [
            'id'        => null,
            'nama'      => '',
            'is_system' => false,
            'exists'    => false,
        ];

        return view('setting.level.form', [
            'level'  => $dummyLevel,
            'menus'  => $this->tree(),
            'access' => [],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        $namaLevel = trim($data['nama']);

        $exists = DB::connection('mysql')
            ->table('ms_level')
            ->where('nama_level', $namaLevel)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages(['nama' => 'Nama level sudah digunakan.']);
        }

        $this->saveAccess($namaLevel, $request->input('access', []));

        return redirect()->route('setting.level.index')->with('success', 'Level berhasil dibuat.');
    }

    public function edit(string $id)
    {
        $namaLevel = $id;

        $exists = DB::connection('mysql')
            ->table('ms_level')
            ->where('nama_level', $namaLevel)
            ->exists();

        if (! $exists) {
            abort(404, 'Level tidak ditemukan.');
        }

        $records = DB::connection('mysql')
            ->table('ms_level')
            ->where('nama_level', $namaLevel)
            ->get();

        $access = [];
        foreach ($records as $r) {
            $actKey = match ((int) $r->act) {
                1 => 'view',
                2 => 'add',
                3 => 'edit',
                4 => 'del',
                default => null,
            };

            if ($actKey) {
                $access[$r->id_menu][$actKey] = true;
            }
        }

        $levelObj = (object) [
            'id'        => $namaLevel,
            'nama'      => $namaLevel,
            'is_system' => strtolower($namaLevel) === 'superuser',
            'exists'    => true,
        ];

        return view('setting.level.form', [
            'level'  => $levelObj,
            'menus'  => $this->tree(),
            'access' => $access,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $namaLevel = $id;

        if (strtolower($namaLevel) !== 'superuser') {
            $data = $request->validate([
                'nama' => 'required|string|max:100',
            ]);
            $newNamaLevel = trim($data['nama']);

            if (strtolower($newNamaLevel) !== strtolower($namaLevel)) {
                $exists = DB::connection('mysql')
                    ->table('ms_level')
                    ->where('nama_level', $newNamaLevel)
                    ->exists();

                if ($exists) {
                    throw ValidationException::withMessages(['nama' => 'Nama level sudah digunakan.']);
                }

                // Update nama level di b_ms_user billing
                DB::connection('billing')
                    ->table('b_ms_user')
                    ->where('akses_satu_sehat', $namaLevel)
                    ->update(['akses_satu_sehat' => $newNamaLevel]);

                $namaLevel = $newNamaLevel;
            }
        }

        $this->saveAccess($namaLevel, $request->input('access', []));

        return redirect()->route('setting.level.index')->with('success', 'Level berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $namaLevel = $id;

        if (strtolower($namaLevel) === 'superuser') {
            throw ValidationException::withMessages(['level' => 'Level Superuser (sistem) tidak dapat dihapus.']);
        }

        $usersCount = DB::connection('billing')
            ->table('b_ms_user')
            ->where(function ($q) use ($namaLevel) {
                $q->where('akses_satu_sehat', $namaLevel)
                  ->orWhere('akses', $namaLevel);
            })
            ->where('aktif', '1')
            ->count();

        if ($usersCount > 0) {
            throw ValidationException::withMessages(['level' => 'Level masih dipakai oleh pengguna.']);
        }

        DB::connection('mysql')
            ->table('ms_level')
            ->where('nama_level', $namaLevel)
            ->delete();

        \Illuminate\Support\Facades\Cache::flush();

        return back()->with('success', "Level {$namaLevel} berhasil dihapus.");
    }

    private function tree()
    {
        return Menu::where(function ($q) {
            $q->whereNull('parent_id')->orWhere('parent_id', 0);
        })->with('childrenRecursive')->orderBy('kdmenu')->get();
    }

    private function saveAccess(string $namaLevel, array $access): void
    {
        DB::connection('mysql')->transaction(function () use ($namaLevel, $access) {
            // Hapus izin level lama
            DB::connection('mysql')
                ->table('ms_level')
                ->where('nama_level', $namaLevel)
                ->delete();

            $insertData = [];

            foreach ($access as $menuId => $acts) {
                $hasView = isset($acts['view']);
                $hasAdd  = isset($acts['add']);
                $hasEdit = isset($acts['edit']);
                $hasDel  = isset($acts['del']);

                // View
                if ($hasView || $hasAdd || $hasEdit || $hasDel) {
                    $insertData[] = [
                        'nama_level' => $namaLevel,
                        'id_menu'    => $menuId,
                        'act'        => 1,
                    ];
                }

                // Add
                if ($hasAdd) {
                    $insertData[] = [
                        'nama_level' => $namaLevel,
                        'id_menu'    => $menuId,
                        'act'        => 2,
                    ];
                }

                // Edit
                if ($hasEdit) {
                    $insertData[] = [
                        'nama_level' => $namaLevel,
                        'id_menu'    => $menuId,
                        'act'        => 3,
                    ];
                }

                // Del
                if ($hasDel) {
                    $insertData[] = [
                        'nama_level' => $namaLevel,
                        'id_menu'    => $menuId,
                        'act'        => 4,
                    ];
                }
            }

            if (! empty($insertData)) {
                DB::connection('mysql')->table('ms_level')->insert($insertData);
            }
        });

        \Illuminate\Support\Facades\Cache::flush();
    }
}
