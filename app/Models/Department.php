<?php

// app/Models/Department.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'description'];

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }
}
