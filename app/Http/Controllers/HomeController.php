<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Video;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $videos=Video::where('user_id', Auth::user()->id)
      ->where('completed', false)
      ->orderBy('updated_at','desc')
      ->get();
      return view('home')->with('videos',$videos);
    }
}
