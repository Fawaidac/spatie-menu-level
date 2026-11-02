<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public const ACTIONS = ['view', 'add', 'edit', 'del'];

    protected $table = 'ms_menu';
    public $timestamps = false;

    protected $fillable = [
        'parent_id',
        'kdmenu',
        'nmmenu',
        'url',
        'icon',
        'level',
        'aktif',
    ];

    // Accessor kode_menu -> kdmenu
    public function getKodeMenuAttribute(): ?string
    {
        return $this->kdmenu;
    }

    public function setKodeMenuAttribute($value): void
    {
        $this->kdmenu = $value;
    }

    // Accessor nama -> nmmenu
    public function getNamaAttribute(): ?string
    {
        return $this->nmmenu;
    }

    public function setNamaAttribute($value): void
    {
        $this->nmmenu = $value;
    }

    // Accessor urutan -> id
    public function getUrutanAttribute(): int
    {
        return (int) $this->id;
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id')->where('id', '!=', 0);
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->orderBy('kdmenu');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
}
