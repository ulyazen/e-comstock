<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bangsal extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'siklus', 'tanggal'];
}
