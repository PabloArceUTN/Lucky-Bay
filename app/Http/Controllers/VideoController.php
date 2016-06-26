<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Video;
use App\User;
use App\Http\Requests;
require '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class VideoController extends Controller
{
  // Index action: It's called for download action on the website
  public function index(Request $request)
  {
    $this->putQueue($request->url, $request->format);
    return redirect('/');
  }
  private function putQueue($url, $format)
  {
    //save url video in db
    $user_id=Auth::user()->id;
    $video= new Video;
    $video->user_id=$user_id;
    $video->video_url=$url;
    $video->state="pending";
    $video->format=$format;
    $video->save();

    $arr =json_encode(array('id'=>$video->id,'user_id'=>$user_id,'url'=>$url,'format'=>$format));
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();
    $channel->queue_declare('hello', false, false, false, false);
    $msg = new AMQPMessage($arr);
    $channel->basic_publish($msg, '', 'hello');
    echo " [x] Sent 'URL!'\n";
    $channel->close();
    $connection->close();
  }


// public function download($request)
//     {
//       $file =$request;
//       return Response::download($file,'cap1.mp4',
//       ['Content-Type','application/mp4']);
//     }
}
