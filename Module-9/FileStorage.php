<?php

class FileStorage extends Storage
{
    const STORE_DIR = './store/';

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
        $i = 1;
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
    function read(int|string $id): object|null
    {
        if (!file_exists(self::STORE_DIR . $id)) {
            echo 'Файл ' . self::STORE_DIR . $id . ' не найден' . PHP_EOL;
            return null;
        }

        $content = file_get_contents(self::STORE_DIR . $id);
        if ($content === false && $content !== '') {
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
    function update(int|string $id, object $newObject): void
    {
        file_put_contents(self::STORE_DIR . $id, serialize($newObject));
    }

    /**
     * @param int|string $id
     * @return void
     */
    function delete(int|string $id): void
    {
        unlink(self::STORE_DIR . $id);
    }

    /**
     * @return array|null
     */
    function list(): array|null
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

            if ($content === false && $content !== '') {
                echo 'Не удалось получить данные из файла ' . self::STORE_DIR . $file . PHP_EOL;
                continue;
            }

            $articleList[] = unserialize($content);
        }

        return $articleList;
    }
}
