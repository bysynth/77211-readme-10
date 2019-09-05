<?php
require_once 'init.php';

$type = $_GET['type'] ?? null;

$content_types = get_content_types($db_connect);

if ($type === '' || ($type !== null && is_type_exist($content_types, $type) === false)) {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

$page_content = include_template('main.php',
    [
        'content_types' => $content_types,
        'posts' => get_posts($db_connect, $type),
        'type' => $type
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--popular',
        'title' => 'readme: популярные посты',
        'user_name' => $user_name
    ]);

print($layout_content);
