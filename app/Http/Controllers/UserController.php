<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Video;
use App\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;


class UserController extends Controller
{
    // Delete an user account
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

    public function profile()
    {
      $user=User::where('id', Auth::user()->id)
      ->get();
      foreach ($user as $key => $value) {
        $data=array(
          'id'=>$value->id,
          'name'=>$value->name,
          'email'=>$value->email
        );
      }
      return view('profile')->with('data',$data);
    }

    public function update(Request $request)
    {
      $user=User::find(Auth::user()->id);
      $user->name=$request->name;
      $user->email=$request->email;
      $user->password=bcrypt($request->pwd);
      $user->save();
      $this->profile();
    }
}
