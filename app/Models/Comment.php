<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Comment extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['comment', 'user_id', 'post_id', 'parent_id'];

    // --------------------------------------------------------------

    /**
     * Get the post that has the comment.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user that commented the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the child comment that belongs to a comment.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderByDesc('created_at');
    }

    /**
     * Get the parent comment that has the child comment(s).
     */
    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get all of the 'User' likes for the comment.
     */
    public function likes(): MorphToMany
    {
        return $this->morphToMany(User::class, 'likeable')->whereDeletedAt(null);
    }

    // --------------------------------------------------------------

    /**
     * Check whether the comment had been given a like by an authorized user
     */
    public function isLiked(): bool
    {
        $like = $this->likes()->where('user_id', auth()->id())->first();

        return !is_null($like) ? true : false;
    }
}
