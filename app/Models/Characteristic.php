<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    protected $fillable =[
        'name',
    ];
    public function attributeCharacteristics()
    {
        return $this->hasMany(AttributeCharacteristic::class, 'characteristic_id');
    }
}
