<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_karyawan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
    ];
}
