<?php
require_once 'init.php';

if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
    exit();
}

$cur_page = $_GET['page'] ?? null;
$type = $_GET['type'] ?? null;
$sort = $_GET['sort'] ?? null;

$sort_types = [
    'popular-desc',
    'popular-asc',
    'likes-desc',
    'likes-asc',
    'date-desc',
    'date-asc'
];

$content_types = get_content_types($db_connect);

if ($type === '' || ($type !== null && is_type_exist($content_types, $type) === false)) {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

if ($sort === '' || ($sort !== null && in_array($sort, $sort_types, true) === false)) {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

if (!isset($type)) {
    $sort_url = [
        'popular-desc' => '\popular.php?sort=popular-desc',
        'popular-asc' => '\popular.php?sort=popular-asc',
        'likes-desc' => '\popular.php?sort=likes-desc',
        'likes-asc' => '\popular.php?sort=likes-asc',
        'date-desc' => '\popular.php?sort=date-desc',
        'date-asc' => '\popular.php?sort=date-asc'
    ];
} else {
    $sort_url = [
        'popular-desc' => '\popular.php?page=1&type=' . $type . '&sort=popular-desc',
        'popular-asc' => '\popular.php?page=1&type=' . $type . '&sort=popular-asc',
        'likes-desc' => '\popular.php?page=1&type=' . $type . '&sort=likes-desc',
        'likes-asc' => '\popular.php?page=1&type=' . $type . '&sort=likes-asc',
        'date-desc' => '\popular.php?page=1&type=' . $type . '&sort=date-desc',
        'date-asc' => '\popular.php?page=1&type=' . $type . '&sort=date-asc'
    ];
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

if ($cur_page > $pages_count && !isset($type) && !isset($sort)) {
    $url = 'Location: /popular.php?page=' . $pages_count;
    $cur_page = $pages_count;
    header($url);
}

if ($cur_page > $pages_count && !isset($type) && isset($sort)) {
    $url = 'Location: /popular.php?page=' . $pages_count . '&sort=' . $sort;
    $cur_page = $pages_count;
    header($url);
}

if ($cur_page > $pages_count && isset($type) && !isset($sort)) {
    $url = 'Location: /popular.php?page=' . $pages_count . '&type=' . $type;
    $cur_page = $pages_count;
    header($url);
}

if ($cur_page > $pages_count && isset($type, $sort)) {
    $url = 'Location: /popular.php?page=' . $pages_count . '&type=' . $type . '&sort=' . $sort;
    $cur_page = $pages_count;
    header($url);
}

if (!isset($type) && !isset($sort)) {
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
}

if (!isset($type) && isset($sort)){
    if ($cur_page === 1) {
        $prev_url = '';
    } else {
        $prev_url = 'href="/popular.php?page=' . ($cur_page - 1) . '&sort=' . $sort . '"';
    }

    if ($cur_page <= $pages_count - 1) {
        $next_url = 'href="/popular.php?page=' . ($cur_page + 1) . '&sort=' . $sort . '"';
    } else {
        $next_url = '';
    }
}

if (isset($type) && !isset($sort)) {
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

if (isset($type, $sort)) {
    if ($cur_page === 1) {
        $prev_url = '';
    } else {
        $prev_url = 'href="/popular.php?page=' . ($cur_page - 1) . '&type=' . $type . '&sort=' . $sort . '"';
    }

    if ($cur_page <= $pages_count - 1) {
        $next_url = 'href="/popular.php?page=' . ($cur_page + 1) . '&type=' . $type . '&sort=' . $sort . '"';
    } else {
        $next_url = '';
    }
}

if (!isset($sort) || (isset($sort) && $sort === 'popular-desc')) {
    $posts = get_popular_posts($db_connect, $type, $offset);
}
if (isset($sort) && $sort === 'popular-asc') {
    $posts = get_popular_posts($db_connect, $type, $offset, 'popular-asc');
}
if (isset($sort) && $sort === 'likes-desc') {
    $posts = get_popular_posts($db_connect, $type, $offset, 'likes-desc');
}
if (isset($sort) && $sort === 'likes-asc') {
    $posts = get_popular_posts($db_connect, $type, $offset, 'likes-asc');
}
if (isset($sort) && $sort === 'date-desc') {
    $posts = get_popular_posts($db_connect, $type, $offset, 'date-desc');
}
if (isset($sort) && $sort === 'date-asc') {
    $posts = get_popular_posts($db_connect, $type, $offset, 'date-asc');
}

//$posts = get_popular_posts($db_connect, $type, $offset);

$page_content = include_template('popular.php',
    [
        'content_types' => $content_types,
        'posts' => $posts,
        'sort' => $sort,
        'sort_url' => $sort_url,
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
