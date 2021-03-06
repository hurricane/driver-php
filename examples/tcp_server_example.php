<?php

require realpath('./../autoload.php.dist');
date_default_timezone_set('America/Denver');

$gateway = new \Hurricane\Gateway(
    new \Hurricane\Erlang\SocketWrapper('localhost', '3000')
);
$gateway->registerServer('time_server');
while (true) {
    $request = $gateway->recv();
    $response = \Hurricane\Message::create()
        ->setType('response')
        ->setDestination($request->getDestination())
        ->setTag($request->getTag())
        ->setData(date('Y-m-d H:i:s'));
    $gateway->send($response);
}
