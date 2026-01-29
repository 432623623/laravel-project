<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'avatar',
        'is_banned',
    ];

    protected function avatar(): Attribute {
        return Attribute::make(
            get: function($value){
                if(!$value){
                    return asset('storage/fallback-avatar.jpg');
                }
                if(str_starts_with($value,'http') || str_starts_with($value,'/storage/')){
                    return $value;
                }
            return asset('/storage/avatars/' . $value);
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    public function feedPosts(){
        return $this->hasManyThrough(Post::class, Follow::class, 'user_id', 'user_id', 'id', 'followeduser');
    }
    public function posts(){
        return $this->hasMany(Post::class,'user_id');
    }
    public function followers(){
        return $this->hasMany(Follow::class,'followeduser');
    }
    public function following(){
        return $this->hasMany(Follow::class,'user_id');
    }
    public function isAdmin():bool{
        return (bool) $this->is_admin;
    }
    public function isBanned():bool{
        return (bool) $this->is_banned;
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    protected static function booted(){
        static::deleting(function ($user){
            foreach($user->posts as $post){
                $post->delete();
            }
        });
    }
}
