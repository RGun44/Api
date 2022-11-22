<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = [
        'daerah_asal',
        'daerah_tujuan',
        'berat_paket',
        'kecepatan'
    ];
}
