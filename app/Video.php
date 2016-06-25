<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
  /** Frist relation
    * Set Video to User
  **/

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
