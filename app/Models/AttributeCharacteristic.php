<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeCharacteristic extends Model
{
    protected $fillable = [
        'attribute_id',
        'characteristic_id'
    ];
    public function attributes()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
    public function characteristic()
    {
        return $this->belongsTo(Characteristic::class, 'characteristic_id');
    }
    public function options()
    {
        return $this->hasMany(Option::class, 'attribute_characteristic_id');
    }
}
