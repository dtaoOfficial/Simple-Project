<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
     protected $fillable = [
        'name',
        'description',
        'schedule',
        'activities',
        'outcomes',
    ];

    public function registrations()
{
    return $this->hasMany(Registration::class);
}
}
