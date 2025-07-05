<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IzinMasuk extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'uuid', 'alasan', 'waktu_izin','dicetak_pada'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
