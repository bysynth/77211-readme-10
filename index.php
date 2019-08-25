<?php
require_once 'init.php';
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';

$page_content = include_template('main.php',
    [
        'content_types' => get_content_types($db_connect),
        'posts' => get_posts($db_connect)
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'title' => 'readme: популярные посты',
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);

print($layout_content);
