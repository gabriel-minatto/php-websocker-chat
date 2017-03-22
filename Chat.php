<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
        $numRecv = count($this->clients) - 1;

        // When a new client connects, greet him.
        //$conn->send(sprintf('Welcome connection #%d. You are now %d user(s) in this chat.', $conn->resourceId, $numRecv));

        // And tell the other clients about the new user.
        foreach ($this->clients as $client) {
            if ($conn !== $client) {
               // $client->send(sprintf('Connection %d has connected to %d other user(s)', $conn->resourceId, $numRecv));
            }
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send("O usuario ".$from->resourceId." diz:\n".$msg."\n");
            }
        }
        
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
