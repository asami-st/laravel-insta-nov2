<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Post;
use App\Models\Follow;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    # Use this method to get ALL the posts of a user
    public function posts(){
        return $this->hasMany(Post::class)->latest();
    }

    //get all the followers
    public function followers(){
        return $this->hasMany(Follow::class, 'following_id');
    }

    public function following(){
        return $this->hasMany(Follow::class, 'follower_id');
    }
    public function isFollowed(){   //true or false[boolean result]
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
        # Auth::user()->id -----> Follower (follower_id)
        # First, get all the followers of a user (followers table) ($this->followers())
        # Thenm from that lists, serach for Auth::user()->id (user who is currently logged-in) in follower_id column
        # using the (where('follower_id', Auth::user()->id)) ---- checking if that id exists (exists())
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    // get messages that user reseived
    public function messages(){
        return $this->hasMany(Message::class);
    }


}
