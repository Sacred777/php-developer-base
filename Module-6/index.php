<?php

$textStorage = [];

function add(string $title, string $text, array &$textStorage):void
{
    $textStorage[] = ['title' => $title, 'text' => $text];
}

add('Первый заголовок', 'Прикольный текст', $textStorage );
add('Второй заголовок', 'Ещё более прикольный текст', $textStorage );
var_dump($textStorage);

function remove(int $index, array &$textStorage):bool
{
    if(isset($textStorage[$index])) {
        unset($textStorage[$index]);
        return true;
    }
    return  false;
}

var_dump(remove(0, $textStorage)) . PHP_EOL;
var_dump(remove(5, $textStorage)) . PHP_EOL;
var_dump($textStorage);

function edit(int $index, string $title, string $text, &$textStorage):bool
{
    if(isset($textStorage[$index])) {
        if ($title !=='') {
            $textStorage[$index]['title'] = $title;
        }
        if ($text !=='') {
            $textStorage[$index]['text'] = $text;
        }
        return true;
    }
    return false;
}

var_dump(edit(1, 'Изменённый заголовок', '', $textStorage));
var_dump(edit(5, 'Неприличный заголовок', 'И текст такой же', $textStorage));
var_dump($textStorage);
