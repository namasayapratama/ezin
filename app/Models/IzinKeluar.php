<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IzinKeluar extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'uuid', 'alasan', 'waktu_izin', 'disetujui','kembali_pada','dicetak_pada'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

public function getSchoolNameAttribute()
{
    return Setting::get('school_name', 'SMK Pratama');
}
}
