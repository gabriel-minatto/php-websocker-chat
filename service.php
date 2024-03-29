<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Chat.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8081
);
echo "Websocket server is running. Press ctrl-c to exit...\r\n";
$server->run();
