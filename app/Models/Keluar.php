<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluar extends Model
{
    use HasFactory;
    protected $table = 'keluars';
    protected $fillable = [
        'nama',
        'nominal',
        'keperluan',
        'tanggal',
        'nota',
    ];

    // public function totalNominalAttribute()
    // {
    //     return $this->attributes['nominal'];
    // }

    // public static function totalNominal()
    // {
    //     return static::sum('nominal');
    // }

}
