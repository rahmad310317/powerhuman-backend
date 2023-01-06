<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employes extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'email',
        'gender',
        'age',
        'phone',
        'photo',
        'team_id',
        'role_id',
        'is_verified',
        'verified_at',
    ];


   // Relationship with employee and team model ( many to one )
    
   public function team()
   {
       return $this->belongsTo(Team::class);
   } 

      // Relationship with employee and role model ( many to one )
    public function role() 
    {
        return $this->belongsTo(Role::class);
    }
}
