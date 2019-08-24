<?php
date_default_timezone_set('Europe/Moscow');

require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';

$db_connect = mysqli_connect('localhost', 'root', '', 'readme');
mysqli_set_charset($db_connect, 'utf8');

if (!$db_connect) {
    $connect_error = 'Ошибка №' . mysqli_connect_errno() . ' -- ' . mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $connect_error]);
} else {
    $sql_content_types = 'SELECT type_name, type_icon FROM content_types';
    $sql_posts = 'SELECT p.created_at, p.title, p.content, p.cite_author, ct.type_name, ct.type_icon, '
        . 'u.name, u.avatar '
        . 'FROM posts AS p '
        . 'JOIN content_types AS ct ON ct.id = p.content_type '
        . 'JOIN users as u ON u.id = p.author_id '
        . 'ORDER BY p.views_counter DESC '
        . 'LIMIT 6;';

    $result_content_types = mysqli_query($db_connect, $sql_content_types);
    $result_posts = mysqli_query($db_connect, $sql_posts);

    if ($result_content_types && $result_posts) {
        $content_types = mysqli_fetch_all($result_content_types, MYSQLI_ASSOC);
        $posts = mysqli_fetch_all($result_posts, MYSQLI_ASSOC);
        $page_content = include_template('main.php',
            [
                'content_types' => $content_types,
                'posts' => $posts
            ]);
    } else {
        $query_error = 'Ошибка №' . mysqli_errno($db_connect) . ' --- ' . mysqli_error($db_connect);
        $page_content = include_template('error.php', ['error' => $query_error]);
    }
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: популярные посты',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);
