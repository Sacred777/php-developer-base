<?php

interface EventListenerInterface
{
    /**
     * @param string $eventName
     * @param callable $callbackFunction
     * @return void
     */
    public function attachEvent(string $eventName, callable $callbackFunction): void;

    /**
     * @param string $eventName
     * @return void
     */
    public function detouchEvent(string $eventName): void;
}
