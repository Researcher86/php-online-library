<?php

if(!function_exists('createLinksForGenres')) {
    function createLinksForGenres($genres, $delimiter = ' / ') {
        return implode($delimiter, array_map(function ($genre) {
            $url = url('/books/genres', $genre['id']);
            $name = $genre['name'];
            return "<a href='{$url}'>{$name}</a>";
        }, $genres));
    }
}