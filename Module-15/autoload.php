<?php

require_once __DIR__ . '/vendor/autoload.php';

/**
 * @param string $className
 * @return void
 */
function loaderEntities(string $className): void
{
    require_once str_replace('\\', '/', $className) . '.php';
}

spl_autoload_register('loaderEntities');
