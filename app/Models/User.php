<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'phone', 'password', 'level_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function access(): array
    {
        if (!$this->level_id) {
            return [];
        }

        return Cache::remember(
            "level_access_{$this->level_id}",
            3600,
            fn() => DB::table('level_menu')
                ->join('menus', 'menus.id', '=', 'level_menu.menu_id')
                ->where('level_menu.level_id', $this->level_id)
                ->get(['menus.kode_menu', 'can_view', 'can_add', 'can_edit', 'can_del'])
                ->mapWithKeys(
                    fn($r) => [
                        $r->kode_menu => [
                            'view' => (bool) $r->can_view,
                            'add' => (bool) $r->can_add,
                            'edit' => (bool) $r->can_edit,
                            'del' => (bool) $r->can_del,
                        ],
                    ],
                )
                ->all(),
        );
    }

    public function canMenu(string $kode, string $aksi = 'view'): bool
    {
        return $this->access()[$kode][$aksi] ?? false;
    }
}
