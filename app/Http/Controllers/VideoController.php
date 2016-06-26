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
    //
    public function index(Request $request)
      {
      $this->putQueue($request->url);
      }
    private function putQueue($url)
    {
      //save url video in db
      $user_id=Auth::user()->id;
      $video= new Video;
      $video->user_id=$user_id;
      $video->video_url=$url;
      $video->state="pending";
      $video->save();

      $arr =json_encode(array('id'=>$video->id,'user_id'=>$user_id,'url'=>$url));
      $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
      $channel = $connection->channel();
      $channel->queue_declare('hello', false, false, false, false);
      $msg = new AMQPMessage($arr);
      $channel->basic_publish($msg, '', 'hello');
      echo " [x] Sent 'URL!'\n";
      $channel->close();
      $connection->close();
    }
}
