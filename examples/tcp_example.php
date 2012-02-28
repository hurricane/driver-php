<?php

require dirname(__FILE__) . '/../src/Hurricane/Autoload.php';

\Hurricane\Autoload::registerSpl();

date_default_timezone_set('America/Denver');

$gateway = new \Hurricane\Gateway(
    new \Hurricane\Erlang\SocketWrapper('localhost', '3000')
);
while (true) {
    $request = \Hurricane\Message::create()
        ->setType('request')
        ->setDestination('time_server')
        ->setTag(0)
        ->setData(null);
    $gateway->send($request);
    $response = $gateway->recv();
    echo $response->getData() . PHP_EOL;
}
