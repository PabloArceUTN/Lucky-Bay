<?php
require_once './vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);
echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg) {
  echo " [x] Received ",json_encode($msg->body), "\n";
  $format = "";
  var_dump(json_decode($msg->body, true));
  $objectQueue = json_decode($msg->body, true);
  echo $objectQueue['url'];
  // define a selected format
  if ($objectQueue['format']!="default") {
    $format = "--format ".$objectQueue['format'];
  }
  echo $format;
  $cmd = 'youtube-dl '.$format.' -o "videos/%(title)s.%(ext)s" '.$objectQueue['url'];
  echo $cmd;
  exec($cmd, $output, $ret);
  echo 'output: ';
  var_export($output);
  echo "\nret: ";
  var_export($ret);
};

$channel->basic_consume('hello', '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}
