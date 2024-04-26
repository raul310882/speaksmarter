<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'pdf_uri' => "No tiene PDF",
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
