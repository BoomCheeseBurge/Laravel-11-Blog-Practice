<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Sluggable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                            'slug',
                            'title',
                            'author',
                            'body',
                            'category_id',
                            'author_id',
                            'featured_image'
                        ];

    // --------------------------------------------------------------

    /**
     * Get the user that owns the post.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the post.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the comments that belong to the post.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get all of the 'User' likes for the post.
     */
    public function likes(): MorphToMany
    {
        return $this->morphToMany(User::class, 'likeable')->whereDeletedAt(null);
    }

    // --------------------------------------------------------------

    /**
     * Scope a query to filter search based on all, author, or category.
     */
    public function scopeFilter(Builder $query, array $filters): void // The filter keyword is made nullable if there are no search keywords
    {
        // Check if keyword search is not empty or null, else skip to the next confitional statement or fall through
        $query->when($filters['search'] ?? false, fn($query, $keyword) => $query->where('title', 'like', '%' . $keyword . '%')) // If there is a search keyword input

            ->when($filters['category'] ?? false, fn($query, $category) => $query->whereHas('category', fn($query) => $query->where('slug', $category))) // If there is a category slug input

            ->when($filters['author'] ?? false, fn($query, $author) => $query->whereHas('author', fn($query) => $query->where('username', $author))); // If there is an author input
    }

    /**
     * Scope a query to a post based on author's username.
     */
    public function scopeRecent($query, $author): void
    {
        if(!empty($author))
        {
            $query->whereHas('author', function ($query) use ($author) {

                $query->where('username', $author);
            });
        }
    }

    // --------------------------------------------------------------

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // --------------------------------------------------------------

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    // --------------------------------------------------------------

    /**
     * Check whether the post had been given a like by an authorized user
     */
    public function isLiked(): bool
    {
        $like = $this->likes()->where('user_id', auth()->id())->first();

        return !is_null($like) ? true : false;
    }
}
