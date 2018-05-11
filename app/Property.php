<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'properties';
    
    protected $fillable = [
        'name', 'description', 'address',
        'user_id', 'surface', 'logement', 'location',
        'rooms_number', 'price'
    ];
    
    public function User() { return $this->belongsTo(\App\User::class); }
    public function Room() { return $this->hasMany(\App\Room::class); }
}
