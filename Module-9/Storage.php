<?php

abstract class Storage
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
}
