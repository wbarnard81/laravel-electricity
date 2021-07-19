<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_id',
        'meter_name',
        'type',
    ];

    public function readings()
    {
        return $this->hasMany(MeterReading::class);
    }
}
