<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    
    protected $fillable = ['property_id', 'surface', 'description', 'name'];
    
    public function Property() { return $this->belongsTo(\App\Property::class); }
}
