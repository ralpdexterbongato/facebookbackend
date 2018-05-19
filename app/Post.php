<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function getCreatedAtAttribute($date)
    {

      $timePosted = Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans(null,true,true);
      $timePosted = str_replace(['11s','12s','13s','14s','15s','16s','17s','18s','19s','20s','1s','2s','3s','4s','5s','6s','7s','8s','9s','10s'], 'just now', $timePosted);
      return $timePosted;
    }
    public function Poster()
    {
      return $this->belongsTo('App\User','user_id','id');
    }
    public function comments()
    {
      return $this->morphToMany('App\Comment','commentable');
    }
    public function reacts()
    {
      return $this->morphToMany('App\User','reactable');
    }
}
