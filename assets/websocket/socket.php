<?php


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require __DIR__. '/../../vendor/autoload.php';
class Sockets implements MessageComponentInterface
{

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        var_dump("con");
    }

    public function onOpen(ConnectionInterface $conn)
    {
        var_dump("coeee");
        // Store the new connection in $this->clients
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);
        foreach ($this->clients as $client) {

            // if ($from !== $client) {
            //     $client->send($msg);
            // }
            // $url = 'http://5.161.107.4/assets/api/ssmData.php?ssm_id=ssm-1';
            // $data = file_get_contents($url);
            // $json = json_decode($data, true);
            // print_r($json);
            // $client->send($msg);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}
$app = new Ratchet\App('localhost', 8989);
$app->route('/chat', new Sockets, array('*'));
$app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
$app->run();