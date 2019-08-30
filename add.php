<?php

require_once 'init.php';

if (!empty($_GET)) {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

$content_types = get_content_types($db_connect);

$page_content = include_template('add-post.php',
    [
        'content_types' => $content_types
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--adding-post',
        'title' => 'readme: добавление публикации',
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);

print($layout_content);
