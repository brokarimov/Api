<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'name',
        'category_id'
    ];
    public function categories(){
        return $this->belongsTo(Category::class, 'category_id');
    } 
    public function characteristics(){
        return $this->hasMany(AttributeCharacteristic::class, 'attribute_id');
    } 
}
