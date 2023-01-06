<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, softDeletes;

    // Relationship with team and companies model ( many to one )

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
     
     // Relationship with team and employee model ( one to many )
    public function employes()
    {
        return $this->hasMany(Employes::class);
    }
}
