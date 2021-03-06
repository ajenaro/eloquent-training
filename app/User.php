<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(UserProfile::class)->withDefault(function ($profile) {
            $profile->website = 'https://styde.net/perfil/' . Str::slug($this->name);
            $profile->job_title = 'Developer';
        });
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function publishedPosts()
    {
        return $this->posts()->where('published_at', '<=', now());
    }

    public function getNameAttribute($value)
    {
        return $value;
    }
}
