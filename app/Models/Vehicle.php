<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_plate',
        'type_vehicle_id',
        'total_minutes',
        'value_for_pay'
    ];

    public function typeVehicle(){
        return $this->belongsTo(Type_vehicle::class);
    }

    public function visits(){
        return $this->hasMany(Visit::class);
    }

    public function setCarPlateAttribute($value){
        $this->attributes['car_plate'] = strtoupper($value);
    }
}
