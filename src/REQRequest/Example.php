<?php
use REQRequest\Rabbitmq;
require 'vendor/autoload.php';
$request= new Rabbitmq();
print_r($request->listQueues());

?>
