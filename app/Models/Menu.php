<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public const ACTIONS = ['view', 'add', 'edit', 'del'];

    protected $fillable = ['parent_id', 'kode_menu', 'nama', 'url', 'icon', 'urutan'];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('urutan');
    }
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'level_menu')->withPivot(
            'can_view',
            'can_add',
            'can_edit',
            'can_del',
        );
    }
}
