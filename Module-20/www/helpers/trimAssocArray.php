<?php

/**
 * @param array $incomingArray
 * @return array|null
 */
function trimAssocArray(array $incomingArray): array|null
{
    if (empty($incomingArray)) return null;

    function trimForString($n)
    {
        if (gettype($n) === 'string') {
            return trim($n);
        } else {
            return $n;
        }

    }

    return array_map('trimForString', $incomingArray);
}
