<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSetting extends Model
{

    protected $fillable = [
        'start_date',
        'end_date',
        'timings',
        'fee',
        'phone',
        'min_age',
        'max_age',
    ];
    
}
