<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Level extends Model
{
    protected $table = 'ms_level';
    protected $primaryKey = 'id_level';
    public $timestamps = false;

    protected $fillable = ['nama_level', 'id_menu', 'act'];

    // Accessor nama -> nama_level
    public function getNamaAttribute(): ?string
    {
        return $this->nama_level;
    }

    public function setNamaAttribute($value): void
    {
        $this->nama_level = $value;
    }

    // Accessor is_system
    public function getIsSystemAttribute(): bool
    {
        return strtolower($this->nama_level ?? '') === 'superuser';
    }

    public static function forgetAccess(?string $levelName = null): void
    {
        Cache::flush();
    }
}
