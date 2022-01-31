<?php

namespace App\Persistence\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'publication_date',
        'category_id'
    ];

    protected $dates = [
        'publication_date'
    ];

    public function scopeNewestPosts($query)
    {
        return $query->orderBy('publication_date', 'desc');
    }

    public function scopeOldestPosts($query)
    {
        return $query->orderBy('publication_date');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }
}
