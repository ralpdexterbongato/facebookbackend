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
      $timeCommented = str_replace(['11s','12s','13s','14s','15s','16s','17s','18s','19s','20s','1s','2s','3s','4s','5s','6s','7s','8s','9s','10s'], 'just now', $timeCommented);
      return $timeCommented;
    }
    public function replies()
    {
        return $this->morphToMany('App\Comment','commentable');
    }
}
