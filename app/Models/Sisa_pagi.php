<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sisa_pagi extends Model
{
    use HasFactory;
    protected $fillable = ['id_pasien', 'makanan_pokok', 'lauk_hewani', 'lauk_nabati', 'sayur', 'buah', 'snack'];
}
