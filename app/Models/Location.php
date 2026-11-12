<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $connection = 'billing';
    protected $table = 'b_ms_unit';
    public $timestamps = false;

    protected $fillable = [
        'kode', 'nama', 'parent_id', 'level', 'aktif',
        'keterangan', 'satu_sehat_id', 'unit_alias',
        'jenis_layanan', 'inap', 'penunjang',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'parent_id' => 'integer',
        'level' => 'integer',
    ];

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id', 'id')->orderBy('kode');
    }

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('aktif', 1);
    }
}
