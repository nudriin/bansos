<?php

// app/Models/Beneficiary.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $fillable = [
        'family_card_number',
        'head_of_family',
        'gender',
        'address',
        'has_received_aid',
        'department_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'user_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Region::class, 'kabupaten_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Region::class, 'kecamatan_id');
    }

    public function desa()
    {
        return $this->belongsTo(Region::class, 'desa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
