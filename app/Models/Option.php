<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'element_id',
        'attribute_characteristic_id'
    ];
    public function elements()
    {
        return $this->belongsTo(Element::class, 'element_id');
    }
    public function attributeCharacteristic()
    {
        return $this->belongsTo(AttributeCharacteristic::class, 'attribute_characteristic_id');
    }
}
