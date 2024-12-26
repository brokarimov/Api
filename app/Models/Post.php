<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'description',
        'text',
        'image',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
