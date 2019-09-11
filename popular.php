<?php
require_once 'init.php';

if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
    exit();
}

$type = $_GET['type'] ?? null;

$content_types = get_content_types($db_connect);

if ($type === '' || ($type !== null && is_type_exist($content_types, $type) === false)) {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

$page_content = include_template('popular.php',
    [
        'content_types' => $content_types,
        'posts' => get_posts($db_connect, $type, null, null, true),
        'type' => $type
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--popular',
        'title' => 'readme: популярные посты'
    ]);

print($layout_content);
