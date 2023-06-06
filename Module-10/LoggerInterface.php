<?php

interface LoggerInterface
{
    /**
     * @param string $message
     * @return void
     */
    public function logMessage(string $message): void;

    /**
     * @param int $messageCount
     * @return array|null
     */
    public function lastMessage(int $messageCount): array|null;
}
