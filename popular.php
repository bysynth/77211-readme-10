<?php
require_once 'init.php';

if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
    exit();
}

$cur_page = $_GET['page'] ?? null;

$type = $_GET['type'] ?? null;
$content_types = get_content_types($db_connect);

if ($type === '' || ($type !== null && is_type_exist($content_types, $type) === false)) {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

if (isset($cur_page)) {
    $cur_page = (int)$cur_page;
}

if ($cur_page === null || $cur_page === 0 || $cur_page === '') {
    $cur_page = 1;
}

$page_items = 6;

$items_count = get_items_count($db_connect);

if (isset($type)) {
    $items_count = get_items_count($db_connect, $type);
}

$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;

if ($cur_page > $pages_count && !isset($type)) {
    $url = 'Location: /popular.php?page=' . $pages_count;
    $cur_page = $pages_count;
    header($url);
}

if ($cur_page > $pages_count && isset($type)) {
    $url = 'Location: /popular.php?page=' . $pages_count . '&type=' . $type;
    $cur_page = $pages_count;
    header($url);
}

if (!isset($type)) {
    if ($cur_page === 1) {
        $prev_url = '';
    } else {
        $prev_url = 'href="/popular.php?page=' . ($cur_page - 1) . '"';
    }

    if ($cur_page <= $pages_count - 1) {
        $next_url = 'href="/popular.php?page=' . ($cur_page + 1) . '"';
    } else {
        $next_url = '';
    }
} else {
    if ($cur_page === 1) {
        $prev_url = '';
    } else {
        $prev_url = 'href="/popular.php?page=' . ($cur_page - 1) . '&type=' . $type . '"';
    }

    if ($cur_page <= $pages_count - 1) {
        $next_url = 'href="/popular.php?page=' . ($cur_page + 1) . '&type=' . $type . '"';
    } else {
        $next_url = '';
    }
}

$posts = get_popular_posts($db_connect, $type, $offset);

$page_content = include_template('popular.php',
    [
        'content_types' => $content_types,
        'posts' => $posts,
        'type' => $type,
        'pages_count' => $pages_count,
        'prev_url' => $prev_url,
        'next_url' => $next_url
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'is_popular' => true,
        'main_class' => 'page__main--popular',
        'title' => 'readme: популярные посты'
    ]);

print($layout_content);
