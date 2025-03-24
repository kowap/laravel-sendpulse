<?php

namespace Kowap\SendPulse\Repositories;

use Sendpulse\RestApi\ApiClient;
use Kowap\SendPulse\Contracts\SendPulseRepositoryInterface;

class SendPulseRepository implements SendPulseRepositoryInterface
{
    private ApiClient $client;

    public function __construct(array $config)
    {
        $this->client = new ApiClient($config['api_key'], $config['api_secret']);
    }

    public function getBalance(): array
    {
        return $this->processResponse($this->client->getBalance());
    }

    public function addEmails(int $listId, array $emails): array
    {
        return $this->processResponse($this->client->addEmails($listId, $emails));
    }

    public function createAddressBook(string $name): array
    {
        return $this->processResponse($this->client->createAddressBook($name));
    }

    public function listAddressBooks(int $limit, int $offset): array
    {
        return $this->processResponse($this->client->listAddressBooks($limit, $offset));
    }

    private function processResponse(mixed $response): array
    {
        return match (true) {
            is_array($response) => $response,
            is_object($response) => (array)$response,
            is_string($response) => (array)json_decode($response, true),
            default => [],
        };
    }
}
