<?php
require_once 'init.php';

if (!isset($_GET['id']) || $_GET['id'] === '') {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

$id = (int) $_GET['id'];

$post_content = get_post($db_connect, $id);

if (empty($post_content)) {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

$user_subscriptions_count = isset($post_content['author_id']) ? get_subscriptions_count($db_connect, $post_content['author_id']) : 0;
$user_publications_count = isset($post_content['author_id']) ? get_publications_count($db_connect, $post_content['author_id']) : 0;

$page_content = include_template('post.php',
    [
        'post_content' => $post_content,
        'user_subscriptions_count' => $user_subscriptions_count['count'],
        'user_publications_count' => $user_publications_count['count']
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--publication',
        'title' => 'readme: ' . $post_content['title'],
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);

print($layout_content);
