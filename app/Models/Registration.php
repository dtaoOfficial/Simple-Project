<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
     protected $fillable = [
        'child_name',
        'child_age',
        'parent_name',
        'parent_email',
        'parent_phone',
        'programme_id',
        'payment_status',
        'payment_amount',
    ];

      public function programme()
    {
        return $this->belongsTo(Programme::class);
    }
}
