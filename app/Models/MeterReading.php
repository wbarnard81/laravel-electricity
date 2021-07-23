<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'meter_id',
        'start_reading',
        'previous_reading',
        'units_purchased',
        'rand_value',
        'reading',
        'units_used',
    ];

    public function meter()
    {
        return $this->belongsTo(Meter::class);
    }

}
