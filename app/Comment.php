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
    	$timeCommented = Carbon::createFromFormat('Y-m-d H:i:s',$date)->diffForHumans(null,true,true);
      $timeCommented = str_replace(['1just now','2just now','3just now','4just now','5just now','6just now','7just now','8just now','9just now'], 'just now', $timeCommented);
      return $timeCommented;
    }
    public function replies()
    {
        return $this->morphToMany('App\Comment','commentable');
    }
}
