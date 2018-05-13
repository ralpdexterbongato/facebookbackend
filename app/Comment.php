<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Comment extends Model
{
    public function CommentOwner()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }
    public function getCreatedAtAttribute($date)
    {
    	return Carbon::createFromFormat('Y-m-d H:i:s',$date)->diffForHumans(null,true,true);
    }
    public function getUpdatedAtAttribute($date)
    {
    	return Carbon::createFromFormat('Y-m-d H:i:s',$date)->diffForHumans(null,true,true);
    }
    public function replies()
    {
        return $this->morphToMany('App\Comment','commentable');
    }
}
