<?php

abstract class User implements EventListenerInterface
{
    private int $id;
    private string $name;
    private string $role;

    /**
     * @return void
     */
    abstract function getTextToEdit(): void;

    /**
     * @param string $eventName
     * @param $callbackFunction
     * @return void
     */
    abstract function attachEvent(string $eventName, $callbackFunction): void;

    /**
     * @param string $eventName
     * @return void
     */
    abstract function detouchEvent(string $eventName): void;

}
