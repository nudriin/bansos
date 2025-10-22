<?php

// app/Models/Region.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'type', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Region::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Region::class, 'parent_id');
    }

    public function beneficiariesKabupaten()
    {
        return $this->hasMany(Beneficiary::class, 'kabupaten_id');
    }

    public function beneficiariesKecamatan()
    {
        return $this->hasMany(Beneficiary::class, 'kecamatan_id');
    }

    public function beneficiariesDesa()
    {
        return $this->hasMany(Beneficiary::class, 'desa_id');
    }
}
