<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'book_code',
        'book_title',
        'book_author',
        'category_id',
        'year_published',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
