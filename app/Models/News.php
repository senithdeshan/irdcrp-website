<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
  protected $fillable = [
    'title_en',
    'title_si',
    'title_ta',
    'content_en',
    'content_si',
    'content_ta',
    'image',
    'published_date',
    'status',
];
}
