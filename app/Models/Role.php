<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, softDeletes;

       // Relationship with Role and Company model ( many to one )
    public function company(){
        return $this->belongsTo(Company::class);
    }
      // Relationship with Role and Employe model ( one to many )
    public function employes()
    {
        return $this->hasMany(Employes::class);
    }
    // Relationship with Role and Responsibility model ( one to many )
    public function responsibilities()
    {
        return $this->hasMany(Responsibility::class);
    } 
}