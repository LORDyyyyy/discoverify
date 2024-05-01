<?php

declare(strict_types=1);

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

/**
 * Creates a new WebSocket client.
 *
 * @return Client The WebSocket client.
 */
function createClient(): Client
{
    $port = $_ENV['SOCKET_PORT'] ?? 3000;

    $version = new Version2X('http://localhost:' . $port);

    $client = new Client($version);

    $client->initialize();

    return $client;
}

/**
 * Closes the client connection.
 *
 * @param Client $client The client to close.
 * @return void
 */
function closeClient(Client $client): void
{
    $client->close();
}
