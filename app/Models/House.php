<?php

namespace App\Models;

use App\Models\Meter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'complex',
        'address',
        'city',
        'province',
        'postal_code',
    ];

    public function meters()
    {
        return $this->hasMany(Meter::class);
    }

    public function meterReadings()
    {
        return $this->hasManyThrough(MeterReading::class, Meter::class);
    }

    public function electricityValue($meterId)
    {
        return array_sum(MeterReading::where('meter_id', $meterId)->pluck('rand_value')->toArray());
    }

    public function waterValue($meterId)
    {
        return array_sum(MeterReading::where('meter_id', $meterId)->pluck('rand_value')->toArray());
    }
}