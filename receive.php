<?php
require_once './vendor/autoload.php';
// require_once './bootstrap/start.php';
include './vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'luckybaydb',
    'username'  => '',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

use App\Video;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);
echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
$callback = function($msg) {
  var_dump(json_decode($msg->body, true));
  $objectQueue = json_decode($msg->body, true);
  // Update video state to processing
  $video = Video::find($objectQueue['id']);
  $video->state = "processing";
  $video->save();
  echo Video::find($objectQueue['id']);
  echo " [x] Received ",json_encode($msg->body), "\n";
  $format = "";
  echo $objectQueue['url'];
  // define a selected format
  if ($objectQueue['format']!="default") {
    $format = "--format ".$objectQueue['format'];
  }
  $cmd = 'youtube-dl '.$format.' -o "videos/'.$objectQueue['user_id'].'/%(title)s.%(ext)s" '.$objectQueue['url'];
  echo $cmd;
  exec($cmd, $output, $ret);
  echo 'output: ';
  var_export($output);
  echo "\nret: ";
  var_export($ret);
  $video = Video::find($objectQueue['id']);
  $video->state = "ready";
  $video->save();
  echo Video::find($objectQueue['id']);
};

$channel->basic_consume('hello', '', false, true, false, false, $callback);

// onprocess
while(count($channel->callbacks)) {
    $channel->wait();
}
