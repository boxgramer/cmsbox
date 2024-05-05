<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'brief_description',
        'content',
        'tags',
        'categories',
        'meta_title',
        'meta_description',
        'status',
        'author_id',

    ];
    protected $casts = [
        'status' => StatusEnum::class,
        'tags' => 'array',
        'categories' => 'array',
    ];
}
