<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class taggable extends Model
{
    public function Post()
    {
      return $this->hasMany('App\Post','id','taggable_id');
    }
    public function Poster()
    {
      return $this->belongsTo('App\User','creator_id','id');
    }
}
