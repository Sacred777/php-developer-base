<?php

namespace Entities;

class FileStorage extends Storage
{
    private const STORE_DIR = './store/';
    private const LOG_FILE = 'log.txt';

    private array $eventListeners = [];

    function __construct()
    {
        if (!is_dir(self::STORE_DIR)) {
            mkdir(self::STORE_DIR);
        }
    }

    /**
     * @param object $object
     * @return string
     */
    public function create(object $object): string
    {
        $fileName = $object->slug . '_' . date('Ymd');
        $newFileName = $fileName;
        $i = 0;
        while (file_exists(self::STORE_DIR . $newFileName)) {
            $i++;
            $newFileName = $fileName . '_' . $i;
        }

        $object->slug = $newFileName;
        file_put_contents(self::STORE_DIR . $object->slug, serialize($object));
        return $object->slug;
    }

    /**
     * @param int|string $id
     * @return object|mixed|null
     */
    public function read(int|string $id): object|null
    {
        if (!file_exists(self::STORE_DIR . $id)) {
            echo 'Файл ' . self::STORE_DIR . $id . ' не найден' . PHP_EOL;
            return null;
        }

        $content = file_get_contents(self::STORE_DIR . $id);
        if (empty($content)) {
            echo 'Не удалось получить данные из файла' . self::STORE_DIR, $id . PHP_EOL;
            return null;
        }

        return unserialize($content);
    }

    /**
     * @param int|string $id
     * @param object $newObject
     * @return void
     */
    public function update(int|string $id, object $newObject): void
    {
        file_put_contents(self::STORE_DIR . $id, serialize($newObject));
    }

    /**
     * @param int|string $id
     * @return void
     */
    public function delete(int|string $id): void
    {
        unlink(self::STORE_DIR . $id);
    }

    /**
     * @return array|null
     */
    public function list(): array|null
    {
        $articleList = [];
        $fileList = scandir(self::STORE_DIR);

        if (count($fileList) < 3) {
            echo 'В директории ' . self::STORE_DIR . ' отсутствуют файлы с данными';
            return null;
        }

        foreach ($fileList as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $content = file_get_contents(self::STORE_DIR . $file);

            if (empty($content)) {
                echo 'Не удалось получить данные из файла ' . self::STORE_DIR . $file . PHP_EOL;
                continue;
            }

            $articleList[] = unserialize($content);
        }

        return $articleList;
    }

    /**
     * @param string $message
     * @return void
     */
    public function logMessage(string $message): void
    {
        $messageList = [];
        if (file_exists(self::LOG_FILE)) {
            $messageList = unserialize(file_get_contents(self::LOG_FILE));
        }

        $messageList[] = $message;
        file_put_contents(self::LOG_FILE, serialize($messageList));
    }

    /**
     * @param int $messageCount
     * @return array|null
     */
    public function lastMessage(int $messageCount): array|null
    {
        if (!file_exists(self::LOG_FILE)) {
            echo "Файла " . self::LOG_FILE . ' не существует';
            return null;
        }

        $messagesList = unserialize(file_get_contents(self::LOG_FILE));

        return array_slice($messagesList, -$messageCount);
    }

    /**
     * @param string $eventName
     * @param callable $callbackFunction
     * @return void
     */
    public function attachEvent(string $eventName, callable $callbackFunction): void
    {
        if (!isset($this->eventListeners[$eventName])) {
            $this->eventListeners[$eventName] = [];
        }

        $this->eventListeners[$eventName][] = $callbackFunction;
    }

    /**
     * @param string $eventName
     * @return void
     */
    public function detouchEvent(string $eventName): void
    {
        unset($this->eventListeners[$eventName]);
    }

    /**
     * @param string $eventName
     * @param ...$args
     * @return void
     */
    public function dispatchEvent(string $eventName, ...$args): void
    {
        if (isset($this->eventListeners[$eventName])) {
            foreach ($this->eventListeners[$eventName] as $callbackFunction) {
                call_user_func_array($callbackFunction, $args);
            }
        }
    }
}
