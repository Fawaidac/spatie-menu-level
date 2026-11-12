<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiJenis extends Model
{
    use HasFactory;

    protected $connection = 'billing';

    protected $table = 'b_ms_pegawai_jenis';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $guarded = [];
}
