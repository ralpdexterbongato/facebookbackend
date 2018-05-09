<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;
use Auth;
class User extends Authenticatable implements JWTSubject
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


    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return ['userid'=>$this->id,'userfname'=>$this->fname,'userlname'=>$this->lname,'isverified'=>$this->isverified,'useremail'=>$this->email,'gender'=>$this->gender];
    }
    // public function Posts()
    // {
    //   return $this->hasMany('App\Post','user_id','id');
    // }
    public function TaggedPostsNewOnly()
    {
      $minAgo = Carbon::now()->subHours(1);
      return $this->morphedByMany('App\Post','taggable')->where('updated_at','>',$minAgo)->orderBy('updated_at','DESC')->take(3);
    }
    public function friends()
    {
        return $this->belongsToMany('App\User','user_friends','user_idf','user_ids')->whereNotNull('isFriends');
    }
    public function friendRequestReceived()
    {
        return $this->belongsToMany('App\User','user_friends','user_ids','user_idf');
    }
}
