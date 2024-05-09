<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [];

    protected $casts = [
        'is_free' => 'boolean'
    ];

    public function categories ()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();;
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
