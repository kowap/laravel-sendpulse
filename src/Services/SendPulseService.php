<?php

/**
 * Service class for integrating with the SendPulse API.
 * Provides methods to interact with email-related operations such as
 * retrieving balance, managing mailing lists, and adding emails.
 */

namespace Kowap\SendPulse\Services;

use /**
 * Interface SendPulseRepositoryInterface
 *
 * This interface defines the contract for interacting with the SendPulse API,
 * providing a set of methods for managing and processing data related to
 * email campaigns, subscribers, and other functionalities supported by SendPulse.
 */
    Kowap\SendPulse\Contracts\SendPulseRepositoryInterface;
use /**
 * Class InvalidArgumentException
 *
 * Represents an exception that is thrown when an invalid argument is passed
 * to a method or function. It is typically used to indicate that the input
 * provided to a piece of code does not meet the required or expected criteria.
 *
 * InvalidArgumentException extends the base LogicException, which in turn
 * extends the built-in Exception class. This allows for structured exception
 * handling specifically targeted to invalid argument scenarios.
 *
 * This exception is commonly used in cases such as:
 * - Type mismatches for a parameter.
 * - Input values that are outside the acceptable range.
 * - Passing null where a non-nullable parameter is expected.
 */
    InvalidArgumentException;

/**
 * Service for interacting with the SendPulse API to manage address books and emails.
 */
class SendPulseService
{
    public function __construct(private SendPulseRepositoryInterface $repository)
    {
    }

    public function getBalance(): array
    {
        return $this->repository->getBalance();
    }

    public function addToList(int $listId, string $email, array $variables = []): self
    {
        $emails = [['email' => $email, 'variables' => $variables]];
        $result = $this->repository->addEmails($listId, $emails);

        if (!($result['result'] ?? false)) {
            throw new InvalidArgumentException(
                sprintf('Failed to add email to list: %s', json_encode($result, JSON_THROW_ON_ERROR))
            );
        }

        return $this;
    }

    public function createList(string $name): int
    {
        $result = $this->repository->createAddressBook($name);

        if (!is_int($listId = $result['id'] ?? null)) {
            throw new InvalidArgumentException(
                sprintf('Failed to create address list: %s', json_encode($result))
            );
        }

        return $listId;
    }

    public function getLists(int $limit = 100, int $offset = 0): array
    {
        return $this->repository->listAddressBooks($limit, $offset);
    }
}
