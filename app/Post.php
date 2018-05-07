<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function getCreatedAtAttribute($date)
    {
      $minute=['1 second'];

      for ($i=0; $i < 59; $i++)
      {
        array_push($minute,$i.' seconds');
      }
      $timePosted = Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
      $timePosted = str_replace($minute, ' just now', $timePosted);
      $timePosted = str_replace(['seconds'], 'sec', $timePosted);
      $timePosted = str_replace([' minutes', ' minute'], 'min', $timePosted);
      $timePosted = str_replace([' hours', ' hour'], 'h', $timePosted);
      $timePosted = str_replace([' months', ' month'], 'm', $timePosted);
      $timePosted = str_replace(' ago', '', $timePosted);
      return $timePosted;
    }
    public function Poster()
    {
      return $this->belongsTo('App\User','user_id','id');
    }
}
