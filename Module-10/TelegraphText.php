<?php

class TelegraphText
{
    public string $text, $title, $author, $published, $slug;

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
    public function storeText(string $title, string $text): void
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
    public function loadText(): string|null
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
}


