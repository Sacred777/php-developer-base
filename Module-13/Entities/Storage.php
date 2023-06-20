<?php

namespace Entities;

use Interfaces\LoggerInterface;
use Interfaces\EventListenerInterface;

abstract class Storage implements LoggerInterface, EventListenerInterface
{
    /**
     * param object $object
     * return int|string
     */
    abstract function create(object $object): int|string;

    /**
     * param int|string $id
     * return object|null
     */
    abstract function read(int|string $id): object|null;

    /**
     * param int|string $id
     * param object $newObject
     * return void
     */
    abstract function update(int|string $id, object $newObject): void;

    /**
     * param int/string $id
     * return void
     */
    abstract function delete(int|string $id): void;

    /**
     * void array|null
     */
    abstract function list(): array|null;

    /**
     * @param string $message
     * @return void
     */
    abstract function logMessage(string $message): void;

    /**
     * @param int $messageCount
     * @return array|null
     */
    abstract function lastMessage(int $messageCount): array|null;

    /**
     * @param string $eventName
     * @param callable $callbackFunction
     * @return void
     */
    abstract function attachEvent(string $eventName, callable $callbackFunction): void;

    /**
     * @param string $eventName
     * @return void
     */
    abstract function detouchEvent(string $eventName): void;

}
