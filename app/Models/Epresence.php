<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Epresence extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'is_approve',
        'waktu',
        'password',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getWaktuMasukAttribute($value)
    { 
        $date = new DateTime($value);
        $waktu_masuk = $date->format('H:i:s');
        return $waktu_masuk;
    }

    public function getTanggalAttribute($value)
    { 
        $date = new DateTime($value);
        $tanggal = $date->format('Y-m-d');
        return $tanggal;
    }
}
