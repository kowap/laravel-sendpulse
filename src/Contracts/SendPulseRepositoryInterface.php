<?php

namespace Kowap\SendPulse\Contracts;

interface SendPulseRepositoryInterface
{
    public function getBalance(): array;
    public function addEmails(int $listId, array $emails): array;
    public function createAddressBook(string $name): array;
    public function listAddressBooks(int $limit, int $offset): array;
}
