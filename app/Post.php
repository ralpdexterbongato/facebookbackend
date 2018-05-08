<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function getCreatedAtAttribute($date)
    {
      $timePosted = Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans(null,true,true);
      // $timePosted = str_replace($sec, 'just now', $timePosted);
      return $timePosted;
    }
    public function Poster()
    {
      return $this->belongsTo('App\User','user_id','id');
    }
}
