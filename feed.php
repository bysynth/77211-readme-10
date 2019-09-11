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

$page_content = include_template('feed.php',
    [
        'content_types' => $content_types,
        'posts' => get_posts($db_connect, $type, $_SESSION['user']['id'], null, false, true),
        'type' => $type
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--feed',
        'title' => 'readme: моя лента'
    ]);

print($layout_content);
