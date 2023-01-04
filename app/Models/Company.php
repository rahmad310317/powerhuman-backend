<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, softDeletes;
   
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'logo',
    ];

    // Relationship with user and company model (Many to Many)

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

     // Relationship with company and teams model (one to Many)

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

     // Relationship with company and teams role (one to Many)
     public function roles()
     {
         return $this->hasMany(Role::class);
     }
}
