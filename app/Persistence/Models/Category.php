<?php

namespace App\Persistence\Models;

use Database\Factories\CategoryFactory;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];


    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    public static function randomCategory(){
        return self::inRandomOrder()->first();
    }
}
