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

if(!function_exists('concatGetParams')) {
    function concatGetParams($url) {
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        $params = array_merge($_GET, $params);

        return explode('?', $url)[0] . '?' . http_build_query($params);
    }
}