<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SessionUser
{
    protected ?string $userId;
    protected ?string $username;
    protected ?string $name;
    protected ?string $groupId;
    protected ?string $aksesSatuSehat;
    protected ?string $unitId;

    public function __construct()
    {
        $this->userId          = Session::get('user_id');
        $this->username        = Session::get('username') ?? Session::get('idname');
        $this->name            = Session::get('name') ?? $this->username ?? 'User';
        $this->groupId         = Session::get('group_id');
        $this->aksesSatuSehat  = Session::get('akses_satu_sehat') ?? Session::get('akses');
        $this->unitId          = Session::get('unit_id');
    }

    public static function current(): ?static
    {
        if (! Session::has('user_id')) {
            return null;
        }

        return new static();
    }

    public function id(): ?string
    {
        return $this->userId;
    }

    public function username(): ?string
    {
        return $this->username;
    }

    public function name(): string
    {
        return $this->name ?? 'User';
    }

    public function groupId(): ?string
    {
        return $this->groupId;
    }

    public function unitId(): ?string
    {
        return $this->unitId;
    }

    public function levelName(): string
    {
        return $this->aksesSatuSehat ?? ($this->groupId ? 'Level ' . $this->groupId : 'Staff');
    }

    public function canMenu(string $kodeMenu, string $aksi = 'view'): bool
    {
        if (empty($this->username)) {
            return false;
        }

        $actCode = match (strtolower($aksi)) {
            'view'    => 1,
            'add'     => 2,
            'edit'    => 3,
            'del'     => 4,
            default   => 1,
        };

        $cacheKey = "user_perm_{$this->username}_{$kodeMenu}_{$actCode}";

        return Cache::remember($cacheKey, 300, function () use ($kodeMenu, $actCode) {
            $hasAccess = DB::connection('mysql')
                ->table('ms_level as ml')
                ->join(DB::raw(config('database.connections.billing.database', 'db_rsd_soebandi_billing') . '.b_ms_user as mu'), function ($join) {
                    $join->on('ml.nama_level', '=', 'mu.akses_satu_sehat')
                         ->orOn('ml.nama_level', '=', 'mu.akses');
                })
                ->join('ms_menu as mm', 'mm.id', '=', 'ml.id_menu')
                ->where('mu.username', $this->username)
                ->where(function ($query) use ($kodeMenu) {
                    $query->where('mm.kdmenu', $kodeMenu)
                          ->orWhere('mm.url', $kodeMenu)
                          ->orWhere('mm.id', $kodeMenu);
                })
                ->where('ml.act', $actCode)
                ->exists();

            if ($hasAccess) {
                return true;
            }

            // Fallback: Jika user Superuser / superadmin atau tabel level_menu Laravel
            if (strtolower($this->levelName()) === 'superuser' || strtolower($this->levelName()) === 'admin') {
                return true;
            }

            return false;
        });
    }
}

