<?php

namespace App\Models;

use App\Notifications\ResetPasswordQueued;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
                            'fullname',
                            'username',
                            'email',
                            'profile_pic',
                            'profile_cover',
                            'about',
                            'password',
                            'is_admin',
                            'date_of_birth',
                            'sex',
                            'phone',
                            'phone_country',
                            'phone_normalized',
                            'phone_national',
                            'phone_e164',
                            'website',
                            'location',
                        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --------------------------------------------------------------

    /**
     * Get the posts for the user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    /**
     * Get the comments for the user/author.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    /**
     * Get the likes for the user.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Likeable::class);
    }

    /**
     * Get all of the posts that are liked by this user.
     */
    public function likedPosts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'likeable');
    }

    /**
     * Get all of the comments that are liked by this user.
     */
    public function likedComments(): MorphToMany
    {
        return $this->morphedByMany(Comment::class, 'likeable');
    }

    // --------------------------------------------------------------

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'username';
    }

    // --------------------------------------------------------------
    /**
     * Send the password reset notification with queue.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordQueued($token));
    }
}
