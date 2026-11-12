<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $connection = 'billing';

    protected $table = 'b_ms_pegawai';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $guarded = [];

    public function jenis()
    {
        return $this->belongsTo(PegawaiJenis::class, 'pegawai_jenis', 'id');
    }
}
