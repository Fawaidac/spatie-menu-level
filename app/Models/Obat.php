<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $connection = 'apotek';

    protected $table = 'a_obat';

    protected $primaryKey = 'OBAT_ID';

    public $timestamps = false;

    protected $guarded = [];
}
