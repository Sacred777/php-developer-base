<?php

class TelegraphText
{
    private string $text, $title, $author, $published, $slug;

    function __construct(string $author, string $slug)
    {
        $this->author = $author;
        $this->slug = $slug;
        $this->published = date('Y-m-d H:m:s');
    }

    /**
     * @param string $title
     * @param string $text
     * return void
     */
    private function storeText(string $title, string $text): void
    {
        $this->title = $title;
        $this->text = $text;

        $article = [
            'title' => $this->title,
            'text' => $this->text,
            'author' => $this->author,
            'published' => $this->published,
        ];

        file_put_contents($this->slug, serialize($article));
    }

    /**
     * return string|null
     */
    private function loadText(): string|null
    {
        if (!file_exists($this->slug)) {
            echo "Файл $this->slug не найден" . PHP_EOL;
            return null;
        }

        $content = file_get_contents($this->slug);
        if ($content === false && $content !== '') {
            echo "Не удалось получить данные из файла $this->slug" . PHP_EOL;
            return null;
        }

        $unserializedContent = unserialize($content);

        $this->title = $unserializedContent['title'];
        $this->text = $unserializedContent['text'];
        $this->author = $unserializedContent['author'];
        $this->published = $unserializedContent['published'];
        return $this->text;
    }

    /**
     * @param string $title
     * @param string $text
     * @return void
     */
    public function editText(string $title, string $text): void
    {
        if ($this->loadText() !== null) {
            $this->storeText($title, $text);
        };
    }

    /**
     * @param string $name
     * @param string|array $value
     * @return void
     */
    public function __set(string $name, string|array $value): void
    {
        switch ($name) {
            case 'author':
                if (mb_strlen($value) > 120) {
                    echo "Невозможна запись значения: $value. Длина строки превышает 120 символов" . PHP_EOL;
                } else {
                    $this->author = $value;
                }
                break;

            case 'slug':
                $patternSlug = "/^[a-zA-Z0-9_-]+$/";
                if (preg_match($patternSlug, $value)) {
                    $this->slug = $value;
                } else {
                    echo "Значение содержит недопустимые символы: $value. Допустимы латинские буквы, цифры, тире, нижнее подчёркивание" . PHP_EOL;
                }
                break;

            case 'published':
                $currentDate = date('Y-m-d H:m:s');
                if ($value < $currentDate) {
                    echo "Дата публикации: $value не должна быть меньше текущей даты: $currentDate" . PHP_EOL;
                } else {
                    $this->published = $value;
                }
                break;

            case 'text':
                $this->storeText($value[0], $value[1]);
                break;
        }
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function __get(string $name): ?string
    {
        switch ($name) {
            case 'author':
                return $this->author;
            case 'slug':
                return $this->slug;
            case 'published':
                return $this->published;
            case 'text':
                return $this->loadText();
            default:
                return null;
        }
    }
}
