<?php

abstract class User
{
    private int $id;
    private string $name;
    private string $role;

    /**
     * @return void
     */
    abstract function getTextToEdit(): void;
}
