<?php
require_once 'init.php';
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';

if (empty($_GET)) {
    $type = null;
} else {
    $type = $_GET['type'];
};

$content_types = get_content_types($db_connect);

if ($type !== null && is_type_exist($content_types, $type) === false) {
    http_response_code(404);
    die;
}

$page_content = include_template('main.php',
    [
        'content_types' => $content_types,
        'posts' => get_posts($db_connect, $type),
        'type' => $type,
        'active_class' => 'filters__button--active'
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--popular',
        'title' => 'readme: популярные посты',
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);

print($layout_content);
