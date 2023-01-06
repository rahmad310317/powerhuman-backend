<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Responsibility extends Model
{
    use HasFactory, softDeletes;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'role_id',
    ];

      // Relationship with Responsibility and Role model ( many to one )
    public function role() 
    {
        return $this->belongsTo(Role::class);
    }
    
}
