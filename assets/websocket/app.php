<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;


require __DIR__. '/../../vendor/autoload.php';
require 'socket.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Sockets()
        )
    ),
    8080
);

$server->run();
