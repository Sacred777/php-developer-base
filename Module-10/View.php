<?php

abstract class View
{
    private object $storage;

    function __construct(object $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param int $id
     */
    abstract function displayTextById(int $id): void;

    /**
     * @param string $url
     */
    abstract function displayTextByUrl(string $id): void;
}
