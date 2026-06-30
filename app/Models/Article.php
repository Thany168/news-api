<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category',
        'author',
        'cover_image',
        'tags',
        'published',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'tags'         => 'array',
        'published'    => 'boolean',
        'published_at' => 'datetime',
    ];

    // Auto-generate slug from title
    protected static function booted(): void
    {
        static::creating(function (Article $article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    // Scope: published articles only
    public function scopePublished($query)
    {
        return $query->where('published', true)
            ->orderBy('published_at', 'desc');
    }
}
