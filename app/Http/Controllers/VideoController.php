<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
require '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class VideoController extends Controller
{
    //
    public function index()
    {

    }
    private function putQueue($url)
    {
      $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
      $channel = $connection->channel();
      $channel->queue_declare('hello', false, false, false, false);
      $msg = new AMQPMessage($url);
      $channel->basic_publish($msg, '', 'hello');
      echo " [x] Sent 'URL!'\n";
      $channel->close();
      $connection->close();
    }

    public function download($value='')
    {
      // return "Hola";
    }
}
