<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Video;
use App\User;

class UserController extends Controller
{
    //
    public function deleteAccount()
    {
      $user = User::find(Auth::user()->id);
      $video=Video::where('user_id',Auth::user()->id);
      Auth::logout();
      if ($user->delete())
      {
      $video->delete();
      return view('auth.login')->with('global', 'Your account has been deleted!');
      }
    }
}
