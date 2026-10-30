<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Level extends Model
{
    protected $fillable = ['nama', 'is_system'];
    protected $casts = ['is_system' => 'boolean'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'level_menu')->withPivot('can_view', 'can_add', 'can_edit', 'can_del');
    }

    /** Hapus cache hak akses satu level, atau semua level. */
    public static function forgetAccess(?int $id = null): void
    {
        $ids = $id ? [$id] : static::pluck('id')->all();
        foreach ($ids as $i) {
            Cache::forget("level_access_{$i}");
        }
    }
}
