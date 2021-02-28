<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sisa extends Model
{
    use HasFactory;

    protected $fillable = ['nilai', 'jenis_makanan', 'waktu', 'id_pasien'];
}
